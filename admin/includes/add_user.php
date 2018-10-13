<?php
	if(isset($_POST['create_user'])){

		$user_firstname = $_POST['user_firstname'];
		$user_lastname = $_POST['user_lastname'];
		$user_role = $_POST['user_role'];
		$username = $_POST['username'];
		$user_email = $_POST['user_email'];
		$user_password = $_POST['user_password'];

		// $query = "SELECT randSalt FROM users ";
  //       $select_randSalt_query = mysqli_query($connection,$query);
  //       if(!$select_randSalt_query ){
  //           die('QUERY_FAILED'.mysqli_error($connection));
  //       }
  //       $row = mysqli_fetch_array($select_randSalt_query);
  //       $salt = $row['randSalt'];

  //      $hashed_password = crypt($user_password,$salt);
		
        $hashed_password = password_hash($user_password,PASSWORD_BCRYPT,array('cost'=>10));
		$query = "INSERT INTO users(user_firstname,user_lastname,user_role,username,user_email,user_password)
			 VALUES('{$user_firstname}','{$user_lastname}','{$user_role}','{$username}','{$user_email}','$hashed_password')";

		$create_user_query = mysqli_query($connection,$query);

		confirm($create_user_query);

		echo "User Created: "." "."<a href='users.php'>View Users</a>";

	}
?>


<form action="" method="post" enctype="multipart/form-data">

	<div class="form-group">
	<label for="title">First Name</label>
	<input type="text" class="form-control" name="user_firstname">
	</div>

	<div class="form-group">
	<label for="post_author">Last Name</label>
	<input type="text" class="form-control" name="user_lastname">
	</div>

	<div class="form-group">
	<label for="user_role">User Role</label>
	<select name="user_role" id="">
		<option value="Subscriber">Select options</option>
		<option value="Admin">Admin</option>
		<option value="Subscriber">Subscriber</option>
	</select>
	</div>

	<div class="form-group">
	<label for="username">Username</label>
	<input type="text" class="form-control" name="username">
	</div>

	<div class="form-group">
	<label for="user_email">Email</label>
	<input type="email" class="form-control" name="user_email">
	</div>

	<div class="form-group">
	<label for="user_password">Password</label>
	<input type="password" class="form-control" name="user_password">
	</div>


	<!-- <div class="form-group">
	<label for="post_image">Post Image</label>
	<input type="file" name="post_image">
	</div> -->


	<div class="form-group">
	<input class="btn btn-primary" type="submit" name="create_user" value="Add User">
	</div>

	</form>