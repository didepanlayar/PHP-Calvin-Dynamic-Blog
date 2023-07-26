<?php
    include "dashboard/includes/config.php";
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <title>Calvin</title>
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
    <?php include "header.php"; ?>
    <section id="hero" class="s-hero">
        <div class="s-hero__slider">
            <!-- Home Placement: 1 -->
            <?php
                $sqlGetFirstPost = "SELECT * FROM posts INNER JOIN categories ON posts.category_id = categories.category_id WHERE post_placement = '1' AND post_status != '2' LIMIT 1";
                $queryGetFirstPost = mysqli_query($connect, $sqlGetFirstPost);
                if ($rowGetFirstPost = mysqli_fetch_assoc($queryGetFirstPost)) {
                    $FirstPostCategory = $rowGetFirstPost['category_title'];
                    $FirstPostCategorySlug = $rowGetFirstPost['category_url'];
                    $FirstPostTitle = $rowGetFirstPost['post_title'];
                    $FirstPostSlug = $rowGetFirstPost['post_url'];
                    $FirstPostMainImage = $rowGetFirstPost['main_image_url'];
            ?>
                    <div class="s-hero__slide">
                        <div class="s-hero__slide-bg" style="background-image: url('<?php echo $FirstPostMainImage; ?>');"></div>
                        <div class="row s-hero__slide-content animate-this">
                            <div class="column">
                                <div class="s-hero__slide-meta">
                                    <span class="cat-links">
                                        <a href="category.php?group=<?php echo $FirstPostCategorySlug; ?>"><?php echo $FirstPostCategory; ?></a>
                                    </span>
                                    <span class="byline"> 
                                        Posted by 
                                        <span class="author">
                                            <a href="#0">Jonathan Doe</a>
                                        </span>
                                    </span>
                                </div>
                                <h1 class="s-hero__slide-text">
                                    <a href="read.php?post=<?php echo $FirstPostSlug; ?>"><?php echo $FirstPostTitle; ?></a>
                                </h1>
                            </div>
                        </div>
                    </div>
            <?php
                }
            ?>
            <!-- Home Placement: 2 -->
            <?php
                $sqlGetSecondPost = "SELECT * FROM posts INNER JOIN categories ON posts.category_id = categories.category_id WHERE post_placement = '2' AND post_status != '2' LIMIT 1";
                $queryGetSecondPost = mysqli_query($connect, $sqlGetSecondPost);
                if ($rowGetSecondPost = mysqli_fetch_assoc($queryGetSecondPost)) {
                    $SecondPostCategory = $rowGetSecondPost['category_title'];
                    $SecondPostCategorySlug = $rowGetSecondPost['category_url'];
                    $SecondPostTitle = $rowGetSecondPost['post_title'];
                    $SecondPostSlug = $rowGetSecondPost['post_url'];
                    $SecondPostMainImage = $rowGetSecondPost['main_image_url'];
            ?>
                    <div class="s-hero__slide">
                        <div class="s-hero__slide-bg" style="background-image: url('<?php echo $SecondPostMainImage; ?>');"></div>
                        <div class="row s-hero__slide-content animate-this">
                            <div class="column">
                                <div class="s-hero__slide-meta">
                                    <span class="cat-links">
                                        <a href="category.php?group=<?php echo $SecondPostCategorySlug; ?>"><?php echo $SecondPostCategory; ?></a>
                                    </span>
                                    <span class="byline"> 
                                        Posted by 
                                        <span class="author">
                                            <a href="#0">Jonathan Doe</a>
                                        </span>
                                    </span>
                                </div>
                                <h1 class="s-hero__slide-text">
                                    <a href="read.php?post=<?php echo $SecondPostSlug; ?>"><?php echo $SecondPostTitle; ?></a>
                                </h1>
                            </div>
                        </div>
                    </div>
            <?php
                }
            ?>
            <!-- Home Placement: 3 -->
            <?php
                $sqlGetThirdPost = "SELECT * FROM posts INNER JOIN categories ON posts.category_id = categories.category_id WHERE post_placement = '3' AND post_status != '2' LIMIT 1";
                $queryGetThirdPost = mysqli_query($connect, $sqlGetThirdPost);
                if ($rowGetThirdPost = mysqli_fetch_assoc($queryGetThirdPost)) {
                    $ThirdPostCategory = $rowGetThirdPost['category_title'];
                    $ThirdPostCategorySlug = $rowGetThirdPost['category_url'];
                    $ThirdPostTitle = $rowGetThirdPost['post_title'];
                    $ThirdPostSlug = $rowGetThirdPost['post_url'];
                    $ThirdPostMainImage = $rowGetThirdPost['main_image_url'];
            ?>
                    <div class="s-hero__slide">
                        <div class="s-hero__slide-bg" style="background-image: url('<?php echo $ThirdPostMainImage; ?>');"></div>
                        <div class="row s-hero__slide-content animate-this">
                            <div class="column">
                                <div class="s-hero__slide-meta">
                                    <span class="cat-links">
                                        <a href="category.php?group=<?php echo $ThirdPostCategorySlug; ?>"><?php echo $ThirdPostCategory; ?></a>
                                    </span>
                                    <span class="byline"> 
                                        Posted by 
                                        <span class="author">
                                            <a href="#0">Jonathan Doe</a>
                                        </span>
                                    </span>
                                </div>
                                <h1 class="s-hero__slide-text">
                                    <a href="read.php?post=<?php echo $ThirdPostSlug; ?>"><?php echo $ThirdPostTitle; ?></a>
                                </h1>
                            </div>
                        </div>
                    </div>
            <?php
                }
            ?>
        </div>
        <div class="s-hero__social hide-on-mobile-small">
            <p>Follow</p>
            <span></span>
            <ul class="s-hero__social-icons">
                <li><a href="https://facebook.com"><i class="fab fa-facebook-f" aria-hidden="true"></i></a></li>
                <li><a href="https://instagram.com"><i class="fab fa-instagram" aria-hidden="true"></i></a></li>
                <li><a href="https://twitter.com"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>
                <li><a href="https://youtube.com"><i class="fab fa-youtube" aria-hidden="true"></i></a></li>
            </ul>
        </div>
        <div class="nav-arrows s-hero__nav-arrows">
            <button class="s-hero__arrow-prev">
                <svg viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg" width="15" height="15"><path d="M1.5 7.5l4-4m-4 4l4 4m-4-4H14" stroke="currentColor"></path></svg>
            </button>
            <button class="s-hero__arrow-next">
               <svg viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg" width="15" height="15"><path d="M13.5 7.5l-4-4m4 4l-4 4m4-4H1" stroke="currentColor"></path></svg>
            </button>
        </div>
    </section>
    <section class="s-content">
        <div class="row">
            <div class="column large-12">
                <article class="s-content__entry">
                    <div class="s-content__entry-header">
                        <h1 class="s-content__title">Home</h1>
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