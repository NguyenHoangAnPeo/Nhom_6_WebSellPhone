<?php
session_start();
include 'includes/db.php';

// Kiểm tra quyền admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}

// Lấy ID người dùng từ URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Xóa người dùng
    $query = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        header('Location: admin.php?message=delete_success');
    } else {
        header('Location: admin.php?message=delete_error');
    }
    exit;
}
header('Location: admin.php');
exit;
?>
