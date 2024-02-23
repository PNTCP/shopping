<header>
<div class="container">
   <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
      <div class="col-md-3 mb-2 mb-md-0">
        <a href="/" class="d-inline-flex link-body-emphasis text-decoration-none">
        <?php
          if (isset($_SESSION['user_login'])){
            $firstname = $_SESSION['user_login'];
            $stmt = $conn->query("SELECT * FROM users WHERE id = $firstname");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            echo $row['firstname'];
          }elseif (isset($_SESSION['admin_login'])){
            $firstname = $_SESSION['admin_login'];
            $stmt = $conn->query("SELECT * FROM users WHERE id = $firstname");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            echo $row['firstname'];
          }else
            echo 'SKSC';
        ?>
        </a>
      </div>

      <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
        <li><a href="product_list.php" class="nav-link px-2">Home</a></li>
        <?php if(!isset($_SESSION['user_login']) && !isset($_SESSION['admin_login'])){
          echo '<li><a href="cart.php" class="nav-link px-2">Cart (0)</a></li>';
        }else{
          echo '<li><a href="cart.php" class="nav-link px-2">Cart (' . count($_SESSION['cart'] ?? []) . ')</a></li>';
        }
        ?>
        <li><a href="order_history.php" class="nav-link px-2">History</a></li>
        <?php if(isset($_SESSION['admin_login']))
        echo '<li><a href="management.php" class="nav-link px-2">Management</a></li>'
        ?>
      </ul>

      <div class="col-md-3 text-end">
        <?php if (isset($_SESSION['user_login'])){
          echo '<a href="logout.php" class="btn btn-danger">Logout</a>';
        }elseif (isset($_SESSION['admin_login'])){
          echo '<a href="logout.php" class="btn btn-danger">Logout</a>'; 
        }else{
          echo '<a href="login.php"><button type="button" class="btn btn-outline-primary me-2">Login</button></a>';
          echo '<a href="register.php"><button type="button" class="btn btn-primary">Sign-up</button></a>';
        }
        
        ?>


      </div>
    </div>
</header>