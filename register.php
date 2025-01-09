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
    <form action="register.php" method="post">
        <div>
            <label for="username">Tên đăng nhập:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div>
            <label for="password">Mật khẩu:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <?php if (!empty($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <button type="submit">Đăng ký</button>
    </form>
    <p>Đã có tài khoản? <a href="login.php">Đăng nhập tại đây</a>.</p>
</body>
</html>
