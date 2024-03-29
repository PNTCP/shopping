<?php 
    session_start() ;
    include 'include/theme.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration System PDO</title>
    <link href="style/bootstrap.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h3 class="mt-4">Login</h3>
        <hr>
        <form action="login_db.php" method="post">
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
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" name="email" aria-describedby="email">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" name="password">
    </div>
    <button type="submit" name="signin" class="btn btn-primary">Sign In</button>
    </form>
    <hr>
    <p>Not a member yet? Click here<a href="register.php">Register</a></p>
    </div>
</body>
</html>