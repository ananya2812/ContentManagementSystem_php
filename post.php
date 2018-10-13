<?php
include "includes/header.php";
include "includes/navigation.php";
?>
<!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

            <?php

            if(isset($_GET['p_id'])){
                $post_id = $_GET['p_id'];

                $update_view_query = "UPDATE posts SET post_view_count = post_view_count + 1 WHERE post_id = '{$post_id}'";
                $send_query = mysqli_query($connection,$update_view_query);

                if(!$send_query){
                    die('QUERY_FAILED'.mysqli_error($connection));
                }

                if(isset($_SESSION['user_role']) && ($_SESSION['user_role'] == 'Admin')){
                    $query = "SELECT * FROM posts where post_id = $post_id";
                }else{
                    $query = "SELECT * FROM posts where post_id = $post_id AND post_status = 'Published'";
                }
                
                $select_all_posts_query = mysqli_query($connection,$query);

                if(mysqli_num_rows($select_all_posts_query) < 1){
                     echo "<h1 class='text-center'>No Posts Available</h1>";
                }else{

                        while($row = mysqli_fetch_assoc($select_all_posts_query)){
                                $post_title = $row['post_title'];
                                $post_author = $row['post_author'];
                                $post_date = $row['post_date'];
                                $post_image = $row['post_image'];
                                $post_content = $row['post_content'];

                            }
                    ?> 
                
                <!-- First Blog Post -->
                <h2>
                    <a href="#"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                <hr>
                <p><?php echo $post_content ?></p>
                <hr>

            <?php    
                    include "includes/comments.php";
                     }
                }else{
                       
                        header("Location: index.php");
                    }
                    
                   
            ?>

                
            </div>

<?php
include "includes/sidebar.php"
?>  

        </div>
        <!-- /.row -->

        <hr>

<?php
include "includes/footer.php"
?>     