<?php
session_start();
include 'includes/db.php';

// Kiểm tra và thêm sản phẩm vào giỏ hàng
if (isset($_GET['action']) && $_GET['action'] == 'add') {
    $id = intval($_GET['id']);  // Đảm bảo id là một số nguyên
    if (!isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] = 1;
    } else {
        $_SESSION['cart'][$id]++;
    }
    header('Location: cart.php');
    exit();
}

// Kiểm tra và xóa sản phẩm khỏi giỏ hàng
if (isset($_GET['action']) && $_GET['action'] == 'remove') {
    $id = intval($_GET['id']);
    unset($_SESSION['cart'][$id]);
    header('Location: cart.php');
    exit();
}

// Lấy giỏ hàng từ session
$cart = $_SESSION['cart'] ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Giỏ hàng</title>
</head>
<body>
    <h1>Giỏ hàng</h1>

    <?php if (empty($cart)): ?>
        <p>Giỏ hàng của bạn hiện tại chưa có sản phẩm nào.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Sản phẩm</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Thao tác</th>
            </tr>
            <?php
            $total = 0;
            foreach ($cart as $id => $quantity):
                $query = "SELECT * FROM products WHERE id = $id";
                $result = $conn->query($query);
                $product = $result->fetch_assoc();
                $subtotal = $product['price'] * $quantity;
                $total += $subtotal;
            ?>
            <tr>
                <td><?php echo htmlspecialchars($product['name']); ?></td>
                <td><?php echo $quantity; ?></td>
                <td><?php echo number_format($subtotal, 0, ',', '.'); ?> VNĐ</td>
                <td><a href="cart.php?action=remove&id=<?php echo $id; ?>">Xóa</a></td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="2">Tổng cộng</td>
                <td><?php echo number_format($total, 0, ',', '.'); ?> VNĐ</td>
            </tr>
        </table>
        <a href="checkout.php" style="display: inline-block; margin-left: 45%; margin-top: 5px; background-color: rgb(127, 58, 58); padding: 10px 15px; border-radius: 5px; color: white; text-align: center; border: 1px solid red; border: 5px;">Thanh toán</a>
    <?php endif; ?>
</body>
</html>