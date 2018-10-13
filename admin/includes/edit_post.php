<?php
	if(isset($_GET['p_id'])){
		$post_id = $_GET['p_id'];
		$query = "SELECT * FROM posts where post_id = $post_id";
        $select_posts_by_id = mysqli_query($connection,$query);
        
        while($row = mysqli_fetch_assoc($select_posts_by_id)){
	        $post_author = $row['post_author'];
	        $post_title = $row['post_title'];
	        $post_content = $row['post_content'];
	        $post_category = $row['post_category_id'];
	        $post_status= $row['post_status'];
	        $post_image = $row['post_image'];
	        $post_tags = $row['post_tags'];
	        $post_date = $row['post_date'];

	}
}	

	if(isset($_POST['update_post'])){
		$post_title = $_POST['post_title'];
		$post_category = $_POST['post_category'];
		$post_author = $_POST['post_author'];
		$post_status = $_POST['post_status'];
		$post_tags = $_POST['post_tags'];
		$post_image = $_FILES['post_image']['name'];
		$post_image_temp = $_FILES['post_image']['tmp_name'];
		$post_content = $_POST['post_content'];
		move_uploaded_file($post_image_temp, "../images/$post_image");


		if(empty($post_image)){
			$query = "SELECT * FROM posts WHERE post_id = $post_id";
			$select_image = mysqli_query($connection,$query);
			while($row = mysqli_fetch_array($select_image)){
				$post_image = $row['post_image'];
			}	

		}

		$query = "UPDATE posts SET ";
		$query .= "post_title = '{$post_title}', ";
		$query .= "post_category_id = '{$post_category}', ";
		$query .= "post_author = '{$post_author}', ";
		$query .= "post_status = '{$post_status}', ";
		$query .= "post_tags = '{$post_tags}', ";
		$query .= "post_image = '{$post_image}', ";
		$query .= "post_date = now(), ";
		$query .= "post_content = '{$post_content}' ";
		$query .= " WHERE post_id = {$post_id}";

		$update_query = mysqli_query($connection,$query);

		confirm($update_query);

		echo "<p class='bg-success'>Post Updated. <a href='../post.php?p_id={$post_id}'>View Post</a> or <a href='posts.php'>Edit More Post</a></p>";
	}

?>
<form action="" method="post" enctype="multipart/form-data">

	<div class="form-group">
	<label for="title">Post Title</label>
	<input value="<?php echo $post_title; ?>" type="text" class="form-control" name="post_title">
	</div>


	<div class="form-group">
	<label for="post_author">Post Author</label>
	<input value="<?php echo $post_author; ?>" type="text" class="form-control" name="post_author">
	</div>

	<div class="form-group">
	<label for="post_category">Post Category</label>
	<select name="post_category" id="">	
	<?php
		$query = "SELECT * FROM categories";
		$select_post_category = mysqli_query($connection,$query);
		confirm($select_post_category);
		while($row = mysqli_fetch_assoc($select_post_category)){
			$post_cat_id = $row['cat_id'];
			$post_cat_title = $row['cat_title'];
			if($post_cat_id == $post_category){
				echo "<option selected value=$post_cat_id >{$post_cat_title}</option>";
			}else{
				echo "<option value=$post_cat_id>{$post_cat_title}</option>";
			}
			
		}
		
	?>		
	</select>
	</div>

	<div class="form-group">
	<label for="post_status">Post Tags</label>
	<input value="<?php echo $post_tags; ?>" type="text" class="form-control" name="post_tags">
	</div>


	<div class="form-group">
	<label for="post_status">Post Status</label>
	<select name="post_status" id="">
		<option value="<?php echo $post_status; ?>"><?php echo $post_status ?></option>
		<?php
		if($post_status == 'Draft'){
			echo "<option value='Published'>Published</option>";
		}else{
			echo "<option value='Draft'>Draft</option>";
		}
		?>
	</select>
	</div>

	<div class="form-group">
	<img src="../images/<?php echo $post_image; ?>" alt="" >
	<input type="file" name="post_image">
	</div>

	<div class="form-group">
	<label for="post_content">Post Content</label>
	<textarea class="form-control" name="post_content" id="body" cols="30" rows="10"><?php echo $post_content;?>
	</textarea>
	</div>

	<div class="form-group">
	<input class="btn btn-primary" type="submit" name="update_post" value="Update Post">
	</div>

</form>
