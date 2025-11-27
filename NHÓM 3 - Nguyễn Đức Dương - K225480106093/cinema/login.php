<?php
session_start();
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"] ?? '');
    $password = trim($_POST["password"] ?? '');

    if ($username === '' || $password === '') {
        echo "Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu.";
        exit;
    }

    $sql = "SELECT * FROM Admins WHERE username = ? AND passwords = ?";
    $params = array($username, $password);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    if ($row) {
        $_SESSION['user_id'] = $row['id'];          
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role']; 
        header("Location: admin_dashboard.php");
        exit();
        }
    }

    $sql = "SELECT * FROM Nguoi_Dung WHERE taikhoan = ? AND matkhau = ?";
    $params = array($username, $password);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    if ($row) {
        $_SESSION['user_id'] = $row['ma_nguoi_dung'];          
        $_SESSION['username'] = $row['taikhoan'];
        $_SESSION['role'] = $row['role']; 
        $_SESSION['hoten'] = $row['hoten'];
        header("Location: user_dashboard.php");
        exit();
        }

    echo "Tên đăng nhập hoặc mật khẩu không đúng.";
?>
