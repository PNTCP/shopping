<?php
    session_start();
    require_once('config/db.php');
    include 'include/theme.php';

    $query = $conn->query("SELECT * FROM products");
    $products = $query->fetchAll(PDO::FETCH_ASSOC);
    $rows = count($products);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style/bootstrap.css" rel="stylesheet">
    <title>List Product</title>
    
</head>
<body >
    <script src="style/bootstrap.js"></script>
    <?php include 'include/menu.php';?>
    <?php if(!empty($_SESSION['message'])): ?>
        <div class="alert alert-success" role="alert">
                <?php
                    echo $_SESSION['message'];
                    unset ($_SESSION['message']);
                ?>
        </div>
    <?php endif ;?>

    <div class ="container" style="margin-top: 30px">
        <h4>Home - Manage Product</h4>
       
        <div class="row g-5">
            <div class="col-md-8 col-sm-12">
            <hr class="my-4">
                <form action="product_form.php" method="post" enctype="multipart/form-data">
                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label class="form-label">Product Name</label>
                            <input type="text" name="product_name" class="form-control" value="">
                        </div>

                        <div class="col-sm-6">
                            <label class="form-label">Price</label>
                            <input type="text" name="product_price" class="form-control" value="">
                        </div>

                        <div class="col-sm-6">
                            <label for="formFile" class="form-label">Image</label>
                            <input type="file" name="product_img" class="form-control" accept="image/png, image/jpg, image/jpeg">
                        </div>

                        <div class="col-sm-12">
                            <label class="form-label">Deltail</label>
                            <textarea name="detail" class="form-control" row="3"></textarea>
                        </div>
                    </div>
                    
                    <button class="btn btn-primary" type="submit">Create</button>
                    <hr class="my-4">

                </form>
            </div>
        </div>
      </div>

      <div class="row">
    <div class="col-12">
        <table class="table table-bordered border-info">
            <thead>
                <tr>
                    <th style="width: 100px;">Image</th>
                    <th>Product Name</th>
                    <th style="width: 200px;">Price</th>
                    <th style="width: 200px;">Action</th>
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
                            <td>
                            <a onclick="return confirm('Are you sure you wnat to delete')" role="button" href="product_delete.php?id=<?php echo $product['product_id']; ?>" class="btn btn-outline-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4"><h4 class="alert alert-warning">ไม่มีรายการสินค้า</h4></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

    


</body>
</html>