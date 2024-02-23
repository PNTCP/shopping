<?php
    require_once 'config/db.php';
    session_start();
    $result = [];

    if (isset($_GET['q']) && $_GET['q'] != '') {
        $q = "%{$_GET['q']}%";
        $stmt = $conn->prepare("SELECT * FROM products WHERE product_name LIKE ?");
        $stmt->execute([$q]);
        $stmt->execute();
        $result = $stmt->fetchAll();
    } else {
        // If no search query, retrieve all products
        $stmt = $conn->prepare("SELECT * FROM products");
        $stmt->execute();
        $result = $stmt->fetchAll();
    }
    include 'include/menu.php';
    include 'include/theme.php';
?>

<link href="style/bootstrap.css" rel="stylesheet">
<script src="style/bootstrap.js"></script>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>

<body>
    <div class="container">
        <h4>Product</h4>
        <div class="row">
            <!-- <div class="col-sm-12"> -->
                <form action="search.php" method="get">
                    <div class="mb-3 row">
                        <label class="col-2 col-sm-1 col-form-label d-none d-sm-block">ค้นหาข้อมูล</label>
                        <div class="col-7 col-sm-5">
                            <input type="text" name="q" required class="form-control"
                                placeholder="ระบุชื่อสินค้าที่ต้องการค้นหา"
                                value="<?php if (isset($_GET['q'])) { echo $_GET['q']; } ?>">
                        </div>
                        <div class="col-2 col-sm-1">
                            <button type="submit" class="btn btn-primary">ค้นหา</button>
                        </div>
                        <div class="col-2 col-sm-1">
                            <a href="product_list.php" class="btn btn-warning">Reset</a>
                        </div>
                    </div>
                </form>
                <div class="d-flex flex-wrap">
                    <?php foreach ($result as $row) { ?>
                        <div class="col-3 mb-3">
                            <div class="card" style="width: 18rem;">
                                <?php if (!empty($row['product_img'])): ?>
                                    <img src="upload_img/<?php echo $row['product_img']; ?>" class="card-img-top"
                                        width="100px">
                                <?php else: ?>
                                    <img src="style/img/no_imge.jpg" class="card-img-top" width="100px">
                                <?php endif; ?>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row['product_name']; ?></h5>
                                    <p class="card-text text-success mb-0"><?php echo number_format($row['product_price']); ?></p>
                                    <p class="card-text text-muted"><?php echo nl2br(htmlspecialchars($row['detail'])); ?></p>
                                    <?php
                                    if (isset($_SESSION['user_login'])){
                                        echo '<a href="cart_add.php?id=' .$row['product_id']. '" class="btn btn-outline-primary w-100">Add Cart</a>';
                                    }elseif (isset($_SESSION['admin_login'])){
                                        echo '<a href="cart_add.php?id=' .$row['product_id']. '" class="btn btn-outline-primary w-100">Add Cart</a>';
                                    }else{
                                        echo '<a href="login.php"><button type="button" class="btn btn-outline-primary w-100">Login</button></a>';
                                    }
                                ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</body>
