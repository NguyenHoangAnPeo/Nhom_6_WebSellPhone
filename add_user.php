<?php
include 'includes/db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $query = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
    $conn->query($query);
    header("Location: admin.php");
    exit;
}
?>

<form method="POST">
    <input type="text" name="username" placeholder="Tên đăng nhập" required>
    <input type="password" name="password" placeholder="Mật khẩu" required>
    <select name="role">
        <option value="user">User</option>
        <option value="admin">Admin</option>
    </select>
    <button type="submit">Thêm</button>
</form>
