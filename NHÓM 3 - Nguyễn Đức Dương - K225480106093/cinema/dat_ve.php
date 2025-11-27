<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

require_once("connection.php");

$username = $_SESSION['username'];

// Lấy dữ liệu POST từ chon_ghe.php
$so_ghe   = $_POST['so_ghe'] ?? '';
$gia_ve   = (int)($_POST['gia_ve'] ?? 0);
$ma_phim  = $_POST['ma_phim'] ?? '';
$ma_chieu = $_POST['ma_chieu'] ?? '';
$ma_rap   = $_POST['ma_rap'] ?? '';
$ten_rap  = $_POST['ten_rap'] ?? '';
$ngay_chieu = $_POST['ngay_chieu'] ?? '';

if (empty($so_ghe) || empty($ma_chieu)) {
    echo "<p style='color:red; text-align:center;'>Thiếu thông tin đặt vé!</p>";
    exit();
}

$ds_ghe = explode(',', $so_ghe);
$so_luong_ve = count($ds_ghe);
$tong_tien = $so_luong_ve * $gia_ve;

// Lấy tên phim
$sql_phim = "SELECT tenphim FROM Phim WHERE ma_phim = ?";
$params = array($ma_phim);
$stmt = sqlsrv_query($conn, $sql_phim, $params);
$ten_phim = 'Không rõ';
if ($stmt && sqlsrv_fetch($stmt)) {
    $ten_phim = sqlsrv_get_field($stmt, 0);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Hóa đơn đặt vé</title>
<style>
body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f5f5; padding: 40px 20px; }
.invoice-box { max-width: 600px; margin: auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
h1 { color: goldenrod; text-align: center; margin-bottom: 30px; font-weight: 700; }
.info-row { margin-bottom: 18px; font-size: 18px; }
.info-row span.label { font-weight: 600; color: #444; width: 130px; display: inline-block; }
.seat-list { background-color: #f0f0f0; border-radius: 8px; padding: 12px; font-size: 16px; margin: 10px 0 25px; word-wrap: break-word; }
.total { font-size: 22px; font-weight: 700; text-align: right; color: #333; margin-top: 20px; border-top: 2px solid goldenrod; padding-top: 15px; }
.button-container { display: flex; justify-content: space-between; gap: 10px; margin-top: 30px; }
.btn-back { flex: 1; background: gray; color: white; text-align: center; padding: 14px; font-weight: 600; border-radius: 10px; text-decoration: none; transition: background 0.3s ease; }
.btn-back:hover { background: #444; }
.btn-confirm { flex: 1; background: linear-gradient(45deg, goldenrod, orange); color: white; border: none; cursor: pointer; font-size: 16px; font-weight: 600; padding: 14px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.2); transition: all 0.3s ease; }
.btn-confirm:hover { background: darkorange; transform: scale(1.05); }
</style>
</head>
<body>

<div class="invoice-box">
    <h1>Hóa đơn đặt vé xem phim</h1>

    <div class="info-row"><span class="label">Ngày chiếu:</span> <?= htmlspecialchars($ngay_chieu) ?></div>
    <div class="info-row"><span class="label">Tên rạp:</span> <?= htmlspecialchars($ten_rap) ?></div>
    <div class="info-row"><span class="label">Tên phim:</span> <?= htmlspecialchars($ten_phim) ?></div>

    <div class="info-row"><span class="label">Số ghế đã chọn:</span></div>
    <div class="seat-list"><?= htmlspecialchars(implode(', ', $ds_ghe)) ?></div>

    <div class="info-row"><span class="label">Giá vé:</span> <?= number_format($gia_ve) ?> VNĐ</div>
    <div class="info-row"><span class="label">Số lượng vé:</span> <?= $so_luong_ve ?></div>

    <div class="total">Tổng tiền: <?= number_format($tong_tien) ?> VNĐ</div>

    <div class="button-container">
        <!-- Quay lại chọn rạp -->
        <a href="lich_rap.php?ma_rap=<?= urlencode($ma_rap) ?>" class="btn-back">Quay lại</a>

        <!-- Xác nhận đặt vé -->
        <form method="post" action="xac_nhan_dat_ve.php" style="flex: 1;">
            <input type="hidden" name="so_ghe" value="<?= htmlspecialchars($so_ghe) ?>">
            <input type="hidden" name="gia_ve" value="<?= $gia_ve ?>">
            <input type="hidden" name="ma_phim" value="<?= htmlspecialchars($ma_phim) ?>">
            <input type="hidden" name="ma_chieu" value="<?= htmlspecialchars($ma_chieu) ?>">
            <input type="hidden" name="ten_rap" value="<?= htmlspecialchars($ten_rap) ?>">
            <input type="hidden" name="ngay_chieu" value="<?= htmlspecialchars($ngay_chieu) ?>">
            <input type="hidden" name="ma_rap" value="<?= htmlspecialchars($ma_rap) ?>">

            <button type="submit" class="btn-confirm">✅ Xác nhận</button>
        </form>
    </div>
</div>
</body>
</html>
