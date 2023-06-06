<?php
    require "config.php";
    
    if(isset($_POST['delete-post-button'])) {
        $post_id = $_POST['post-id'];
        // Delete Post
        $sqlDeletePost = "UPDATE posts SET post_status = '2' WHERE post_id = '$post_id'";
        if(mysqli_query($connect, $sqlDeletePost)) {
            mysqli_close($connect);
            header("Location: ../posts.php?remove=success");
            exit();
        }
        else {
            mysqli_close($connect);
            header("Location: ../posts.php?remove=error");
            exit();
        }
    }
    else {
        header("Location: ../posts.php");
        exit();
    }