<?php
session_start();
include 'includes/db.php';

// Kiểm tra quyền admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}

// Lấy thông tin người dùng theo ID
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
} else {
    header('Location: admin.php');
    exit;
}

// Cập nhật thông tin người dùng
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = $_POST['password'];

    // Cập nhật thông tin cơ bản
    $updateQuery = "UPDATE users SET username = ?, email = ?, role = ? WHERE id = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param('sssi', $username, $email, $role, $id);
    $updateStmt->execute();

    // Cập nhật mật khẩu nếu được nhập
    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $updatePasswordQuery = "UPDATE users SET password = ? WHERE id = ?";
        $updatePasswordStmt = $conn->prepare($updatePasswordQuery);
        $updatePasswordStmt->bind_param('si', $hashedPassword, $id);
        $updatePasswordStmt->execute();
    }

    header('Location: admin.php?message=update_success');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
    <link rel="stylesheet" href="css/edit_user.css">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa người dùng</title>
</head>
<body>
    <h1>Sửa thông tin người dùng</h1>
    <form method="POST">
        <label for="username">Tên đăng nhập:</label>
        <input type="text" name="username" id="username" value="<?php echo $user['username']; ?>" required><br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo $user['email']; ?>" required><br>
        <label for="role">Vai trò:</label>
        <select name="role" id="role">
            <option value="user" <?php if ($user['role'] === 'user') echo 'selected'; ?>>Người dùng</option>
            <option value="admin" <?php if ($user['role'] === 'admin') echo 'selected'; ?>>Quản trị viên</option>
        </select><br>
        <label for="password">Mật khẩu mới (để trống nếu không đổi):</label>
        <input type="password" name="password" id="password"><br>
        <button type="submit">Lưu thay đổi</button>
        <a href="admin.php" class="back-button">Về trang quản trị</a>

    </form>
</body>
</html>