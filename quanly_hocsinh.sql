-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 08, 2021 lúc 04:25 PM
-- Phiên bản máy phục vụ: 10.4.21-MariaDB
-- Phiên bản PHP: 7.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `quanly_hocsinh`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `gv_giangday`
--

CREATE TABLE `gv_giangday` (
  `magv` varchar(8) NOT NULL,
  `namhoc` varchar(12) NOT NULL,
  `mamh` varchar(8) NOT NULL,
  `malop` varchar(8) NOT NULL,
  `update_by` varchar(8) NOT NULL DEFAULT '''admin''',
  `update_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `gv_giangday`
--

INSERT INTO `gv_giangday` (`magv`, `namhoc`, `mamh`, `malop`, `update_by`, `update_time`) VALUES
('GV000001', '2021-2022', 'toan', '10a1', 'admin', '2021-10-25 08:42:35'),
('GV000002', '2021-2022', 'van', '10a2', 'admin', '2021-10-25 08:42:35'),
('GV000003', '2021-2022', 'ly', '10a2', 'admin', '2021-10-25 08:42:35'),
('GV000004', '2021-2022', 'hoa', '10a1', 'admin', '2021-10-25 08:42:35'),
('GV000001', '2021-2022', 'toan', '10a2', 'admin', '2021-10-28 02:21:57'),
('GV000001', '2021-2022', 'toan', '10a3', 'admin', '2021-10-28 02:22:22'),
('GV000004', '2021-2022', 'toan', '10a3', 'admin', '2021-10-28 02:23:05');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `gv_thongtin`
--

CREATE TABLE `gv_thongtin` (
  `id` int(11) NOT NULL,
  `magv` varchar(8) NOT NULL,
  `hoten_gv` varchar(30) NOT NULL,
  `ngaysinh` date NOT NULL,
  `gioitinh` varchar(8) NOT NULL,
  `chucvu` varchar(50) NOT NULL,
  `malop` varchar(8) NOT NULL,
  `namhoc` varchar(12) NOT NULL,
  `chuyennganh` varchar(50) NOT NULL,
  `sdt` varchar(20) NOT NULL,
  `diachi` varchar(100) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_by` varchar(8) NOT NULL DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `gv_thongtin`
--

INSERT INTO `gv_thongtin` (`id`, `magv`, `hoten_gv`, `ngaysinh`, `gioitinh`, `chucvu`, `malop`, `namhoc`, `chuyennganh`, `sdt`, `diachi`, `update_time`, `update_by`) VALUES
(1, 'GV000001', 'Phạm Thị A', '1980-01-01', 'Nữ', 'Giáo viên', '10a1', '2021-2022', 'lập trình nâng cao', '0123456789', 'Hà Nội', '2021-10-25 08:46:37', 'admin'),
(2, 'GV000002', 'Phạm Thị B', '1980-01-01', 'Nữ', 'Hiệu phó', '10a2', '2021-2022', 'lập trình nâng cao', '0123456789', 'Hà Nội', '2021-10-25 08:53:01', 'admin'),
(3, 'GV000003', 'Phạm Thị C', '1980-01-01', 'Nữ', 'Hiệu trưởng', '10a3', '2021-2022', 'lập trình nâng cao', '0123456789', 'Hà Nội', '2021-10-25 08:53:01', 'admin'),
(4, 'GV000004', 'Nguyễn Văn A', '1980-01-01', 'Nam', 'Giáo viên', '11a1', '2021-2022', 'lập trình nâng cao', '0123456789', 'Hà Nội', '2021-10-25 08:53:01', 'admin'),
(5, 'GV000005', 'Phạm Thị D', '1980-01-01', 'Nữ', 'Giáo viên', '11a2', '2021-2022', 'lập trình nâng cao', '0123456789', 'Hà Nội', '2021-10-28 07:01:29', 'admin'),
(6, 'GV000006', 'Phạm Thị E', '1980-01-01', 'Nữ', 'Giáo viên', '11a3', '2021-2022', 'lập trình nâng cao', '0123456789', 'Hà Nội', '2021-10-28 07:10:54', 'admin'),
(10, 'GV000010', 'Phạm Thị F', '1980-01-01', 'Nữ', 'Giáo viên', '12a1', '2021-2022', 'lập trình nâng cao', '0123456789', 'Hà nội', '2021-10-28 09:28:03', 'admin'),
(12, 'GV000012', 'Nguyễn Văn B', '0101-01-01', 'Nam', 'giáo viên', '12a2', '2021-2022', 'lập trình nâng cao', '0123456789', 'Hà Nội', '2021-11-03 13:12:08', 'admin');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hs_diem`
--

CREATE TABLE `hs_diem` (
  `id` int(11) NOT NULL,
  `mahs` varchar(8) NOT NULL,
  `mamh` varchar(20) NOT NULL,
  `diem1` double NOT NULL,
  `diem2` double NOT NULL,
  `diem3` double NOT NULL,
  `diem4` double NOT NULL,
  `diem5` double NOT NULL,
  `diem6` double NOT NULL,
  `update_by` varchar(8) NOT NULL DEFAULT '''admin''',
  `update_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `hs_diem`
--

INSERT INTO `hs_diem` (`id`, `mahs`, `mamh`, `diem1`, `diem2`, `diem3`, `diem4`, `diem5`, `diem6`, `update_by`, `update_time`) VALUES
(1, 'HS000002', 'MH000003', 8, 5, 7, 9, 8, 8, 'admin', '2021-10-25 03:05:52'),
(3, 'HS000001', 'MH000001', 4, 5, 8, 8, 8, 8, 'admin', '2021-10-25 03:05:52'),
(7, 'HS000001', 'MH000002', 5, 7, 8, 7, 7, 7, 'admin', '2021-10-25 03:14:39'),
(17, 'HS000006', 'MH000003', 7, 7, 7, 8, 8, 8, 'admin', '2021-11-04 08:27:57');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hs_thongtin`
--

CREATE TABLE `hs_thongtin` (
  `id` int(6) UNSIGNED NOT NULL,
  `mahs` varchar(8) NOT NULL,
  `hoten_hs` varchar(30) NOT NULL,
  `ngaysinh` date NOT NULL,
  `gioitinh` varchar(8) NOT NULL,
  `malop` varchar(8) NOT NULL,
  `namhoc` varchar(12) NOT NULL,
  `diachi` varchar(100) NOT NULL,
  `maph` varchar(8) NOT NULL,
  `hoten_bo` varchar(30) NOT NULL,
  `sdt_bo` varchar(20) NOT NULL,
  `hoten_me` varchar(30) NOT NULL,
  `sdt_me` varchar(20) NOT NULL,
  `update_by` varchar(8) NOT NULL DEFAULT '''admin''',
  `update_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `hs_thongtin`
--

INSERT INTO `hs_thongtin` (`id`, `mahs`, `hoten_hs`, `ngaysinh`, `gioitinh`, `malop`, `namhoc`, `diachi`, `maph`, `hoten_bo`, `sdt_bo`, `hoten_me`, `sdt_me`, `update_by`, `update_time`) VALUES
(1, 'HS000001', 'Nguyễn thị A', '2006-01-01', 'Nữ', '10a1', '2021-2022', 'HN', 'PH000001', 'Nguyễn Văn A', '0123456789', 'Phạm Thị A', '0123456789', 'admin', '2021-11-08 15:07:30'),
(2, 'HS000002', 'Nguyễn Văn A', '2006-01-01', 'Nam', '10a2', '2021-2022', 'HN', 'PH000002', 'Nguyễn Văn A', '0912770655', 'Phạm Thị A', '0910998443', 'admin', '2021-11-08 15:16:33'),
(3, 'HS000003', 'Nguyễn thị A', '2006-05-19', 'Nam', '10a3', '2021-2022', 'HN', 'PH000003', 'Nguyễn Văn A', '0900097634', 'Phạm Thị A', '0988223091', 'admin', '2021-11-08 15:16:41'),
(4, 'HS000004', 'Nguyễn Văn A', '2006-04-23', 'Nam', '11a1', '2021-2022', 'HN', 'PH000004', 'Nguyễn Văn A', '0987634123', 'Phạm Thị A', '0911234789', 'admin', '2021-11-08 15:16:50'),
(5, 'HS000005', 'Đặng Thị Lệ', '2006-02-15', 'Nam', '11a2', '2021-2022', 'Hà Nội', 'PH000005', 'Nguyễn Văn A', '0921998129', 'mama', '0123456789', 'admin', '2021-11-08 15:17:01'),
(6, 'HS000006', 'Nguyễn Văn A', '2006-11-03', 'Nam', '11a3', '2021-2022', 'HN', 'PH000006', 'Nguyễn Văn A', '0921998129', 'Phạm Thị A', '0911222444', 'admin', '2021-11-08 15:17:11'),
(8, 'HS000008', 'Trần Văn Hùng', '2006-03-07', 'Nam', '12a1', '2021-2022', 'HN', 'PH000008', 'papa', '0921998100', 'mama', '0911222400', 'admin', '2021-11-08 15:17:28'),
(9, 'HS000009', 'Nguyễn Văn Tứ', '2006-11-03', 'Nam', '12a2', '2021-2022', 'BG', 'PH000009', 'papa', '0921998129', 'mama', '0911222444', 'admin', '2021-11-08 15:17:36');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `monhoc`
--

CREATE TABLE `monhoc` (
  `id` int(11) NOT NULL,
  `mamh` varchar(8) NOT NULL,
  `tenmh` varchar(50) NOT NULL,
  `update_by` varchar(8) NOT NULL DEFAULT '''admin''',
  `update_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `monhoc`
--

INSERT INTO `monhoc` (`id`, `mamh`, `tenmh`, `update_by`, `update_time`) VALUES
(1, 'MH000001', 'Toán', 'admin', '2021-10-25 08:56:15'),
(2, 'MH000002', 'Lý', 'admin', '2021-10-25 08:57:45'),
(3, 'MH000003', 'Hóa', 'admin', '2021-10-25 08:57:45'),
(4, 'MH000004', 'Văn', 'admin', '2021-10-25 08:57:45');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tb_message`
--

CREATE TABLE `tb_message` (
  `id` int(11) NOT NULL,
  `nguoigui` varchar(8) NOT NULL,
  `nguoinhan` varchar(8) NOT NULL,
  `message` text NOT NULL,
  `trangthai` varchar(8) NOT NULL DEFAULT 'unread',
  `sendtime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `tb_message`
--

INSERT INTO `tb_message` (`id`, `nguoigui`, `nguoinhan`, `message`, `trangthai`, `sendtime`) VALUES
(1, 'admin', 'GV000003', 'Xin chào, đây là admin!', 'seen', '2021-11-01 03:26:20'),
(2, 'GV000003', 'admin', 'Chào admin. Tôi là hiệu trưởng. Nice to meet u!', 'seen', '2021-11-01 03:27:36'),
(3, 'admin', 'GV000004', 'Tôi là admin. Xin chào GV000004!', 'seen', '2021-11-01 03:28:44'),
(4, 'GV000001', 'GV000003', 'Hello GV000003', 'seen', '2021-11-01 03:29:22'),
(5, 'GV000001', 'GV000002', 'Bác vào xem thời khóa biểu đi!', 'unread', '2021-11-01 03:29:50'),
(6, 'admin', 'GV000003', 'Vâng, tôi sẽ hướng dẫn anh cách sử dụng web', 'seen', '2021-11-01 03:32:54'),
(7, 'GV000004', 'admin', 'Hello admin, tôi là GV000004', 'seen', '2021-11-01 04:02:44'),
(8, 'GV000004', 'admin', 'Đọc tin nhắn đi admin!', 'seen', '2021-11-01 04:26:19'),
(9, 'GV000001', 'admin', 'Tôi muốn thêm điểm thì làm ntn?', 'seen', '2021-11-01 04:34:26'),
(10, 'GV000001', 'admin', 'Mong admin giúp đõ!', 'seen', '2021-11-01 05:07:30'),
(11, 'GV000004', 'admin', 'Tôi đang cần gấp', 'seen', '2021-11-01 05:11:07'),
(13, 'admin', 'GV000004', 'Bác cần giúp gì?', 'seen', '2021-11-01 10:59:58'),
(14, 'admin', 'GV000004', 'Bác cần hướng dẫn về thêm điểm hay thêm học sinh?', 'seen', '2021-11-01 11:05:51'),
(15, 'GV000002', 'admin', 'Admin có ở đó không vậy? ', 'seen', '2021-11-02 07:07:34'),
(17, 'GV000003', 'GV000002', 'hello bác 02', 'unread', '2021-11-02 07:31:01'),
(18, 'GV000003', 'GV000002', 'nice to meet you', 'unread', '2021-11-02 07:31:12'),
(22, 'GV000004', 'admin', 'Làm sao để chỉnh sửa thông tin học sinh?', 'seen', '2021-11-02 11:28:11'),
(23, 'GV000003', 'GV000002', 'Bác cần giúp gì?', 'unread', '2021-11-03 10:23:58'),
(24, 'GV000003', 'GV000002', 'Có gì cứ hỏi tôi', 'unread', '2021-11-03 10:24:04'),
(25, 'GV000003', 'GV000002', 'Bác cần hướng dẫn về thêm điểm hay thêm học sinh?', 'unread', '2021-11-03 10:24:07'),
(26, 'GV000003', 'GV000002', 'hello', 'unread', '2021-11-03 10:24:17'),
(27, 'GV000003', 'GV000002', 'Ok ko bác?', 'unread', '2021-11-03 10:24:36'),
(28, 'GV000003', 'GV000002', '', 'unread', '2021-11-03 10:24:57'),
(29, 'GV000003', 'GV000002', 'hello', 'unread', '2021-11-03 10:25:15'),
(30, 'GV000003', 'admin', 'Cám ơn anh! Tôi muốn biết làm như thế nào để thêm điểm cho học sinh?', 'seen', '2021-11-03 10:31:30'),
(31, 'GV000003', 'admin', 'admin giúp tôi với!', 'seen', '2021-11-04 09:53:23'),
(32, 'admin', 'GV000001', 'giúp?', 'unread', '2021-11-08 12:05:51');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tb_user`
--

CREATE TABLE `tb_user` (
  `id` int(11) NOT NULL,
  `username` varchar(8) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `level` tinyint(4) NOT NULL,
  `update_by` varchar(8) NOT NULL DEFAULT 'admin',
  `update_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `tb_user`
--

INSERT INTO `tb_user` (`id`, `username`, `password`, `email`, `level`, `update_by`, `update_time`) VALUES
(1, 'admin', '202cb962ac59075b964b07152d234b70', 'admin@gmai.com', 1, 'admin', '2021-10-25 09:59:33'),
(2, 'HS000001', '202cb962ac59075b964b07152d234b70', 'userhs1@gmai.com', 2, 'admin', '2021-10-25 10:03:52'),
(3, 'HS000002', '202cb962ac59075b964b07152d234b70', 'userhs2@gmai.com', 2, 'admin', '2021-10-25 10:03:52'),
(4, 'GV000001', '202cb962ac59075b964b07152d234b70', 'usergv1@gmai.com', 1, 'admin', '2021-10-25 10:03:52'),
(6, 'GV000002', '202cb962ac59075b964b07152d234b70', 'usergv02@gmail.com', 1, 'admin', '2021-10-25 10:17:03'),
(7, 'HS000003', '202cb962ac59075b964b07152d234b70', 'hs03@g.c', 2, 'admin', '2021-10-25 10:42:43'),
(11, 'HS000004', '202cb962ac59075b964b07152d234b70', 'hs04@g.c', 2, 'admin', '2021-10-26 03:10:48'),
(16, 'GV000004', '202cb962ac59075b964b07152d234b70', 'aaaa@g.c', 2, 'admin', '2021-10-27 05:14:55'),
(18, 'GV000003', '202cb962ac59075b964b07152d234b70', 'gv03@g.c', 1, 'admin', '2021-10-28 01:20:26'),
(19, 'PH000001', '202cb962ac59075b964b07152d234b70', 'hello@g.c', 2, 'admin', '2021-10-28 01:20:26'),
(20, 'HS000005', '202cb962ac59075b964b07152d234b70', 'hs05@g.c', 2, 'admin', '2021-11-03 12:46:21'),
(21, 'HS000008', '202cb962ac59075b964b07152d234b70', 'hs08@g.c', 2, 'admin', '2021-11-04 09:45:46');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `gv_thongtin`
--
ALTER TABLE `gv_thongtin`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `hs_diem`
--
ALTER TABLE `hs_diem`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `hs_thongtin`
--
ALTER TABLE `hs_thongtin`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `monhoc`
--
ALTER TABLE `monhoc`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tb_message`
--
ALTER TABLE `tb_message`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `gv_thongtin`
--
ALTER TABLE `gv_thongtin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `hs_diem`
--
ALTER TABLE `hs_diem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `hs_thongtin`
--
ALTER TABLE `hs_thongtin`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT cho bảng `monhoc`
--
ALTER TABLE `monhoc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `tb_message`
--
ALTER TABLE `tb_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT cho bảng `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
