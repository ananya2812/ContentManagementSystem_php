<?php

include("delete_modal.php");

if(isset($_POST['checkBoxArray'])){
    foreach($_POST['checkBoxArray'] as $postValueId){
        $bulk_options = $_POST['bulk_options'];
        switch($bulk_options){
            case 'Published':
            $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId}";
            $update_to_publish_post = mysqli_query($connection,$query);
            confirm($update_to_publish_post);
            break;
            case 'Draft':
            $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId}";
            $update_to_draft_post = mysqli_query($connection,$query);
            confirm($update_to_draft_post);
            break;
            case 'Clone':
            $query = "SELECT * FROM posts WHERE post_id = {$postValueId}";
            $select_post = mysqli_query($connection,$query);
            while($row = mysqli_fetch_assoc($select_post)){
                $post_title = $row['post_title'];
                $post_category_id = $row['post_category_id'];
                $post_author = $row['post_author'];
                $post_status = $row['post_status'];
                $post_tags = $row['post_tags'];
                $post_image = $row['post_image'];
                $post_content = $row['post_content'];
                $post_date = $row['post_date'];

            }

            $insert_query = "INSERT INTO posts(post_category_id,post_title,post_author,post_status,post_image,post_content,post_date,post_tags)
             VALUES({$post_category_id},'{$post_title}','{$post_author}','{$post_status}','{$post_image}','$post_content','{$post_date}','{$post_tags}')";
            $clone_post = mysqli_query($connection,$insert_query);
            confirm($clone_post);
            break;

            case 'Delete':
            $query = "DELETE FROM posts WHERE post_id = {$postValueId}";
            $delete_post = mysqli_query($connection,$query);
            confirm($delete_post);
            break;
        }
    }
}

?>

<form action="" method="post">

<div id="bulkOptionsContainer" class="col-xs-4">
<select class="form-control" name="bulk_options" id="">
    <option value="">Select an Option</option>
    <option value="Published">Published</option>
    <option value="Draft">Draft</option>
    <option value="Clone">Clone</option>
    <option value="Delete">Delete</option>
</select>
<br>
</div>

<div class="col-xs-4">
<input type="submit" name="submit" class="btn btn-success" value="Apply">
<a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
<br>
</div>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th><input id="selectAllBoxes" type="checkbox"></th>
                                    <th>Id</th>
                                    <th>Author</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Image</th>
                                    <th>Tags</th>
                                    <th>Comments</th>
                                    <th>View Count</th>
                                    <th>Date</th>
                                    <th>View</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                <tbody>

                                <?php
                                    $query = "SELECT * FROM posts ORDER BY post_id DESC ";
                                    $select_posts = mysqli_query($connection,$query);
                                    while($row = mysqli_fetch_assoc($select_posts)){
                                    $post_id = $row['post_id'];
                                    $post_author = $row['post_author'];
                                    $post_title = $row['post_title'];
                                    $post_category = $row['post_category_id'];
                                    $post_status= $row['post_status'];
                                    $post_image = $row['post_image'];
                                    $post_tags = $row['post_tags'];
                                    $post_date = $row['post_date'];
                                    $post_view_count = $row['post_view_count'];
                                    echo "<tr>";
                                    ?>
                                    <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $post_id ;?>'></td>
                                    <?php
                                    echo "<td>{$post_id}</td>";
                                    echo "<td>{$post_author}</td>";
                                    echo "<td>{$post_title}</td>";

                                    $query = "SELECT * FROM categories where cat_id = $post_category";
                                    $select_categories_sidebar = mysqli_query($connection,$query);
                                    while($row = mysqli_fetch_assoc($select_categories_sidebar)){
                                        $cat_title = $row['cat_title'];
                                    }    
                                    
                                    echo "<td>{$cat_title}</td>";
                                    echo "<td>{$post_status}</td>";
                                    echo "<td><img width=100 src='../images/{$post_image}' alt='No image available'></td>";
                                    echo "<td>{$post_tags}</td>";

                                    $query = "SELECT * FROM comments WHERE comment_post_id = {$post_id} ";
                                    $query .= " AND comment_status = 'approved' ";
                                    $select_comment_query = mysqli_query($connection,$query);
                                    $commentCount = mysqli_num_rows($select_comment_query);

                                    echo "<td>{$commentCount}</td>";
                                    echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to reset view count ?')\" href='posts.php?reset={$post_id }'>{$post_view_count}</a></td>";
                                    echo "<td>{$post_date}</td>";
                                    
                                    echo "<td><a class='btn btn-primary' href='../post.php?p_id={$post_id}'>View</a></td>";
                                    
                                    echo "<td><a class='btn btn-info' href='posts.php?source=edit_post&p_id={$post_id }'>Edit</a></td>";
                                    
                                    echo "<td><a rel='$post_id' href='javascript:void(0)' class='btn btn-danger delete_link'>DELETE</a></td>";
                                    
                                    // echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete ?')\" href='posts.php?delete={$post_id }'>DELETE</a></td>";
                                    
                                    echo "</tr>";
                                    }

                                ?>







                                </tbody>
                            </thead>
                        </table>
</form>                        


<?php
if(isset($_GET['delete'])){
    $postId = $_GET['delete'];
    $query = "DELETE FROM  posts WHERE post_id = {$postId}";
    $delete_category_query = mysqli_query($connection,$query);
    confirm($delete_category_query);   
    header("Location: posts.php");
}

if(isset($_GET['reset'])){
    $postId= $_GET['reset'];
    $query = "UPDATE posts SET post_view_count = 0 WHERE post_id = '{$postId}'";
    $reset_view_query = mysqli_query($connection,$query);
    confirm($reset_view_query);   
    header("Location: posts.php");
}
?>

<script>
    $(document).ready(function(){

        $(".delete_link").on('click',function(){
            var id = $(this).attr('rel');
            var delete_url = "posts.php?delete="+id+"";
            $(".modal_delete_link").attr("href",delete_url);
            $("#myModal").modal("show");
        });

    });
    
</script>