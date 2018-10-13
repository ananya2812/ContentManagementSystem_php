<?php
include "includes/admin_header.php";
include "function.php";
include "includes/admin_navigation.php";


if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    $query = "SELECT * FROM users WHERE username = '{$username}'";
    $select_user_profile_query = mysqli_query($connection,$query);
    while($row = mysqli_fetch_array($select_user_profile_query)){
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email= $row['user_email'];
        $user_role = $row['user_role'];
        $db_password = $row['user_password'];
    }
}
?>

<?php
    if(isset($_POST['update_profile'])){
        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_role = $_POST['user_role'];
        $updated_username = $_POST['username'];
        $user_email = $_POST['user_email'];
        $user_password = $_POST['user_password'];

        if(!empty($user_password)){
            $hashed_password = password_hash($user_password,PASSWORD_BCRYPT,array('cost'=>10));
        }else{
            $hashed_password = $db_password;
        }

        $query = "UPDATE users SET ";
        $query .= "user_firstname = '{$user_firstname}', ";
        $query .= "user_lastname = '{$user_lastname}', ";
        $query .= "user_role = '{$user_role}', ";
        $query .= "username = '{$updated_username}', ";
        $query .= "user_email = '{$user_email}', ";
        $query .= "user_password = '{$hashed_password}' ";
        $query .= " WHERE username = '{$username}'";

        $update_query = mysqli_query($connection,$query);

        confirm($update_query);
               if(isset($updated_username)){
                $_SESSION['username'] = $updated_username ;
               }
    }

?>

    <div id="wrapper">
        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to Admin
                            <small><?php echo $_SESSION['username'];?></small>
                        </h1>

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
                                    if($user_role = 'Admin'){
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
                                <input class="btn btn-primary" type="submit" name="update_profile" value="Update Profile">
                                </div>

</form>
                        
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
<?php include "includes/admin_footer.php"; ?>

   