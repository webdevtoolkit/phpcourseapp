<?php
require_once $_SERVER['DOCUMENT_ROOT'] . PROCESS_USERS;
 
function userIsLoggedIn()
{
  $user = new ProcessUsers;
  if (isset($_POST['action']) and $_POST['action'] == 'login')
  {
    if (!isset($_POST['username']) or $_POST['username'] == '' or
      !isset($_POST['password']) or $_POST['password'] == '')
    {
      $GLOBALS['loginError'] = 'Please fill in both fields';
      return FALSE;
    }

    $password = sha1($_POST['password'] . 'lfiDE3VtFQEK57a2CEupBN6I27B3E5H4');
	
	$userExists = $user->databaseContainsUser($_POST['username'], $password);

    if($userExists)
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
    header('Location: ' . $_POST['goto']);
    exit();
  }

  session_start();
  if (isset($_SESSION['loggedIn']))
  {
	$userExists = $user->databaseContainsUser($_SESSION['username'], $_SESSION['password']);
    return $userExists;
  }
}
 
