<?php
    require "config.php";
    
    if(isset($_POST['add-category-button'])) {
        $title = $_POST['category-title'];
        $metaTitle = $_POST['category-meta-title'];
        $slug = $_POST['category-slug'];
        $date = date("Y-m-d");
        $time = date("H:i:s");
        // Add Category
        $sqlAddCategory = "INSERT INTO categories (category_title, category_meta_title, category_url, date_created, time_created) VALUES ('$title', '$metaTitle', '$slug', '$date', '$time')";
        if(mysqli_query($connect, $sqlAddCategory)) {
            mysqli_close($connect);
            header("Location: ../post-category.php?status=success");
            exit();
        }
        else {
            mysqli_close($connect);
            header("Location: ../post-category.php?status=error");
            exit();
        }
    }
    else {
        header("Location: ../post-category.php");
        exit();
    }