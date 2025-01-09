<?php
include 'includes/db.php';

// Kiểm tra xem id có tồn tại và hợp lệ không
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Truy vấn thông tin sản phẩm
    $query = "SELECT * FROM products WHERE id = $id";
    $result = $conn->query($query);

    // Kiểm tra xem sản phẩm có tồn tại không
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        // Nếu không tìm thấy sản phẩm, chuyển hướng về trang chủ
        header("Location: index.php");
        exit();
    }
} else {
    // Nếu không có id hợp lệ, chuyển hướng về trang chủ
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Chi tiết sản phẩm</title>
</head>
<body>
    <h1><?php echo htmlspecialchars($product['name']); ?></h1>
    <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
    <p>Giá: <?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ</p>
    <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
    <a href="cart.php?action=add&id=<?php echo $product['id']; ?>">Thêm vào giỏ hàng</a>
</body>
</html>