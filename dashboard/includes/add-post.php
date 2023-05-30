<?php
    require "config.php";

    if(isset($_POST['submit-post'])) {
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
        $sqlCheckTitle = "SELECT post_title FROM posts WHERE post_title = '$title' AND post_status != '2'";
        $queryCheckTitle = mysqli_query($connect, $sqlCheckTitle);
        $sqlCheckSlug = "SELECT post_url FROM posts WHERE post_url = '$slug' AND post_status != '2'";
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
        // Add Post
        $sqlAddPost = "INSERT INTO posts (category_id, post_title, post_meta_title, post_url, post_summary, post_content, post_placement, post_status, date_created, time_created) VALUES ('$category', '$title', '$metaTitle', '$slug', '$summary', '$content', '$homePlacement', '1', '$date', '$time')";
        if(mysqli_query($connect, $sqlAddPost)) {
            mysqli_close($connect);
            header("Location: ../posts.php?status=success");
            exit();
        }
        else {
            formError("sql-error");
        }
    }
    else {
        header("Location: ../posts.php");
        exit();
    }

    function formError($errorCode) {
        header("Location: ../add-post.php?status=" . $errorCode);
        exit();
    }