-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 08, 2019 lúc 08:51 PM
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
-- Cấu trúc bảng cho bảng `pricing_product`
--

CREATE TABLE `pricing_product` (
  `pro_id` int(10) UNSIGNED NOT NULL,
  `pri_id` int(11) NOT NULL,
  `type` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` int(11) NOT NULL,
  `unit` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL,
  `specs` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delete_flg` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `inp_date` timestamp NULL DEFAULT NULL,
  `inp_user` int(11) NOT NULL,
  `upd_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `upd_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `pricing_product`
--

INSERT INTO `pricing_product` (`pro_id`, `pri_id`, `type`, `code`, `name`, `price`, `unit`, `amount`, `specs`, `delivery_date`, `status`, `delete_flg`, `inp_date`, `inp_user`, `upd_date`, `upd_user`) VALUES
(5, 1, '1', NULL, NULL, 5600000, 'Cai', 2, 'Bom A', '2019-03-16 17:00:00', '1', '0', '2019-03-06 17:00:00', 1, '2019-03-07 09:16:45', 1),
(6, 1, '1', NULL, NULL, 3450000, 'Cai', 3, 'Bom B', '2019-03-07 16:17:29', '0', '0', '2019-03-06 17:00:00', 1, '2019-03-06 17:00:00', 1),
(7, 1, '2', 'F0001', 'Phu tung 1', 1200000, 'Chiec', 3, NULL, '2019-03-07 16:17:34', '1', '0', '2019-03-06 17:00:00', 1, '2019-03-06 17:00:00', 1),
(8, 1, '2', 'F0002', 'Phu tung 2', 2780000, 'Thanh', 2, NULL, '2019-06-11 17:00:00', '1', '0', '2019-03-06 17:00:00', 1, '2019-03-07 09:16:45', 1),
(15, 12, '1', NULL, NULL, 5600000, 'Cái', 3, 'Bơm C', '2019-04-01 17:00:00', '1', '0', '2019-03-07 17:00:00', 1, '2019-03-08 12:39:07', 1),
(16, 12, '1', NULL, NULL, 3250000, 'Cái', 2, 'Bơm D', '2019-04-29 17:00:00', '0', '0', '2019-03-07 17:00:00', 1, '2019-03-08 12:39:07', 1),
(17, 12, '2', 'F0003', 'Phụ tùng 3', 1240000, 'Chiếc', 2, NULL, '2019-05-04 17:00:00', '1', '0', '2019-03-07 17:00:00', 1, '2019-03-08 12:39:07', 1),
(18, 12, '2', 'F0004', 'Phụ tùng 4', 750000, 'Thanh', 3, NULL, '2019-03-08 19:39:07', '0', '1', '2019-03-07 17:00:00', 1, '2019-03-07 17:00:00', 1),
(19, 13, '1', NULL, NULL, 7600000, 'Cái', 3, 'Bơm E\r\nCông suất XXX', '2019-08-17 17:00:00', '1', '0', '2019-03-07 17:00:00', 1, '2019-03-07 17:00:00', 1),
(20, 13, '2', 'F0005', 'Phụ tùng 5', 950000, 'Thanh', 2, NULL, '2019-09-09 17:00:00', '0', '0', '2019-03-07 17:00:00', 1, '2019-03-07 17:00:00', 1),
(21, 13, '2', 'F0006', 'Phụ tùng 6', 780000, 'Cái', 1, NULL, '2019-09-14 17:00:00', '1', '0', '2019-03-07 17:00:00', 1, '2019-03-07 17:00:00', 1),
(22, 2, '1', NULL, NULL, 4500000, 'Cái', 1, 'Bơm C', '2019-03-16 17:00:00', '1', '0', '2019-03-07 17:00:00', 1, '2019-03-07 17:00:00', 1),
(31, 18, '1', NULL, NULL, 1600000, 'Cái', 1, 'Bơm Y', '2018-12-31 17:00:00', '1', '0', '2019-03-07 17:00:00', 1, '2019-03-08 08:47:51', 1),
(32, 18, '1', NULL, NULL, 1800000, 'Cái', 2, 'Bơm Z', '2018-12-31 17:00:00', '0', '0', '2019-03-07 17:00:00', 1, '2019-03-07 17:00:00', 1),
(33, 18, '2', 'F0006', 'Phụ tùng 6', 1430000, 'Chiếc', 2, NULL, '2018-12-31 17:00:00', '1', '0', '2019-03-07 17:00:00', 1, '2019-03-07 17:00:00', 1),
(40, 27, '1', NULL, NULL, 23423423, 'Cái', 1, 'Bơm CCCC', '2018-12-31 17:00:00', '1', '0', '2019-03-07 17:00:00', 1, '2019-03-07 17:00:00', 1),
(41, 28, '1', NULL, NULL, 3400000, 'Cái', 2, 'Bơm G', '2019-01-01 17:00:00', '1', '0', '2019-03-07 17:00:00', 1, '2019-03-08 11:20:23', 1),
(42, 28, '1', NULL, NULL, 4550000, 'Cái', 3, 'Bơm H', '2019-02-04 17:00:00', '0', '0', '2019-03-07 17:00:00', 1, '2019-03-08 11:20:23', 1),
(43, 28, '2', 'F0006', 'Phụ tùng 6', 900000, 'Chiếc', 2, NULL, '2019-02-01 17:00:00', '1', '0', '2019-03-07 17:00:00', 1, '2019-03-08 11:20:23', 1),
(44, 28, '2', 'F0007', 'Phụ tùng 7', 650000, 'Thanh', 3, NULL, '2019-02-07 17:00:00', '0', '0', '2019-03-07 17:00:00', 1, '2019-03-08 11:20:23', 1),
(45, 29, '2', 'F0009', 'Phụ tùng 9', 1350000, 'Chiếc', 8, NULL, '2019-05-04 17:00:00', '0', '0', '2019-03-07 17:00:00', 1, '2019-03-07 17:00:00', 1),
(46, 30, '1', NULL, NULL, 3250000, 'Cái', 2, 'Bơm ABC', '2019-02-09 17:00:00', '1', '0', '2019-03-07 17:00:00', 1, '2019-03-07 17:00:00', 1),
(47, 30, '1', NULL, NULL, 4990000, 'Cái', 3, 'Bơm DEF', '2019-03-19 17:00:00', '0', '0', '2019-03-07 17:00:00', 1, '2019-03-07 17:00:00', 1),
(48, 30, '2', 'F0010', 'Phụ tùng 10', 1200000, 'Chiếc', 2, NULL, '2019-02-11 17:00:00', '1', '0', '2019-03-07 17:00:00', 1, '2019-03-07 17:00:00', 1),
(49, 30, '2', 'F0011', 'Phụ tùng 11', 1430000, 'Thanh', 3, NULL, '2019-03-14 17:00:00', '0', '0', '2019-03-07 17:00:00', 1, '2019-03-07 17:00:00', 1),
(50, 12, '2', 'F0005', 'Linh kiện 5', 960000, 'Thanh', 3, NULL, '2019-05-13 17:00:00', '0', '0', '2019-03-07 17:00:00', 1, '2019-03-07 17:00:00', 1);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `pricing_product`
--
ALTER TABLE `pricing_product`
  ADD PRIMARY KEY (`pro_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `pricing_product`
--
ALTER TABLE `pricing_product`
  MODIFY `pro_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
