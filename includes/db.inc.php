<?php
	try
	{
	  $pdo = new PDO('mysql:host=localhost;dbname=db_name', 'db_username', 'db_password');
	  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	  $pdo->exec('SET NAMES "utf8"');
	}
	catch (PDOException $e)
	{
	  $system_error = "\n" . "ERROR: Date: " . date("d/m/Y") . " " . date("h:i:sa") . ", Unable to connect to the database server." . $e;
	  //Write system error to logfile
	  $error_log = fopen("logs/log.txt", "a") or die("Unable to open file.");
	  fwrite($error_log, $system_error);
	  fclose($error_log);
	  
	  $error = 'Unable to connect to the database server.';
	  include $_SERVER['DOCUMENT_ROOT'] . 'helpdesk/views/error.html.php';
	  exit();
	}
?>
