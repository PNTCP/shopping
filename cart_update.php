<?php
    session_start();
    include('config.php');

    foreach($_SESSION['cart'] as $productids => $productqty){
        $_SESSION['cart'][$productids] = $_POST['product'][$productids]['quantity'];
    }

    $_SESSION['message'] = 'Cart Add Success';
    header('location: cart.php');