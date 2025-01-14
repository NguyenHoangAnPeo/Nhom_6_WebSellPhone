<?php
session_start();
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        header('Location: index.php');
        exit;
    } else {
        $error = "Tên đăng nhập hoặc mật khẩu không đúng.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Đăng nhập</title>
    <style>
        .button:hover{
    background-color: #45a049;
}
    </style>
</head>
<body>
    <h1>Đăng nhập</h1>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <form style="padding: auto;margin: auto; background-color: #34495e; width: 35%;height: 200px; border-radius: 10px;padding-top:4%;" method="POST">
        <label style="font-size: 1.2em;color: white; font-weight: bold; margin-left: 60px;">Tên đăng nhập:</label>
        <input type="text" style="height: 30px; width: 200px; margin-left: 30px; margin-bottom: 25px;" name="username" required></br>
        <label style="font-size: 1.2em; font-weight: bold;color: white; margin-left: 60px;">Mật khẩu:</label>
        <input type="password" style="height: 30px; width: 200px; margin-left: 82px;" name="password" required> </br>
        <button type="submit" class="button" style="color: white;background-color:rgb(85, 137, 87);color: white;margin-left: 36%;margin-top: 20px; border: none; padding: 10px 20px; text-align: center; display: inline-block; font-size: 16px; border-radius: 5px;cursor: pointer; transition: background-color 0.3s ease;">Đăng nhập</button>
    </form>
      <!-- Footer -->
<footer style="background-color: #333; color: white; text-align: center; padding: 10px 0;position: fixed; bottom: 0; width: 100%;">
    <p>&copy; 2025 Web Bán Điện Thoại. Tất cả các quyền được bảo lưu.</p>
    <p>Liên hệ: <a href="mailto:support@webbanhang.com" style="color: #f4a261;">support@webbanhang.com</a></p>
</footer>
</body>
</html>
