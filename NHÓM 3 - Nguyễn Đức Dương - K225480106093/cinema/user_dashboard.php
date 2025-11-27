<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include("connection.php");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang người dùng</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }

        header {
            background-color: #fff;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        header div:first-child {
            font-size: 22px;
            font-weight: bold;
            color: #333;
        }

        nav a {
            margin: 0 12px;
            text-decoration: none;
            color: #007bff;
            font-weight: 500;
        }

        nav a:hover {
            text-decoration: underline;
        }

    .banner {
    background-image: url("https://daknong.1cdn.vn/2025/01/03/study-group-thong-tin-va-lich-chieu-phim.jpg"); 
    background-size: cover;
    background-position: center ;
    height: 450px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 30px;
    font-weight: bold;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
    border-radius: 10px;
    margin: 20px 0;
}


        .quick-booking {
            background: #fff;
            padding: 20px;
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 30px auto;
            max-width: 900px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        select, button {
            padding: 10px 12px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 15px;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        .tabs {
            display: flex;
            justify-content: center;
            border-bottom: 2px solid #ccc;
            margin: 20px auto;
            max-width: 900px;
        }

        .tab {
            padding: 10px 20px;
            cursor: pointer;
            color: #999;
            border-bottom: 3px solid transparent;
            font-weight: bold;
        }

        .tab.active {
            color: #007bff;
            border-bottom-color: #007bff;
        }

        .movies {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            max-width: 1200px;
            margin: 30px auto;
            justify-content: center;
        }

        .movie {
            background: white;
            width: 250px;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 0 5px #ccc;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .movie img {
            width: 100%;
            height: 340px;
            object-fit: cover;
            border-radius: 10px;
        }

        .movie p {
            font-size: 16px;
            font-weight: 600;
            margin: 10px 0;
            height: 45px;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .movie-button {
            display: inline-block;
            margin-bottom: 10px;
            padding: 8px 14px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: background-color 0.3s;
        }

        .movie-button:hover {
            background-color: #0056b3;
        }

.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-toggle {
    color: #007bff;
    text-decoration: none;
    font-weight: 500;
    padding: 0 12px;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: white;
    min-width: 200px;
    box-shadow: 0 8px 16px rgba(0,0,0,0.15);
    border-radius: 6px;
    overflow: hidden;
    top: 100%;
    left: 0;
    z-index: 999;
}

.dropdown-content a {
    display: block;
    padding: 10px 16px;
    color: #333;
    text-decoration: none;
    border-bottom: 1px solid #eee;
}

.dropdown-content a:hover {
    background-color: #f2f2f2;
}

.dropdown:hover .dropdown-content {
    display: block;
}

    </style>
</head>
<body>

<header>
    <div>🍿 CINEMA THEATRE</div>
    <nav>
    <a href="#">Phim</a>
    <a href="#">Góc điện ảnh</a>
    <a href="#">Sự kiện</a>
    <div class="dropdown">
        <a href="#" class="dropdown-toggle">Rạp/Giá vé </a>
        <div class="dropdown-content">
    <?php
    $sql_rap = "SELECT ma_rap, tenrap FROM Rạp_Phim";
    $stmt_rap = sqlsrv_query($conn, $sql_rap);
    if ($stmt_rap) {
        while ($row = sqlsrv_fetch_array($stmt_rap, SQLSRV_FETCH_ASSOC)) {
            $ma_rap = $row['ma_rap'];
            $tenrap = htmlspecialchars($row['tenrap']);
            echo "<a href='lich_rap.php?ma_rap=$ma_rap'>$tenrap</a>";
        }
    }
    ?>
</div>
    </div>
</nav>

    <div>
        Xin chào, <strong><?= htmlspecialchars($_SESSION['hoten']); ?></strong> |
        <a href="logout.php">Đăng xuất</a>
    </div>
</header>

<div class="banner">Phim mới nhất đang chiếu</div>

<div class="tabs">
    <div class="tab active" data-tab="dang-chieu">Đang chiếu</div>
    <div class="tab" data-tab="sap-chieu">Sắp chiếu</div>
</div>

<!-- Phim đang chiếu -->
<div id="dang-chieu" class="movies tab-content" style="display: flex;">
    <?php
    $sql_dc = "SELECT ma_phim, tenphim FROM phim WHERE trangthai = 'dang_chieu'";
    $stmt_dc = sqlsrv_query($conn, $sql_dc);
    if ($stmt_dc === false) {
        echo "<p>Lỗi truy vấn phim đang chiếu.</p>";
    } else {
        while ($row = sqlsrv_fetch_array($stmt_dc, SQLSRV_FETCH_ASSOC)) {
            $ma_phim = $row['ma_phim'];
            $tenphim = $row['tenphim'];
            $img = "Picture/" . strtolower(str_replace(' ', '_', $tenphim)) . ".jpg";

            echo '<div class="movie">';
            echo '<img src="'.htmlspecialchars($img).'" alt="'.htmlspecialchars($tenphim).'">';
            echo '<p>'.htmlspecialchars($tenphim).'</p>';
            echo '<div>';
            echo '<a href="#" class="movie-button">Chi tiết</a> ';
            echo '<a href="chon_ghe.php?ma_phim='.urlencode($ma_phim).'" class="movie-button" style="background-color:#28a745;">Đặt vé</a>';
            echo '</div>';
            echo '</div>';
        }
    }
    ?>
</div>

<!-- Phim sắp chiếu -->
<div id="sap-chieu" class="movies tab-content" style="display: none;">
    <?php
    $sql_sc = "SELECT tenphim FROM phim WHERE trangthai = 'sap_chieu'";
    $stmt_sc = sqlsrv_query($conn, $sql_sc);
    if ($stmt_sc === false) {
        echo "<p>Lỗi truy vấn phim sắp chiếu.</p>";
    } else {
        while ($row = sqlsrv_fetch_array($stmt_sc, SQLSRV_FETCH_ASSOC)) {
            $tenphim = $row['tenphim'];
            $img = "Picture/" . strtolower(str_replace(' ', '_', $tenphim)) . ".jpg";
            echo '<div class="movie">';
            echo '<img src="'.htmlspecialchars($img).'" alt="'.htmlspecialchars($tenphim).'">';
            echo '<p>'.htmlspecialchars($tenphim).'</p>';
            echo '<a href="#" class="movie-button">Chi tiết</a>';
            echo '</div>';
        }
    }
    ?>
</div>

<script>
    const tabs = document.querySelectorAll('.tab');
    const contents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            const target = tab.getAttribute('data-tab');
            contents.forEach(c => {
                c.style.display = (c.id === target) ? 'flex' : 'none';
            });
        });
    });
</script>
</body>
</html>
