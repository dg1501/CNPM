<?php
include 'connection.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $hoten            = $_POST['hoten'] ?? '';
    $username         = $_POST['taikhoan'] ?? '';
    $email            = $_POST['email'] ?? '';
    $phone            = $_POST['sdt'] ?? '';
    $password         = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? ''; 

    if ($password !== $confirm_password) {
        echo "Mật khẩu xác nhận không khớp.";
        exit;
    }

    $checkQuery = "SELECT * FROM Nguoi_Dung WHERE taikhoan = ?";
    $checkStmt = sqlsrv_query($conn, $checkQuery, array($username));
    if ($checkStmt && sqlsrv_has_rows($checkStmt)) {
        echo "Tên đăng nhập đã tồn tại.";
        exit;
    }

    $ma_nguoi_dung = uniqid("ND");

    $insertQuery = "
        INSERT INTO Nguoi_Dung (ma_nguoi_dung, hoten, taikhoan, email, matkhau, sdt)
        VALUES (?, ?, ?, ?, ?, ?)
    ";
    $params = array($ma_nguoi_dung, $hoten, $username, $email, $password, $phone);

    $insertStmt = sqlsrv_query($conn, $insertQuery, $params);

    if ($insertStmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    echo "Đăng ký thành công! <a href='#' onclick='window.history.back();'>Quay lại đăng nhập</a>";
}
?>
