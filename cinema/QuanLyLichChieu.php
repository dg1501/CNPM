<?php
session_start();
include("connection.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "Bạn không có quyền truy cập trang này.";
    exit();
}

// Cập nhật nhiều suất chiếu
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ma_chieu']) && is_array($_POST['ma_chieu'])) {
    foreach ($_POST['ma_chieu'] as $ma_chieu) {
        $ngaychieu = $_POST['ngaychieu'][$ma_chieu] ?? null;
        $giobatdau = $_POST['giobatdau'][$ma_chieu] ?? null;
        $ma_rap = $_POST['ma_rap'][$ma_chieu] ?? null;

        if ($ngaychieu && $giobatdau && $ma_rap) {
            $sql_update = "UPDATE Suất_Chiếu SET ngaychieu = ?, giobatdau = ?, ma_rap = ? WHERE ma_chieu = ?";
            $params = array($ngaychieu, $giobatdau, trim($ma_rap), $ma_chieu);
            $stmt_update = sqlsrv_query($conn, $sql_update, $params);

            if ($stmt_update === false) {
                echo "<pre>Lỗi khi cập nhật ma_chieu = $ma_chieu:\n";
                print_r(sqlsrv_errors(), true);
                echo "</pre>";
                exit();
            }
        }
    }

    echo "<script>alert('Cập nhật tất cả thành công'); window.location='QuanLyLichChieu.php';</script>";
    exit();
}

// Lấy danh sách lịch chiếu
$sql = "SELECT SC.ma_chieu, SC.ma_phim, SC.ma_rap, SC.ngaychieu, SC.giobatdau, P.tenphim
        FROM Suất_Chiếu SC
        JOIN Phim P ON SC.ma_phim = P.ma_phim
        ORDER BY SC.ngaychieu DESC, SC.giobatdau";
$stmt = sqlsrv_query($conn, $sql);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Lịch Chiếu</title>
    <style>
        body { font-family: Arial; background-color: #f8f9fa; padding: 20px; }
        h1 { text-align: center; margin-bottom: 20px; }
        .container { display: flex; flex-wrap: wrap; gap: 20px; justify-content: center; }
        .card {
            background: white;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 10px;
            width: 300px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .card h3 { margin-bottom: 10px; }
        .card input {
            display: block;
            margin: 5px 0;
            padding: 6px;
            width: 100%;
        }
        .submit-wrapper {
            text-align: center;
            margin-top: 30px;
        }
        .submit-wrapper button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }
        a {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <h1>Quản Lý Lịch Chiếu</h1>
    <form method="POST">
        <div class="container">
        <?php while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)): ?>
            <?php
                $ma_chieu = $row['ma_chieu'];
                $tenphim = htmlspecialchars($row['tenphim']);
                $ngay = $row['ngaychieu'] ? $row['ngaychieu']->format('Y-m-d') : '';
                $gio = $row['giobatdau'] ? $row['giobatdau']->format('H:i') : '';
                $ma_rap = htmlspecialchars(trim($row['ma_rap']));
            ?>
            <div class="card">
                <h3><?= $tenphim ?></h3>
                <input type="hidden" name="ma_chieu[]" value="<?= $ma_chieu ?>">
                <label>Ngày chiếu:</label>
                <input type="date" name="ngaychieu[<?= $ma_chieu ?>]" value="<?= $ngay ?>" required>
                <label>Giờ bắt đầu:</label>
                <input type="time" name="giobatdau[<?= $ma_chieu ?>]" value="<?= $gio ?>" required>
                <label>Mã rạp:</label>
                <input type="text" name="ma_rap[<?= $ma_chieu ?>]" value="<?= $ma_rap ?>" required>
            </div>
        <?php endwhile; ?>
        </div>

        <div class="submit-wrapper">
            <button type="submit">Lưu tất cả thay đổi</button>
            <a href="admin_dashboard.php">← Quay lại trang Admin</a>
        </div>
    </form>
</body>
</html>
