<!-- Blog Comments -->

<?php
    if(isset($_POST['create_comment'])){
        $comment_post_id = $_GET['p_id'];
        $comment_author = $_POST['comment_author'];
        $comment_email = $_POST['comment_email'];
        $comment_content = $_POST['comment_content'];

        $query = "INSERT INTO comments(comment_post_id,comment_author,comment_email,comment_content,comment_status,comment_date) ";
        $query .= "VALUES($comment_post_id,'{$comment_author}','{$comment_email}','$comment_content' ,'Unapproved',now())";

        $create_comment_query = mysqli_query($connection,$query);
        if(!$create_comment_query){
            die('QUERY_FAILED'.mysqli_error($connection));
        }
        
        // $update_query = "UPDATE posts SET post_comment_count=post_comment_count+1 WHERE post_id = $comment_post_id";
        // $update_post_query = mysqli_query($connection,$update_query);

        // if(!$update_post_query){
        //     die('QUERY_FAILED'.mysqli_error($connection));
        // }
    }
?>

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form role="form" action="" method="POST">
                        <div class="form-group">
                            <label for="author">Author</label>
                            <input type="text" class="form-control" name="comment_author" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="comment_email" required>
                        </div>
                        <div class="form-group">
                            <label for="comment">Comment</label>
                            <textarea name="comment_content" class="form-control" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" name="create_comment">Submit</button>
                    </form>
                </div>



                <hr>

                <!-- Posted Comments -->

                <?php
                $comment_post_id = $_GET['p_id'];
                $query = "SELECT * FROM comments WHERE comment_post_id = {$comment_post_id} ";
                $query .= " AND comment_status = 'approved' ";
                $query .= " ORDER BY comment_id DESC ";
                $select_comment_query = mysqli_query($connection,$query);
                if(!$select_comment_query){
                    die('QUERY_FAILED'.mysqli_error($connection));
                }
                while($row = mysqli_fetch_array($select_comment_query)){
                    $comment_date = $row['comment_date'];
                    $comment_author = $row['comment_author'];
                    $commment_content = $row['comment_content'];

                ?>
                    <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_author; ?>
                            <small><?php echo $comment_date; ?></small>
                        </h4>
                            <?php echo $commment_content; ?>
                    </div>
                </div>
                <?php
                }
                ?>

                