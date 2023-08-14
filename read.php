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
    </section>
    <?php include "footer.php"; ?>
    <script src="assets/js/jquery-3.5.0.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>