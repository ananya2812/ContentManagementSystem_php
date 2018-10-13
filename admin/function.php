<?php

function userOnline(){
        global $connection;
        $session = session_id();
        $time = time();
        $time_out_in_seconds = 60;
        $time_out =  $time - $time_out_in_seconds;

        $query = "SELECT * FROM users_online WHERE session = '$session'";
        $send_query= mysqli_query($connection,$query);
        $count = mysqli_num_rows($send_query);
        if($count == NULL){
            mysqli_query($connection,"INSERT INTO users_online(time,session) VALUES ('$time','$session')");
        }else{
            mysqli_query($connection,"UPDATE users_online SET time ='$time' WHERE session ='$session'");
        }

        $users_online = mysqli_query($connection,"SELECT * FROM users_online WHERE time >'$time_out'");
        return mysqli_num_rows($users_online); 
    
}


function insertCategories(){
	global $connection;
	 if(isset($_POST["submit"])){
            $catTitle = $_POST['cat_title'];
            if($catTitle =='' || empty($catTitle)){
                echo "This field should not be empty";
            }else{
                $query = "INSERT INTO categories(cat_title) VALUES ('{$catTitle}')";
                $create_category_query = mysqli_query($connection,$query);

                if(!$create_category_query){
                die('QUERY_FAILED'.mysqli_error($connection));
                }
            }
        }
}

function findAllCategories(){
	global $connection;
        $query = "SELECT * FROM categories";
        $select_categories_sidebar = mysqli_query($connection,$query);
        while($row = mysqli_fetch_assoc($select_categories_sidebar)){
        $cat_title = $row['cat_title'];
        $cat_id = $row['cat_id'];
        echo "<tr>";
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete ?')\"href='categories.php?delete={$cat_id }'>DELETE</a></td>";
        echo "<td><a href='categories.php?edit={$cat_id }'>EDIT</a></td>";
        echo "</tr>";
        }
}

function deleteCategories(){
	global $connection;
	if(isset($_GET['delete'])){
        $catId= $_GET['delete'];
        $query = "DELETE FROM  categories WHERE cat_id = {$catId}";
        $delete_category_query = mysqli_query($connection,$query);
                            
        if(!$delete_category_query){
            die('QUERY_FAILED'.mysqli_error($connection));
        }

        header("Location: categories.php");
    }
}

function findAllPosts(){
    global $connection;
        $query = "SELECT * FROM posts";
        $select_posts = mysqli_query($connection,$query);
        while($row = mysqli_fetch_assoc($select_posts)){
        $post_id = $row['post_id'];
        $post_author = $row['post_author'];
        $post_title = $row['post_title'];
        $post_category = $row['post_category_id'];
        $post_status= $row['post_status'];
        $post_image = $row['post_image'];
        $post_tags = $row['post_tags'];
        $post_comments = $row['post_comments'];
        $post_date = $row['post_date'];
        echo "<tr>";
        echo "<td>{$post_id}</td>";
        echo "<td>{$post_author}</td>";
        echo "<td>{$post_title}</td>";
        echo "<td>{$post_category}</td>";
        echo "<td>{$post_status}</td>";
        echo "<td><img width=100 src='../images/{$post_image}' alt='Sorry'></td>";
        echo "<td>{$post_tags}</td>";
        echo "<td>{$post_comments}</td>";
        echo "<td>{$post_date}</td>";
        echo "</tr>";
        }

}

function confirm($query_result){ 
    global $connection;  
        if(!$query_result){
            die('QUERY_FAILED'.mysqli_error($connection));
        }
}

function countPost(){
    global $connection;
    $query = "SELECT * FROM posts";
    $select_posts_query = mysqli_query($connection,$query);
    $post_count = mysqli_num_rows($select_posts_query);
    return $post_count;
}

function countComment(){
    global $connection;
    $query = "SELECT * FROM comments";
    $select_comments_query = mysqli_query($connection,$query);
    $comment_count = mysqli_num_rows($select_comments_query);
    return $comment_count;
}

function countUser(){
    global $connection;
    $query = "SELECT * FROM users";
    $select_users_query = mysqli_query($connection,$query);
    $user_count = mysqli_num_rows($select_users_query);
    return $user_count;
}

function countCategory(){
    global $connection;
    $query = "SELECT * FROM categories";
    $select_category_query = mysqli_query($connection,$query);
    $category_count = mysqli_num_rows($select_category_query);
    return $category_count;
}

function countDraftPost(){
    global $connection;
    $query = "SELECT * FROM posts WHERE post_status = 'Draft'";
    $select_posts_query = mysqli_query($connection,$query);
    $draft_post_count = mysqli_num_rows($select_posts_query);
    return $draft_post_count;
}

function countPublishedPost(){
    global $connection;
    $query = "SELECT * FROM posts WHERE post_status = 'Published'";
    $select_posts_query = mysqli_query($connection,$query);
    $publish_post_count = mysqli_num_rows($select_posts_query);
    return $publish_post_count;
}

function countUnapprovedComment(){
    global $connection;
    $query = "SELECT * FROM comments WHERE comment_status = 'Unapproved'";
    $select_comments_query = mysqli_query($connection,$query);
    $unapproved_comment_count = mysqli_num_rows($select_comments_query);
    return $unapproved_comment_count;
}

function countSubscribers(){
    global $connection;
    $query = "SELECT * FROM users WHERE user_role = 'Subscriber'";
    $select_users_query = mysqli_query($connection,$query);
    $subscriber_count = mysqli_num_rows($select_users_query);
    return $subscriber_count;
}

function is_Admin($username = ''){
    global $connection;
    $query = "SELECT user_role FROM users WHERE username = '$username'";
    $result = mysqli_query($connection,$query);
    confirm($result);
    $row = mysqli_fetch_array($result);
    return ($row['user_role']=='Admin')? true : false;
}
?>