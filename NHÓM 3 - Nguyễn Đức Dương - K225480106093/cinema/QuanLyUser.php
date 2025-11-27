<?php
session_start();
include("connection.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "Bạn không có quyền truy cập trang này.";
    exit();
}

// Lấy danh sách người dùng
$sql = "SELECT ma_nguoi_dung, hoten, taikhoan, matkhau, email, sdt FROM Nguoi_Dung";
$stmt = sqlsrv_query($conn, $sql);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Người Dùng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef1f5;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            margin-top: 30px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #2c3e50;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        a.back-link {
            display: block;
            text-align: center;
            margin-top: 30px;
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
        }

        a.back-link:hover {
            color: #1abc9c;
        }
    </style>
</head>
<body>

<h1>Danh Sách Người Dùng</h1>

<table>
    <thead>
        <tr>
            <th>Mã Người Dùng</th>
            <th>Họ Tên</th>
            <th>Tài Khoản</th>
            <th>Mật Khẩu</th>
            <th>Email</th>
            <th>SĐT</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)): ?>
            <tr>
                <td><?= htmlspecialchars($row['ma_nguoi_dung']) ?></td>
                <td><?= htmlspecialchars($row['hoten']) ?></td>
                <td><?= htmlspecialchars($row['taikhoan']) ?></td>
                <td><?= htmlspecialchars($row['matkhau']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['sdt']) ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<a class="back-link" href="admin_dashboard.php">← Quay lại trang Admin</a>

</body>
</html>
