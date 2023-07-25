<?php

    session_start();
    // Add Post
    unset($_SESSION['title']);
    unset($_SESSION['metaTitle']);
    unset($_SESSION['category']);
    unset($_SESSION['summary']);
    unset($_SESSION['content']);
    unset($_SESSION['tags']);
    unset($_SESSION['slug']);
    unset($_SESSION['placement']);
    // Update Post
    unset($_SESSION['edit-post-id']);
    unset($_SESSION['edit-title']);
    unset($_SESSION['edit-meta-title']);
    unset($_SESSION['edit-category-id']);
    unset($_SESSION['edit-summary']);
    unset($_SESSION['edit-content']);
    unset($_SESSION['edit-slug']);
    unset($_SESSION['edit-tags']);
    unset($_SESSION['edit-home-placement']);