<?php
 
require_once $_SERVER['DOCUMENT_ROOT'] . "/helpdesk/modules/users/models/processUsers.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/helpdesk/includes/helpers.inc.php";
 
define("ADMIN_PAGEHEADER", $_SERVER['DOCUMENT_ROOT']."/helpdesk/views/templates/header.html.php");
define("ADMIN_PAGEFOOTER", $_SERVER['DOCUMENT_ROOT']."/helpdesk/views/templates/footer.html.php");
define("DATABASE", $_SERVER['DOCUMENT_ROOT'] . "/helpdesk/includes/db.inc.php");
define("CMS_ERROR", $_SERVER['DOCUMENT_ROOT']."/helpdesk/views/error.html.php");
define("USERS_LIST", $_SERVER['DOCUMENT_ROOT']."/helpdesk/modules/users/views/users.html.php");
define("USER_FORM", $_SERVER['DOCUMENT_ROOT']."/helpdesk/modules/users/views/form.html.php");

$validateUser = new ProcessUsers;
 
if (isset($_GET['add']))
{
  $pageTitle = 'New user';
  $action = 'addform';
  $name = '';
  $password = '';
  $login = '';
  $email = '';
  $authorid = '';
  $id = '';
  $button = 'Add user';
  
  include_once ADMIN_PAGEHEADER;
  include_once USER_FORM;
  include_once ADMIN_PAGEFOOTER;
 
  exit();
 }
 
 
if (isset($_GET['addform']))
{
 
 $data['login'] = $_POST['username'];
 $data['password'] = $_POST['password'];
 $data['email'] = $_POST['email'];
 $data['name'] = $_POST['name'];

 $successFlag = $validateUser->add_user($data);
  
  if(!$successFlag)
  {
    $error = 'Error adding user.';
    include CMS_ERROR;
    exit(); 
  }
  
  header('Location: .');
  exit();
}

if (isset($_POST['action']) and $_POST['action'] == 'Edit')
{
  $userDetails = $validateUser->get_user($_POST['id']);
  
  if(!$userDetails)
  {
    $error = 'Error fetching users .';
    include CMS_ERROR;
    exit();
  }
  
  foreach ($userDetails as $row)
  {
    $name = $row['name'];
    $email = $row['email'];
    $login = $row['login']; 
	$id = $row['id'];
  }
  
  $pageTitle = 'Edit user';
  $action = 'editform';
  $password = '';
  
  $button = 'Update user';
  
  include_once ADMIN_PAGEHEADER;
  include_once USER_FORM;
  include_once ADMIN_PAGEFOOTER;
  exit();
}

if (isset($_GET['editform']))
{
  

  $data['login'] = $_POST['username'];
  $data['password'] = $_POST['password'];
  $data['email'] = $_POST['email'];
  $data['name'] = $_POST['name'];
  $data['userId'] = $_POST['id'];
  
  $successFlag = $validateUser->update_user($data);
  
  if(!$successFlag)
  {
    $error = 'Error updating user.';
    include 'error.html.php'; 
    exit();
  }

  header('Location: .');
  exit();
}

//delete_user
if (isset($_POST['action']) and $_POST['action'] == 'Remove user')
{
  $removeUser = $_POST['id'];
  
  $successFlag = $validateUser->delete_user($removeUser);
  
  $successFlag = $validateUser->delete_user($removeUser);
  
  if(!$successFlag)
  {
    $error = 'Error deleting user.';
    include 'error.html.php';
    exit();
  }
  header('Location: .');
  exit();

}
$usersList = false;
$usersList = $validateUser->fetch_users();

if($usersList)
 {
    foreach ($usersList as $row)
	{
	  $users[] = array('id' => $row['id'], 'name' => $row['name']);
	}
 }
 else
 {
	$users = false;
	 
 }

  include_once ADMIN_PAGEHEADER;
  include_once USERS_LIST;
  include_once ADMIN_PAGEFOOTER;

?>