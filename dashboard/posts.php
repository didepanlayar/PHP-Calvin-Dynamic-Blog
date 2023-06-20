<?php
    require "includes/config.php";
    
    // Get Posts
    $sqlPosts = "SELECT * FROM posts WHERE post_status != '2'";
    $queryPosts = mysqli_query($connect, $sqlPosts);
    $numPosts = mysqli_num_rows($queryPosts)
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Posts</title>
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
                            Posts
                        </h1>
                    </div>
                </div>
                <?php
                    if(isset($_REQUEST['status'])) {
                        if($_REQUEST['status'] == "success") {
                            echo "<div class='alert alert-success'><strong>Success!</strong> Post added.</div>";
                        }
                    }
                    if(isset($_REQUEST['remove'])) {
                        if($_REQUEST['remove'] == "success") {
                            echo "<div class='alert alert-success'><strong>Success!</strong> Post deleted.</div>";
                        }
                        else if($_REQUEST['remove'] == "error") {
                            echo "<div class='alert alert-danger'><strong>Error!</strong> Post was not deleted.</div>";
                        }
                    }
                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                All Post
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Category</th>
                                                <th>Views</th>
                                                <th>Slug</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $counter = 0;
                                                while($rowPosts = mysqli_fetch_assoc($queryPosts)) {
                                                    $counter++;
                                                    $post_id = $rowPosts['post_id'];
                                                    $category_id = $rowPosts['category_id'];
                                                    $post_title = $rowPosts['post_title'];
                                                    $post_view = $rowPosts['post_view'];
                                                    $post_url = $rowPosts['post_url'];
                                                    $sqlGetCategoryName = "SELECT category_title FROM categories WHERE category_id = '$category_id'";
                                                    $queryGetCategoryName = mysqli_query($connect, $sqlGetCategoryName);
                                                    if($rowGetCategoryName = mysqli_fetch_assoc($queryGetCategoryName)) {
                                                        $category_title = $rowGetCategoryName['category_title'];
                                                    }
                                            ?>
                                                    <tr>
                                                        <td><?php echo $counter; ?></td>
                                                        <td><?php echo $post_title; ?></td>
                                                        <td><?php echo $category_title; ?></td>
                                                        <td><?php echo $post_view; ?></td>
                                                        <td><?php echo $post_url; ?></td>
                                                        <td>
                                                            <button class="popup-button" onclick="window.open('../read.php?post=<?php echo $post_url; ?>', '_blank')">View</button>
                                                            <button class="popup-button" onclick="location.href='edit-post.php?id=<?php echo $post_id; ?>'">Edit</button>
                                                            <button class="popup-button" data-toggle="modal" data-target="#delete-<?php echo $post_id; ?>">Delete</button>
                                                        </td>
                                                    </tr>
                                                    <div class="modal fade" id="delete-<?php echo $post_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <form method="POST" action="includes/delete-post.php">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                        <h4 class="modal-title" id="myModalLabel">Delete Post</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <input type="hidden" name="post-id" value="<?php echo $post_id; ?>">
                                                                        <p>Are you sure that you want to delete this post?</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-danger" name="delete-post-button">Delete</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
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