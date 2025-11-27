<?php
session_start();
session_unset(); // Xóa tất cả biến phiên
session_destroy(); // Hủy phiên

// Chuyển hướng về trang đăng nhập
header("Location: login.html");
exit();
