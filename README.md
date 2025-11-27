# 🎬 WEBSITE ĐẶT VÉ XEM PHIM ONLINE
## 🎯 Giới thiệu
Website đặt vé xem phim trực tuyến giúp người dùng dễ dàng tìm kiếm phim, chọn rạp, suất chiếu và ghế ngồi một cách nhanh chóng. Hệ thống được thiết kế trực quan, hoạt động ổn định trên mọi thiết bị và mang đến trải nghiệm mua vé hiện đại – tiện lợi – an toàn.
## 🔥 Tại sao xây dựng hệ thống này?
1. Tự động hóa quy trình mua vé truyền thống
 
2. Hạn chế xếp hàng tại quầy
 
3. Giúp rạp dễ dàng quản lý phim, suất chiếu và đặt chỗ
  
4. Tạo môi trường thực hành backend + database dành cho sinh viên CNTT
## 🚀 Tính năng nổi bật
### 👤 Người dùng
- 🔍 Tìm kiếm phim theo tên hoặc thể loại

- 🎦 Xem danh sách phim đang chiếu & sắp chiếu

- 🏢 Chọn rạp và xem lịch chiếu theo từng ngày

- 🕒 Chọn suất chiếu phù hợp

- 💺 Chọn ghế theo sơ đồ phòng chiếu

- 💳 Đặt vé & xuất hóa đơn tự động

- 👤 Đăng nhập/Đăng ký người dùng

### 🛠️ Trang quản trị dành cho admin
- Quản lý phim: thêm – sửa – xóa</p>
<img width="1920" height="980" alt="image" src="https://github.com/user-attachments/assets/ca2b18fa-51fa-4de8-bbac-54a89e3f25d0" /></p>

- Quản lý suất chiếu</p>
<img width="1920" height="925" alt="image" src="https://github.com/user-attachments/assets/f95a47e4-5757-40f9-b8e1-b0c446348a94" /></p>

- Quản lý người dùng</p>
<img width="1920" height="926" alt="image" src="https://github.com/user-attachments/assets/a0b8dd4d-2df0-4659-872a-fade3963907f" /></p>

## 🖥️ Giao diện hệ thống
### 1. Trang Auth Page: Đăng ký + Đăng nhập
🔑 Đăng nhập</P>
<img width="1920" height="879" alt="image" src="https://github.com/user-attachments/assets/604bc1ad-3489-446d-9175-fa2419de0247" /></p>

✍️ Đăng ký</P>
<img width="1920" height="971" alt="image" src="https://github.com/user-attachments/assets/3c00f345-6083-4412-bffa-da796e211f85" /></p>

### 2. Trang chủ : Hiển thị danh sách phim đang chiếu + sắp chiếu.</p>
🎥 Đang chiếu</p>
<img width="1919" height="1031" alt="image" src="https://github.com/user-attachments/assets/b1eedec4-39dc-4285-9c2f-ca4cd05b2199" /></p>

⏳ Sắp chiếu</p>
<img width="1920" height="982" alt="image" src="https://github.com/user-attachments/assets/6d3bcbe3-a81e-4d8b-b9e4-fca3c1da5600" /></p>

### 3. Trang chọn rạp: Danh sách rạp + lịch chiếu theo ngày.</p>
<img width="1920" height="981" alt="image" src="https://github.com/user-attachments/assets/b4dc50b3-e733-4947-87b5-d2a01c4777fd" /></p>

### 4. Trang chọn ghế: Sơ đồ ghế trực quan</p>
<img width="1919" height="982" alt="image" src="https://github.com/user-attachments/assets/28855c37-ada0-4475-a0c3-b4f629eca147" /></p>

### 5. Trang thanh toán: Tóm tắt vé + giá + xác nhận</p>
<img width="1913" height="924" alt="image" src="https://github.com/user-attachments/assets/a45baee0-c640-425d-844e-2a7b18a65754" /></p>

### 6. Trang admin: Quản lý phim, người dùng, suất chiếu, rạp</p>
<img width="1917" height="928" alt="image" src="https://github.com/user-attachments/assets/9e37de2d-7060-48c7-93de-aca6ca9d5512" /></p>

## 🧱 Công nghệ sử dụng
- Frontend: HTML, CSS, JavaScript
 
- Backend: PHP
 
- Database: SQL Server</P>
<img width="225" height="225" alt="image" src="https://github.com/user-attachments/assets/22ffb1b7-ab1d-425b-9939-8b8839eed868" /></P>

- Visual studio code</P>
<img width="300" height="250" alt="image" src="https://github.com/user-attachments/assets/293b11eb-f1e2-4194-96c2-6043875b12b9" /></p>

- Kết nối: PHP + SQLSRV Driver
 
- Triển khai: Localhost/XAMPP</P>
<img width="300" height="168" alt="image" src="https://github.com/user-attachments/assets/d2c461ff-7871-4366-ba81-e14ff0e2cfaa" /></P>

## 🗂️ Cấu trúc thư mục
```📁 project
 ├── 📁 assets
 ├── 📁 css
 ├── 📁 js
 ├── 📄 connection.php
 ├── 📄 user_dashboard.php
 ├── 📄 movie.php
 ├── 📄 chon_ghe.php
 ├── 📄 dat_ve.php
 ├── 📁 admin
 │    ├── 📄 manage_movie.php
 │    ├── 📄 manage_user.php
 └── 📄 README.md
```
## 🧪 Cách chạy dự án
### 1️⃣ Cài đặt yêu cầu
- XAMPP

- PHP driver SQL Server

- SQL Server Management Studio

### 2️⃣ Cài đặt
1. Clone project về máy</p>
  `git clone <link-repo>`

2. Import cơ sở dữ liệu vào SQL Server
   
3. Mở XAMPP → bật Apache<P>
<img width="833" height="545" alt="image" src="https://github.com/user-attachments/assets/081000ba-1557-4723-adf1-fe46c412512d" /></P>

4. Truy cập trên trình duyệt</p>
  `http://localhost/tên_folder`</p>
<img width="352" height="51" alt="image" src="https://github.com/user-attachments/assets/3378f8d8-ab4a-48ca-86bc-2d8bb642fc7c" /></p>

---
## 💖 CẢM ƠN CÔ ĐÃ DÀNH THỜI GIAN XEM VÀ ĐÁNH GIÁ DỰ ÁN CỦA NHÓM EM!

