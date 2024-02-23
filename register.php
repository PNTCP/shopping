<?php
    session_start();
    require_once("config/db.php");
    include 'include/theme.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration System</title>
    <link href="style/bootstrap.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h3 class="mt-4">Register</h3>
        <hr>
        <form action="register_db.php" method="post">
            <?php if(isset($_SESSION['error'])) {?>
                <div class="alert alert-danger" role="alert">
                    <?php
                        echo $_SESSION['error'];
                        unset ($_SESSION['error']);
                    ?>
                </div>
            <?php }?>
            <?php if(isset($_SESSION['success'])) {?>
                <div class="alert alert-success" role="alert">
                    <?php
                        echo $_SESSION['success'];
                        unset ($_SESSION['success']);
                    ?>
                </div>
            <?php }?>
            <?php if(isset($_SESSION['warning'])) {?>
                <div class="alert alert-warning" role="alert">
                    <?php
                        echo $_SESSION['warning'];
                        unset ($_SESSION['warning']);
                    ?>
                </div>
            <?php }?>
    <div class="mb-3">
        <label for="firstname" class="form-label">First name</label>
        <input type="text" class="form-control" name="firstname" aria-describedby="firstanme">
    </div>
    <div class="mb-3">
        <label for="lastname" class="form-label">Last name</label>
        <input type="text" class="form-control" name="lastname" aria-describedby="lastname">
    </div>
    <div class="mb-3">
        <label for="nickname" class="form-label">Nick name</label>
        <input type="text" class="form-control" name="nickname" aria-describedby="nickname">
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" name="email" aria-describedby="email">
    </div>
    <div class="mb-3">
        <label for="telephone" class="form-label">Phone Number</label>
        <input type="tel" class="form-control" name="telephone">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" name="password">
    </div>
    <div class="mb-3">
        <label for="confirm password" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" name="c_password">
    </div>
    <button type="submit" name="signup" class="btn btn-primary">Sign Up</button>
    </form>
    <hr>
    <p>เป็นสมาชิกแล้วใช่ไหม คลิกที่นี้เพื่อเข้าสู่ระบบ<a href="login.php">เข้าสู่ระบบ</a></p>
    </div>
</body>
</html>