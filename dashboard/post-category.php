<?php
    require "includes/config.php";
    include "includes/unset-session.php";
    
    // Get Categories
    $sqlCategories = "SELECT * FROM categories";
    $queryCategories = mysqli_query($connect, $sqlCategories);
    $numCategories = mysqli_num_rows($queryCategories)
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Post Categories</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <link href="assets/css/custom-styles.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
    <div id="wrapper">
        <?php
            include "header.php";
            include "sidebar.php";
        ?>
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Post Categories
                        </h1>
                    </div>
                </div>
                <?php
                    if(isset($_REQUEST['status'])) {
                        if($_REQUEST['status'] == "success") {
                            echo "<div class='alert alert-success'><strong>Success!</strong> Category added.</div>";
                        }
                        else if($_REQUEST['status'] == "error") {
                            echo "<div class='alert alert-danger'><strong>Error!</strong> Category was not added, there was an unexpected error.</div>";
                        }
                    }
                    else if(isset($_REQUEST['change'])) {
                        if($_REQUEST['change'] == "success") {
                            echo "<div class='alert alert-success'><strong>Success!</strong> Changes to the category were saved.</div>";
                        }
                        else if($_REQUEST['change'] == "error") {
                            echo "<div class='alert alert-danger'><strong>Error!</strong> Changes to the category were not saved.</div>";
                        }
                    }
                    else if(isset($_REQUEST['remove'])) {
                        if($_REQUEST['remove'] == "success") {
                            echo "<div class='alert alert-success'><strong>Success!</strong> Category deleted.</div>";
                        }
                        else if($_REQUEST['remove'] == "error") {
                            echo "<div class='alert alert-danger'><strong>Error!</strong> Category not deleted.</div>";
                        }
                    }
                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Add a Category
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <form role="form" method="POST" action="includes/add-category.php">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input class="form-control" name="category-title">
                                            </div>
                                            <div class="form-group">
                                                <label>Meta Title</label>
                                                <input class="form-control" name="category-meta-title">
                                            </div>
                                            <div class="form-group">
                                                <label>Slug</label>
                                                <input class="form-control" name="category-slug">
                                            </div>
                                            <button type="submit" class="btn btn-default" name="add-category-button">Add Category</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                All Categories
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Meta Title</th>
                                                <th>Slug</th>
                                                <th><center>Action</center></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $counter = 0;
                                                while($rowCategories = mysqli_fetch_assoc($queryCategories)) {
                                                    $counter++;
                                                    $id = $rowCategories['category_id'];
                                                    $title = $rowCategories['category_title'];
                                                    $metaTitle = $rowCategories['category_meta_title'];
                                                    $slug = $rowCategories['category_url'];
                                            ?>
                                                    <tr>
                                                        <td><?php echo $counter; ?></td>
                                                        <td><?php echo $title; ?></td>
                                                        <td><?php echo $metaTitle; ?></td>
                                                        <td><?php echo $slug; ?></td>
                                                        <td>
                                                            <center>
                                                                <button class="popup-button" onclick="window.open('../category.php?group=<?php echo $slug; ?>', '_blank');">View</button>
                                                                <button class="popup-button" data-toggle="modal" data-target="#edit-<?php echo $id; ?>">Edit</button>
                                                                <button class="popup-button" data-toggle="modal" data-target="#delete-<?php echo $id; ?>">Delete</button>
                                                            </center>
                                                        </td>
                                                        <div class="modal fade" id="edit-<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <form method="POST" action="includes/edit-category.php">
                                                                        <div class="modal-header">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                            <h4 class="modal-title" id="myModalLabel">Edit Category</h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <input type="hidden" name="category-id" value="<?php echo $id; ?>">
                                                                            <div class="form-group">
                                                                                <label>Name</label>
                                                                                <input class="form-control" name="edit-category-title" value="<?php echo $title; ?>">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>Meta Title</label>
                                                                                <input class="form-control" name="edit-category-meta-title" value="<?php echo $metaTitle; ?>">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>Slug</label>
                                                                                <input class="form-control" name="edit-category-slug" value="<?php echo $slug; ?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                            <button type="submit" class="btn btn-primary" name="edit-category-button">Save</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal fade" id="delete-<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <form method="POST" action="includes/delete-category.php">
                                                                        <div class="modal-header">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                            <h4 class="modal-title" id="myModalLabel">Delete Category</h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <input type="hidden" name="category-id" value="<?php echo $id; ?>">
                                                                            <p>Are you sure that you want to delete this category?</p>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                            <button type="submit" class="btn btn-danger" name="delete-category-button">Delete</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </tr>
                                            <?php
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<?php include "footer.php"; ?>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.metisMenu.js"></script>
    <script src="assets/js/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/js/morris/morris.js"></script>
    <script src="assets/js/custom-scripts.js"></script>
</body>
</html>