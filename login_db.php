<?php
    session_start();
    require_once("config/db.php");

    if (isset($_POST['signin'])){
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (empty($email) || empty($password)){
            $_SESSION['error'] = 'Enter Complet Information';
            header('location: login.php');
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $_SESSION['error'] = 'Wrong Email';
            header('location: login.php');
        } else if (strlen($password) > 20 || strlen($password) < 5){
            $_SESSION['error'] = 'NOT FOUND USER!';
            header('location: login.php');
        } else {
            try {
                $check_data = $conn->prepare("SELECT * FROM users WHERE email = :email");
                $check_data->bindParam(":email", $email);
                $check_data->execute();
                $row = $check_data->fetch(PDO::FETCH_ASSOC);

                if($check_data->rowCount() > 0){
                    if($email == $row["email"]){
                    if (password_verify($password, $row["password"])){
                        if($row['urole'] == 'admin'){
                            $_SESSION['admin_login'] = $row['id'];
                            header("location: product_list.php");
                        } else {
                            $_SESSION['user_login'] = $row['id'];
                            header("location: product_list.php");
                        }
                    } else {
                        $_SESSION['error'] = 'Wrong Password';
                        header("location: login.php");
                    }
                } else{
                    $_SESSION['error'] = 'Wrong Email';
                    header("location: login.php");
                }
             } else {
                   $_SESSION['error'] = "Have Not Data In System!";
                   header("location: login.php");
                }
            } catch(PDOException $e) {
                $_SESSION['error'] = "Something is Wrong: " . $e->getMessage();
            }
        }
    }