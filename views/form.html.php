<div class="container-fluid">
<div class="col-md-10">
    <h2><?php htmlout($pageTitle); ?></h2>

	
	
    <form action="?<?php htmlout($action); ?>" method="post">
	 <ul>
	 
      <li class="form-group">
        <label for="postTitle">Title: <input class="form-control" type="text" name="requestTitle"
            id="postTitle" value="<?php htmlout($requestTitle ); ?>"></label>
      </li>
	   
	  
	 
	   
	   <li class="textAreaSection"><label for="text">Content:</label>
        <textarea class="postContent editme" id="requestContent" name="requestContent" rows="8" cols="40"><?php
          echo $requestContent; ?></textarea>
	  </li>
      
     
	  
	  </ul>
	  
	  <label for="status">Status:
        <select name="status" id="status">
		<?php $arrlength = count($pageStatus );?>
          <option value="">Select one</option>
          <?php for($x = 0; $x < $arrlength; $x++): ?>
            <option value="<?php htmlout($pageStatus[$x]); ?>"
			<?php if ($pageStatus[$x] == $status)
                {
                  echo 'selected';
                }
			?>>
			<?php htmlout($pageStatus[$x]); ?>
			</option>
			
		   <?php endfor; ?>
          
        </select>
		</label>
	  
	  <?php if($categoriesList) : ?>
	   <fieldset>
	   <legend>Categories</legend>
	   <ul>
	   <?php foreach ($categoriesList as $category): ?>
          <li><label for="category<?php htmlout($category['id']);
              ?>"><input type="checkbox" name="requestCats[]"
              id="category<?php htmlout($category['id']); ?>"
              value="<?php htmlout($category['id']); ?>"<?php
              if ($category['selected'])
              {
                echo 'checked';
              }
              ?>><?php htmlout($category['category']); ?></label></li>
        <?php endforeach; ?>
	   </ul>
	   <?php else : ?>
			 <p> No categories yet </p>
	   <?php endif ?>
	 </fieldset>
	 <ul>
	 <li class="form-group">
        <input type="hidden" name="id" value="<?php
            htmlout($id); ?>">
        <input  class="btn btn-default" type="submit" value="<?php htmlout($button); ?>">
      </li>
	</ul>
    </form>
</div>
</div>
	

