        <form action="" method="post">
                        <div class="form-group">
                            <label for="cat_title">Edit Category</label>  
                            <?php
                                if(isset($_GET['edit'])){
                                    $cat_id = $_GET['edit'];
                                    $query = "SELECT * FROM categories where cat_id = $cat_id";
                                    $select_categories_sidebar = mysqli_query($connection,$query);
                                    while($row = mysqli_fetch_assoc($select_categories_sidebar)){
                                        $cat_title = $row['cat_title'];
                                        $cat_id = $row['cat_id'];
                            ?>
                                    <input value="<?php if(isset($cat_title)){echo $cat_title;} ?>" type="text" class="form-control" name="cat_title">            
                               
                            <?php            
                                } 
                            }
                            ?>  

                            <?php  
                             if(isset($_POST['update_category'])){
                                $postcatTitle = $_POST['cat_title'];
                                $query = "UPDATE categories SET cat_title = '{$postcatTitle}' WHERE cat_id = {$catId}";
                                $update_category_query = mysqli_query($connection,$query);
                                if(!$update_category_query){
                                    die('QUERY_FAILED'.mysqli_error($connection));
                                }
                                header("Location: categories.php");
                             }
                        ?>


                        </div>
                        <div class="form-group">
                            <input class ="btn btn-primary" type="submit" name="update_category" value="Update Category">
                        </div>
                        </form>