    
	<?php if(isset($navArray)): ?>
	<nav class="navbar navbar-default">
	<div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">MOF CMS</a>
    </div>
	 <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <?php foreach ($navArray as $navLink): ?> 
				<li><a href="<?php echo PARENT_URL.$navLink['urlSegment']; ?>"><?php echo $navLink['label']; ?></a></li>
		<?php endforeach; ?>
      </ul>

	
		<ul class="nav navbar-nav navbar-right">
		<li>
		
		<form action="<?php echo ADMIN_LOGOUT ?>" method="get">
			 <input type="hidden" name="goHome" value="<?php echo ADMIN_HOME ?>">
			<input type="hidden" name="action" value="logout">
			<input class="btn btn-default navbar-btn" type="submit" value="Log out">
		  
		</form>
		</li>
		</ul>
		</div>
		</div>
		</nav>
	<?php endIf ?>