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
<body>
    <!-- Navbar -->
    <div class="navbar">
        <?php if ($isLoggedIn): ?>
            <p>Chào, <?php echo $_SESSION['user']['username']; ?>!</p>
            <a href="logout.php">Đăng xuất</a>
        <?php else: ?>
            <a href="login.php">Đăng nhập</a> | <a href="register.php">Đăng ký</a>
        <?php endif; ?>
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
</body>
</html>
