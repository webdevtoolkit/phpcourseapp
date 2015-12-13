<?php

function userIsLoggedIn()
{
  if (isset($_POST['action']) and $_POST['action'] == 'login')
  {
    if (!isset($_POST['username']) or $_POST['username'] == '' or
      !isset($_POST['password']) or $_POST['password'] == '')
    {
      $GLOBALS['loginError'] = 'Please fill in both fields';
      return FALSE;
    }

    $password = sha1($_POST['password'] . 'lfiDE3VtFQEK57a2CEupBN6I27B3E5H4');
	

    if (databaseContainsUser($_POST['username'], $password))
    {
      session_start();
      $_SESSION['loggedIn'] = TRUE;
      $_SESSION['username'] = $_POST['username'];
      $_SESSION['password'] = $password;
      return TRUE;
    }
    else
    {
      session_start();
      unset($_SESSION['loggedIn']);
      unset($_SESSION['username']);
      unset($_SESSION['password']);
      $GLOBALS['loginError'] =
          'The specified username address or password was incorrect.';
      return FALSE;
    }
  }

  if (isset($_POST['action']) and $_POST['action'] == 'logout')
  {
    session_start();
    unset($_SESSION['loggedIn']);
    unset($_SESSION['username']);
    unset($_SESSION['password']);
    header('Location: ' . $_POST['goHome']);
    exit();
  }

  session_start();
  if (isset($_SESSION['loggedIn']))
  {
    return databaseContainsUser($_SESSION['username'], $_SESSION['password']);
  }
}

function databaseContainsUser($username, $password)
{
  include 'db.inc.php';

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
    $error = 'Error searching for app user.';
    include 'error.html.php';
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

function userHasRole($role)
{
  include 'db.inc.php';

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
    $error = 'Error searching for appUser roles.';
    include 'error.html.php';
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
