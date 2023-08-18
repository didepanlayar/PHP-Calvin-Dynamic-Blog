<?php
    require "dashboard/includes/config.php";
    if (isset($_REQUEST['post'])) {
        $slug = $_REQUEST['post'];
        $sqlGetPost = "SELECT * FROM posts WHERE post_url = '$slug' AND post_status = '1'";
        $queryGetPost = mysqli_query($connect, $sqlGetPost);
        if ($rowGetPost = mysqli_fetch_assoc($queryGetPost)) {
            $postId = $rowGetPost['post_id'];
            $postCategoryId = $rowGetPost['category_id'];
            $postTitle = $rowGetPost['post_title'];
            $postMetaTitle = $rowGetPost['post_meta_title'];
            $postContent = $rowGetPost['post_content'];
            $postThumbnails = $rowGetPost['main_image_url'];
            $postCreated = $rowGetPost['date_created'];
        }
        else {
            header("Location: index.php");
            exit();
        }
        $sqlGetCategory = "SELECT * FROM categories WHERE category_id = '$postCategoryId'";
        $queryGetCategory = mysqli_query($connect, $sqlGetCategory);
        if ($rowGetCategory = mysqli_fetch_assoc($queryGetCategory)) {
            $PostCategoryTitle = $rowGetCategory['category_title'];
            $PostCategorySlug = $rowGetCategory['category_url'];
        }
        $sqlGetPostTags = "SELECT * FROM tags WHERE post_id = '$postId'";
        $queryGetPostTags = mysqli_query($connect, $sqlGetPostTags);
        if($rowGetPostTags = mysqli_fetch_assoc($queryGetPostTags)) {
            $postTags = $rowGetPostTags['tag'];
            $postTagsArray = explode(",", $postTags);
        }
    }
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <title>Calvin - <?php echo $postTitle; ?></title>
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/vendor.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="assets/js/modernizr.js"></script>
    <script defer src="assets/js/fontawesome/all.min.js"></script>
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon-16x16.png">
    <link rel="manifest" href="assets/site.webmanifest">
</head>
<body id="top">
    <div id="preloader"> 
    	<div id="loader"></div>
    </div>
    <?php include "header-opaque.php"; ?>
    <section class="s-content">
        <div class="row">
            <div class="column large-12">
                <article class="s-content__entry format-standard">
                    <div class="s-content__media">
                        <div class="s-content__post-thumb">
                            <img src="<?php echo $postThumbnails; ?>" srcset="<?php echo $postThumbnails; ?> 2100w, <?php echo $postThumbnails; ?> 1050w, <?php echo $postThumbnails; ?> 525w" sizes="(max-width: 2100px) 100vw, 2100px" alt="">
                        </div>
                    </div>
                    <div class="s-content__entry-header">
                        <h1 class="s-content__title s-content__title--post"><?php echo $postTitle; ?></h1>
                    </div>
                    <div class="s-content__primary">
                        <div class="s-content__entry-content">
                            <?php echo $postContent; ?>
                        </div>
                        <div class="s-content__entry-meta">
                            <div class="entry-author meta-blk">
                                <div class="author-avatar">
                                    <img class="avatar" src="assets/images/user.jpg" alt="">
                                </div>
                                <div class="byline">
                                    <span class="bytext">Posted By</span>
                                    <a href="#0">Di Depan Layar</a>
                                </div>
                            </div>
                            <div class="meta-bottom">
                                <div class="entry-cat-links meta-blk">
                                    <div class="cat-links">
                                        <span>In</span> 
                                        <a href="category.php?group=<?php echo $PostCategorySlug; ?>"><?php echo $PostCategoryTitle; ?></a>
                                    </div>
                                    <span>On</span>
                                    <?php echo date("M j, Y", strtotime($postCreated)); ?>
                                </div>
                                <div class="entry-tags meta-blk">
                                    <span class="tagtext">Tags</span>
                                    <?php
                                        for ($i = 0; $i < count($postTagsArray); $i++) {
                                            if (!empty($postTagsArray[$i])) {
                                                echo "<a href='search.php?query=" . $postTagsArray[$i] . "'>" . $postTagsArray[$i] . "</a>";
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="s-content__pagenav">
                            <?php
                                $sqlGetPrevPost = "SELECT * FROM posts WHERE post_id = (SELECT max(post_id) FROM posts WHERE post_id < '" . $postId . "') AND post_status = '1'";
                                $queryGetPrevPost = mysqli_query($connect, $sqlGetPrevPost);
                                if ($rowGetPrevPost = mysqli_fetch_assoc($queryGetPrevPost)) {
                                    $postTitlePrev = $rowGetPrevPost['post_title'];
                                    $postUrlPrev = $rowGetPrevPost['post_url'];
                            ?>
                                    <div class="prev-nav">
                                        <a href="read.php?post=<?php echo $postUrlPrev; ?>" rel="prev">
                                            <span>Previous</span>
                                            <?php echo $postTitlePrev; ?>
                                        </a>
                                    </div>
                            <?php
                                }
                                $sqlGetNextPost = "SELECT * FROM posts WHERE post_id = (SELECT min(post_id) FROM posts WHERE post_id > '" . $postId . "') AND post_status = '1'";
                                $queryGetNextPost = mysqli_query($connect, $sqlGetNextPost);
                                if ($rowGetNextPost = mysqli_fetch_assoc($queryGetNextPost)) {
                                    $postTitleNext = $rowGetNextPost['post_title'];
                                    $postUrlNext = $rowGetNextPost['post_url'];
                            ?>
                                    <div class="next-nav">
                                        <a href="read.php?post=<?php echo $postUrlNext; ?>" rel="next">
                                            <span>Next</span>
                                            <?php echo $postTitleNext; ?>
                                        </a>
                                    </div>
                            <?php
                                }
                            ?>
                         </div>
                    </div>
                </article>
            </div>
        </div>
        <?php
            $sqlGetAllComments = "SELECT * FROM comments WHERE post_id = '$postId'";
            $queryGetAllComments = mysqli_query($connect, $sqlGetAllComments);
            $numComments = mysqli_num_rows($queryGetAllComments);
        ?>
        <div class="comments-wrap">
            <div id="comments" class="row">
                <div class="column large-12">
                    <h3><?php echo $numComments; ?> Comments</h3>
                    <ol class="commentlist" id="commentlist">
                        <?php
                            $sqlGetComments = "SELECT * FROM comments WHERE post_id = '$postId' AND comment_parent_id = '0' ORDER BY date_created ASC";
                            $queryGetComments = mysqli_query($connect, $sqlGetComments);
                            while ($rowComments = mysqli_fetch_assoc($queryGetComments)) {
                                $commentId = $rowComments['comment_id'];
                                $commentAuthor = $rowComments['comment_author'];
                                $comment = $rowComments['comment'];
                                $commentDate = $rowComments['date_created'];
                                $sqlCheckCommentChildren = "SELECT * FROM comments WHERE comment_parent_id = '$commentId' ORDER BY date_created ASC";
                                $queryCheckCommentChildren = mysqli_query($connect, $sqlCheckCommentChildren);
                                $numCommentChildren = mysqli_num_rows($queryCheckCommentChildren);
                                if ($numCommentChildren == 0) {
                        ?>
                                    <li class="depth-1 comment">
                                        <div class="comment__avatar">
                                            <img class="avatar" src="assets/images/avatar.jpg" alt="" width="50" height="50">
                                        </div>
                                        <div class="comment__content">
                                            <div class="comment__info">
                                                <input type="hidden" id="comment-author-<?php echo $commentId; ?>" value="<?php echo $commentAuthor; ?>">
                                                <div class="comment__author"><?php echo $commentAuthor; ?></div>
                                                <div class="comment__meta">
                                                    <div class="comment__time"><?php echo date("M j, Y", strtotime($commentDate)); ?></div>
                                                    <div class="comment__reply">
                                                        <a class="comment-reply-link" href="#reply-comment-section" onclick="prepareReply('<?php echo $commentId; ?>');">Reply</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="comment__text">
                                            <p><?php echo $comment; ?></p>
                                            </div>
                                        </div>
                                    </li>
                        <?php
                                }
                                else {
                        ?>
                                    <li class="thread-alt depth-1 comment">
                                        <div class="comment__avatar">
                                            <img class="avatar" src="assets/images/avatar.jpg" alt="" width="50" height="50">
                                        </div>
                                        <div class="comment__content">
                                            <div class="comment__info">
                                                <input type="hidden" id="comment-author-<?php echo $commentId; ?>" value="<?php echo $commentAuthor; ?>">
                                                <div class="comment__author"><?php echo $commentAuthor; ?></div>
                                                <div class="comment__meta">
                                                    <div class="comment__time"><?php echo date("M j, Y", strtotime($commentDate)); ?></div>
                                                    <div class="comment__reply">
                                                        <a class="comment-reply-link" href="#reply-comment-section" onclick="prepareReply('<?php echo $commentId; ?>');">Reply</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="comment__text">
                                            <p><?php echo $comment; ?></p>
                                            </div>
                                        </div>
                        <?php
                                    while ($rowCommentChildren = mysqli_fetch_assoc($queryCheckCommentChildren)) {
                                        $commentIdChild = $rowCommentChildren['comment_id'];
                                        $commentAuthorChild = $rowCommentChildren['comment_author'];
                                        $commentChild = $rowCommentChildren['comment'];
                                        $commentDateChild = $rowCommentChildren['date_created'];
                        ?>
                                        <ul class="children">
                                            <li class="depth-2 comment">
                                                <div class="comment__avatar">
                                                    <img class="avatar" src="assets/images/avatar.jpg" alt="" width="50" height="50">
                                                </div>
                                                <div class="comment__content">
                                                    <div class="comment__info">
                                                        <div class="comment__author"><?php echo $commentAuthorChild; ?></div>
                                                        <div class="comment__meta">
                                                            <div class="comment__time"><?php echo date("M j, Y", strtotime($commentDateChild)); ?></div>
                                                        </div>
                                                    </div>
                                                    <div class="comment__text">
                                                        <p><?php echo $commentChild; ?></p>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                        <?php
                                    }
                                }
                            }
                        ?>
                                    </li>
                    </ol>
                </div>
            </div>
            <div class="row comment-respond">
                <div id="respond" class="column">
                    <h3>
                        Add Comment
                        <span>Your email address will not be published.</span>
                    </h3>
                    <p style="color: green; display: none;" id="comment-success">Your comment was added successfully.</p>
                    <p style="color: red; display: none;" id="comment-error"></p>
                    <form name="commentForm" id="commentForm">
                        <fieldset>
                            <input type="hidden" name="postId" id="postId" value="<?php echo $postId; ?>">
                            <div class="form-field">
                                <input name="cName" id="cName" class="h-full-width h-remove-bottom" placeholder="Your Name" value="" type="text">
                            </div>
                            <div class="form-field">
                                <input name="cEmail" id="cEmail" class="h-full-width h-remove-bottom" placeholder="Your Email" value="" type="text">
                            </div>
                            <div class="message form-field">
                                <textarea name="cMessage" id="cMessage" class="h-full-width" placeholder="Your Message"></textarea>
                            </div>
                            <br>
                            <input name="submit" id="submitCommentForm" class="btn btn--primary btn-wide btn--large h-full-width" value="Add Comment" type="submit">
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <?php include "footer.php"; ?>
    <script src="assets/js/jquery-3.5.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/main.js"></script>
    <script>
        $(document).ready(function() {
            prepareComment();
        });
        function checkEmail(email) {
            var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if (!regex.test(email)) {
                return false;
            }
            else {
                return true;
            }
        }
        function prepareComment() {
            $("#comment-success").css("display", "none");
            $("#comment-error").css("display", "none");
            $("#reply-comment-section").hide();
            $("#add-comment-section").show();
        }
        $(document).on('submit', '#commentForm', function(e) {
            e.preventDefault();
            $("#comment-success").css("display", "none");
            $("#comment-error").css("display", "none");
            var name = $("#cName").val();
            var email = $("#cEmail").val();
            var comment = $("#cMessage").val();
            if (!name || !email || !comment) {
                $("#comment-error").css("display", "block");
                $("#comment-error").html("Please fill all fields.");
            } else if (name.lenght > 50) {
                $("#comment-error").css("display", "block");
                $("#comment-error").html("Name max 50 characters.");
            } else if (comment.lenght > 500) {
                $("#comment-error").css("display", "block");
                $("#comment-error").html("Message max 500 characters.");
            } else if (checkEmail(email) == false) {
                $("#comment-error").css("display", "block");
                $("#comment-error").html("Please enter a valid email address.");
            } else {
                var date = new Date();
                var months = ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"];
                var dateFormated = months[date.getMonth()] + " " + date.getDate() + ", " + date.getFullYear();
                $.ajax({
                    method: "POST",
                    url: "includes/add-comment.php",
                    data: $(this).serialize(),
                    success: function(data) {
                        if (data == "success") {
                            var newComment = "<li class='depth-1 comment'><div class='comment__avatar'><img class='avatar' src='assets/images/avatar.jpg' alt='' width='50' height='50'></div><div class='comment__content'><div class='comment__info'><div class='comment__author'>" + name + "</div><div class='comment__meta'><div class='comment__time'>" + dateFormated + "</div></div></div><div class='comment__text'><p>" + comment + "</p></div></div></li>";
                            $("#comment-success").css("display", "block");
                            $("#commentlist").append(newComment);
                            $("#commentForm").hide();
                        } else {
                            $("#comment-error").css("display", "block");
                            $("#comment-error").html("Error! Please try again later.");
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>