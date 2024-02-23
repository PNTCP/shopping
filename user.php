<?php
    session_start();
    require_once("config/db.php");
    if (!isset($_SESSION['user_login'])) {
        header('product_list.php');
    }
