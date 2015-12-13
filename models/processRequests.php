<?php

define("DATABASE", $_SERVER['DOCUMENT_ROOT'] . "/helpdesk/includes/db.inc.php");

class ProcessRequests
{
	
	public function fetch_request($reqRef)
	{
		include DATABASE;
		try
		  {
			$sql = 'SELECT support_queries.ID, support_queries.title, support_queries.content, support_queries.status	
			FROM support_queries
			WHERE support_queries.ID = :id';
			$s = $pdo->prepare($sql);
			$s->bindValue(':id', $reqRef);
			$s->execute();
		  }
		  catch (PDOException $e)
		  {
			return false;
		  }
		  
	    foreach ($s as $row)
		{
		  $reqDetails[] = array('id' => $row['ID'], 'title' => $row['title'], 'content' => $row['content'], 'status' => $row['status'] );
		}
		return  $reqDetails;
	}
	
	public function get_categories()
	{
		include DATABASE;
		try
		{
		  $result = $pdo->query('SELECT ID, category FROM support_categories ORDER BY category ASC');
		  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	 
		}
		catch (PDOException $e)
		{
		  $error = 'Error getting helpdesk category. ' . $e;
			//include $_SERVER['DOCUMENT_ROOT'] . CMS_ERROR;
			include $_SERVER['DOCUMENT_ROOT'] . '/cprcourse/helpdesk/views/error.html.php';
			exit();
		 // return false;
		  
		}
		
		
		
		//$authors = '';
	    foreach ($result as $row)
		{
		  //$authors[] = $row;
		  $categories[] = array('id' => $row['ID'], 'category' => $row['category']);
		}
		
	 
		 
		if(isset($categories))
		{
		 return $categories;
		}
		else
        {
			$categories="";
	    }
		
		return $categories;
		
		
	}
	
	public function get_selected_categories($reqRef)
	{
		include DATABASE;
	
		try
		  {
			$sql = 'SELECT categoryID FROM request_categories_lookup WHERE requestID = :id';
			$s = $pdo->prepare($sql);
			$s->bindValue(':id', $reqRef);
			$s->execute();
		  }
		  catch (PDOException $e)
		  {
			$error = 'Error fetching list of selected categories.';
			include CMS_ERROR;
			exit();
		  }

		  foreach ($s as $row)
		  {
			$selectedCategories[] = $row['categoryID'];
		  }
		  
		  if(isset($selectedCategories))
		  {
			  
			return $selectedCategories;  
		  }
	  
		 return false;
		
	}
	
	
	public function get_requests()
	{
	   include DATABASE;
	 
	 
		try
		{
		  $result = $pdo->query('SELECT ID, title FROM support_queries ORDER BY title ASC');
		 
		}
		catch (PDOException $e)
		{
		  return false;
		  
		}
		
		
		
		//$authors = '';
	    foreach ($result as $row)
		{
		  //$authors[] = $row;
		  $requests[] = array('ID' => $row['ID'], 'title' => $row['title']);
		}

		if(isset($requests))
		{
		 return $requests;
		}
		
		return $requests;

	}
	
	//UPDATE POST
	public function update_request($updateInfo)
	{
	 include DATABASE;
    
	  try
	  {
		$sql = 'UPDATE support_queries SET
			support_queries.content = :content, 
			support_queries.title = :title, 
			support_queries.status = :status, 
			support_queries.lastUpdated = CURRENT_TIMESTAMP()
			WHERE support_queries.ID = :id';
		$s = $pdo->prepare($sql);
		$s->bindValue(':content', $updateInfo['content']);
		$s->bindValue(':title', $updateInfo['title']);
		$s->bindValue(':status', $updateInfo['status']);
		$s->bindValue(':id', $updateInfo['reqId']);
		$s->execute();
		
	  }
	  catch (PDOException $e)
	  {
		$error = 'Error updating request details.';
	    include CMS_ERROR;
		//return false;
		exit();
	  }
	  
	 
	  $catsFlag = $this->removeRequestCategories($updateInfo['reqId']);
	  
	  try
		{
		  $sql = 'INSERT INTO request_categories_lookup SET
			  categoryID = :categoryID,
			  requestID = :reqID';
		  $s = $pdo->prepare($sql);
		  
		 // var_dump($recipeData['seasonCats']);

		  foreach ($updateInfo['reqCats'] as $categoryId)
		  {
			$s->bindValue(':reqID', $updateInfo['reqId']);
			$s->bindValue(':categoryID', $categoryId);
			$s->execute();
		  }
		}
		catch (PDOException $e)
		{
		  $error = 'Error inserting request categories into request_categories_lookup.';
		  include CMS_ERROR;
		  exit();
		}

	  return true;
	 
	  
	}
	
	public function removeRequestCategories($reqRef)
	{
		
	  include DATABASE;
	  
	  try
	  {
		$sql = 'DELETE FROM request_categories_lookup WHERE requestID = :reqId';
		$s = $pdo->prepare($sql);
		$s->bindValue(':reqId', $reqRef);
		$s->execute();
	  }
	  catch (PDOException $e)
	  {
		$error = 'Error removing obsolete request category entries.';
		include CMS_ERROR;
		exit();
	  }
	  
	  return true;
		
	}

	public function add_request($requestData) {
  
		include DATABASE;
		
		  try
		  {
			$sql = 'INSERT INTO support_queries SET
				title = :reqTitle,
				content = :reqContent,
				dateAdded =  CURRENT_TIMESTAMP()';
				
			$s = $pdo->prepare($sql);
			$s->bindValue(':reqTitle', $requestData['requestTitle']);
			$s->bindValue(':reqContent', $requestData['requestContent']);
			$s->execute();
		  }
		  catch (PDOException $e)
		  {
			$error = 'Error adding request.';
			include CMS_ERROR;
			exit();
		  }
		  
		   $reqId = $pdo->lastInsertId();
		   
		  //Insert into post categories lookup
			try
			{
			  $sql = 'INSERT INTO request_categories_lookup SET
				  categoryID = :categoryID,
				  requestID = :reqID';
			  $s = $pdo->prepare($sql);
			  
			  foreach ($requestData['requestCats'] as $categoryId)
			  {
				$s->bindValue(':reqID', $reqId);
				$s->bindValue(':categoryID', $categoryId);
				$s->execute();
			  }
			}
			catch (PDOException $e)
			{
			  $error = 'Error inserting request categories into request_categories_lookup.';
			  include CMS_ERROR;
			  exit();
			}
		  return $reqId ;
	}
	
	
	
	//Delete post
	public function delete_request($reqRef)
	{
		include DATABASE; 
		  try
		  {
			$sql = 'DELETE FROM support_queries WHERE ID = :id';
			$s = $pdo->prepare($sql);
			$s->bindValue(':id', $reqRef);
			$s->execute();
		  }
			
		  catch (PDOException $e)
		  {
			$error = 'Error deleting request.';
			include CMS_ERROR;
			return false;
			exit();
		  }
		  
		$catsFlag = $this->removeRequestCategories($reqRef);
		  
		return true;

	}
	
	
}