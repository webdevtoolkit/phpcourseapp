<div class="col-md-2">

 <h3>Modules</h3>
   <ul class="sidebar-nav">
        <?php foreach ($navSideArray as $navLink): ?> 
				<li><a  href="<?php echo PARENT_URL.$navLink['urlSegment']; ?>"><?php echo $navLink['label']; ?></a></li>
		<?php endforeach; ?>
      </ul>


</div>