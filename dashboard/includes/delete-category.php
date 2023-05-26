<?php
    require "config.php";
    
    if(isset($_POST['delete-category-button'])) {
        $id = $_POST['category-id'];
        // Delete Category
        $sqlDeleteCategory = "DELETE FROM categories WHERE category_id = '$id'";
        if(mysqli_query($connect, $sqlDeleteCategory)) {
            mysqli_close($connect);
            header("Location: ../post-category.php?remove=success");
            exit();
        }
        else {
            mysqli_close($connect);
            header("Location: ../post-category.php?remove=error");
            exit();
        }
    }
    else {
        header("Location: ../post-category.php");
        exit();
    }