<?php
    require "includes/config.php";
    
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
                                                <th>Action</th>
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
                                                            <button>View</button>
                                                            <button>Edit</button>
                                                            <button>Delete</button>
                                                        </td>
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