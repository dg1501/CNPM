<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

// Lấy dữ liệu từ lich_rap.php
if (!isset($_GET['ma_phim'], $_GET['ma_chieu'], $_GET['ten_rap'], $_GET['ngay_chieu'], $_GET['ma_rap'])) {
    echo "Thiếu thông tin đặt vé!";
    exit();
}

$ma_phim   = $_GET['ma_phim'];
$ma_chieu  = $_GET['ma_chieu'];
$ten_rap   = $_GET['ten_rap'];
$ngay_chieu= $_GET['ngay_chieu'];
$ma_rap    = $_GET['ma_rap'];

include("connection.php");

// Lấy tên phim
$sql_phim = "SELECT tenphim FROM Phim WHERE ma_phim = ?";
$params_phim = [$ma_phim];
$stmt_phim = sqlsrv_query($conn, $sql_phim, $params_phim);
if ($stmt_phim === false) { die(print_r(sqlsrv_errors(), true)); }
$phim = sqlsrv_fetch_array($stmt_phim, SQLSRV_FETCH_ASSOC);
$ten_phim = $phim ? $phim['tenphim'] : "Không xác định";
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Chọn ghế</title>
<style>
body { font-family: Arial,sans-serif; background: url('https://congngheviet.com/wp-content/uploads/2023/12/galaxy-sala-02.webp') no-repeat center center fixed; background-size: cover; padding: 30px; text-align:center; color:#fff; }
h2 { margin-bottom:20px; color:#fff; text-shadow:1px 1px 4px rgba(0,0,0,0.6); }
.screen { background: rgba(0,0,0,0.8); color:white; padding:10px; margin:0 auto 15px; width:60%; border-radius:6px; box-shadow:0 0 10px rgba(0,0,0,0.5);}
.seat-container { width: fit-content; margin:0 auto; padding:20px; background-color: rgba(255,255,255,0.1); border-radius:12px;}
.seat { width:50px; height:50px; background:#ddd; margin:5px; display:inline-block; text-align:center; line-height:50px; border-radius:8px; cursor:pointer; font-weight:bold; transition:0.2s;}
.seat:hover { background:#bbb;}
.seat.selected { background:goldenrod; color:white; box-shadow:0 0 8px gold;}
button { margin-top:20px; padding:10px 24px; font-size:16px; font-weight:bold; background:goldenrod; color:white; border:none; border-radius:6px; cursor:pointer; box-shadow:0 4px 6px rgba(0,0,0,0.3);}
button:hover { background:darkorange;}
form { margin-top:20px; }
.back-btn { position: fixed; bottom:20px; left:20px; z-index:1000; padding:10px 20px; background-color:#007bff; color:#fff; text-decoration:none; border-radius:5px; transition: background-color 0.3s; }
.back-btn:hover { background-color:#0056b3; }
</style>
</head>
<body>

<h2>
Chọn ghế xem phim: <strong><?= htmlspecialchars($ten_phim) ?></strong><br>
Tại rạp: <strong><?= htmlspecialchars($ten_rap) ?></strong><br>
Ngày chiếu: <strong><?= date('d/m/Y', strtotime($ngay_chieu)) ?></strong>
</h2>

<div class="screen">MÀN HÌNH</div>

<div class="seat-container">
<?php
$rows = range('A','F');
for ($i=1;$i<=5;$i++){
    foreach($rows as $row){
        $seat_id = $row.$i;
        echo "<div class='seat' data-seat='{$seat_id}'>{$seat_id}</div>";
    }
    echo "<br>";
}
?>
</div>

<form method="POST" action="dat_ve.php">
<input type="hidden" name="so_ghe" id="so_ghe">
<input type="hidden" name="gia_ve" value="100000">
<input type="hidden" name="ma_phim" value="<?= htmlspecialchars($ma_phim) ?>">
<input type="hidden" name="ma_chieu" value="<?= htmlspecialchars($ma_chieu) ?>">
<input type="hidden" name="ten_rap" value="<?= htmlspecialchars($ten_rap) ?>">
<input type="hidden" name="ngay_chieu" value="<?= htmlspecialchars($ngay_chieu) ?>">
<input type="hidden" name="ma_rap" value="<?= htmlspecialchars($ma_rap) ?>">
<button type="submit">Xác nhận đặt vé</button>
</form>

<!-- Nút quay lại gửi đủ thông số -->
<a href="lich_rap.php?ma_phim=<?= urlencode($ma_phim) ?>&ma_chieu=<?= urlencode($ma_chieu) ?>&ten_rap=<?= urlencode($ten_rap) ?>&ngay_chieu=<?= urlencode($ngay_chieu) ?>&ma_rap=<?= urlencode($ma_rap) ?>" class="back-btn">← Quay lại</a>

<script>
const seats = document.querySelectorAll('.seat');
const selectedInput = document.getElementById('so_ghe');
let selectedSeats = [];
seats.forEach(seat=>{
    seat.addEventListener('click',()=>{
        const ghe = seat.dataset.seat;
        if(seat.classList.contains('selected')){
            seat.classList.remove('selected');
            selectedSeats = selectedSeats.filter(s=>s!==ghe);
        }else{
            seat.classList.add('selected');
            selectedSeats.push(ghe);
        }
        selectedInput.value = selectedSeats.join(',');
    });
});
</script>
</body>
</html>
