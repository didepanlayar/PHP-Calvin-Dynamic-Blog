<?php
    require "config.php";
    session_start();

    if(isset($_POST['submit-edit-post'])) {
        $post_id = $_POST['post-id'];
        $title = $_POST['post-title'];
        $metaTitle = $_POST['post-meta-title'];
        $category = $_POST['post-category'];
        $summary = $_POST['post-summary'];
        $content = $_POST['post-content'];
        $tags = $_POST['post-tags'];
        $slug = $_POST['post-slug'];
        $homePlacement = $_POST['post-home-placement'];
        $date = date("Y-m-d");
        $time = date("H:i:s");
        // Input Field Validation
        if(empty($title)) {
            formError("empty-title");
        }
        else if(empty($category)) {
            formError("empty-category");
        }
        else if(empty($summary)) {
            formError("empty-summary");
        }
        else if(empty($content)) {
            formError("empty-content");
        }
        else if(empty($tags)) {
            formError("empty-tags");
        }
        else if(empty($slug)) {
            formError("empty-slug");
        }
        if(strpos($slug, " ") !== false) {
            formError("slug-contains-spaces");
        }
        if(empty($homePlacement)) {
            $homePlacement = 0;
        }
        // Title and Slug
        $sqlCheckTitle = "SELECT post_title FROM posts WHERE post_title = '$title' AND post_title != '$title' AND post_status != '2'";
        $queryCheckTitle = mysqli_query($connect, $sqlCheckTitle);
        $sqlCheckSlug = "SELECT post_url FROM posts WHERE post_url = '$slug' AND post_url != '$slug' AND post_status != '2'";
        $queryCheckSlug = mysqli_query($connect, $sqlCheckSlug);
        if(mysqli_num_rows($queryCheckTitle) > 0) {
            formError("title-used");
        }
        else if(mysqli_num_rows($queryCheckSlug) > 0) {
            formError("slug-used");
        }
        // Home Placement
        if($homePlacement != 0) {
            $sqlCheckHomePlacement = "SELECT * FROM posts WHERE post_placement = '$homePlacement' AND post_status != '2'";
            $queryCheckHomePlacement = mysqli_query($connect, $sqlCheckHomePlacement);
            if(mysqli_num_rows($queryCheckHomePlacement) > 0) {
                $sqlUpdateHomePlacement = "UPDATE posts SET post_placement = '0' WHERE post_placement = '$homePlacement' AND post_status != '2'";
                if(!mysqli_query($connect, $sqlUpdateHomePlacement)) {
                    formError("post-placement-error");
                }
            }
        }
        // Upload Image
        $mainImgUrl = uploadImage($_FILES["post-main-image"]["name"], "post-main-image", "main", "main_image_url");
        $altImgUrl = uploadImage($_FILES["post-alt-image"]["name"], "post-alt-image", "alt", "alt_image_url");
        // Update Post
        if($mainImgUrl == "no-update") {
            if($altImgUrl == "no-update") {
                $sqlUpdatePost = "UPDATE posts SET category_id = '$category', post_title = '$title', post_meta_title = '$metaTitle', post_url = '$slug', post_summary = '$summary', post_content = '$content', post_placement = '$homePlacement', date_updated = '$date', time_updated = '$time' WHERE post_id = '$post_id'";
            }
            else {
                $sqlUpdatePost = "UPDATE posts SET category_id = '$category', post_title = '$title', post_meta_title = '$metaTitle', post_url = '$slug', post_summary = '$summary', post_content = '$content', alt_image_url = '$altImgUrl', post_placement = '$homePlacement', date_updated = '$date', time_updated = '$time' WHERE post_id = '$post_id'";
            }
        }
        else if($altImgUrl == "no-update") {
            if($mainImgUrl != "no-update") {
                $sqlUpdatePost = "UPDATE posts SET category_id = '$category', post_title = '$title', post_meta_title = '$metaTitle', post_url = '$slug', post_summary = '$summary', post_content = '$content', main_image_url = '$mainImgUrl', post_placement = '$homePlacement', date_updated = '$date', time_updated = '$time' WHERE post_id = '$post_id'";
            }
        }
        else {
            $sqlUpdatePost = "UPDATE posts SET category_id = '$category', post_title = '$title', post_meta_title = '$metaTitle', post_url = '$slug', post_summary = '$summary', post_content = '$content', main_image_url = '$mainImgUrl', alt_image_url = '$altImgUrl', post_placement = '$homePlacement', date_updated = '$date', time_updated = '$time' WHERE post_id = '$post_id'";
        }
        $sqlUpdateTags = "UPDATE tags SET tag = '$tags' WHERE post_id = '$post_id'";
        if(mysqli_query($connect, $sqlUpdatePost) && mysqli_query($connect, $sqlUpdateTags)) {
            formSuccess();
        }
        else {
            formError("sql-error");
        }
    }
    else {
        header("Location: ../posts.php");
        exit();
    }

    function formSuccess() {
        require "config.php";
        mysqli_close($connect);
        unset($_SESSION['edit-post-id']);
        unset($_SESSION['edit-title']);
        unset($_SESSION['edit-meta-title']);
        unset($_SESSION['edit-category-id']);
        unset($_SESSION['edit-summary']);
        unset($_SESSION['edit-content']);
        unset($_SESSION['edit-slug']);
        unset($_SESSION['edit-tags']);
        unset($_SESSION['edit-home-placement']);
        header("Location: ../posts.php?update=success");
        exit();
    }

    function formError($errorCode) {
        require "config.php";
        $_SESSION['edit-title'] = $_POST['post-title'];
        $_SESSION['edit-meta-title'] = $_POST['post-meta-title'];
        $_SESSION['edit-category-id'] = $_POST['post-category'];
        $_SESSION['edit-summary'] = $_POST['post-summary'];
        $_SESSION['edit-content'] = $_POST['post-content'];
        $_SESSION['edit-tags'] = $_POST['post-tags'];
        $_SESSION['edit-slug'] = $_POST['post-slug'];
        $_SESSION['edit-home-placement'] = $_POST['post-home-placement'];
        mysqli_close($connect);
        header("Location: ../edit-post.php?update=" . $errorCode);
        exit();
    }

    function uploadImage($img, $imgName, $imgType, $imgDataColumn) {
        require "config.php";
        $imgUrl = "";
        $validExtention = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
        if($img == "") {
            return "no-update";
        }
        else {
            if($_FILES[$imgName]["size"] <= 0) {
                formError($imgType . "-image-error");
            }
            else {
                $extention = strtolower(end(explode(".", $img)));
                if(!in_array($extention, $validExtention)) {
                    formError("invalid-type-" . $imgType . "-image");
                }
                // Delete Old Image
                $post_id = $_POST['post-id'];
                $sqlGetOldImage = "SELECT " . $imgDataColumn . " FROM posts WHERE post_id = '$post_id'";
                $queryGetOldImage = mysqli_query($connect, $sqlGetOldImage);
                if($rowGetOldImage = mysqli_fetch_assoc($queryGetOldImage)) {
                    $oldImage = $rowGetOldImage[$imgDataColumn];
                }
                if(!empty($oldImage)) {
                    $oldImageArray = explode("/", $oldImage);
                    $oldImageName = end($oldImageArray);
                    $oldImageSlug = "../../assets/images/posts/" . $oldImageName;
                    unlink($oldImageSlug);
                }
                // Store New Image
                $folder = "../../assets/images/posts/";
                $imgNewName = rand(10000, 990000) . '_' . time() . '.' . $extention;
                $imgSlug = $folder . $imgNewName;
                if(move_uploaded_file($_FILES[$imgName]['tmp_name'], $imgSlug)) {
                    $imgUrl = "/assets/images/posts/" . $imgNewName;
                }
                else {
                    formError("error-uploading-" . $imgType . "-image");
                }
            }
            return $imgUrl;
        }
    }