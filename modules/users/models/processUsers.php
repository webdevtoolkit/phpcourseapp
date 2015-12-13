<?php

define("ROLE_REFS", $_SERVER['DOCUMENT_ROOT']."/helpdesk/modules/users/includes/roleRefs.inc.php");

class ProcessUsers
{
  public $username;
  public $password;
  
  public function databaseContainsUser($username, $password)
  {
        include DATABASE;

        try
        {
              $sql = 'SELECT COUNT(*) FROM logins
                      WHERE login = :username AND password = :password';
              $s = $pdo->prepare($sql);
              $s->bindValue(':username', $username);
              $s->bindValue(':password', $password);
              $s->execute();
        }
        catch (PDOException $e)
        {
              $error = 'Error checking login details.';
              include CMS_ERROR;
              return false;
              exit();
        }

        $row = $s->fetch();

        if ($row[0] > 0)
        {
              return TRUE;
        }
        else
        {
              return FALSE;
        }
     }
	
    public function userHasRole($role)
    {
      include DATABASE;

      try
      {
            $sql = "SELECT COUNT(*) FROM appUsers
                    INNER JOIN userRole ON appUsers.id = userRole.userId
                    INNER JOIN role ON userRole.roleId = role.id
                    INNER JOIN logins ON logins.userId = appUsers.id
                    WHERE logins.login = :username AND role.id = :roleId";
            $s = $pdo->prepare($sql);
            $s->bindValue(':username', $_SESSION['username']);
            $s->bindValue(':roleId', $role);
            $s->execute();
      }
      catch (PDOException $e)
      {
            $error = 'Error checking roles' . $s->errorInfo();
        include CMS_ERROR;
            return false;
            exit();
      }

      $row = $s->fetch();

      if ($row[0] > 0)
      {
            return TRUE;
      }
      else
      {
            return FALSE;
      }
    }
	
    public function get_user($userRef)
    {

      include DATABASE;
      include ROLE_REFS;

       try
              {
                    $sql = 'SELECT appusers.id, appusers.name, contactdetails.email, logins.login FROM appusers 
                    INNER JOIN contactdetails ON contactdetails.contactId = appusers.id 
        INNER JOIN logins ON logins.userId = appusers.id 			
                    WHERE appusers.id = :id';
                    $s = $pdo->prepare($sql);
                    $s->bindValue(':id', $userRef);
                    $s->execute();
              }
              catch (PDOException $e)
              {
                    return false;
              }

              //$authors = '';
        foreach ($s as $row)
            {
              //$authors[] = $row;
              $users[] = array('id' => $row['id'], 'name' => $row['name'], 'email' => $row['email'], 'login' => $row['login']);
            }
            return $users;
    }
	
    public function add_user($userDetails) {
        include DATABASE;
        include ROLE_REFS;

        $email = $userDetails['email'];
        $name = $userDetails['name'];

        $password = sha1($userDetails['password'] . 'lfiDE3VtFQEK57a2CEupBN6I27B3E5H4');

        try
          {
                $sql = 'INSERT INTO appusers SET
                        name = :name,
                        accountStatus = :accountStatus,
                        userCatId =  :userCatId,
                        dateAdded =  CURRENT_TIMESTAMP()';

                $s = $pdo->prepare($sql);
                $s->bindValue(':name', $userDetails['name']);
                $s->bindValue(':accountStatus', 'live');
            $s->bindValue(':userCatId', ADMIN);
                $s->execute();
          }
          catch (PDOException $e)
          {
            $error = 'Error adding submitted user.' . $s->errorInfo();
            include CMS_ERROR;
            exit();
          }

          $userId = $pdo->lastInsertId();

    if($userDetails['email'])
    {
          try
          {
              $sql = 'INSERT INTO contactdetails SET
                      contactId = :contactId,
                      contactCategory = :contactCategory,
                      email = :email,
              dateAdded =  CURRENT_TIMESTAMP()';

              $s = $pdo->prepare($sql);
              $s->bindValue(':contactId', $userId);
              $s->bindValue(':contactCategory', ADMIN);
              $s->bindValue(':email', $userDetails['email']);
              $s->execute();
          }
          catch (PDOException $e)
          {

              $error = 'Error adding submitted contact details.' . $s->errorInfo();
              include CMS_ERROR;
              exit();
          }

          $contactId = $pdo->lastInsertId();
          echo $contactId;
    }
  
  //insert into logins
    try
    {
          $sql = 'INSERT INTO logins SET
                  login = :login,
                  userId = :userId,
                  password = :password,
          dateAdded =  CURRENT_TIMESTAMP()';

          $s = $pdo->prepare($sql);
          $s->bindValue(':userId',  $userId);
          $s->bindValue(':login',  $userDetails['login']);
          $s->bindValue(':password', $password);
          $s->execute();
    }
    catch (PDOException $e)
    {
        $error = 'Error adding submitted login details.';
            include CMS_ERROR;

        exit();
     }
     return true;
	
    }   
	
    public function fetch_users()
    {
     include DATABASE;
     include ROLE_REFS;

      try
            {
              $result = $pdo->query('SELECT id, name FROM appusers');
              //return $result;
            }
            catch (PDOException $e)
            {
              return false;

            }

            //$authors = '';
        foreach ($result as $row)
        {

              $users[] = array('id' => $row['id'], 'name' => $row['name']);
        }

        if(isset($users))
        {
            return $users;
        }

            return false;
    }
	
    public function update_user($updateInfo)
    {
     include DATABASE;
     try
      {
            $sql = 'UPDATE appusers SET
                    name = :name, 
                    lastUpdated = CURRENT_TIMESTAMP()
                    WHERE id = :id';
            $s = $pdo->prepare($sql);
            $s->bindValue(':name', $updateInfo['name']);
            $s->bindValue(':id', $updateInfo['userId']);
            $s->execute();
      }
      catch (PDOException $e)
      {

            $error = 'Error updating submitted login details.';
        include CMS_ERROR;
            return false;
            exit();
      }

      try
      {
            $sql = 'UPDATE logins SET
                    login = :login, 
                    lastUpdated = CURRENT_TIMESTAMP()
                    WHERE userId = :id';
            $s = $pdo->prepare($sql);
            $s->bindValue(':login', $updateInfo['login']);
            $s->bindValue(':id', $updateInfo['userId']);
            $s->execute();

      }
      catch (PDOException $e)
      {
            $error = 'Error updating login details.';
        include CMS_ERROR;
            return false;
            exit();
      }

      try
      {
            $sql = 'UPDATE contactdetails SET
                    email = :email, 
                    lastUpdated = CURRENT_TIMESTAMP()
                    WHERE contactId = :id';
            $s = $pdo->prepare($sql);
            $s->bindValue(':email', $updateInfo['email']);
            $s->bindValue(':id', $updateInfo['userId']);
            $s->execute();

      }
      catch (PDOException $e)
      {
            $error = 'Error adding submitted login details.';
        include CMS_ERROR;
            return false;
            exit();
      }

      return true;
      exit();

    }

    public function delete_user($delInfo)
    {
     include DATABASE;
            try
              {
                    $sql = 'DELETE FROM appusers WHERE id = :id';
                    $s = $pdo->prepare($sql);
                    $s->bindValue(':id', $delInfo);
                    $s->execute();
              }


      catch (PDOException $e)
      {
            $error = 'Error deleting app user details.';
        include CMS_ERROR;
            return false;
            exit();
      }

      try
      {
        $sql = 'DELETE FROM contactdetails WHERE contactId = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $delInfo);
        $s->execute();
      }


      catch (PDOException $e)
      {
            $error = 'Error deleting contact details.';
        include CMS_ERROR;
            return false;
            exit();
      }

        try
        {
              $sql = 'DELETE FROM logins WHERE userId = :id';
              $s = $pdo->prepare($sql);
              $s->bindValue(':id', $delInfo);
              $s->execute();
        }


      catch (PDOException $e)
      {
            $error = 'Error deleting login details.';
        include CMS_ERROR;
            return false;
            exit();
      }

      return true;
      exit();

    }
}
?>