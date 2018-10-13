<?php
	if(isset($_GET['u_id'])){
		$user_id = $_GET['u_id'];
		$query = "SELECT * FROM users where user_id = $user_id";
        $select_user_by_id = mysqli_query($connection,$query);
        
        while($row = mysqli_fetch_assoc($select_user_by_id)){
	        $user_firstname = $row['user_firstname'];
	        $user_lastname = $row['user_lastname'];
	        $user_email = $row['user_email'];
	        $user_role = $row['user_role'];
	        $username = $row['username'];
	        $db_password = $row['user_password'];

	}
}	

	if(isset($_POST['update_user'])){
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

        // $hashed_password = crypt($user_password,$salt);
        if(!empty($user_password)){
        	$hashed_password = password_hash($user_password,PASSWORD_BCRYPT,array('cost'=>10));
        }else{
        	$hashed_password = $db_password;

        }
        
		$query = "UPDATE users SET ";
		$query .= "user_firstname = '{$user_firstname}', ";
		$query .= "user_lastname = '{$user_lastname}', ";
		$query .= "user_role = '{$user_role}', ";
		$query .= "username = '{$username}', ";
		$query .= "user_email = '{$user_email}', ";
		$query .= "user_password = '{$hashed_password}' ";
		$query .= " WHERE user_id = {$user_id}";

		$update_query = mysqli_query($connection,$query);

		confirm($update_query);

	}

?>
<form action="" method="post" enctype="multipart/form-data">

	<div class="form-group">
	<label for="user_firstname">First Name</label>
	<input value="<?php echo $user_firstname; ?>" type="text" class="form-control" name="user_firstname">
	</div>

	<div class="form-group">
	<label for="user_lastname">Last Name</label>
	<input value="<?php echo $user_lastname; ?>" type="text" class="form-control" name="user_lastname">
	</div>

	<div class="form-group">
	<label for="user_role">User Role</label>
	<select name="user_role" id="">
		<option value="<?php echo $user_role ?>"><?php echo $user_role ?></option>
		<?php
		if($user_role == 'Admin'){
			echo "<option value='Subscriber'>Subscriber</option>";
		}else{
			echo "<option value='Admin'>Admin</option>";
		}
		?>
	</select>
	</div>

	<div class="form-group">
	<label for="username">Username</label>
	<input value="<?php echo $username; ?>" type="text" class="form-control" name="username">
	</div>

	<div class="form-group">
	<label for="user_email">Email</label>
	<input value="<?php echo $user_email; ?>" type="email" class="form-control" name="user_email">
	</div>

	<div class="form-group">
	<label for="user_password">Password</label>
	<input autocomplete="off" type="password" class="form-control" name="user_password">
	</div>
	
	<div class="form-group">
	<input class="btn btn-primary" type="submit" name="update_user" value="Update User">
	</div>

</form>