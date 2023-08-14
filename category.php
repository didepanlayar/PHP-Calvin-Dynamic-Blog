<?php
    require "dashboard/includes/config.php";
    if (isset($_REQUEST['group'])) {
        $slug = $_REQUEST['group'];
        $sqlGetCategory = "SELECT * FROM categories WHERE category_url = '$slug'";
        $queryGetCategory = mysqli_query($connect, $sqlGetCategory);
        if ($rowGetCategory = mysqli_fetch_assoc($queryGetCategory)) {
            $categoryId = $rowGetCategory['category_id'];
            $categoryTitle = $rowGetCategory['category_title'];
            $categoryMetaTitle = $rowGetCategory['category_meta_title'];
        }
        else {
            header("Location: index.php");
            exit();
        }
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <title>Calvin - <?php echo $categoryTitle; ?></title>
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
        <div class="s-pageheader">
            <div class="row">
                <div class="column large-12">
                    <h1 class="page-title">
                        <span class="page-title__small-type">Category</span>
                        <?php echo $categoryTitle; ?>
                    </h1>
                </div>
            </div>
        </div>
        <div class="s-bricks s-bricks--half-top-padding">
            <div class="masonry">
                <div class="bricks-wrapper h-group">
                    <div class="grid-sizer"></div>
                    <div class="lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <?php
                        $sqlGetAllPosts = "SELECT * FROM posts WHERE category_id = '$categoryId' AND post_status = '1' ORDER BY post_id DESC";
                        $queryGetAllPosts = mysqli_query($connect, $sqlGetAllPosts);
                        while ($rowGetAllPosts = mysqli_fetch_assoc($queryGetAllPosts)) {
                            $postTitle = $rowGetAllPosts['post_title'];
                            $postSlug = $rowGetAllPosts['post_url'];
                            $postSummary = $rowGetAllPosts['post_summary'];
                            $postAltImage = $rowGetAllPosts['alt_image_url'];
                    ?>
                            <article class="brick entry" data-aos="fade-up">
                                <div class="entry__thumb">
                                    <a href="read.php?post=<?php echo $postSlug; ?>" class="thumb-link">
                                        <img src="<?php echo $postAltImage; ?>" srcset="<?php echo $postAltImage; ?> 1x, <?php echo $postAltImage; ?>" alt="">
                                    </a>
                                </div>
                                <div class="entry__text">
                                    <div class="entry__header">
                                        <h1 class="entry__title"><a href="read.php?post=<?php echo $postSlug; ?>"><?php echo $postTitle; ?></a></h1>
                                        <div class="entry__meta">
                                            <span class="byline">By:
                                                <span class='author'>
                                                    <a href="#">Di Depan Layar</a>
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="entry__excerpt">
                                        <p><?php echo $postSummary; ?></p>
                                    </div>
                                    <a class="entry__more-link" href="read.php?post=<?php echo $postSlug; ?>">Read More</a>
                                </div>
                            </article>
                    <?php
                        }
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="column large-12">
                    <nav class="pgn">
                        <ul>
                            <li>
                                <span class="pgn__prev" href="#0">
                                    Prev
                                </span>
                            </li>
                            <li><a class="pgn__num" href="#0">1</a></li>
                            <li><span class="pgn__num current">2</span></li>
                            <li><a class="pgn__num" href="#0">3</a></li>
                            <li><a class="pgn__num" href="#0">4</a></li>
                            <li><a class="pgn__num" href="#0">5</a></li>
                            <li><span class="pgn__num dots">…</span></li>
                            <li><a class="pgn__num" href="#0">8</a></li>
                            <li>
                                <span class="pgn__next" href="#0">
                                    Next
                                </span>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <?php include "footer.php"; ?>
    <script src="assets/js/jquery-3.5.0.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
<?php
    }
    else {
        header("Location: index.php");
        exit();
    }
?>