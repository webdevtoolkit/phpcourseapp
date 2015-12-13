<?php
        //print_r($_SERVER['DOCUMENT_ROOT']); 
        //exit();
	require_once $_SERVER['DOCUMENT_ROOT'] . "/helpdesk/includes/db.inc.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/helpdesk/includes/access.inc.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/helpdesk/models/processRequests.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/helpdesk/includes/helpers.inc.php";
	 
	define("LOGIN", $_SERVER['DOCUMENT_ROOT']."/helpdesk/modules/users/views/login.html.php");
	define("ADMIN_HOME", $_SERVER['DOCUMENT_ROOT']."/helpdesk/index.php");
	define("ADMIN_PAGEHEADER", $_SERVER['DOCUMENT_ROOT']."/helpdesk/views/templates/header.html.php");
	define("ADMIN_PAGEFOOTER", $_SERVER['DOCUMENT_ROOT']."/helpdesk/views/templates/footer.html.php");
	define("REQUESTS_LIST", $_SERVER['DOCUMENT_ROOT']."/helpdesk/views/requests.html.php");
	define("REQUEST_FORM", $_SERVER['DOCUMENT_ROOT']."/helpdesk/views/form.html.php");
	define("CMS_ERROR", $_SERVER['DOCUMENT_ROOT']."/helpdesk/views/error.html.php");

	if (!userIsLoggedIn())
	{
		include LOGIN;
		exit();
	}
	
	$requests = new ProcessRequests;
	
	if (isset($_GET['add']))
	{
	  $pageTitle = 'New request';
	  $action = 'addRequest';
	  $requestTitle = '';
	  $id = false;
	  $requestContent = '';
	  $button = 'Save request';
	  $status = false;

	  $pageStatus = pageStatus();
	  $requestCategories = $requests->get_categories();
	 
	  if($requestCategories)
		{
			foreach ($requestCategories as $row)
			{
			 $categoriesList[] = array('id' => $row['id'], 'category' => $row['category'], 'selected' => FALSE);
			}

		}
		else
		{
		  $categoriesList = false;
			
		}
		
		$status = array();
		
		 include_once ADMIN_PAGEHEADER;
		 include REQUEST_FORM;
		 include_once ADMIN_PAGEFOOTER;
		 exit();

	}
	
	//add request
	if (isset($_GET['addRequest']))
	{
		$data['requestTitle'] = $_POST['requestTitle'];
		$data['requestContent'] = $_POST['requestContent'];
		$data['requestCats'] = $_POST['requestCats'];
		
		$successFlag = $requests->add_request($data);
		  
		  if(!$successFlag)
		  {
			$error = 'Error adding request.';
			include CMS_ERROR;
			exit(); 
		  }
		  header('Location: .');
		  exit();
	}
	
//Edit request
if (isset($_POST['action']) and $_POST['action'] == 'Edit')
{
	$requestDetails = $requests->fetch_request($_POST['id']);
	
	 if(!$requestDetails)
	  {
		$error = 'Error fetching users .';
		include CMS_ERROR;
		exit();
	  }
	 
	  foreach ($requestDetails as $row)
	  {
	   
		$requestTitle = $row['title']; 
		$id = $row['id'];
		$requestContent = $row['content']; 
		$status = $row['status'];
		
	  }
	  
	  $pageStatus = pageStatus();
	  //Get post categories
	  $requestCategories = $requests->get_categories();
	  
	  //Get selected categories
	  $requestCategoriesSelected = $requests->get_selected_categories($_POST['id']);
	  
	  //Use in_array
	  foreach ($requestCategories as $row)
	  {
		  if($requestCategoriesSelected)
		  {
			 $categoriesList[] = array('id' => $row['id'], 'category' => $row['category'],  'selected' => in_array($row['id'],  $requestCategoriesSelected)); 
		  }
		  else
		  {
			 $categoriesList[] = array('id' => $row['id'], 'category' => $row['category'],  'selected' => FALSE);  
			  
		  }
	  }
	 
	  $pageTitle = 'Edit request';
	  $action = 'editRequest';
	  $button = 'Update request';
	  
	 include_once ADMIN_PAGEHEADER;
     include REQUEST_FORM;
     include_once ADMIN_PAGEFOOTER;
	 exit();
	
}

if (isset($_GET['editRequest']))
{
  
  $data['title'] = $_POST['requestTitle'];
  $data['content'] = $_POST['requestContent'];
  $data['reqId'] = $_POST['id'];
  $data['reqCats'] = $_POST['requestCats'];
  $data['status'] = $_POST['status'];
  
  $successFlag = $requests->update_request($data);
  
  if(!$successFlag)
  {
    $error = 'Error updating request.';
   include CMS_ERROR;
   exit();
  }

  header('Location: .');
  exit();
	
}

//delete_user
if (isset($_POST['action']) and $_POST['action'] == 'Remove request')
{
  $removeRequest = $_POST['id'];
  
  $successFlag = $requests->delete_request($removeRequest);
  
  if(!$successFlag)
  {
    $error = 'Error deleting request.';
    include CMS_ERROR;
    exit(); 
  }
  header('Location: .');
  exit();
}

	
	$requestsDisplayList = $requests->get_requests();
 
    if($requestsDisplayList)
	{
		foreach ($requestsDisplayList as $row)
		{
		 $requestsList[] = array('id' => $row['ID'], 'title' => $row['title']);
		}

	}
	else
	{
	  $requestsList = false;
		
	}

	 include_once ADMIN_PAGEHEADER;
     include REQUESTS_LIST;
     include_once ADMIN_PAGEFOOTER;
		
		
