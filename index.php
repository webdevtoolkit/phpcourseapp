<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>CyberCPR Helpdesk</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->
        <link rel="stylesheet" type="text/css" href="/helpdesk/css/layout.css">
		
		
        <script src="js/vendor/modernizr-2.8.3.min.js"></script>
    </head>
    <body>
	  <div class="page-header">
		  <header class="container-fluid">	
			<h1>CyberCPR Helpdesk</h1>
				
		  </header>
	  </div>

<?php 
	define("LOGIN", $_SERVER['DOCUMENT_ROOT']."/helpdesk/modules/users/views/login.html.php");
	require_once $_SERVER['DOCUMENT_ROOT'] . "/helpdesk/includes/access.inc.php";
?>

	<?php if (!userIsLoggedIn()):
		include LOGIN;
		exit();
	else: ?>
		<a href="controllers/">Helpdesk</a>
	<?php endif; ?></body><div class="container-fluid footer">

&copy<?php echo date("Y"); ?> Logically Secure 
</div>
 <!-- End wrapper-->
</body>
</html>