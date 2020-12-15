-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th12 13, 2020 lúc 01:30 PM
-- Phiên bản máy phục vụ: 5.7.24
-- Phiên bản PHP: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `ssm`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin_role`
--

CREATE TABLE `admin_role` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `admin_role`
--

INSERT INTO `admin_role` (`id`, `name`) VALUES
(1, 'Giám đốc'),
(2, 'Nhân viên pha chế'),
(3, 'Nhân viên phục vụ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phoneNumber` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `firstName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lastName` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `role` int(11) NOT NULL,
  `createBy` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `dateCreate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`, `email`, `phoneNumber`, `firstName`, `lastName`, `role`, `createBy`, `dateCreate`, `active`) VALUES
(1, 'admin', '$2y$10$V.V.HPnm92ERywu6gZxn1On2tjV82Zi9yATEZiEFGPm8botEzAq8q', 'admin@ssm.com', '0335740004', 'Nguyễn Quốc', 'Trung', 1, '', '2020-11-15 09:02:03', 1),
(3, 'phucvu', '$2y$10$BXi.sBENyYtmacA5hrfLOeGCUGjnIxwuUQU2ogycqKrVZSEeOTbIa', 'phucvu@ssm.com', '0123456789', 'Nguyễn Thanh Bình', 'Phước', 3, 'admin', '2020-11-15 09:51:58', 1),
(4, 'phache', '$2y$10$2h1Vfo34WMSZelwH11AyQOu3jdctTrkfEYASRplzuCWIrrjJ0lLTW', 'quachquesh2@gmail.com', '0335740004', 'Nguyễn', 'Quốc Trung', 2, 'admin', '2020-11-15 10:40:56', 1),
(5, 'phucvu2', '$2y$10$12PtUZGipykzTpUJ0A9ooO2I4PqiH9GCS83gTw9hS9f/EqoUlYnay', 'quachquesh2@gmail.com', '0335740004', 'Nguyễn', 'Quốc Trung', 3, 'admin', '2020-11-17 14:28:27', 0),
(8, 'phache2', '$2y$10$RQSAhT2ZFN8Jinp74faml.ASX4fqNojhGet4aMf/jriBcLtZ1dKKu', 'phache2@ssm.com', '0123456789', 'Nguyễn Thanh Bình', 'Phước', 2, 'admin', '2020-11-17 14:30:00', 1),
(10, 'phucvu3', '$2y$10$n3rQBsjnVl5cUog7oTw6X.Kn.7F3VYbDEa5o47/rFGfNxHkCG6JF2', 'quachquesh2@gmail.com', '0335740004', 'Nguyễn', 'Quốc Trung', 3, 'admin', '2020-12-05 15:45:29', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` double NOT NULL,
  `priceOrder` int(11) NOT NULL COMMENT 'Tiền tổng hóa đơn',
  `priceDiscount` int(11) NOT NULL COMMENT 'Tiền giảm giá',
  `pricePayment` int(11) NOT NULL COMMENT 'Tiền thanh toán',
  `note` text COLLATE utf8_unicode_ci NOT NULL,
  `tableId` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0: Chờ hệ thống xử lý\r\n1: Chờ thanh toán\r\n2: Đã thanh toán\r\n3: Pha chế\r\n4: Giao hàng\r\n5: Thất bại',
  `voucher` int(11) DEFAULT NULL,
  `payment` int(11) NOT NULL,
  `cancelReason` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'lý do hủy đơn'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `priceOrder`, `priceDiscount`, `pricePayment`, `note`, `tableId`, `status`, `voucher`, `payment`, `cancelReason`) VALUES
(1605772045865, 170300, 0, 170300, '', 102, 4, NULL, 2, ''),
(1605772050817, 170300, 10, 153270, '', 102, 5, 6, 2, 'Khách hàng yêu cầu hủy đơn'),
(1605772058227, 146300, 200000, 0, '', 102, 5, 5, 2, 'Khách hàng yêu cầu hủy'),
(1605772145245, 98300, 200000, 0, '', 102, 4, 5, 2, ''),
(1605772160835, 57150, 0, 57150, '', 102, 5, NULL, 2, 'Hủy đơn'),
(1605772328664, 57150, 0, 57150, '', 102, 4, NULL, 2, ''),
(1606121163115, 89150, 0, 89150, '', 102, 4, NULL, 2, ''),
(1606121170015, 110150, 0, 110150, '', 102, 4, NULL, 2, ''),
(1606121180559, 205150, 200000, 5150, '', 102, 4, 5, 2, ''),
(1606121186204, 205150, 10, 184635, '', 102, 5, 6, 2, 'Khách hàng yêu cầu hủy đơn'),
(1606121722725, 157150, 10, 141435, '', 102, 4, 6, 2, ''),
(1606121755005, 157150, 10, 141435, '', 102, 4, 6, 2, ''),
(1606127702147, 95000, 200000, 0, '', 102, 4, 5, 2, ''),
(1606127771076, 95000, 200000, 0, '', 102, 4, 5, 2, ''),
(1606128284178, 95000, 200000, 0, '', 102, 4, 5, 2, ''),
(1606128294799, 101000, 0, 101000, '', 102, 5, NULL, 2, 'Khách hàng yêu cầu hủy đơn'),
(1606133834729, 101000, 0, 101000, '', 102, 4, NULL, 2, ''),
(1606133871497, 101000, 0, 101000, '', 102, 5, NULL, 2, 'Khách hàng yêu cầu hủy đơn'),
(1606133880410, 258000, 200000, 58000, '', 102, 4, 5, 2, ''),
(1606137929019, 508000, 10, 457200, '', 102, 4, 6, 2, ''),
(1606138272075, 130000, 0, 117000, '', 102, 4, 6, 2, ''),
(1606138318213, 106000, 0, 95400, '', 102, 4, 6, 2, ''),
(1606138524547, 175000, 17500, 157500, '', 102, 4, 6, 2, ''),
(1606139704422, 196000, 196000, 0, '', 102, 4, 5, 2, ''),
(1606139738618, 196000, 196000, 0, '', 102, 5, 5, 2, 'asd'),
(1606139739725, 196000, 196000, 0, '', 102, 5, 5, 2, 'Không có khách hàng tại bàn'),
(1606139775396, 196000, 196000, 0, '', 102, 5, 5, 2, 'Không có khách hàng tại bàn'),
(1606139836432, 196000, 196000, 0, '', 102, 4, 5, 2, ''),
(1606139902708, 196000, 196000, 0, '', 102, 4, 5, 2, ''),
(1606145833591, 89150, 8915, 80235, '', 102, 4, 6, 2, ''),
(1606145847653, 89150, 26745, 62405, '', 102, 4, 6, 2, ''),
(1606145851062, 89150, 26745, 62405, '', 102, 5, 6, 2, 'Khách hàng yêu cầu hủy đơn'),
(1606159031899, 57150, 0, 57150, '', 102, 4, NULL, 2, ''),
(1606159045777, 57150, 17145, 40005, '', 102, 4, 6, 2, ''),
(1606159062013, 413900, 124170, 289730, '', 102, 4, 6, 2, ''),
(1606159068956, 458900, 137670, 321230, '', 102, 4, 6, 2, ''),
(1606159128487, 458900, 137670, 321230, '', 102, 5, 6, 2, 'Khách hàng yêu cầu hủy đơn'),
(1606161422007, 146300, 43890, 102410, '', 102, 5, 6, 2, 'Khách hàng yêu cầu hủy đơn'),
(1606161618232, 146300, 43890, 102410, '', 102, 5, 6, 2, 'Không có khách hàng tại bàn'),
(1606161638607, 146300, 43890, 102410, '', 102, 4, 6, 2, ''),
(1606161649879, 339300, 70000, 269300, '', 102, 4, 5, 2, ''),
(1606161657205, 281300, 84390, 196910, '', 102, 4, 6, 2, ''),
(1606228214392, 118150, 35445, 82705, '', 102, 4, 6, 2, ''),
(1606228246188, 169150, 0, 169150, '', 102, 4, NULL, 2, ''),
(1606228280350, 446300, 133890, 312410, '', 102, 4, 6, 2, ''),
(1606228286867, 446300, 133890, 312410, '', 102, 5, 6, 2, 'Khách hàng yêu cầu hủy đơn'),
(1606228287861, 446300, 133890, 312410, '', 102, 5, 6, 2, 'Khách hàng yêu cầu hủy đơn'),
(1606230077965, 446300, 133890, 312410, '', 102, 4, 6, 2, ''),
(1606230106007, 446300, 70000, 376300, '', 102, 4, 5, 2, ''),
(1606230262364, 33150, 0, 33150, '', 102, 5, NULL, 2, 'test asd'),
(1606230553991, 33150, 0, 33150, '', 102, 4, NULL, 2, ''),
(1606230630191, 33150, 0, 33150, '', 102, 5, NULL, 2, ''),
(1606230690514, 777150, 70000, 707150, '', 102, 4, 5, 2, ''),
(1606230707391, 303150, 90945, 212205, '', 102, 5, 6, 2, ''),
(1606230730035, 303150, 90945, 212205, '', 102, 4, 6, 2, ''),
(1606746194941, 379000, 0, 379000, '', 102, 0, NULL, 1, ''),
(1606746208535, 56000, 0, 56000, '', 102, 1, NULL, 2, ''),
(1606882267214, 113150, 0, 113150, '', 102, 0, NULL, 1, ''),
(1606882907175, 57150, 0, 57150, '', 102, 2, NULL, 1, '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_confirm`
--

CREATE TABLE `order_confirm` (
  `id` int(11) NOT NULL,
  `orderId` double NOT NULL,
  `adminId` int(11) NOT NULL,
  `orderStatus` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_confirm`
--

INSERT INTO `order_confirm` (`id`, `orderId`, `adminId`, `orderStatus`) VALUES
(18, 1605772045865, 3, 2),
(19, 1605772045865, 4, 3),
(20, 1605772045865, 3, 4),
(21, 1605772145245, 3, 2),
(22, 1605772328664, 3, 2),
(23, 1606121180559, 3, 2),
(24, 1606121170015, 3, 2),
(25, 1606121163115, 3, 2),
(26, 1605772145245, 4, 3),
(27, 1605772328664, 4, 3),
(28, 1606121180559, 4, 3),
(29, 1606121170015, 4, 3),
(30, 1606121163115, 4, 3),
(31, 1605772145245, 3, 4),
(32, 1605772328664, 3, 4),
(33, 1606121180559, 3, 4),
(34, 1606121170015, 3, 4),
(35, 1606121163115, 3, 4),
(36, 1606121722725, 3, 2),
(37, 1606121722725, 4, 3),
(38, 1606121722725, 3, 4),
(39, 1606121755005, 3, 2),
(40, 1606121755005, 4, 3),
(41, 1606121755005, 3, 4),
(42, 1606127702147, 3, 2),
(43, 1606127702147, 4, 3),
(44, 1606127702147, 3, 4),
(45, 1606127771076, 3, 2),
(46, 1606127771076, 4, 3),
(47, 1606127771076, 3, 4),
(48, 1606128284178, 3, 2),
(49, 1606128284178, 4, 3),
(50, 1606128284178, 3, 4),
(51, 1606133834729, 3, 2),
(52, 1606133834729, 4, 3),
(53, 1606133834729, 3, 4),
(54, 1606133880410, 3, 2),
(55, 1606133880410, 4, 3),
(56, 1606133880410, 3, 4),
(57, 1606137929019, 3, 2),
(58, 1606137929019, 4, 3),
(59, 1606137929019, 3, 4),
(60, 1606138272075, 3, 2),
(61, 1606138318213, 3, 2),
(62, 1606138524547, 3, 2),
(63, 1606138272075, 4, 3),
(64, 1606138318213, 4, 3),
(65, 1606138524547, 4, 3),
(66, 1606138272075, 3, 4),
(67, 1606138318213, 3, 4),
(68, 1606138524547, 3, 4),
(69, 1606139704422, 3, 2),
(70, 1606139704422, 4, 3),
(71, 1606139704422, 3, 4),
(72, 1606139836432, 3, 2),
(73, 1606139836432, 4, 3),
(74, 1606139902708, 3, 2),
(75, 1606139902708, 4, 3),
(76, 1606139836432, 3, 4),
(77, 1606139902708, 3, 4),
(78, 1606145833591, 3, 2),
(79, 1606145847653, 3, 2),
(80, 1606145833591, 4, 3),
(81, 1606145847653, 4, 3),
(82, 1606145833591, 3, 4),
(83, 1606145847653, 3, 4),
(84, 1606159031899, 3, 2),
(85, 1606159045777, 3, 2),
(86, 1606159062013, 3, 2),
(87, 1606159068956, 3, 2),
(88, 1606159031899, 4, 3),
(89, 1606159045777, 4, 3),
(90, 1606159062013, 4, 3),
(91, 1606159068956, 4, 3),
(92, 1606159031899, 3, 4),
(93, 1606159045777, 3, 4),
(94, 1606159062013, 3, 4),
(95, 1606159068956, 3, 4),
(96, 1606161638607, 3, 2),
(97, 1606161649879, 3, 2),
(98, 1606161657205, 3, 2),
(99, 1606161638607, 4, 3),
(100, 1606161649879, 4, 3),
(101, 1606161657205, 4, 3),
(102, 1606161638607, 3, 4),
(103, 1606161649879, 3, 4),
(104, 1606161657205, 3, 4),
(105, 1606228214392, 3, 2),
(106, 1606228214392, 4, 3),
(107, 1606228214392, 3, 4),
(108, 1606228246188, 3, 2),
(109, 1606228246188, 4, 3),
(110, 1606228246188, 3, 4),
(111, 1606228280350, 3, 2),
(112, 1606228280350, 4, 3),
(113, 1606228280350, 3, 4),
(114, 1606230077965, 3, 2),
(115, 1606230077965, 4, 3),
(116, 1606230077965, 3, 4),
(117, 1606230106007, 3, 2),
(118, 1606230106007, 4, 3),
(119, 1606230106007, 3, 4),
(120, 1606230262364, 3, 5),
(121, 1606230630191, 3, 5),
(122, 1606230553991, 3, 2),
(123, 1606230553991, 4, 3),
(124, 1606230553991, 3, 4),
(125, 1606230690514, 3, 2),
(126, 1606230707391, 3, 5),
(127, 1606230690514, 4, 3),
(128, 1606230690514, 3, 4),
(129, 1606230730035, 3, 2),
(130, 1606230730035, 4, 3),
(131, 1606230730035, 3, 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `orderId` double NOT NULL,
  `productId` int(11) NOT NULL,
  `productAmount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_details`
--

INSERT INTO `order_details` (`id`, `orderId`, `productId`, `productAmount`) VALUES
(227, 1605772045865, 149, 2),
(228, 1605772045865, 150, 3),
(229, 1605772045865, 151, 1),
(230, 1605772050817, 149, 2),
(231, 1605772050817, 150, 3),
(232, 1605772050817, 151, 1),
(233, 1605772058227, 149, 2),
(234, 1605772058227, 150, 2),
(235, 1605772058227, 151, 1),
(236, 1605772145245, 149, 2),
(237, 1605772145245, 151, 1),
(238, 1605772160835, 149, 1),
(239, 1605772160835, 150, 1),
(240, 1605772328664, 149, 1),
(241, 1605772328664, 150, 1),
(242, 1606121163115, 149, 1),
(243, 1606121163115, 150, 1),
(244, 1606121163115, 151, 1),
(245, 1606121170015, 149, 1),
(246, 1606121170015, 150, 2),
(247, 1606121170015, 152, 1),
(248, 1606121180559, 130, 1),
(249, 1606121180559, 131, 1),
(250, 1606121180559, 149, 1),
(251, 1606121180559, 150, 2),
(252, 1606121180559, 152, 1),
(253, 1606121186204, 130, 1),
(254, 1606121186204, 131, 1),
(255, 1606121186204, 149, 1),
(256, 1606121186204, 150, 2),
(257, 1606121186204, 152, 1),
(258, 1606121722725, 130, 1),
(259, 1606121722725, 131, 1),
(260, 1606121722725, 149, 1),
(261, 1606121722725, 152, 1),
(262, 1606121755005, 130, 1),
(263, 1606121755005, 131, 1),
(264, 1606121755005, 149, 1),
(265, 1606121755005, 152, 1),
(266, 1606127702147, 130, 1),
(267, 1606127702147, 131, 1),
(268, 1606127771076, 130, 1),
(269, 1606127771076, 131, 1),
(270, 1606128284178, 130, 1),
(271, 1606128284178, 131, 1),
(272, 1606128294799, 130, 1),
(273, 1606128294799, 150, 1),
(274, 1606128294799, 151, 1),
(275, 1606133834729, 130, 1),
(276, 1606133834729, 150, 1),
(277, 1606133834729, 151, 1),
(278, 1606133871497, 130, 1),
(279, 1606133871497, 150, 1),
(280, 1606133871497, 151, 1),
(281, 1606133880410, 130, 1),
(282, 1606133880410, 150, 1),
(283, 1606133880410, 151, 5),
(284, 1606133880410, 152, 1),
(285, 1606137929019, 130, 3),
(286, 1606137929019, 150, 1),
(287, 1606137929019, 151, 10),
(288, 1606137929019, 152, 1),
(289, 1606138272075, 130, 1),
(290, 1606138272075, 150, 1),
(291, 1606138272075, 151, 1),
(292, 1606138272075, 152, 1),
(293, 1606138318213, 130, 1),
(294, 1606138318213, 151, 1),
(295, 1606138318213, 152, 1),
(296, 1606138524547, 130, 2),
(297, 1606138524547, 150, 1),
(298, 1606138524547, 151, 1),
(299, 1606138524547, 152, 1),
(300, 1606139704422, 150, 2),
(301, 1606139704422, 151, 1),
(302, 1606139704422, 152, 4),
(303, 1606139738618, 150, 2),
(304, 1606139738618, 151, 1),
(305, 1606139738618, 152, 4),
(306, 1606139739725, 150, 2),
(307, 1606139739725, 151, 1),
(308, 1606139739725, 152, 4),
(309, 1606139775396, 150, 2),
(310, 1606139775396, 151, 1),
(311, 1606139775396, 152, 4),
(312, 1606139836432, 150, 2),
(313, 1606139836432, 151, 1),
(314, 1606139836432, 152, 4),
(315, 1606139902708, 150, 2),
(316, 1606139902708, 151, 1),
(317, 1606139902708, 152, 4),
(318, 1606145833591, 149, 1),
(319, 1606145833591, 150, 1),
(320, 1606145833591, 151, 1),
(321, 1606145847653, 149, 1),
(322, 1606145847653, 150, 1),
(323, 1606145847653, 151, 1),
(324, 1606145851062, 149, 1),
(325, 1606145851062, 150, 1),
(326, 1606145851062, 151, 1),
(327, 1606159031899, 149, 1),
(328, 1606159031899, 150, 1),
(329, 1606159045777, 149, 1),
(330, 1606159045777, 150, 1),
(331, 1606159062013, 149, 6),
(332, 1606159062013, 150, 4),
(333, 1606159062013, 151, 1),
(334, 1606159062013, 152, 3),
(335, 1606159068956, 130, 1),
(336, 1606159068956, 149, 6),
(337, 1606159068956, 150, 4),
(338, 1606159068956, 151, 1),
(339, 1606159068956, 152, 3),
(345, 1606159128487, 130, 1),
(346, 1606159128487, 149, 6),
(347, 1606159128487, 150, 4),
(348, 1606159128487, 151, 1),
(349, 1606159128487, 152, 3),
(350, 1606161422007, 149, 2),
(351, 1606161422007, 150, 2),
(352, 1606161422007, 151, 1),
(353, 1606161618232, 149, 2),
(354, 1606161618232, 150, 2),
(355, 1606161618232, 151, 1),
(356, 1606161638607, 149, 2),
(357, 1606161638607, 150, 2),
(358, 1606161638607, 151, 1),
(359, 1606161649879, 130, 3),
(360, 1606161649879, 149, 2),
(361, 1606161649879, 150, 2),
(362, 1606161649879, 151, 1),
(363, 1606161649879, 152, 2),
(364, 1606161657205, 130, 3),
(365, 1606161657205, 149, 2),
(366, 1606161657205, 150, 2),
(367, 1606161657205, 151, 1),
(368, 1606228214392, 149, 1),
(369, 1606228214392, 150, 1),
(370, 1606228214392, 151, 1),
(371, 1606228214392, 152, 1),
(372, 1606228246188, 149, 1),
(373, 1606228246188, 150, 3),
(374, 1606228246188, 151, 2),
(375, 1606228280350, 130, 4),
(376, 1606228280350, 149, 2),
(377, 1606228280350, 150, 3),
(378, 1606228280350, 151, 4),
(379, 1606228286867, 130, 4),
(380, 1606228286867, 149, 2),
(381, 1606228286867, 150, 3),
(382, 1606228286867, 151, 4),
(383, 1606228287861, 130, 4),
(384, 1606228287861, 149, 2),
(385, 1606228287861, 150, 3),
(386, 1606228287861, 151, 4),
(387, 1606230077965, 130, 4),
(388, 1606230077965, 149, 2),
(389, 1606230077965, 150, 3),
(390, 1606230077965, 151, 4),
(391, 1606230106007, 130, 4),
(392, 1606230106007, 149, 2),
(393, 1606230106007, 150, 3),
(394, 1606230106007, 151, 4),
(395, 1606230262364, 149, 1),
(396, 1606230553991, 149, 1),
(397, 1606230630191, 149, 1),
(398, 1606230690514, 130, 4),
(399, 1606230690514, 131, 4),
(400, 1606230690514, 132, 3),
(401, 1606230690514, 133, 2),
(402, 1606230690514, 149, 1),
(403, 1606230690514, 150, 1),
(404, 1606230690514, 151, 1),
(405, 1606230690514, 152, 2),
(406, 1606230707391, 130, 4),
(407, 1606230707391, 149, 1),
(408, 1606230707391, 151, 1),
(409, 1606230707391, 152, 2),
(410, 1606230730035, 130, 4),
(411, 1606230730035, 149, 1),
(412, 1606230730035, 151, 1),
(413, 1606230730035, 152, 2),
(414, 1606746194941, 153, 1),
(415, 1606746194941, 154, 1),
(416, 1606746208535, 150, 1),
(417, 1606746208535, 151, 1),
(418, 1606882267214, 149, 1),
(419, 1606882267214, 150, 2),
(420, 1606882267214, 151, 1),
(421, 1606882907175, 149, 1),
(422, 1606882907175, 150, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payment_method`
--

CREATE TABLE `payment_method` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `payment_method`
--

INSERT INTO `payment_method` (`id`, `name`) VALUES
(1, 'Ví momo'),
(2, 'Tiền mặt');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `typeCode` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `avt` text COLLATE utf8_unicode_ci NOT NULL,
  `itemsNew` tinyint(1) NOT NULL DEFAULT '1',
  `bestSeller` tinyint(1) NOT NULL DEFAULT '0',
  `business` tinyint(1) NOT NULL DEFAULT '1',
  `discountType` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: Phần trăm\r\n1: Giá tiền',
  `discount` int(11) NOT NULL DEFAULT '0',
  `dcExpiryDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`id`, `name`, `price`, `typeCode`, `avt`, `itemsNew`, `bestSeller`, `business`, `discountType`, `discount`, `dcExpiryDate`) VALUES
(123, 'Bạc sỉu', 32000, 'cfvn', 'uploads/menu/cfvn_123.jpg', 0, 0, 1, 0, 0, '2020-10-20 22:46:51'),
(124, 'Cà phê đen', 32000, 'cfvn', 'uploads/menu/cfvn_124.jpg', 0, 1, 1, 0, 0, '2020-10-20 22:47:05'),
(125, 'Cà phê sữa', 32000, 'cfvn', 'uploads/menu/cfvn_125.jpg', 0, 1, 1, 0, 0, '2020-10-20 22:47:20'),
(126, 'Americano', 39000, 'cfmc', 'uploads/menu/cfmc_126.jpg', 0, 0, 1, 0, 0, '2020-10-20 22:51:37'),
(127, 'Cappuccino', 45000, 'cfmc', 'uploads/menu/cfmc_127.jpg', 0, 1, 1, 0, 0, '2020-10-20 22:51:57'),
(128, 'Caramel macchiato', 55000, 'cfmc', 'uploads/menu/cfmc_128.jpg', 0, 0, 1, 0, 0, '2020-10-20 22:53:03'),
(129, 'Latte', 45000, 'cfmc', 'uploads/menu/cfmc_129.jpg', 0, 0, 1, 0, 0, '2020-10-20 22:53:19'),
(130, 'Cold Brew Truyền Thống', 45000, 'cbw', 'uploads/menu/cbw_130.jpg', 0, 0, 1, 1, 10000, '2020-10-20 22:58:40'),
(131, 'Cold Brew Sữa tươi Macchiato', 50000, 'cbw', 'uploads/menu/cbw_131.jpg', 0, 0, 1, 0, 0, '2020-10-20 22:59:43'),
(132, 'Cold brew phúc bổn tử', 50000, 'cbw', 'uploads/menu/cbw_132.jpg', 0, 0, 1, 0, 0, '2020-10-20 23:00:15'),
(133, 'Cold Brew Sữa tươi', 50000, 'cbw', 'uploads/menu/cbw_133.jpg', 0, 0, 1, 0, 0, '2020-10-20 23:00:31'),
(134, 'Trà OOLong Vải', 45000, 'ttc', 'uploads/menu/ttc_134.jpg', 0, 0, 1, 0, 0, '2020-10-20 23:05:09'),
(135, 'Trà OOLong Phúc Bổn Tử', 50000, 'ttc', 'uploads/menu/ttc_135.jpg', 0, 1, 1, 0, 0, '2020-10-20 23:08:19'),
(136, 'Trà OOLong Hạt Sen', 45000, 'ttc', 'uploads/menu/ttc_136.jpg', 0, 0, 1, 0, 0, '2020-10-20 23:08:54'),
(137, 'Trà OOLong Cam Sả', 45000, 'ttc', 'uploads/menu/ttc_137.jpg', 0, 1, 1, 0, 0, '2020-10-20 23:09:13'),
(138, 'Trà OOLong Bưởi Mật Ong', 50000, 'ttc', 'uploads/menu/ttc_138.jpg', 0, 0, 1, 0, 0, '2020-10-20 23:09:29'),
(140, 'Trà đen Macchiato', 42000, 'tsm', 'uploads/menu/tsm_140.jpg', 0, 0, 1, 0, 0, '2020-10-20 23:12:07'),
(141, 'Trà sữa mắc ca trân châu trắng', 45000, 'tsm', 'uploads/menu/tsm_141.jpg', 0, 0, 1, 0, 0, '2020-10-20 23:12:30'),
(142, 'Trà matcha Macchiato', 45000, 'tsm', 'uploads/menu/tsm_142.jpg', 0, 0, 1, 0, 0, '2020-10-20 23:12:42'),
(143, 'Trà cà phê đá xay', 59000, 'cfgi', 'uploads/menu/cfgi_143.jpg', 0, 0, 1, 0, 0, '2020-10-20 23:14:01'),
(144, 'Cà phê đá xay', 59000, 'cfgi', 'uploads/menu/cfgi_144.jpg', 0, 0, 1, 0, 0, '2020-10-20 23:14:12'),
(145, 'Phúc bổn tử cam đá xay', 59000, 'fje', 'uploads/menu/fje_145.jpg', 0, 0, 1, 0, 0, '2020-10-20 23:15:54'),
(146, 'Sinh Tố cam xoài', 59000, 'fje', 'uploads/menu/fje_146.jpg', 0, 0, 1, 0, 0, '2020-10-20 23:16:11'),
(147, 'Sinh tố việt quất', 59000, 'fje', 'uploads/menu/fje_147.jpg', 0, 0, 1, 0, 0, '2020-10-20 23:16:23'),
(149, 'Bánh gấu chocolate', 39000, 'casn', 'uploads/menu/casn_149.jpg', 1, 1, 1, 0, 15, '2020-10-20 23:21:33'),
(150, 'Bánh matcha', 29000, 'casn', 'uploads/menu/casn_150.jpg', 1, 0, 1, 1, 5000, '2020-10-20 23:21:44'),
(151, 'Bánh mì chà bông phô mai', 32000, 'casn', 'uploads/menu/casn_151.jpg', 0, 0, 1, 0, 0, '2020-10-20 23:21:59'),
(152, 'Bánh passion cheese', 29000, 'casn', 'uploads/menu/casn_152.jpg', 0, 0, 1, 0, 0, '2020-10-20 23:22:15'),
(153, 'Bình giữ nhiệt inox con thuyền', 300000, 'zotr', 'uploads/menu/zotr_153.jpg', 0, 0, 1, 0, 0, '2020-10-20 23:25:21'),
(154, 'Bộ ống hút inox', 79000, 'zotr', 'uploads/menu/zotr_154.jpg', 0, 0, 1, 0, 0, '2020-10-20 23:25:33'),
(155, 'Cà phê ARABICA', 100000, 'zcfg', 'uploads/menu/zcfg_155.jpg', 0, 1, 1, 0, 0, '2020-10-20 23:28:38'),
(156, 'Cà phê phin', 120000, 'zcfg', 'uploads/menu/zcfg_156.jpg', 1, 1, 1, 0, 10, '2020-10-20 23:28:55'),
(157, 'Cà phê phin Đắk Nông X Cầu đát', 70000, 'zcfg', 'uploads/menu/zcfg_157.jpg', 1, 1, 1, 0, 5, '2020-10-20 23:29:32'),
(158, 'Matcha đá xay', 59000, 'mcscl', 'uploads/menu/mcscl_158.jpg', 0, 0, 1, 0, 0, '2020-10-20 23:31:48'),
(159, 'Sô-cô-la đá xay', 59000, 'mcscl', 'uploads/menu/mcscl_159.jpg', 0, 0, 1, 0, 0, '2020-10-20 23:32:03');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_type`
--

CREATE TABLE `product_type` (
  `code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `typeName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `business` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1: mở bán, 0: không bán'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product_type`
--

INSERT INTO `product_type` (`code`, `typeName`, `business`) VALUES
('casn', 'Bánh & Snack', 1),
('cbw', 'Cold brew', 1),
('cfgi', 'Cà phê đá say', 1),
('cfmc', 'Cà phê máy', 1),
('cfvn', 'Cà phê Việt Nam', 1),
('fje', 'Thức uống trái cây', 1),
('mcscl', 'Matcha - Sôcôla', 1),
('tsm', 'Trà sữa Macchiato', 1),
('ttc', 'Trà trái cây', 1),
('zcfg', 'Cà phê gói', 1),
('zotr', 'Khác', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vouchers`
--

CREATE TABLE `vouchers` (
  `id` int(11) NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Mô tả',
  `discountType` tinyint(1) NOT NULL COMMENT '0: Phần trăm\r\n1: Giá trị',
  `discountValue` int(11) NOT NULL,
  `count` int(11) NOT NULL COMMENT '-999: Vô hạn',
  `Ordercondition` int(11) NOT NULL,
  `timeStart` double NOT NULL COMMENT 'Thời gian bắt đầu',
  `timeEnd` double NOT NULL COMMENT 'Thời gian kết thúc'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `vouchers`
--

INSERT INTO `vouchers` (`id`, `code`, `content`, `discountType`, `discountValue`, `count`, `Ordercondition`, `timeStart`, `timeEnd`) VALUES
(2, 'CHRISTMAS', 'Giảm giá 10% cho chương trình giáng sinh', 0, 10, 999, 0, 1604275200, 1609459200),
(5, 'TEST', 'asd', 1, 70000, 76, 0, 1604966400, 1606694400),
(6, 'TEST2', 'Giảm giá 10%', 0, 30, 27, 0, 1604966400, 1607990400),
(8, 'TEST3', '0', 0, 0, 8, 0, 1604707200, 1606953600);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin_role`
--
ALTER TABLE `admin_role`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`,`username`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `fk_admin_role` (`role`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_voucher` (`voucher`),
  ADD KEY `fk_order_payment` (`payment`);

--
-- Chỉ mục cho bảng `order_confirm`
--
ALTER TABLE `order_confirm`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_confirm_admin` (`adminId`),
  ADD KEY `fk_confirm_order` (`orderId`);

--
-- Chỉ mục cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_orderDetail_product` (`productId`),
  ADD KEY `fk_orderDetail_order` (`orderId`);

--
-- Chỉ mục cho bảng `payment_method`
--
ALTER TABLE `payment_method`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tên món` (`name`),
  ADD KEY `fk_menu_type` (`typeCode`);

--
-- Chỉ mục cho bảng `product_type`
--
ALTER TABLE `product_type`
  ADD PRIMARY KEY (`code`),
  ADD UNIQUE KEY `typeName` (`typeName`);

--
-- Chỉ mục cho bảng `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admin_role`
--
ALTER TABLE `admin_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `order_confirm`
--
ALTER TABLE `order_confirm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=423;

--
-- AUTO_INCREMENT cho bảng `payment_method`
--
ALTER TABLE `payment_method`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;

--
-- AUTO_INCREMENT cho bảng `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `admin_users`
--
ALTER TABLE `admin_users`
  ADD CONSTRAINT `fk_admin_role` FOREIGN KEY (`role`) REFERENCES `admin_role` (`id`);

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_order_payment` FOREIGN KEY (`payment`) REFERENCES `payment_method` (`id`),
  ADD CONSTRAINT `fk_order_voucher` FOREIGN KEY (`voucher`) REFERENCES `vouchers` (`id`);

--
-- Các ràng buộc cho bảng `order_confirm`
--
ALTER TABLE `order_confirm`
  ADD CONSTRAINT `fk_confirm_admin` FOREIGN KEY (`adminId`) REFERENCES `admin_users` (`id`),
  ADD CONSTRAINT `fk_confirm_order` FOREIGN KEY (`orderId`) REFERENCES `orders` (`id`);

--
-- Các ràng buộc cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `fk_orderDetail_order` FOREIGN KEY (`orderId`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `fk_orderDetail_product` FOREIGN KEY (`productId`) REFERENCES `product` (`id`);

--
-- Các ràng buộc cho bảng `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_type` FOREIGN KEY (`typeCode`) REFERENCES `product_type` (`code`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
