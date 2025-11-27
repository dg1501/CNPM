<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

if ($_SESSION['role'] !== 'admin') {
    echo "Bạn không có quyền truy cập trang này.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang quản lý Admin</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            text-align: center;
        }

        main {
            max-width: 800px;
            margin: 40px auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        h1, h2 {
            color: #2c3e50;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin: 15px 0;
        }

        a {
            text-decoration: none;
            color: #3498db;
            font-weight: bold;
            font-size: 18px;
            transition: color 0.3s;
        }

        a:hover {
            color: #1abc9c;
        }

        .welcome {
            font-size: 18px;
            margin-bottom: 20px;
            color: #34495e;
        }
    </style>
</head>
<body>

<header>
    <h1>Trang quản lý Admin</h1>
</header>

<main>
    <div class="welcome">
        👋 Xin chào, <strong><?php echo $_SESSION['username']; ?></strong> (Admin)
    </div>

    <h2>📋 Chức năng quản lý</h2>
    <ul>
        <li><a href="QuanLyPhim.php">🎬 Quản Lý Phim</a></li>
        <li><a href="QuanLyUser.php">👥 Quản Lý Người Dùng</a></li>
        <li><a href="QuanLyLichChieu.php">🕒 Quản Lý Lịch Chiếu</a></li>
        <li><a href="logout.php">🚪 Đăng Xuất</a></li>
    </ul>
</main>

</body>
</html>
