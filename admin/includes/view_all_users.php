
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Username</th>
                                    <th>Firstname</th>
                                    <th>Lastname</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Admin</th>
                                    <th>Subscribe</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                <tbody>

                                <?php
                                    $query = "SELECT * FROM users";
                                    $select_users = mysqli_query($connection,$query);
                                    while($row = mysqli_fetch_assoc($select_users)){
                                    $user_id = $row['user_id'];
                                    $username = $row['username'];
                                    $user_firstname = $row['user_firstname'];
                                    $user_lastname = $row['user_lastname'];
                                    $user_email= $row['user_email'];
                                    $user_role = $row['user_role'];

                                    echo "<tr>";
                                    echo "<td>{$user_id}</td>";
                                    echo "<td>{$username}</td>";
                                    echo "<td>{$user_firstname}</td>";
                                    echo "<td>{$user_lastname}</td>";
                                   
                                    echo "<td>{$user_email}</td>";
                                    echo "<td>{$user_role}</td>";
                                    echo "<td><a href='users.php?change_to_admin={$user_id }'>Admin</a></td>";
                                    echo "<td><a href='users.php?change_to_subscribe={$user_id }'>Subscribe</a></td>";
                                    echo "<td><a href='users.php?source=edit_user&u_id={$user_id }'>EDIT</a></td>";
                                    echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete ?')\" href='users.php?delete={$user_id }'>DELETE</a></td>";
                                    echo "</tr>";
                                    }

                                ?>
                                </tbody>
                            </thead>
                        </table>


<?php
if(isset($_GET['delete']) && ($_SESSION['user_role'] =='Admin')){
    $userId= $_GET['delete'];
    $query = "DELETE FROM  users WHERE user_id = {$userId}";
    $delete_user_query = mysqli_query($connection,$query);
    confirm($delete_user_query);   
    header("Location: users.php");
}

if(isset($_GET['change_to_admin'])){
    $userId= $_GET['change_to_admin'];
    $query = "UPDATE users SET user_role = 'Admin' WHERE user_id = {$userId}";
    $admin_user_query = mysqli_query($connection,$query);
    confirm($admin_user_query);   
    header("Location: users.php");
}

if(isset($_GET['change_to_subscribe'])){
    $userId= $_GET['change_to_subscribe'];
    $query = "UPDATE users SET user_role = 'Subscriber' WHERE user_id = {$userId}";
    $subscriber_user_query = mysqli_query($connection,$query);
    confirm($subscriber_user_query);   
    header("Location: users.php");
}

?>