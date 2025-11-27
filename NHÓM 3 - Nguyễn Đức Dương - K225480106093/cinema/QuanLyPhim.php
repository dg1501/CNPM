<?php
session_start();
include("connection.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "Bạn không có quyền truy cập trang này.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ma_phim'])) {
    $ma_phim = intval($_POST['ma_phim']);
    $tenphim = $_POST['tenphim'];
    $theloai = $_POST['theloai'];
    $thoiluong = intval($_POST['thoiluong']);

    $sql_update = "UPDATE Phim SET tenphim = ?, theloai = ?, thoiluong = ? WHERE ma_phim = ?";
    $params = array($tenphim, $theloai, $thoiluong, $ma_phim);
    $stmt_update = sqlsrv_query($conn, $sql_update, $params);

    if ($stmt_update === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    header("Location: QuanLyPhim.php");
    exit();
}

// Lấy danh sách phim
$sql = "SELECT ma_phim, tenphim, theloai, thoiluong FROM Phim";
$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách phim</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .movie-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            gap: 20px;
        }
        .movie-card {
            background-color: #fff;
            border-radius: 10px;
            width: 240px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            text-align: center;
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        .movie-card:hover {
            transform: scale(1.03);
        }
        .movie-card img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-bottom: 2px solid #f7f7f7;
        }
        .movie-info {
            padding: 10px;
        }
        .movie-info h3 {
            font-size: 18px;
            color: #333;
        }
        .movie-info p {
            font-size: 14px;
            color: #777;
            margin: 5px 0;
        }
        .toggle-edit {
            margin: 10px auto;
            padding: 6px 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        .edit-form {
            display: none;
            background-color: #f9f9f9;
            padding: 10px;
            border-top: 1px solid #ccc;
        }
        .edit-form input {
            width: 90%;
            margin: 5px auto;
            padding: 5px;
        }
        .edit-form button {
            padding: 6px 12px;
            margin-top: 5px;
            background-color: green;
            color: white;
            border: none;
            border-radius: 4px;
        }
        a {
            display: block;
            margin-top: 30px;
            text-align: center;
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>

<h1>Danh Sách Phim</h1>

<div class="movie-container">
<?php while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)): ?>
    <?php $image_path = "Picture/" . strtolower(str_replace(' ', '_', $row['tenphim'])) . ".jpg"; ?>
    <div class="movie-card">
        <img src="<?= $image_path ?>" alt="<?= $row['tenphim'] ?>">
        <div class="movie-info">
            <h3><?= $row['tenphim'] ?></h3>
            <p><strong>Thể loại:</strong> <?= $row['theloai'] ?></p>
            <p><strong>Thời lượng:</strong> <?= $row['thoiluong'] ?> phút</p>
            <button class="toggle-edit" data-id="<?= $row['ma_phim'] ?>">Chi tiết</button>
        </div>

        <form class="edit-form" id="form-<?= $row['ma_phim'] ?>" method="POST">
            <input type="hidden" name="ma_phim" value="<?= $row['ma_phim'] ?>">
            <input type="text" name="tenphim" value="<?= $row['tenphim'] ?>" required>
            <input type="text" name="theloai" value="<?= $row['theloai'] ?>" required>
            <input type="number" name="thoiluong" value="<?= $row['thoiluong'] ?>" required>
            <button type="submit">Lưu</button>
        </form>
    </div>
<?php endwhile; ?>
</div>

<a href="admin_dashboard.php">← Quay lại trang Admin</a>

<script>
    document.querySelectorAll('.toggle-edit').forEach(button => {
        button.addEventListener('click', () => {
            const id = button.dataset.id;
            const form = document.getElementById('form-' + id);
            form.style.display = form.style.display === 'none' || form.style.display === '' ? 'block' : 'none';
        });
    });
</script>

</body>
</html>
