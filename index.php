<?php
include 'includes/db.php';
$query = "SELECT * FROM products";
$result = $conn->query($query);

// Kiểm tra xem có sản phẩm hay không
if ($result->num_rows > 0) {
    // Sản phẩm có dữ liệu
    $products = $result->fetch_all(MYSQLI_ASSOC);
} else {
    // Không có sản phẩm
    $products = [];
}
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
    <h1>Danh sách sản phẩm</h1>

    <?php if (count($products) > 0): ?>
        <div class="product-list">
            <?php foreach ($products as $row): ?>
                <div class="product">
                    <!-- Kiểm tra xem hình ảnh có tồn tại -->
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