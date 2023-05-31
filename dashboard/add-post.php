<?php
    require "includes/config.php";
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Post</title>
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
                            Create a Post
                        </h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Create a Post
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <form role="form" method="POST" action="includes/add-post.php" enctype="multipart/form-data" onsubmit="return validateImage();">
                                            <div class="form-group">
                                                <label>Title</label>
                                                <input class="form-control" name="post-title">
                                            </div>
                                            <div class="form-group">
                                                <label>Meta Title</label>
                                                <input class="form-control" name="post-meta-title">
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
                                                            echo "<option value='" . $cId . "'>" . $cName . "</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Main Image</label>
                                                <input type="file" name="post-main-image" id="post-main-image">
                                            </div>
                                            <div class="form-group">
                                                <label>Alternate Image</label>
                                                <input type="file" name="post-alt-image" id="post-alt-image">
                                            </div>
                                            <div class="form-group">
                                                <label>Summary</label>
                                                <textarea class="form-control" rows="3" name="post-summary"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Content</label>
                                                <textarea class="form-control" rows="3" name="post-content"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Tags</label>
                                                <input class="form-control" name="post-tags">
                                            </div>
                                            <div class="form-group">
                                                <label>Slug</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">www.domain.com/</span>
                                                    <input type="text" class="form-control" placeholder="Slug" name="post-slug">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Home Placement</label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="post-home-placement" id="optionsRadiosInline1" value="1" checked="">1
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="post-home-placement" id="optionsRadiosInline2" value="2">2
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="post-home-placement" id="optionsRadiosInline3" value="3">3
                                                </label>
                                            </div>
                                            <button type="submit" class="btn btn-default" name="submit-post">Add Post</button>
                                        </form>
                                    </div>
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