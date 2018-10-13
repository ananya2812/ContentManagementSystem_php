<?php  
include "includes/header.php";
include "includes/navigation.php";

if(isset($_POST['register'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];

    $username = mysqli_escape_string($connection,$username);
    $email = mysqli_escape_string($connection,$email);
    $password = mysqli_escape_string($connection,$password);
    $encrypt_password = password_hash($password,PASSWORD_BCRYPT,array('cost'=>10));

    $error = [
        'username' => '',
        'email' => '',
        'password' => ''] ;
    $error = validateUser($username,$email,$encrypt_password,$error);

    foreach($error as $key=>$value){
        if(empty($value)){
            unset($error[$key]);
        }
    }

    if(empty($error)){
        register_user($username,$email,$encrypt_password,$firstname,$lastname);
        login_user($username,$password);
    }
}
?>    
    
 
<!-- Page Content -->
<div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Enter Desired Username" autocomplete="on" 
                            value="<?php echo isset($username)? $username : '' ?>" 
                            required>
                            <p><?php echo isset($error['username'])? $error['username'] : '' ?></p>
                        </div>
                         <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="somebody@example.com" autocomplete="on"
                            value="<?php echo isset($email)? $email : '' ?>"required>
                             <p><?php echo isset($error['email'])? $error['email'] : '' ?></p>
                        </div>
                        <div class="form-group">
                            <label for="firstname">First Name</label>
                            <input type="text" name="firstname" class="form-control" placeholder="Enter your first name" autocomplete="on" 
                            value="<?php echo isset($firstname)? $firstname : '' ?>"required>
                        </div>
                        <div class="form-group">
                            <label for="lastname">Last Name</label>
                            <input type="text" name="lastname" class="form-control" placeholder="Enter your Last Name" autocomplete="on" 
                            value="<?php echo isset($lastname)? $lastname : '' ?>"required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                             <p><?php echo isset($error['password'])? $error['password'] : '' ?></p>
                        </div>
                
                        <input type="submit" name="register" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>

<hr>



<?php include "includes/footer.php";?>
