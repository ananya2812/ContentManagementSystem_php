<?php

function confirm($query_result){ 
    global $connection;  
        if(!$query_result){
            die('QUERY_FAILED'.mysqli_error($connection));
        }
}

function username_Exsits($username){
	global $connection;
	$queryUser = "SELECT username FROM users WHERE username = '$username'";
	$resultUser = mysqli_query($connection,$queryUser);
	$userCount = mysqli_num_rows($resultUser);
	return ($userCount > 0)? true : false;
}

function email_Exsits($user_email){
	global $connection;
	$queryEmail = "SELECT user_email FROM users WHERE user_email = '$email'";
    $resultEmail = mysqli_query($connection,$queryEmail);
	$emailCount = mysqli_num_rows($resultEmail);
	return ($emailCount > 0)? true : false;
}

function validateUser($username,$email,$password,$error){
	if(strlen($username) < 4){
		$error['username'] = "Username must be 4 characters long";
	}
	if(empty($email)){
		$error['email'] = "Email Cannot be Empty";
	}
	if(username_Exsits($username)){
		$error['username'] = "Username Already Exists";
	}
	if(email_Exsits($email)){
		$error['email'] = "Email Already Exists";
	}
	if(empty($password)){
		$error['password'] = "Password Cannot be Empty";
	}
	return $error;
}

function register_user($username,$email,$password,$firstname,$lastname){
	global $connection;
	$insertQuery = "INSERT INTO users(username,user_email,user_firstname,user_lastname,user_password,user_role) VALUES ";
    $insertQuery .= "('{$username}','{$email}','{$firstname}','{$lastname}','{$password}','Subscriber')";
    $register_user_query = mysqli_query($connection,$insertQuery);
    confirm($register_user_query);
	
}

function login_user($username,$password){
	global $connection;
	$query = "SELECT * FROM users WHERE username = '{$username}'";
	$select_user_query = mysqli_query($connection,$query);
	confirm($select_user_query);
	while($row = mysqli_fetch_array($select_user_query)){
		$db_user_id = $row['user_id'];
		$db_username = $row['username'];
		$db_user_firstname = $row['user_firstname'];
		$db_user_role = $row['user_role'];
		$db_user_password = $row['user_password'];
	}
	if(password_verify($password,$db_user_password)){
		$_SESSION['username'] = $db_username ;
		$_SESSION['firstname'] = $db_user_firstname;
		$_SESSION['user_role'] = $db_user_role;
		if($_SESSION['user_role'] !== 'Admin'){
    		header("Location: http://localhost/cms/index.php");
		}else{
			header("Location: http://localhost/cms/admin");
		}
	}else{
		header("Location: http://localhost/cms/index.php");
	}
}


?>