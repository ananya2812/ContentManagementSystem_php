<?php 
include "db.php";
include "function.php";
session_start(); 


if(isset($_POST['login'])){
	$username = $_POST['username'];
	$password = $_POST['password'];
	$username = mysqli_real_escape_string($connection,$username);
	$password = mysqli_real_escape_string($connection,$password);
	login_user($username,$password);
	
}
?>