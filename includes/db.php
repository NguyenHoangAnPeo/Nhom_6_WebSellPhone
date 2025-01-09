<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'websellphone';

// Kết nối cơ sở dữ liệu
$conn = new mysqli($host, $user, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Thiết lập báo lỗi chi tiết (chế độ phát hiện lỗi)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Đảm bảo đóng kết nối sau khi hoàn tất công việc
// $conn->close();
?>