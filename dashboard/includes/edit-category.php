<?php
    require "config.php";
    
    if(isset($_POST['edit-category-button'])) {
        $id = $_POST['category-id'];
        $title = $_POST['edit-category-title'];
        $metaTitle = $_POST['edit-category-meta-title'];
        $slug = $_POST['edit-category-slug'];
        // Edit Category
        $sqlEditCategory = "UPDATE categories SET category_title = '$title', category_meta_title = '$metaTitle', category_url = '$slug' WHERE category_id = '$id'";
        if(mysqli_query($connect, $sqlEditCategory)) {
            mysqli_close($connect);
            header("Location: ../post-category.php?change=success");
            exit();
        }
        else {
            mysqli_close($connect);
            header("Location: ../post-category.php?change=error");
            exit();
        }
    }
    else {
        header("Location: ../post-category.php");
        exit();
    }