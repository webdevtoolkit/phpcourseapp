<div class="container-fluid">


<div class="col-md-10">
    <h2><?php htmlout($pageTitle); ?></h2>
    <form action="?<?php htmlout($action); ?>" method="post">
	 <ul>
      <li class="form-group">
        <label for="name">Name: <input class="form-control" type="text" name="name"
            id="name" value="<?php htmlout($name); ?>"></label>
      </li>
      <li class="form-group">
        <label for="email">Email: <input class="form-control" type="text" name="email"
            id="email" value="<?php htmlout($email); ?>"></label>
      </li>
	  <li>
        <label for="username">Username: <input class="form-control" type="text" name="username"
            id="username" value="<?php htmlout($login); ?>"></label>
      </li>
	  <li class="form-group">
        <label for="password">Password: <input class="form-control" type="password" name="password"
            id="password" value="<?php htmlout($password); ?>"></label>
      </li>
      <li class="form-group">
        <input type="hidden" name="id" value="<?php
            htmlout($id); ?>">
        <input  class="btn btn-default" type="submit" value="<?php htmlout($button); ?>">
      </li>
	  </ul>
	
    </form>
</div>
</div>
	

