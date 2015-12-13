<div class="container-fluid">

<div class="col-md-10">
<h2>Manage Users</h2>
    <p><a href="?add">Add new user</a></p>
	<?php if($users) : ?>
    <ul>
      <?php foreach ($users as $user): ?>
        <li>
          <form action="" method="post">
            <div>
              <?php htmlout($user['name']); ?>
              <input type="hidden" name="id" value="<?php
                  echo $user['id']; ?>">
              <input type="submit" class="btn btn-default" name="action" value="Edit">
              <input type="submit" class="btn btn-default" name="action" value="Remove user">
            </div>
          </form>
        </li>
      <?php endforeach; ?>
	  <?php else : ?>
	     <p> No users yet </p>
	  <?php endif ?>
    </ul>
    <p><a href="..">Return to CPR Helpdesk Home</a></p>
   </div>
</div>	


