<?php
    $base_url = 'http://localhost/shopping/';
    $servername = "localhost";
    $dbname = "systems";
    $username = "root";
    $password = "";
    
    try {
      $conn = new PDO("mysql:host=$servername;dbname=systems", $username, $password) ;
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //   echo "Connected successfully";
    } catch(PDOException $e) {  
      echo "Connection failed: " . $e->getMessage();
    }