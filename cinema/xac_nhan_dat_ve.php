<?php
session_start();
require_once("connection.php");

if (!isset($_SESSION['username'])) {
    die("Bạn chưa đăng nhập.");
}

$username = $_SESSION['username'];

// Lấy dữ liệu từ form
$so_ghe = isset($_POST['so_ghe']) ? $_POST['so_ghe'] : '';
$gia_ve_don = isset($_POST['gia_ve']) ? (int)$_POST['gia_ve'] : 0;
$ma_chieu = isset($_POST['ma_chieu']) ? $_POST['ma_chieu'] : '';

if (empty($so_ghe) || empty($ma_chieu)) {
    die("Thiếu thông tin ghế hoặc mã chiếu.");
}

// Tách số ghế và tính số lượng vé + tổng tiền
$ds_ghe = explode(',', $so_ghe);
$so_luong = count($ds_ghe);
$tong_tien = $so_luong * $gia_ve_don;

// Lấy mã người dùng từ tên tài khoản
$sql_get_user = "SELECT ma_nguoi_dung FROM Nguoi_Dung WHERE taikhoan = ?";
$params = array($username);
$stmt = sqlsrv_query($conn, $sql_get_user, $params);

if (!$stmt || !sqlsrv_has_rows($stmt)) {
    die("Không tìm thấy người dùng: $username");
}
$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
$ma_nguoi_dung = $row['ma_nguoi_dung'];

// Thêm vào bảng Đặt_Vé (không truyền ngay_dat vì đã có mặc định)
$sql_insert = "INSERT INTO Đặt_Vé (ma_nguoi_dung, ma_chieu, so_ghe, soluong, gia_ve) 
               VALUES (?, ?, ?, ?, ?)";
$params_insert = array($ma_nguoi_dung, $ma_chieu, $so_ghe, $so_luong, $tong_tien);
$result = sqlsrv_query($conn, $sql_insert, $params_insert);

if ($result) {
    echo "<p style='color:green; text-align:center;'>✅ Đặt vé thành công!</p>";
    echo "<p style='text-align:center;'><a href='user_dashboard.php'>Quay về trang chủ</a></p>";
} else {
    echo "<p style='color:red; text-align:center;'>❌ Lỗi khi lưu vào CSDL.</p>";
}
?>
