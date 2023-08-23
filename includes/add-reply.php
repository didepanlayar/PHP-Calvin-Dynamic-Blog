<?php
    require_once("../dashboard/includes/config.php");
    $postId = isset($_POST['replyPostId']) ? $_POST['replyPostId'] : "";
    $parentId = isset($_POST['commentParentId']) ? $_POST['commentParentId'] : "";
    $cName = isset($_POST['replyCName']) ? $_POST['replyCName'] : "";
    $cEmail = isset($_POST['replyCEmail']) ? $_POST['replyCEmail'] : "";
    $comment = isset($_POST['replyCMessage']) ? $_POST['replyCMessage'] : "";
    $date = date("Y-m-d");
    $time = date("H:i:s");
    // Add Comment
    $sqlAddReply = "INSERT INTO comments (comment_parent_id, post_id, comment_author, comment_author_email, comment, date_created, time_created) VALUES ('$parentId', '$postId', '$cName', '$cEmail', '$comment', '$date', '$time')";
    $queryAddReply = mysqli_query($connect, $sqlAddReply);
    if (!$queryAddReply) {
        $result = "error";
    }
    else {
        $result = "success";
    }
    echo $result;