<?php
include "includes/admin_header.php";
include "function.php";
include "includes/admin_navigation.php";

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

                        <div class="col-xs-6">
                        <?php 
                        insertCategories(); 
                        deleteCategories();  
                        ?>

                        <form action="" method="post">
                        <div class="form-group">
                            <label for="cat_title">Add Category</label>
                            <input type="text" class="form-control" name="cat_title">
                        </div>
                        <div class="form-group">
                            <input class ="btn btn-primary" type="submit" name="submit" value="Add Category">
                        </div>
                        </form>

                        <?php
                            if(isset($_GET['edit'])){
                                $catId = $_GET['edit'];
                                include "includes/update_categories.php";
                            }
                        ?>

                        </div>

                        <div class="col-xs-6">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Category Title</th>
                                    <th>Delete</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php findAllCategories(); ?>
                            </tbody>
                        </table>
                        </div>

                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
<?php include "includes/admin_footer.php"; ?>

   