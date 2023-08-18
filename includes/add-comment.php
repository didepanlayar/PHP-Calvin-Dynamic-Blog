<?php
    require_once("../dashboard/includes/config.php");
    $postId = isset($_POST['postId']) ? $_POST['postId'] : "";
    $cName = isset($_POST['cName']) ? $_POST['cName'] : "";
    $cEmail = isset($_POST['cEmail']) ? $_POST['cEmail'] : "";
    $comment = isset($_POST['cMessage']) ? $_POST['cMessage'] : "";
    $date = date("Y-m-d");
    $time = date("H:i:s");
    // Add Comment
    $sqlAddComment = "INSERT INTO comments (post_id, comment_author, comment_author_email, comment, date_created, time_created) VALUES ('$postId', '$cName', '$cEmail', '$comment', '$date', '$time')";
    $queryAddComment = mysqli_query($connect, $sqlAddComment);
    if (!$queryAddComment) {
        $result = "error";
    }
    else {
        $result = "success";
    }
    echo $result;