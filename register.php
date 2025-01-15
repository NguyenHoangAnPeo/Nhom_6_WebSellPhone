<?php
include 'includes/db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash mật khẩu để bảo mật

    // Kiểm tra xem tên đăng nhập đã tồn tại chưa
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error = "Tên đăng nhập đã tồn tại. Vui lòng chọn tên khác.";
    } else {
        // Thêm tài khoản mới vào cơ sở dữ liệu
        $query = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ss', $username, $password);

        if ($stmt->execute()) {
            header('Location: login.php'); // Chuyển hướng đến trang đăng nhập
            exit;
        } else {
            $error = "Đăng ký thất bại. Vui lòng thử lại.";
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
    <title>Đăng ký</title>
</head>
<body>
    <h1>Đăng ký tài khoản</h1>
    <form action="register.php" method="post" style="padding: auto;margin: auto; background-color: #34495e; width: 35%;height: 200px; border-radius: 10px;padding-top:4%;">
        <div>
            <label for="username" style="font-size: 1.2em; font-weight: bold;color: white; margin-left: 60px;">Tên đăng nhập:</label>
            <input type="text" style="height: 30px; width: 200px; margin-left: 30px; margin-bottom: 25px;" id="username" name="username" required>
        </div>
        <div>
            <label for="password" style="font-size: 1.2em; font-weight: bold;color: white; margin-left: 60px;">Mật khẩu:</label>
            <input type="password" style="height: 30px; width: 200px; margin-left: 80px; margin-bottom: 25px;" id="password" name="password" required>
        </div>
        <?php if (!empty($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <button type="submit" style="background-color:rgb(85, 137, 87);color: white;margin-left: 36%;margin-top: 20px; border: none; padding: 10px 20px; text-align: center; display: inline-block; font-size: 16px; border-radius: 5px;cursor: pointer; transition: background-color 0.3s ease;">Đăng ký</button>
    </form>
    <p style="margin-left: 40%;">Đã có tài khoản? <a href="login.php">Đăng nhập tại đây</a>.</p>
    <!-- Footer -->
<footer style="background-color: #333; color: white; text-align: center; padding: 10px 0;position: fixed; bottom: 0; width: 100%;">
    <p>&copy; 2025 Web Bán Điện Thoại. Tất cả các quyền được bảo lưu.</p>
    <p>Liên hệ: <a href="mailto:support@webbanhang.com" style="color: #f4a261;">support@webbanhang.com</a></p>
</footer>
</body>
</html>
