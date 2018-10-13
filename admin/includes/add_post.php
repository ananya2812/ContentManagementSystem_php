<?php
	if(isset($_POST['create_post'])){

		$post_title = $_POST['post_title'];
		$post_category_id = $_POST['post_category_id'];
		$post_author = $_POST['post_author'];
		$post_status = $_POST['post_status'];
		$post_tags = $_POST['post_tags'];

		$post_image = $_FILES['post_image']['name'];
		$post_image_temp = $_FILES['post_image']['tmp_name'];

		$post_content = $_POST['post_content'];
		$postDate = date('d-m-y');
		move_uploaded_file($post_image_temp, "../images/$post_image");

		$query = "INSERT INTO posts(post_category_id,post_title,post_author,post_status,post_image,post_content,post_date,post_tags)
			 VALUES({$post_category_id},'{$post_title}','{$post_author}','{$post_status}','{$post_image}','$post_content',now(),'{$post_tags}')";

		$create_post_query = mysqli_query($connection,$query);
		$new_post_id = mysqli_insert_id($connection);

		confirm($create_post_query);
		echo "<p class='bg-success'>Post Added Successfully. <a href='../post.php?p_id={$new_post_id }'>View Post</a> or <a href='posts.php'>Edit More Post</a></p>";

	}
?>


<form action="" method="post" enctype="multipart/form-data">

	<div class="form-group">
	<label for="title">Post Title</label>
	<input type="text" class="form-control" name="post_title">
	</div>

	<div class="form-group">
	<label for="post_category">Post Category Id</label>
	<select name="post_category_id" id="">
		<?php
		$query = "SELECT * FROM categories";
		$select_categories = mysqli_query($connection,$query);
		confirm($select_categories);
		while($row = mysqli_fetch_assoc($select_categories)){
			$cat_id = $row['cat_id'];
			$cat_title = $row['cat_title'];
			echo "<option value=$cat_id>{$cat_title}</option>";
		}
		?>
	</select>
	</div>

	<div class="form-group">
	<label for="post_author">Post Author</label>
	<input type="text" class="form-control" name="post_author">
	</div>

	<div class="form-group">
	<label for="post_status">Post Tags</label>
	<input type="text" class="form-control" name="post_tags">
	</div>

	<div class="form-group">
	<label for="post_status">Post Status</label>
	<select name="post_status" id="">
	<option value='Draft'>Draft</option>
	<option value='Published'>Published</option>
	</select>
	</div>

	<div class="form-group">
	<label for="post_image">Post Image</label>
	<input type="file" name="post_image">
	</div>

	<div class="form-group">
	<label for="post_content">Post Content</label>
	<textarea class="form-control" id="body" name="post_content" cols="30" rows="10"></textarea>
	</div>
	  
	<div class="form-group">
	<input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
	</div>

	</form>