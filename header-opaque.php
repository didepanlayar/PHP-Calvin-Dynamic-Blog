<?php
    $sqlCategories = "SELECT * FROM categories";
    $queryCategories = mysqli_query($connect, $sqlCategories);
?>
    <header class="s-header s-header--opaque">
        <div class="s-header__logo">
            <a class="logo" href="<?php echo $base_url; ?>">
                <img src="assets/images/logo.svg" alt="Homepage">
            </a>
        </div>
        <div class="row s-header__navigation">
            <nav class="s-header__nav-wrap">
                <h3 class="s-header__nav-heading h6">Navigate to</h3>
                <ul class="s-header__nav">
                    <li class="current"><a href="<?php echo $base_url; ?>" title="">Home</a></li>
                    <li class="has-children">
                        <a href="category.php" title="">Categories</a>
                        <ul class="sub-menu">
                            <?php
                                while ($rowCategories = mysqli_fetch_assoc($queryCategories)) {
                                    $categoryName = $rowCategories['category_title'];
                                    $categorySlug = $rowCategories['category_url'];
                            ?>
                                    <li><a href="category.php?group=<?php echo $categorySlug; ?>"><?php echo $categoryName; ?></a></li>
                            <?php
                                }
                            ?>
                        </ul>
                    </li>
                    <li><a href="about.php" title="">About</a></li>
                    <li><a href="contact.php" title="">Contact</a></li>
                </ul>
                <a href="#0" title="Close Menu" class="s-header__overlay-close close-mobile-menu">Close</a>
            </nav>
        </div>
        <a class="s-header__toggle-menu" href="#0" title="Menu"><span>Menu</span></a>
        <div class="s-header__search">
            <div class="s-header__search-inner">
                <div class="row wide">
                    <form role="search" method="get" class="s-header__search-form" action="search.php">
                        <label>
                            <span class="h-screen-reader-text">Search for:</span>
                            <input type="search" class="s-header__search-field" placeholder="Search for..." value="" name="query" title="Search for:" autocomplete="off">
                        </label>
                        <input type="submit" class="s-header__search-submit" value="Search">
                    </form>
                    <a href="#close" title="Close Search" class="s-header__overlay-close">Close</a>
                </div>
            </div>
        </div>
        <a class="s-header__search-trigger" href="#">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17.982 17.983"><path fill="#010101" d="M12.622 13.611l-.209.163A7.607 7.607 0 017.7 15.399C3.454 15.399 0 11.945 0 7.7 0 3.454 3.454 0 7.7 0c4.245 0 7.699 3.454 7.699 7.7a7.613 7.613 0 01-1.626 4.714l-.163.209 4.372 4.371-.989.989-4.371-4.372zM7.7 1.399a6.307 6.307 0 00-6.3 6.3A6.307 6.307 0 007.7 14c3.473 0 6.3-2.827 6.3-6.3a6.308 6.308 0 00-6.3-6.301z"/></svg>
        </a>
    </header>