<?php
session_start();
include 'includes/db.php';

// Kiểm tra trạng thái đăng nhập
$isLoggedIn = isset($_SESSION['user']);

// Lấy danh sách sản phẩm
$query = "SELECT * FROM products";
$result = $conn->query($query);
$products = $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Web Bán Điện Thoại</title>
</head>
<body style="position: relative;">
   <!-- Navbar -->
   <div class="navbar" style="padding-left: 70%;width: 100%;height: 80px;background-color: #b3b0b0; position: fixed; top: 0px;">
        <?php if ($isLoggedIn): ?>
            <p style="font-weight: bold;display: inline-block ;margin-left: 20px;">Chào, <?php echo $_SESSION['user']['username']; ?>!</p>
            <a href="logout.php" style="display: inline-block; margin-top: 17px; background-color: rgb(127, 58, 58); padding: 10px 15px; border-radius: 5px; color: white; text-align: center; border: 1px solid red; border: 5px;">Đăng xuất</a>
            <a href="cart.php" style="display: inline-block ;padding; margin-top: 17px; border-radius: 50%; background-color: rgb(127, 58, 58); padding: 15px 15px; color: white; text-align: center; border: 1px solid red; border: 5px;">Giỏ hàng</a>
        <?php else: ?>
            <a href="login.php" style="display: inline-block; margin-left: 20px; margin-top: 20px; background-color: rgb(127, 58, 58); padding: 10px 15px; border-radius: 5px; color: white; text-align: center; border: 1px solid red; border: 5px;">Đăng nhập</a><a href="register.php" style="display: inline-block; margin-left: 20px; margin-top: 20px; border-radius: 5px; background-color: rgb(127, 58, 58); padding: 10px 15px; color: white; text-align: center; border: 1px solid red; border: 5px;">Đăng ký</a>
    
        <?php endif; ?>
    </div>
    <!-- Banner -->
<div style="background-image: url(https://images.samsung.com/is/image/samsung/assets/eg/smartphones/galaxy-s23-ultra/images/galaxy-s23-ultra-highlights-kv.jpg?$ORIGIN_JPG$);background-repeat: no-repeat;background-size: cover; color: white; padding: 20px 0; margin-bottom: 20px;height: 800px; margin-top: 80px;">
<div class="banner-text">
            <h1 style="font-size: 3em; margin: 0;">Galaxy S23 Ultra</h1>
            <p style="font-size: 1.2em; margin: 10px 0;">Đỉnh cao công nghệ - Camera 200MP, Hiệu năng vượt trội</p>
            <a href="product.php?id=2" style="display: inline-block; padding: 10px 20px; background-color: #e50914; /* Màu đỏ nổi bật */ color: white; text-decoration: none; border-radius: 5px;font-weight: bold;">Khám phá ngay</a>
        </div>
</div>

    <!-- Danh sách sản phẩm -->
    <h1>Danh sách sản phẩm</h1>
    <?php if (count($products) > 0): ?>
        <div class="product-list">
            <?php foreach ($products as $row): ?>
                <div class="product">
                    <img src="images/<?php echo !empty($row['image']) ? $row['image'] : 'default.jpg'; ?>" alt="<?php echo $row['name']; ?>">
                    <h2><?php echo $row['name']; ?></h2>
                    <p>Giá: <?php echo number_format($row['price'], 0, ',', '.'); ?> VNĐ</p>
                    <a href="product.php?id=<?php echo $row['id']; ?>">Xem chi tiết</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Hiện tại không có sản phẩm nào.</p>
    <?php endif; ?>
    <!-- Footer -->
<footer style="background-color: #333; color: white; text-align: center; padding: 10px 0; width: 100%;">
    <p>&copy; 2025 Web Bán Điện Thoại. Tất cả các quyền được bảo lưu.</p>
    <p>Liên hệ: <a href="mailto:support@webbanhang.com" style="color: #f4a261;">support@webbanhang.com</a></p>
</footer>

</body>
</html>
