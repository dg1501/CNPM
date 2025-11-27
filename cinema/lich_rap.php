<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

include("connection.php");

if (!isset($_GET['ma_rap']) || empty($_GET['ma_rap'])) {
    echo "Không có rạp phim được chọn!";
    exit();
}

$ma_rap = intval($_GET['ma_rap']);

// Lấy tên rạp
$sql_rap = "SELECT tenrap FROM Rạp_Phim WHERE ma_rap = ?";
$params = array($ma_rap);
$stmt_rap = sqlsrv_query($conn, $sql_rap, $params);
if ($stmt_rap === false) {
    die(print_r(sqlsrv_errors(), true));
}
$rap = sqlsrv_fetch_array($stmt_rap, SQLSRV_FETCH_ASSOC);
if (!$rap) {
    echo "Rạp không tồn tại.";
    exit();
}
$ten_rap = $rap['tenrap'];

// Lấy ngày trong tuần
function getDateOfWeekDay($dayNumber) {
    $monday = strtotime("Monday this week");
    return date("Y-m-d", strtotime("+".($dayNumber-1)." days", $monday));
}

$daysOfWeek = [];
$dayNames = ["Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7", "Chủ nhật"];
for ($i = 1; $i <= 7; $i++) {
    $daysOfWeek[$i] = [
        'date' => getDateOfWeekDay($i),
        'name' => $dayNames[$i - 1]
    ];
}

// Lấy danh sách phim theo từng ngày
$filmsByDate = [];
foreach ($daysOfWeek as $dayNumber => $day) {
    $sql = "SELECT SC.ma_chieu, P.ma_phim, P.tenphim, P.theloai, P.thoiluong
            FROM Suất_Chiếu SC
            JOIN Phim P ON SC.ma_phim = P.ma_phim
            WHERE SC.ma_rap = ? AND CONVERT(date, SC.ngaychieu) = ?";
    $params = array($ma_rap, $day['date']);
    $stmt = sqlsrv_query($conn, $sql, $params);
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $films = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $tenphim = $row['tenphim'];
        $image_path = "Picture/" . strtolower(str_replace(' ', '_', $tenphim)) . ".jpg";

        $films[] = [
            'ma_phim' => $row['ma_phim'],
            'ma_chieu' => $row['ma_chieu'],
            'tenphim' => $tenphim,
            'theloai' => $row['theloai'],
            'thoiluong' => $row['thoiluong'],
            'image' => $image_path
        ];
    }
    $filmsByDate[$dayNumber] = $films;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8" />
<title>Lịch chiếu phim tại rạp <?= htmlspecialchars($ten_rap); ?></title>
<style>
/* Giữ nguyên toàn bộ CSS cũ */
body {
    font-family: Arial, sans-serif;
    max-width: 1000px;
    margin: 30px auto;
    background: url('https://www.inminhdai.vn/Upload/2019/9/3/poster-b9bf.jpg') no-repeat center center fixed;
    background-size: cover;
    padding: 20px;
    color: #fff;
}

h1 { text-align: center; margin-bottom: 30px; text-shadow: 1px 1px 4px rgba(0,0,0,0.5); }

.day-buttons { display: flex; justify-content: space-between; flex-wrap: wrap; margin-bottom: 30px; }
.day-button { flex: 1; margin: 5px; padding: 12px; background-color: rgba(255,255,255,0.8); border: 1px solid #ccc; border-radius: 6px; text-align: center; cursor: pointer; transition: background-color 0.3s, transform 0.2s; color: #000; }
.day-button:hover { background-color: #007bff; color: white; transform: translateY(-2px); }
.day-button.active { background-color: #007bff; color: white; }

.film-list { display: none; background: rgba(255, 255, 255, 0.95); border-radius: 6px; padding: 20px; box-shadow: 0 0 6px rgba(0,0,0,0.1); animation: fadeIn 0.3s ease-in-out; color: #000; }
.film-list.active { display: block; }
.film-grid { display: flex; flex-wrap: wrap; gap: 20px; justify-content: center; }
.film-card { width: 200px; background: #fff; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.15); overflow: hidden; text-align: center; transition: transform 0.2s; }
.film-card:hover { transform: scale(1.03); }
.film-card img { width: 100%; height: 280px; object-fit: cover; }
.film-card h4 { margin: 10px 5px 5px; font-size: 16px; }
.film-card p { margin: 4px 5px; font-size: 13px; color: #555; }
.film-card a { display: inline-block; margin: 10px 0; padding: 6px 12px; background-color: goldenrod; color: white; text-decoration: none; border-radius: 4px; }

@keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>
</head>
<body>

<h1>Lịch chiếu phim tại rạp <?= htmlspecialchars($ten_rap); ?></h1>

<div style="position: fixed; bottom: 20px; left: 20px; z-index: 1000;">
    <a href="user_dashboard.php" style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; transition: background-color 0.3s;"
       onmouseover="this.style.backgroundColor='#0056b3'" onmouseout="this.style.backgroundColor='#007bff'">
        ← Quay lại
    </a>
</div>

<div class="day-buttons">
<?php foreach ($daysOfWeek as $dayNumber => $day): ?>
    <div class="day-button" data-day="<?= $dayNumber ?>">
        <small><?= date("d/m/Y", strtotime($day['date'])) ?></small>
    </div>
<?php endforeach; ?>
</div>

<?php foreach ($daysOfWeek as $dayNumber => $day): ?>
    <div class="film-list" id="films-<?= $dayNumber ?>">
        <h3><?= $day['name'] ?> (<?= date("d/m/Y", strtotime($day['date'])) ?>)</h3>
        <?php if (count($filmsByDate[$dayNumber]) > 0): ?>
            <div class="film-grid">
                <?php foreach ($filmsByDate[$dayNumber] as $film): ?>
                    <div class="film-card">
                        <img src="<?= htmlspecialchars($film['image']) ?>" alt="<?= htmlspecialchars($film['tenphim']) ?>">
                        <h4><?= htmlspecialchars($film['tenphim']) ?></h4>
                        <p><strong>Thể loại:</strong> <?= htmlspecialchars($film['theloai']) ?></p>
                        <p><strong>Thời lượng:</strong> <?= htmlspecialchars($film['thoiluong']) ?> phút</p>
                        <a href="chon_ghe.php?ma_phim=<?= urlencode($film['ma_phim']) ?>
&ma_chieu=<?= $film['ma_chieu'] ?>
&ten_rap=<?= urlencode($ten_rap) ?>
&ngay_chieu=<?= $day['date'] ?>
&ma_rap=<?= $ma_rap ?>">Đặt vé</a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <em>Không có phim chiếu</em>
        <?php endif; ?>
    </div>
<?php endforeach; ?>

<script>
const buttons = document.querySelectorAll('.day-button');
const filmLists = document.querySelectorAll('.film-list');

buttons.forEach(button => {
    button.addEventListener('click', () => {
        const day = button.getAttribute('data-day');
        buttons.forEach(btn => btn.classList.remove('active'));
        filmLists.forEach(list => list.classList.remove('active'));
        button.classList.add('active');
        document.getElementById('films-' + day).classList.add('active');
    });
});

const today = new Date();
let todayIndex = today.getDay();
if (todayIndex === 0) todayIndex = 7;
const defaultButton = document.querySelector(`.day-button[data-day='${todayIndex}']`);
if (defaultButton) defaultButton.click();
</script>

</body>
</html>
