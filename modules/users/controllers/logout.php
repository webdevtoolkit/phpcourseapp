<?php

	if($_GET['action'] == 'logout')
	{
		echo "This is logout!";
	    session_start();
		unset($_SESSION['loggedIn']);
		unset($_SESSION['username']);
		unset($_SESSION['password']);
		header('Location: ' . $_GET['goHome']);
		 
		exit();
	 
		
	}


?>