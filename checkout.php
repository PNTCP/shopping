<?php
session_start();
require_once('config/db.php');
include 'include/theme.php';

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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style/bootstrap.css" rel="stylesheet">
    <title>List Product</title>
</head>
<body class="bg-body-tertiary">
    <script src="style/bootstrap.js"></script>
    <?php include 'include/menu.php'; ?>
    <div class="container" style="margin-top: 30px;"></div>
    
    <?php if (!empty($_SESSION['message'])): ?>
        <div class="alert alert-success" role="alert">
            <?php
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            ?>
        </div>
    <?php endif; ?>

    <h4 class="mb-3">Checkout</h4>
    <form action="checkout_form.php" method="post">
        <div class="row g-5">
            <div class="col-md-6 col-lg-7">
                <!-- ที่นี่คือส่วนของฟอร์ม -->
                <div class="row g-3">
                        <div class="col-sm-12">
                            <label class="form-label">Fullname</label>
                            <input type="text" class="form-control" name="fullname" placeholder="" value="">
                        </div>
                        <div class="col sm-6">
                            <label class="form-label">Tel</label>
                            <input type="text" class="form-control" name="tel" placeholder="" value="">
                        </div>
                        <div class="col sm-6">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" name="address" placeholder="บ้านเลขที่ ซอย(ถ้ามี) ถ./ต./อ./จ./" value="">
                        </div>
                    </div>
                    <hr class="my-4">
                    <div class="text-end">
                        <a href="cart.php" class="btn btn-secondary btn-lg" role="button">Back</a>
                        <button class="btn btn-primary btn-lg" type="submit">Continue</button>
                    </div>
                </div>

            <div class="col-md-5 col-lg-4 order-md-last">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-primary">Your cart</span>
                    <span class="badge bg-primary rounded-pill"><?php echo $rows; ?></span>
                </h4>

                <?php if(isset($products) && $rows > 0): ?>
                    <ul class="list-group mb-3">
                        <?php $grand_total = 0; ?>
                        <?php foreach ($products as $product): ?>
                            <li class="list-group-item d-flex justify-content-between lh-sm">
                                <!-- แสดงข้อมูลสินค้าที่นี่ -->
                                <div>
                                    <h6 class="my-0"><?php echo $product['product_name']; ?> (<?php echo $_SESSION['cart'][$product['product_id']]; ?>)</h6>
                                    <small class="text-body-secondary"><?php echo nl2br($product['detail']); ?></small>
                                    <input type="hidden" name="product[<?php echo $product['product_id'];?>][price]" value="<?php echo $product['product_price']; ?>">
                                    <input type="hidden" name="product[<?php echo $product['product_id'];?>][name]" value="<?php echo $product['product_name']; ?>">
                                    <input type="hidden" name="product[<?php echo $product['product_id'];?>][quantity]" value="<?php echo $_SESSION['cart'][$product['product_id']]; ?>">
                                </div>
                            </li>
                            <?php $grand_total += $_SESSION['cart'][$product['product_id']] * $product['product_price']; ?>
                        <?php endforeach; ?>
                        <li class="list-group-item d-flex justify-content-between bg-body-tertiary">
                            <div class="text-success">
                                <h6 class="my-0">Grand Total</h6>
                                <small>Amount</small>
                            </div>
                            <span class="text-success"><strong>$<?php echo number_format($grand_total)?></strong></span>
                        </li>
                    </ul>
                    <input type="hidden" name="grand_total" value="<?php echo $grand_total; ?>">
                <?php endif; ?>
            </div>
        </div>
    </form>
</body>
</html>
