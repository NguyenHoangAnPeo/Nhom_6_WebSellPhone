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
    <div style="padding: auto;margin: auto; background-color: #34495e; width: 35%;height: 500px; border-radius: 10px;padding-top:4%;">
        <div style="height: 60%; padding: 0px; width: 45%;border-radius: 5px; background-color: white;margin: auto;">
        <img src="images/<?php echo htmlspecialchars($product['image']); ?>" style="width: 100%; height: 100%;" alt="<?php echo htmlspecialchars($product['name']); ?>">
        </div>
    <p style="margin-left: 20px;color: white;">Giá: <?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ</p>
    <p style="margin-left: 20px;color: white;"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
    <a href="cart.php?action=add&id=<?php echo $product['id']; ?>" style="display: block; background-color: #fff; height: 50px; width: 80%; margin: auto; text-align: center;line-height: 50px; font-size: 1.3em; border-radius: 5px;">Thêm vào giỏ hàng</a>
    </div>
</body>
</html>