<?php
session_start();
require_once ('config/db.php');
include 'include/theme.php';

if (!isset($_SESSION['user_login']) && !isset($_SESSION['admin_login'])) {
    header('location: login.php');
}

$rows = 0; // กำหนดค่าเริ่มต้น

if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    $productids = [];
    foreach ($_SESSION['cart'] as $cartid => $cartqty) {
        $productids[] = $cartid;
    }

    // ตรวจสอบว่ามีสินค้าในตะกร้าหรือไม่
    if (!empty($productids)) {
        // สร้าง array ของ placeholder
        $placeholders = array_fill(0, count($productids), '?');

        // สร้างสตริงของ placeholder แบบ comma-separated
        $placeholderString = implode(',', $placeholders);

        // สร้างคำสั่ง SQL พร้อม placeholders
        $sql = "SELECT * FROM products WHERE product_id IN ($placeholderString)";

        // ตรงนี้คือการใช้คำสั่ง SQL พร้อมกับ array ของค่าที่จะ bind
        $query = $conn->prepare($sql);
        $query->execute($productids);

        // ดึงผลลัพธ์
        $products = $query->fetchAll(PDO::FETCH_ASSOC);
        $rows = count($products);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style/bootstrap.css" rel="stylesheet">
    <title>Cart</title>
</head>
<body class="bg-body-tertiary">
    <script src="style/bootstrap.js"></script>
    <?php include 'include/menu.php'; ?>
    <div class="container" style="margin-top: 30px;"></div>
    
    <?php if (!empty($_SESSION['message'])): ?>
        <div class="alert alert-success" role="alert">
            <?php
                echo $_SESSION['message'];
                unset ($_SESSION['message']);
            ?>
        </div>
    <?php endif; ?>

    <div class="album py-5 bg-body-tertiary">
    <div class ="container">
    <h4>Cart</h4>
        <div class="row">
            <div class="col-12">
                <form action ="cart_update.php" method="post">
                <table class="table table-bordered border-info">
            <thead>
                <tr>
                    <th style="width: 100px;">Image</th>
                    <th>Product Name</th>
                    <th style="width: 200px;">Price</th>
                    <th style="width: 100px;">Quantity</th>
                    <th style="width: 200px;">Total</th>
                    <th style="width: 120px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($rows > 0): ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td>
                                <?php if (!empty($product['product_img'])): ?>
                                    <img src="upload_img/<?php echo $product['product_img']; ?>" width="100px">
                                <?php else: ?>
                                    <img src="style/img/no_imge.jpg<?php echo $product['product_img']; ?>" width="100px">
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($product['product_name']); ?>
                                <div>
                                    <small class="text-muted"><?php echo nl2br(htmlspecialchars($product['detail'])); ?></small>
                                </div>
                            </td>
                            <td><?php echo number_format($product['product_price']); ?></td>
                            <td><input type="number" name="product[<?php echo $product['product_id']?>][quantity]" value="<?php echo $_SESSION['cart'][$product['product_id']];?>" class="form-control"></td>
                            <td>
                                <?php echo number_format($product['product_price'] * $_SESSION['cart'][$product['product_id']]);?>
                            </td>
                            <td>
                            <a onclick="return confirm('Are you sure you wnat to delete')" role="button" href="cart_delete.php?id=<?php echo $product['product_id']; ?>" class="btn btn-outline-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="6" class="text-end">
                            <a href="product_list.php" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-lh btn-success">Update Cart</button>
                            <a href="checkout.php" class="btn btn-lh btn-primary">CheckOut Order</a>
                        </td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="6"><h4 class="alert alert-warning">ไม่มีรายการสินค้าในตะกร้า</h4></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
                </form>
            
            </div>
        </div>
    </div>
</body>
</html>
