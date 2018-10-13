
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Author</th>
                                    <th>Comment</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>In Response To</th>
                                    <th>Date</th>
                                    <th>Approve</th>
                                    <th>Unapprove</th>
                                    <th>Delete</th>
                                </tr>
                                <tbody>

                                <?php
                                    $query = "SELECT * FROM comments";
                                    $select_comments = mysqli_query($connection,$query);
                                    while($row = mysqli_fetch_assoc($select_comments)){
                                    $comment_id = $row['comment_id'];
                                    $comment_post_id = $row['comment_post_id'];
                                    $comment_author = $row['comment_author'];
                                    $comment_email = $row['comment_email'];
                                    $comment_content = $row['comment_content'];
                                    $comment_status= $row['comment_status'];
                                    $comment_date = $row['comment_date'];
                                    
                                    echo "<tr>";
                                    echo "<td>{$comment_id}</td>";
                                    echo "<td>{$comment_author}</td>";
                                    echo "<td>{$comment_content}</td>";
                                    echo "<td>{$comment_email}</td>";
                                    echo "<td>{$comment_status}</td>";
                                    $query = "SELECT * FROM posts where post_id = $comment_post_id";
                                    $select_categories_sidebar = mysqli_query($connection,$query);
                                    while($row = mysqli_fetch_assoc($select_categories_sidebar)){
                                        $post_title = $row['post_title'];
                                        $post_id = $row['post_id'];
                                    }    
                                    echo "<td><a href='../post.php?p_id=$post_id'</a>$post_title</td>";
                                    echo "<td>{$comment_date}</td>";
                                    echo "<td><a href='comments.php?approve={$comment_id }'>Approve</a></td>";
                                    echo "<td><a href='comments.php?unapprove={$comment_id }'>Unapprove</a></td>";
                                    echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete ?')\" href='comments.php?delete={$comment_id }'>DELETE</a></td>";
                                    echo "</tr>";
                                    }

                                ?>
                                </tbody>
                            </thead>
                        </table>


<?php

if(isset($_GET['approve'])){
    $commentId= $_GET['approve'];
    $query = "UPDATE comments SET comment_status = 'Approved' WHERE comment_id = {$commentId}";
    $approve_category_query = mysqli_query($connection,$query);
    confirm($approve_category_query);   
    header("Location: comments.php");
}

if(isset($_GET['unapprove'])){
    $commentId= $_GET['unapprove'];
    $query = "UPDATE comments SET comment_status = 'Unapproved' WHERE comment_id = {$commentId}";
    $unapprove_category_query = mysqli_query($connection,$query);
    confirm($unapprove_category_query);   
    header("Location: comments.php");
}

if(isset($_GET['delete'])){
    $commentId= $_GET['delete'];
    $query = "DELETE FROM  comments WHERE comment_id = {$commentId}";
    $delete_category_query = mysqli_query($connection,$query);
    confirm($delete_category_query);   
    header("Location: comments.php");
}
?>