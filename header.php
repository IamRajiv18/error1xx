<?php
ob_start();
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

include('http/db.conn.php');
include('function.inc.php');









ob_end_flush(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LegalHead - Essential Laws for Youths</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>

    <header>
        <div class=" container header-container">
            <a href="#" class="logo">Legal<span>Head</span></a>
            <button class="mobile-menu-btn">☰</button>
            <nav>
                <ul id="navMenu">
                    <li><a href="#">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#personal-laws">Your Laws</a></li>
                    <li><a href="#resources">Resources</a></li>
                    <li><a href="#youth-laws">Youth Laws</a></li>
                    <li><a href="#faqs">FAQs</a></li>
                    <?php

                    if (isset($_SESSION['LOGIN']) && $_SESSION["LOGIN"] == "yes") { ?>
                        <li><a href="Dashboard">Dashboard</a></li>
                    <?php } else { ?>

                        <li><a href="login.php">Sign-in</a></li>
                    <?php }
                    ?>
                </ul>
            </nav>
        </div>
    </header>