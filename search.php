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

                    if(isset($_POST['submit'])){
                        $search = $_POST['search'];

                        if(isset($_SESSION['user_role']) && ($_SESSION['user_role'] == 'Admin')){
                            $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%'";
                        }else{
                                $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%' AND post_status = 'Published'";
                        }




                        
                        $search_query = mysqli_query($connection,$query);
                        $count = mysqli_num_rows($search_query);
                        if($count == 0){
                            echo "<h3>No Result Found</h3>";
                        }else{
                            while($row = mysqli_fetch_assoc($search_query)){
                                $post_id = $row['post_id'];
                                $post_title = $row['post_title'];
                                $post_author = $row['post_author'];
                                $post_date = $row['post_date'];
                                $post_image = $row['post_image'];
                                $post_content = substr($row['post_content'],0,100);

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
                        <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id ;?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                        <hr>  
            <?php   

                        }
                    }    
  
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