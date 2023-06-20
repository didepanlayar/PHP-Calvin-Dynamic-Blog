<?php
    require "includes/config.php";
    session_start();
    if(isset($_REQUEST['id'])) {
        $post_id = $_REQUEST['id'];
        if(empty($post_id)) {
            header("Location: posts.php?");
        }
        $_SESSION['edit-post-id'] = $_REQUEST['id'];
        $sqlGetPostDetails = "SELECT * FROM posts WHERE post_id = '$post_id'";
        $queryGetPostDetails = mysqli_query($connect, $sqlGetPostDetails);
        if($rowGetPostDetails = mysqli_fetch_assoc($queryGetPostDetails)) {
            $_SESSION['edit-title'] = $rowGetPostDetails['post_title'];
            $_SESSION['edit-meta-title'] = $rowGetPostDetails['post_meta_title'];
            $_SESSION['edit-category-id'] = $rowGetPostDetails['category_id'];
            $_SESSION['edit-summary'] = $rowGetPostDetails['post_summary'];
            $_SESSION['edit-content'] = $rowGetPostDetails['post_content'];
            $_SESSION['edit-slug'] = $rowGetPostDetails['post_url'];
            $_SESSION['edit-home-placement'] = $rowGetPostDetails['post_placement'];
        }
        else {
            header("Location: posts.php");
            exit();
        }
        $sqlGetPostTags = "SELECT * FROM tags WHERE post_id = '$post_id'";
        $queryGetPostTags = mysqli_query($connect, $sqlGetPostTags);
        if($rowGetPostTags = mysqli_fetch_assoc($queryGetPostTags)) {
            $_SESSION['edit-tags'] = $rowGetPostTags['tag'];
        }
    }
    else if(isset($_SESSION['edit-post-id'])) {}
    else {
        header("Location: posts.php");
        exit();
    }
    $sqlGetImages = "SELECT * FROM posts WHERE post_id = '" . $_SESSION['edit-post-id'] . "'";
    $queryGetImages = mysqli_query($connect, $sqlGetImages);
    if($rowGetImages = mysqli_fetch_assoc($queryGetImages)) {
        $mainImage = $rowGetImages['main_image_url'];
        $altImage = $rowGetImages['alt_image_url'];
    }
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Post</title>
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
                            Edit a Post
                        </h1>
                    </div>
                </div>
                <?php
                    if(isset($_REQUEST['status'])) {
                        if($_REQUEST['status'] == "empty-title") {
                            echo "<div class='alert alert-danger'><strong>Error!</strong> Please add a Title.</div>";
                        }
                        else if($_REQUEST['status'] == "title-used") {
                            echo "<div class='alert alert-danger'><strong>Error!</strong> The Title being used in another post.</div>";
                        }
                        else if($_REQUEST['status'] == "empty-category") {
                            echo "<div class='alert alert-danger'><strong>Error!</strong> Please select a Category.</div>";
                        }
                        else if($_REQUEST['status'] == "empty-summary") {
                            echo "<div class='alert alert-danger'><strong>Error!</strong> Please enter a Summary.</div>";
                        }
                        else if($_REQUEST['status'] == "empty-content") {
                            echo "<div class='alert alert-danger'><strong>Error!</strong> Please enter a Content.</div>";
                        }
                        else if($_REQUEST['status'] == "empty-tags") {
                            echo "<div class='alert alert-danger'><strong>Error!</strong> Please add a Tags.</div>";
                        }
                        else if($_REQUEST['status'] == "empty-slug") {
                            echo "<div class='alert alert-danger'><strong>Error!</strong> Please add a Slug.</div>";
                        }
                        else if($_REQUEST['status'] == "slug-used") {
                            echo "<div class='alert alert-danger'><strong>Error!</strong> The Slug being used in another post.</div>";
                        }
                        else if($_REQUEST['status'] == "slug-contains-spaces") {
                            echo "<div class='alert alert-danger'><strong>Error!</strong> Please do not add any spaces in the Slug.</div>";
                        }
                        else if($_REQUEST['status'] == "empty-main-image") {
                            echo "<div class='alert alert-danger'><strong>Error!</strong> Please upload a Main Image.</div>";
                        }
                        else if($_REQUEST['status'] == "empty-alt-image") {
                            echo "<div class='alert alert-danger'><strong>Error!</strong> Please upload a Alternate Image.</div>";
                        }
                        else if($_REQUEST['status'] == "main-image-error") {
                            echo "<div class='alert alert-danger'><strong>Error!</strong> Please upload another Main Image.</div>";
                        }
                        else if($_REQUEST['status'] == "alt-image-error") {
                            echo "<div class='alert alert-danger'><strong>Error!</strong> Please upload another Alternate Image.</div>";
                        }
                        else if($_REQUEST['status'] == "invalid-type-main-image") {
                            echo "<div class='alert alert-danger'><strong>Error!</strong> Main Image upload only JPG, JPEG, PNG, GIF and BMP.</div>";
                        }
                        else if($_REQUEST['status'] == "invalid-type-alt-image") {
                            echo "<div class='alert alert-danger'><strong>Error!</strong> Alternate Image upload only JPG, JPEG, PNG, GIF and BMP.</div>";
                        }
                        else if($_REQUEST['status'] == "error-uploading-main-image") {
                            echo "<div class='alert alert-danger'><strong>Error!</strong> Main Image was error while uploading.</div>";
                        }
                        else if($_REQUEST['status'] == "error-uploading-alt-image") {
                            echo "<div class='alert alert-danger'><strong>Error!</strong> Alternate Image was error while uploading.</div>";
                        }
                        else if($_REQUEST['status'] == "post-placement-error") {
                            echo "<div class='alert alert-danger'><strong>Error!</strong> An unexpcted error occured while trying to set the post placement.</div>";
                        }
                        else if($_REQUEST['status'] == "sql-error") {
                            echo "<div class='alert alert-danger'><strong>Error!</strong> Please try again.</div>";
                        }
                    }
                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Edit: <?php echo $_SESSION['edit-title']; ?>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <form role="form" method="POST" action="includes/update-post.php" enctype="multipart/form-data" onsubmit="return validateImage();">
                                            <div class="form-group">
                                                <label>Title</label>
                                                <input class="form-control" name="post-title" value="<?php echo $_SESSION['edit-title']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Meta Title</label>
                                                <input class="form-control" name="post-meta-title" value="<?php echo $_SESSION['edit-meta-title']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Category</label>
                                                <select class="form-control" name="post-category">
                                                    <option>Select Category</option>
                                                    <?php
                                                        $sqlCategories = "SELECT * FROM categories";
                                                        $queryCategories = mysqli_query($connect, $sqlCategories);
                                                        while($rowCategories = mysqli_fetch_assoc($queryCategories)) {
                                                            $cId = $rowCategories['category_id'];
                                                            $cName = $rowCategories['category_title'];
                                                            if($_SESSION['edit-category-id'] == $cId) {
                                                                echo "<option value='" . $cId . "' selected=''>" . $cName . "</option>";
                                                            }
                                                            else {
                                                                echo "<option value='" . $cId . "'>" . $cName . "</option>";
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Main Image</label>
                                                <input type="file" name="post-main-image" id="post-main-image">
                                                <?php
                                                    if(!empty($mainImage)) {
                                                        echo "<p style='font-size: inherit;'><a class='popup-button' href='' data-toggle='modal' data-target='#main-image' style='margin-top: 10px;'>View Image</a></p>";
                                                    }
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <label>Alternate Image</label>
                                                <input type="file" name="post-alt-image" id="post-alt-image">
                                                <?php
                                                    if(!empty($altImage)) {
                                                        echo "<p style='font-size: inherit;'><a class='popup-button' href='' data-toggle='modal' data-target='#alt-image' style='margin-top: 10px;'>View Image</a></p>";
                                                    }
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <label>Summary</label>
                                                <textarea class="form-control" rows="3" name="post-summary"><?php echo $_SESSION['edit-summary']; ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Content</label>
                                                <textarea class="form-control" rows="3" name="post-content"><?php echo $_SESSION['edit-content']; ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Tags</label>
                                                <input class="form-control" name="post-tags" value="<?php echo $_SESSION['edit-tags']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Slug</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">www.domain.com/</span>
                                                    <input type="text" class="form-control" name="post-slug" value="<?php echo $_SESSION['edit-slug']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Home Placement</label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="post-home-placement" id="optionsRadiosInline1" value="1" <?php if(isset($_SESSION['edit-home-placement'])) { if($_SESSION['edit-home-placement'] == 1) {echo "checked=''";} } ?>>1
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="post-home-placement" id="optionsRadiosInline2" value="2" <?php if(isset($_SESSION['edit-home-placement'])) { if($_SESSION['edit-home-placement'] == 2) {echo "checked=''";} } ?>>2
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="post-home-placement" id="optionsRadiosInline3" value="3" <?php if(isset($_SESSION['edit-home-placement'])) { if($_SESSION['edit-home-placement'] == 3) {echo "checked=''";} } ?>>3
                                                </label>
                                            </div>
                                            <button type="submit" class="btn btn-default" name="submit-edit-post">Update Post</button>
                                        </form>
                                    </div>
                                </div>
                                <?php
                                    if(!empty($mainImage)) {
                                ?>
                                        <div class="modal fade" id="main-image" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title" id="myModalLabel">Main Image</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <img src="<?php echo $mainImage; ?>" alt="<?php echo $_SESSION['edit-title']; ?>" style="max-width: 100%; height: auto;">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                    }
                                ?>
                                <?php
                                    if(!empty($altImage)) {
                                ?>
                                        <div class="modal fade" id="alt-image" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title" id="myModalLabel">Alt Image</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <img src="<?php echo $altImage; ?>" alt="<?php echo $_SESSION['edit-title']; ?>" style="max-width: 100%; height: auto;">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
				<?php include "footer.php"; ?>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.metisMenu.js"></script>
    <script src="assets/js/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/js/morris/morris.js"></script>
    <script src="assets/js/custom-scripts.js"></script>
    <script>
        function validateImage() {
            var mainImage = $("#post-main-image").val();
            var altImage = $("#post-alt-image").val();
            var extention = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
            var getExtMainImage = mainImage.split('.');
            var getExtAltImage = altImage.split('.');
            getExtMainImage = getExtMainImage.reverse();
            getExtAltImage = getExtAltImage.reverse();
            mainImageCheck = false;
            altImageCheck = false;
            if(mainImage.length > 0) {
                if($.inArray(getExtMainImage[0].toLowerCase(), extention) >= -1) {
                    mainImageCheck = true;
                }
                else {
                    alert("Error! Main Image. Upload only JPG, JPEG, PNG, GIF and BMP images.");
                    mainImageCheck = false;
                }
            }
            else {
                alert("Please upload a Main Image.");
                mainImageCheck = false;
            }
            if(altImage.length > 0) {
                if($.inArray(getExtAltImage[0].toLowerCase(), extention) >= -1) {
                    altImageCheck = true;
                }
                else {
                    alert("Error! Alternate Image. Upload only JPG, JPEG, PNG, GIF and BMP images.");
                    altImageCheck = false;
                }
            }
            else {
                alert("Please upload a Alternate Image.");
                altImageCheck = false;
            }
            if(mainImageCheck == true && altImageCheck == true) {
                return true;
            }
            else {
                return false;
            }
        }
    </script>
</body>
</html>