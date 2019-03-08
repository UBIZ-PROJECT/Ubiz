-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 08, 2019 lúc 08:50 PM
-- Phiên bản máy phục vụ: 10.1.38-MariaDB
-- Phiên bản PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `ubiz`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `pricing`
--

CREATE TABLE `pricing` (
  `pri_id` int(10) UNSIGNED NOT NULL,
  `pri_code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cus_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pri_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `exp_date` timestamp NULL DEFAULT NULL,
  `delete_flg` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `inp_date` timestamp NULL DEFAULT NULL,
  `inp_user` int(11) NOT NULL,
  `upd_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `upd_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `pricing`
--

INSERT INTO `pricing` (`pri_id`, `pri_code`, `cus_id`, `user_id`, `pri_date`, `exp_date`, `delete_flg`, `inp_date`, `inp_user`, `upd_date`, `upd_user`) VALUES
(1, '00001', 1, 1, '2019-03-07 16:16:45', '2019-03-29 17:00:00', '0', '2019-03-07 13:27:03', 1, '2019-03-07 09:16:45', 1),
(2, '00002', 2, 2, '2019-03-08 19:36:21', '2019-03-26 17:00:00', '0', '2019-03-07 13:28:00', 1, '2019-03-08 08:29:35', 1),
(12, '00012', 1, 1, '2019-03-08 19:39:07', '2019-05-29 17:00:00', '0', '2019-03-08 08:08:42', 1, '2019-03-08 12:39:07', 1),
(13, '00013', 2, 1, '2019-03-08 15:25:29', '2019-09-19 17:00:00', '0', '2019-03-08 08:25:29', 1, '2019-03-08 08:25:29', 1),
(18, '00018', 1, 2, '2019-03-08 19:36:24', '2018-12-31 17:00:00', '0', '2019-03-08 08:45:32', 1, '2019-03-08 08:47:51', 1),
(27, '00027', 2, 1, '2019-03-08 16:05:17', '2018-12-31 17:00:00', '0', '2019-03-08 09:05:17', 1, '2019-03-08 09:05:17', 1),
(28, '00028', 1, 1, '2019-03-08 18:20:23', '2019-02-09 17:00:00', '0', '2019-03-08 09:31:03', 1, '2019-03-08 11:20:23', 1),
(29, '00029', 2, 1, '2019-03-08 16:32:35', '2019-05-19 17:00:00', '0', '2019-03-08 09:32:35', 1, '2019-03-08 09:32:35', 1),
(30, '00030', 2, 2, '2019-03-08 19:36:26', '2019-03-29 17:00:00', '0', '2019-03-08 12:30:04', 1, '2019-03-08 12:30:04', 1);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `pricing`
--
ALTER TABLE `pricing`
  ADD PRIMARY KEY (`pri_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `pricing`
--
ALTER TABLE `pricing`
  MODIFY `pri_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
