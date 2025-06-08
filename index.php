<?php
session_start();
require_once(__DIR__ . '/inc/requires.php');

if (isset($_SESSION['LOGGED_USER'])) {
    redirectToUrl('pages/home.html.php');
}

redirectToUrl('security/login.html.php');
