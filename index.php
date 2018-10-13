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
            $offset = 3;
            $page = isset($_GET['page'])? $_GET['page']:1;
            $page_limit = ($page == 1) ? 0 : (($page*$offset)-$offset);

            if(isset($_SESSION['user_role']) && ($_SESSION['user_role'] == 'Admin')){
                    $postquerycount = "SELECT * FROM posts";
            }else{
                    $postquerycount = "SELECT * FROM posts WHERE post_status='Published'";
            }

            $find_count = mysqli_query($connection,$postquerycount);
            $count = mysqli_num_rows($find_count);
            if($count<1){
                echo "<h1 class='text-center'>No Posts Available</h1>";
            }else{
                    $count = ceil($count/$offset);

                    if(isset($_SESSION['user_role']) && ($_SESSION['user_role'] == 'Admin')){
                        $query = "SELECT * FROM posts LIMIT $page_limit,$offset";
                    }else{
                         $query = "SELECT * FROM posts WHERE post_status='Published' LIMIT $page_limit,$offset";
                    }


                   
                    $select_all_posts_query = mysqli_query($connection,$query);
                    
                    while($row = mysqli_fetch_assoc($select_all_posts_query)){
                            $post_id = $row['post_id'];
                            $post_title = $row['post_title'];
                            $post_author = $row['post_author'];
                            $post_date = $row['post_date'];
                            $post_image = $row['post_image'];
                            $post_content = substr($row['post_content'],0,100);

            ?>    
                
                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id ;?>"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                    by <a href="author_posts.php?author=<?php echo $post_author; ?>&p_id=<?php echo $post_id ;?>"><?php echo $post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
                <hr>

                <a href="post.php?p_id=<?php echo $post_id ;?>">
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                </a>

                <hr>
                <p><?php echo $post_content ?></p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id ;?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                <hr>
                
            <?php 
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
        <ul class="pager">
            <?php
                for($i=1;$i<=$count;$i++){
                    if($i == $page){
                        echo "<li><a style='background : #000 !important;' href='index.php?page={$i}'>{$i}</a></li>";
                     }else{
                        echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
                     }

                }
            ?>
        </ul>

<?php
include "includes/footer.php"
?>     