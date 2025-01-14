<?php
session_start();
include 'includes/db.php';

// Kiểm tra giỏ hàng
$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    echo "<p>Giỏ hàng của bạn trống. Vui lòng thêm sản phẩm vào giỏ hàng trước khi thanh toán.</p>";
    exit();
}

// Tính toán tổng giá trị giỏ hàng
$total = 0;
foreach ($cart as $id => $quantity) {
    $query = "SELECT price FROM products WHERE id = $id";
    $result = $conn->query($query);
    $product = $result->fetch_assoc();
    $subtotal = $product['price'] * $quantity;
    $total += $subtotal;
    
}

// Xử lý thông tin thanh toán khi người dùng gửi form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    // Kiểm tra thông tin người dùng
    if (empty($name) || empty($address) || empty($phone) || empty($email)) {
        echo "<p>Vui lòng điền đầy đủ thông tin.</p>";
    } else {
        // Lưu thông tin đơn hàng vào cơ sở dữ liệu
        $query = "INSERT INTO orders (`name`, `address`, `phone`, `email`, `total`) VALUES ('$name', '$address', '$phone', '$email', '$total')";
        if ($conn->query($query)) {
            $order_id = $conn->insert_id; // Lấy ID của đơn hàng vừa tạo

            // Lưu chi tiết đơn hàng
            foreach ($cart as $id => $quantity) {
                $query = "SELECT price FROM products WHERE id = $id";
                $result = $conn->query($query);
                $product = $result->fetch_assoc();
                $subtotal = $product['price'] * $quantity;

                $query = "INSERT INTO orderdetail (order_id, product_id, quantity, price) VALUES ($order_id, $id, $quantity, $subtotal)";
                $conn->query($query);
            }

            // Xóa giỏ hàng sau khi thanh toán
            unset($_SESSION['cart']);
            echo "<p style=\"text-align: center; margin: 20px 0;font-size:1.3em; color: #333;\">Đơn hàng của bạn đã được thanh toán thành công. Cảm ơn bạn!</p>";
        } else {
            echo "<p>Đã xảy ra lỗi khi thanh toán. Vui lòng thử lại.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Thanh toán</title>
</head>
<body style="width :1256px; margin: auto;">
    <h1>Thanh toán</h1>

    <h2>Thông tin đơn hàng</h2>
    <table>
        <tr>
            <th>Sản phẩm</th>
            <th>Số lượng</th>
            <th>Giá</th>
        </tr>
        <?php
        // Hiển thị các sản phẩm trong giỏ hàng
        foreach ($cart as $id => $quantity):
            $query = "SELECT * FROM products WHERE id = $id";
            $result = $conn->query($query);
            $product = $result->fetch_assoc();
            $subtotal = $product['price'] * $quantity;
        ?>
        <tr>
<td><?php echo htmlspecialchars($product['name']); ?></td>
            <td><?php echo $quantity; ?></td>
            <td><?php echo number_format($subtotal, 0, ',', '.'); ?> VNĐ</td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="2">Tổng cộng</td>
            <td><?php echo number_format($total, 0, ',', '.'); ?> VNĐ</td>
        </tr>
    </table>

    <h2>Nhập thông tin thanh toán</h2>
    <form action="checkout.php"style="padding: auto;position: relative; margin: auto; background-color: #34495e; width: 35%;height: 200px; border-radius: 10px;padding-top:4%;" method="POST">
        <label for="name" style="font-size: 1.2em;color: white; font-weight: bold; margin-left: 60px;">Họ và tên:</label>
        <input type="text" style="height: 15px;position: absolute; right: 40px; width: 200px; " name="name" id="name" required><br>

        <label for="address" style="font-size: 1.2em;color: white; font-weight: bold; margin-left: 60px;">Địa chỉ:</label>
        <input type="text" style="height: 15px;position: absolute; right: 40px; width: 200px; " name="address" id="address" required><br>

        <label for="phone" style="font-size: 1.2em;color: white; font-weight: bold; margin-left: 60px;">Số điện thoại:</label>
        <input type="text" style="height: 15px;position: absolute; right: 40px; width: 200px; " name="phone" id="phone" required><br>

        <label for="email" style="font-size: 1.2em;color: white; font-weight: bold; margin-left: 60px;">Email:</label>
        <input type="email" style="height: 15px;position: absolute; right: 40px; width: 200px;  " name="email" id="email" required><br>

        <button type="submit" style="display: inline-block; position: absolute; right: 40px;cursor: pointer;  margin-top: 20px; background-color: rgb(127, 58, 58); padding: 10px 15px; border-radius: 5px; color: white; text-align: center; border: 1px solid red; border: 5px;">Thanh toán</button>
    </form>
</body>
</html>
