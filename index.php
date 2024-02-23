<?php
    session_start();
    require_once('config/db.php');
    include ('include/theme.php');
    header("Location: product_list.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style/bootstrap.css" rel="stylesheet">
    <title>List Product</title>
    
</head>
<body>
    <script src="style/bootsrap.js"></script>
    <?php include 'include/menu.php';?>
    
</body>
</html>