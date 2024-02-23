<?php
session_start();
require_once 'config/db.php';
include 'include/theme.php';

if (!isset($_SESSION['user_login']) && !isset($_SESSION['admin_login'])) {
    header('location: login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style/bootstrap.css" rel="stylesheet">
    <title>History </title>
</head>

<body class="bg-body-tertiary">
    <script src="style/bootstrap.js"></script>
    <?php include 'include/menu.php'; ?>
    <div class="container" style="margin-top: 30px;"></div>
    <div class="container">
        <h4>History</h4>
        <div class="row">
            <div class="col-12">
                <form action="cart_update.php" method="post">
                    <table class="table table-bordered border-info">
                        <thead>
                            <tr>
                                <th style="width: 100px">OrderID</th>
                                <th style="width: 100px">Name</th>
                                <th style="width: 50px">Quantity</th>
                                <th style="width: 100px;">Total Price</th>
                                <th style="width: 100px;">Date</th>
                                <th style="width: 100px;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT od.product_name, od.total, o.order_date, o.order_status, od.quantity, od.order_id
                                    FROM orders o
                                    INNER JOIN order_details od ON o.id = od.order_id";


                            $hand = $conn->query($sql);
                            while ($row = $hand->fetch(PDO::FETCH_ASSOC)) {
                                $status = $row['order_status'];
                            ?>
                                <tr>
                                    <td><?php echo $row['order_id']; ?></td>
                                    <td><?php echo $row['product_name']; ?></td>
                                    <td><?php echo $row['quantity']; ?></td>
                                    <td><?php echo $row['total']; ?></td>
                                    <td><?php echo $row['order_date']; ?></td>
                                    <td>
                                        <?php
                                        if ($status == 1) {
                                            echo "กำลังจัดส่ง";
                                        } elseif ($status == 2) {
                                            echo "จัดส่งเสร็จสิ้น";
                                        } else {
                                            echo "จัดการพัสดุ";
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
