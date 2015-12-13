<div class="container-fluid">
<div class="col-md-10">
	
	<h2>Manage Requests</h2>
		<p><a href="?add">Add new request</a></p>
		<?php if(isset($requestsList)) : ?>
		<ul class="requests">
		  <?php foreach ($requestsList as $request): ?>
			<li>
			  <form action="" method="post">
				<div>
				  <?php htmlout($request['title']); ?>
				  <input type="hidden" name="id" value="<?php
					  echo $request['id']; ?>">
				  <input type="submit" class="btn btn-default" name="action" value="Edit">
				  <input type="submit" class="btn btn-default" name="action" value="Remove request">
				</div>
			  </form>
			</li>
		  <?php endforeach; ?>
		  <?php else : ?>
			 <p> No requests yet </p>
		  <?php endif ?>
		</ul>
	 </div>
</div>	


