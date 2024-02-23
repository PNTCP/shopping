<?php
    session_start();
    require_once("config/db.php");

    if (isset($_POST['signup'])){
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $nickname = $_POST['nickname'];
        $email = $_POST['email'];
        $telephone = $_POST['telephone'];
        $password = $_POST['password'];
        $c_password = $_POST['c_password'];
        $urole = 'user';

        if (empty($firstname) || empty($lastname) || empty($nickname) || empty($email) || empty($telephone) || empty($password) || empty($c_password)){
            $_SESSION['error'] = 'กรุณากรอกข้อมูลทั้งหมด';
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $_SESSION['error'] = 'รูปแบบอีเมลไม่ถูกต้อง';
        } else if (strlen($password) > 20 || strlen($password) < 5){
            $_SESSION['error'] = 'รหัสผ่านต้องมีความยาวระหว่าง 5 ถึง 20 ตัวอักษร';
        } else if ($password != $c_password){
            $_SESSION['error'] = 'รหัสผ่านไม่ตรงกัน';
        } else {
            try {
                $check_email = $conn->prepare("SELECT email FROM users WHERE email = :email");
                $check_email->bindParam(":email", $email);
                $check_email->execute();

                if($check_email->rowCount() > 0){
                    $_SESSION['warning'] = "มีอีเมลนี้อยู่ในระบบแล้ว <a href='login.php'>คลิกที่นี้</a> เพื่อเข้าสู่ระบบ";
                } else {
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("INSERT INTO users(firstname, lastname,nickname, email, telephone, password, urole)
                                           VALUES(:firstname, :lastname,:nickname, :email, :telephone, :password, :urole)");
                    $stmt->bindParam(":firstname", $firstname);
                    $stmt->bindParam(":lastname", $lastname);
                    $stmt->bindParam(":nickname", $nickname);
                    $stmt->bindParam(":email", $email);
                    $stmt->bindParam(":telephone", $telephone);
                    $stmt->bindParam(":password", $passwordHash);
                    $stmt->bindParam(":urole", $urole);
                    $stmt->execute();
                    $_SESSION['success'] = "สมัครสมาชิกเรียบร้อยแล้ว! <a href='login.php' class='alert-ink'>คลิกที่นี้</a> เพื่อเข้าสู่ระบบ";
                }
            } catch(PDOException $e) {
                $_SESSION['error'] = "มีบางอย่างผิดพลาด: " . $e->getMessage();
            }
        }

        header("location: register.php");
    }

