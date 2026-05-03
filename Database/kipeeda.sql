-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 03, 2026 at 08:21 AM
-- Server version: 8.4.3
-- PHP Version: 8.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kipeeda`
--
CREATE DATABASE IF NOT EXISTS `kipeeda` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `kipeeda`;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `warranty_months` int DEFAULT '12'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`, `warranty_months`) VALUES
(1, 'Laptop', 'big_banner1.jpg', 12),
(2, 'Laptop Gaming', 'big_banner2.jpg', 12),
(3, 'Build PC', 'big_banner3.jpg', 12),
(4, 'Màn Hình', 'big_banner4.jpg', 12),
(5, 'Bàn Phím', 'big_banner5.jpg', 12),
(6, 'Chuột, Lót Chuột', 'big_banner6.jpg', 12),
(7, 'Ổ Cứng, Ram', 'banner1.jpg', 12),
(8, 'Ghế, Bàn Gaming', 'banner2.jpg', 12),
(9, 'Tai Nghe', 'big_banner4.jpg', 12),
(10, 'Phụ Kiện', 'big_banner6.jpg', 12),
(11, 'Loa PC', 'flash_sale1.jpg', 12);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int NOT NULL,
  `sender` varchar(20) DEFAULT NULL,
  `message` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  `sender_id` int DEFAULT NULL,
  `receiver_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `chat_title` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender`, `message`, `created_at`, `user_id`, `role`, `sender_id`, `receiver_id`, `product_id`, `chat_title`) VALUES
(37, 'admin', 'a', '2026-05-02 07:32:35', 1, 'user', 1, 1, NULL, NULL),
(38, 'admin', 'ââsd', '2026-05-02 07:39:34', 2, 'admin', 1, 2, NULL, NULL),
(39, 'user1', 'ádasaca', '2026-05-02 07:39:51', 2, 'user', 2, 1, NULL, NULL),
(40, 'user1', 'Tư vấn sản phẩm: Apple   ', '2026-05-02 08:35:45', 2, 'user', 2, 1, NULL, 'Tư vấn sản phẩm: Apple   '),
(41, 'user1', 'Tư vấn sản phẩm: Laptop Dubai', '2026-05-02 08:58:41', 2, '0', 2, 1, NULL, 'Tư vấn sản phẩm: Laptop Dubai'),
(42, 'user1', 'Tư vấn sản phẩm: Laptop Lenovo IdeaPad Slim 5', '2026-05-02 08:59:03', 2, '0', 2, 1, NULL, 'Tư vấn sản phẩm: Laptop Lenovo IdeaPad Slim 5'),
(43, 'user1', 'Hỗ trợ đơn hàng: #13', '2026-05-02 09:16:59', 2, '0', 2, 1, NULL, 'Hỗ trợ đơn hàng: #13'),
(44, 'user1', 'null', '2026-05-02 09:27:44', 2, '0', 2, 1, NULL, 'null'),
(45, 'user1', 'Hỗ trợ đơn hàng: #14', '2026-05-02 09:32:10', 2, '0', 2, 1, NULL, 'Hỗ trợ đơn hàng: #14'),
(46, 'user1', 'b', '2026-05-02 09:36:44', 2, 'user', 2, 1, NULL, 'Hỗ trợ đơn hàng: #13'),
(47, 'user2', 'Tư vấn sản phẩm: Laptop Dubai', '2026-05-02 12:10:44', 6, '0', 6, 1, NULL, 'Tư vấn sản phẩm: Laptop Dubai'),
(48, 'Tuvan1', 'mmb', '2026-05-02 12:34:28', 2, 'tuvan', 7, 2, NULL, 'Tư vấn sản phẩm: Apple   ');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_general_ci NOT NULL,
  `note` text COLLATE utf8mb4_general_ci,
  `total` decimal(10,0) NOT NULL,
  `discount` decimal(10,2) DEFAULT '0.00',
  `final_total` decimal(10,2) NOT NULL,
  `status` enum('pending','confirmed','shipping','completed') COLLATE utf8mb4_general_ci DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `voucher_code` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `phone`, `email`, `address`, `note`, `total`, `discount`, `final_total`, `status`, `created_at`, `voucher_code`) VALUES
(7, 1, 'Vinh', '0394408287', '', '10/1', 'Dán màn ', 28070000, 0.00, 28070000.00, 'completed', '2026-04-12 16:26:23', NULL),
(11, 1, 'Apple   ', '2', '', '10/1', '', 3190000, 0.00, 3190000.00, 'pending', '2026-04-12 17:06:57', NULL),
(12, 1, 'Apple   ', '0394408287', 'vinhmoba998@gmail.com', '10/1', '', 5290000, 0.00, 5290000.00, 'completed', '2026-04-12 19:24:22', NULL),
(17, 2, 'deltarune ', '000000000', '', '0000000', '', 5290000, 0.00, 5290000.00, 'pending', '2026-05-02 11:02:13', NULL),
(18, 2, 'Huy', '097876', '', '0000000', '', 6190000, 0.00, 6190000.00, 'pending', '2026-05-02 11:18:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int NOT NULL,
  `order_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `price` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(9, 7, 54, 2, 5290000),
(10, 7, 44, 1, 17490000),
(14, 11, 56, 1, 3190000),
(15, 12, 54, 1, 5290000),
(20, 17, 54, 1, 5290000),
(21, 18, 55, 1, 6190000);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `name` varchar(500) COLLATE utf8mb4_general_ci NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `old_price` decimal(10,0) DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `short_description` text COLLATE utf8mb4_general_ci NOT NULL,
  `category_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('0','1') COLLATE utf8mb4_general_ci NOT NULL,
  `flash_sale` enum('0','1') COLLATE utf8mb4_general_ci DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `old_price`, `image`, `description`, `short_description`, `category_id`, `created_at`, `status`, `flash_sale`) VALUES
(42, 'Laptop Dell Inspiron 15 3530', 16490000, 18490000, 'laptop2.jpg', 'Dell Inspiron 15 3530 mang đến hiệu năng ổn định với Intel Core i5 thế hệ mới, màn hình lớn 15.6 inch giúp làm việc và giải trí thoải mái.', 'Core i5 Gen 13 | 16GB | 512GB SSD', 10, '2026-03-15 16:56:33', '0', '1'),
(43, 'Laptop Lenovo IdeaPad Slim 5', 14990000, 16990000, 'laptop3.jpg', 'Lenovo IdeaPad Slim 5 có thiết kế gọn nhẹ, pin bền bỉ cùng hiệu năng ổn định cho sinh viên và dân văn phòng.', 'Ryzen 5 | 16GB RAM | 512GB SSD', 1, '2026-03-15 16:56:33', '0', '1'),
(44, 'Laptop HP Pavilion 15', 15970000, 17490000, 'laptop4.jpg', 'HP Pavilion 15 là chiếc laptop đa năng với thiết kế sang trọng, hiệu năng tốt đáp ứng mọi nhu cầu học tập và làm việc.', 'Core i5 | 16GB | 512GB SSD', 1, '2026-03-15 16:56:33', '0', '1'),
(45, 'Laptop Gaming ASUS ROG Strix G15', 28990000, 31990000, 'gaming1.jpg', 'ASUS ROG Strix G15 là laptop gaming mạnh mẽ với RTX 4060, màn hình 165Hz cho trải nghiệm chiến game mượt mà.', 'Ryzen 7 | RTX 4060 | 16GB | 512GB', 11, '2026-03-15 16:56:33', '0', '1'),
(46, 'Laptop Gaming Acer Predator Helios Neo', 30990000, 33990000, 'gaming2.jpg', 'Acer Predator Helios Neo mang sức mạnh từ Intel Core i7 và RTX 4060, sẵn sàng chinh phục mọi tựa game AAA.', 'Core i7 | RTX 4060 | 16GB | 1TB SSD', 2, '2026-03-15 16:56:33', '0', '0'),
(47, 'Laptop Gaming MSI Katana 15', 26990000, 29990000, 'gaming3.jpg', 'MSI Katana 15 sở hữu thiết kế chuẩn gaming cùng card đồ họa RTX 4050 cho hiệu năng chiến game ổn định.', 'Core i7 | RTX 4050 | 16GB | 512GB', 2, '2026-03-15 16:56:33', '0', '0'),
(48, 'Laptop Gaming Lenovo Legion 5', 29990000, 32990000, 'gaming4.jpg', 'Lenovo Legion 5 nổi tiếng với hiệu năng mạnh mẽ, hệ thống tản nhiệt tối ưu cho game thủ.', 'Ryzen 7 | RTX 4060 | 16GB', 2, '2026-03-15 16:56:33', '0', '0'),
(49, 'PC Gaming RTX 4060 Ultra', 22990000, 25990000, 'pc1.jpg', 'PC Gaming RTX 4060 Ultra mang đến hiệu năng vượt trội cho game thủ với khả năng chiến game AAA ở thiết lập cao.', 'Core i5 | RTX 4060 | 16GB RAM', 3, '2026-03-15 16:56:33', '0', '0'),
(50, 'PC Gaming RTX 4070 Pro', 30990000, 33990000, 'pc2.jpg', 'Cấu hình PC RTX 4070 Pro dành cho game thủ và streamer với sức mạnh vượt trội.', 'Core i7 | RTX 4070 | 32GB RAM', 3, '2026-03-15 16:56:33', '0', '0'),
(51, 'PC Gaming Tầm Trung GTX 1660', 15990000, 17990000, 'pc3.jpg', 'PC Gaming tầm trung phù hợp chơi các tựa game phổ biến như Valorant, CS2, PUBG.', 'Core i3 | GTX 1660 | 16GB RAM', 3, '2026-03-15 16:56:33', '0', '0'),
(52, 'PC Streaming RTX 4070', 34990000, 37990000, 'pc4.jpg', 'PC Streaming RTX 4070 dành cho streamer và gamer chuyên nghiệp.', 'Core i7 | RTX 4070 | 32GB RAM', 3, '2026-03-15 16:56:33', '0', '0'),
(53, 'Màn hình ASUS TUF Gaming 24 inch 165Hz', 3590000, 4190000, 'monitor1.jpg', 'ASUS TUF Gaming 24 inch mang đến tần số quét 165Hz giúp trải nghiệm game mượt mà hơn.', '24 inch | IPS | 165Hz', 4, '2026-03-15 16:56:33', '0', '0'),
(54, 'Màn hình MSI Optix 27 inch 170Hz', 5290000, 5890000, 'monitor2.jpg', 'MSI Optix 27 inch là màn hình gaming với tần số quét 170Hz cùng màu sắc sống động.', '27 inch | 170Hz | IPS', 4, '2026-03-15 16:56:33', '0', '0'),
(55, 'Màn hình LG UltraGear 27 inch', 6190000, 6890000, 'monitor3.jpg', 'LG UltraGear mang đến trải nghiệm gaming mượt mà và hình ảnh sắc nét.', '27 inch | 180Hz', 4, '2026-03-15 16:56:33', '0', '0'),
(56, 'Màn hình Dell 24 inch IPS', 3190000, 3790000, 'monitor4.jpg', 'Màn hình Dell 24 inch phù hợp làm việc và giải trí với tấm nền IPS.', '24 inch | IPS', 4, '2026-03-15 16:56:33', '0', '0'),
(57, 'Bàn phím cơ AKKO 3087 RGB', 1290000, 1490000, 'keyboard1.jpg', 'AKKO 3087 RGB là bàn phím cơ được game thủ yêu thích với thiết kế nhỏ gọn và LED RGB đẹp mắt.', 'Switch Red | RGB', 2, '2026-03-15 16:56:33', '0', '0'),
(58, 'Bàn phím cơ Razer BlackWidow V3', 2890000, 3190000, 'keyboard2.jpg', 'Razer BlackWidow V3 mang lại cảm giác gõ tuyệt vời cùng độ bền cao.', 'Switch Green | RGB', 5, '2026-03-15 16:56:33', '0', '0'),
(59, 'Bàn phím Logitech G Pro', 2590000, 2890000, 'keyboard3.jpg', 'Logitech G Pro là bàn phím esports dành cho game thủ chuyên nghiệp.', 'Switch GX', 5, '2026-03-15 16:56:33', '0', '0'),
(60, 'Bàn phím DareU EK87', 990000, 1190000, 'keyboard4.jpg', 'DareU EK87 là bàn phím cơ giá tốt dành cho game thủ.', 'Switch Blue', 5, '2026-03-15 16:56:33', '0', '0'),
(61, 'Chuột Logitech G102 Lightsync', 350000, 450000, 'mouse1.jpg', 'Logitech G102 Lightsync là chuột gaming phổ biến với độ chính xác cao.', '8000 DPI | RGB', 6, '2026-03-15 16:56:33', '0', '0'),
(62, 'Chuột Razer DeathAdder Essential', 890000, 990000, 'mouse2.jpg', 'Razer DeathAdder là dòng chuột gaming huyền thoại của Razer.', '16000 DPI', 6, '2026-03-15 16:56:33', '0', '0'),
(63, 'Chuột SteelSeries Rival 3', 650000, 750000, 'mouse3.jpg', 'SteelSeries Rival 3 mang đến độ chính xác và độ bền cao.', '8500 DPI', 6, '2026-03-15 16:56:33', '0', '0'),
(64, 'Chuột Logitech G Pro X Superlight', 2990000, 3290000, 'mouse4.jpg', 'Chuột Logitech G Pro X Superlight siêu nhẹ dành cho game thủ chuyên nghiệp.', 'Wireless | 25600 DPI', 6, '2026-03-15 16:56:33', '0', '0'),
(65, 'RAM Corsair Vengeance 16GB', 950000, 1150000, 'ram1.jpg', 'RAM Corsair Vengeance 16GB giúp nâng cao hiệu năng hệ thống.', 'DDR4 3200MHz', 7, '2026-03-15 16:56:33', '0', '0'),
(66, 'SSD Samsung 980 1TB NVMe', 1890000, 2190000, 'ssd1.jpg', 'SSD Samsung 980 mang đến tốc độ đọc ghi cực nhanh.', '1TB NVMe', 7, '2026-03-15 16:56:33', '0', '0'),
(67, 'RAM Kingston Fury 32GB', 2050000, 2350000, 'ram2.jpg', 'RAM Kingston Fury 32GB dành cho PC gaming và workstation.', 'DDR4 3600MHz', 7, '2026-03-15 16:56:33', '0', '0'),
(68, 'SSD WD Black SN850 2TB', 3590000, 3990000, 'ssd2.jpg', 'SSD WD Black SN850 cho tốc độ cao dành cho gaming.', '2TB NVMe Gen4', 7, '2026-03-15 16:56:33', '0', '0'),
(69, 'Ghế Gaming E-Dra EGC203', 3590000, 3990000, 'chair1.jpg', 'Ghế gaming E-Dra EGC203 thiết kế công thái học cho game thủ.', 'Ngả 180°', 8, '2026-03-15 16:56:33', '0', '0'),
(70, 'Ghế Gaming DXRacer Drifting', 6590000, 7530000, 'chair2.jpg', 'DXRacer Drifting là dòng ghế gaming cao cấp.', 'Da PU', 8, '2026-03-15 16:56:33', '0', '0'),
(71, 'Bàn Gaming chữ Z RGB', 2290000, 2590000, 'desk1.jpg', 'Bàn gaming chữ Z chắc chắn với LED RGB đẹp mắt.', 'Khung thép', 8, '2026-03-15 16:56:33', '0', '0'),
(72, 'Bàn Gaming chữ L', 3290000, 3590000, 'desk2.jpg', 'Bàn gaming chữ L rộng rãi cho setup gaming.', 'Khung thép', 8, '2026-03-15 16:56:33', '0', '0'),
(73, 'Tai nghe Razer Kraken X', 1290000, 1590000, 'headset1.jpg', 'Razer Kraken X mang đến âm thanh 7.1 sống động cho game thủ.', '7.1 Surround', 9, '2026-03-15 16:56:33', '0', '0'),
(74, 'Tai nghe Logitech G733', 2890000, 3190000, 'headset2.jpg', 'Logitech G733 là tai nghe gaming không dây với thiết kế hiện đại.', 'Wireless', 9, '2026-03-15 16:56:33', '0', '0'),
(75, 'Tai nghe HyperX Cloud II', 2390000, 2690000, 'headset3.jpg', 'HyperX Cloud II là tai nghe gaming nổi tiếng với chất âm tốt.', '7.1 Surround', 9, '2026-03-15 16:56:33', '0', '0'),
(76, 'Tai nghe SteelSeries Arctis 7', 3590000, 3990000, 'headset4.jpg', 'SteelSeries Arctis 7 mang lại trải nghiệm âm thanh cao cấp.', 'Wireless', 9, '2026-03-15 16:56:33', '0', '0'),
(77, 'Lót chuột Gaming XXL RGB', 250000, 350000, 'pad1.jpg', 'Lót chuột gaming kích thước lớn với LED RGB.', 'Size XXL', 6, '2026-03-15 16:56:33', '0', '0'),
(78, 'Webcam Logitech C920', 1950000, 2250000, 'webcam1.jpg', 'Webcam Logitech C920 hỗ trợ quay video Full HD cho stream và họp online.', 'Full HD 1080p', 10, '2026-03-15 16:56:33', '0', '0'),
(79, 'Hub USB Type C 6 in 1', 450000, 550000, 'hub1.jpg', 'Hub USB Type C mở rộng cổng kết nối cho laptop.', '6 in 1', 10, '2026-03-15 16:56:33', '0', '0'),
(80, 'Đế tản nhiệt laptop RGB', 350000, 420000, 'cooler1.jpg', 'Đế tản nhiệt laptop giúp giảm nhiệt độ khi chơi game.', 'RGB Cooling Pad', 10, '2026-03-15 16:56:33', '0', '0'),
(85, 'DTA', 30000, 200000, 'hinh\\hinh1.jpg', '1', '2', 1, '2026-03-29 15:45:12', '0', '0'),
(86, 'DTA', 100000, 1000000, '1', '2', '3', 1, '2026-03-29 15:47:15', '0', '0'),
(87, 'DTA', 40000, 100000, 'hinh\\hinh1.jpg', '2', '1', 1, '2026-03-29 15:49:45', '0', '0'),
(88, 'DTA', 40000, 100000, 'hinh\\hinh1.jpg', '2', '2', 1, '2026-03-29 15:54:14', '0', '0'),
(96, 'Sou', 30000, 100000, '', '3', '2', 2, '2026-03-29 20:46:23', '0', '0'),
(100, 'Laptop Dubai', 999999999, 1000000000, 'gaming4.jpg', 'Laptop cho giới tài phiệt, tiểu thư đài cát', 'Intel Core i5 | 16GB RAM | 512GB SSD | OLED', 1, '2026-04-12 20:28:23', '0', '1'),
(101, 'Apple   ', 9999999, 10000000, 'laptop4.jpg', 'Apple giới thượng lưu', 'Intel Core i5 | 16GB RAM | 512GB SSD | OLED', 1, '2026-04-12 20:38:27', '0', '1');

-- --------------------------------------------------------

--
-- Table structure for table `product_specs`
--

CREATE TABLE `product_specs` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `spec_name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `spec_value` varchar(250) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_specs`
--

INSERT INTO `product_specs` (`id`, `product_id`, `spec_name`, `spec_value`) VALUES
(6, 42, 'CPU', 'Intel Core i5 Gen 13'),
(7, 42, 'RAM', '16GB'),
(8, 42, 'Ổ cứng', '512GB SSD'),
(9, 42, 'Màn hình', '15.6 inch FHD'),
(10, 42, 'Trọng lượng', '1.7kg'),
(11, 43, 'CPU', 'AMD Ryzen 5'),
(12, 43, 'RAM', '16GB'),
(13, 43, 'Ổ cứng', '512GB SSD'),
(14, 43, 'Màn hình', '15.6 inch'),
(15, 43, 'Pin', '56Wh'),
(16, 44, 'CPU', 'Intel Core i5'),
(17, 44, 'RAM', '16GB'),
(18, 44, 'Ổ cứng', '512GB SSD'),
(19, 44, 'Màn hình', '15.6 inch IPS'),
(20, 44, 'Trọng lượng', '1.75kg'),
(21, 45, 'CPU', 'Ryzen 7'),
(22, 45, 'GPU', 'RTX 4060'),
(23, 45, 'RAM', '16GB'),
(24, 45, 'Màn hình', '15.6 inch 165Hz'),
(25, 45, 'Ổ cứng', '512GB SSD'),
(26, 46, 'CPU', 'Intel Core i7'),
(27, 46, 'GPU', 'RTX 4060'),
(28, 46, 'RAM', '16GB'),
(29, 46, 'Ổ cứng', '1TB SSD'),
(30, 46, 'Màn hình', '165Hz'),
(31, 47, 'CPU', 'Intel Core i7'),
(32, 47, 'GPU', 'RTX 4050'),
(33, 47, 'RAM', '16GB'),
(34, 47, 'Ổ cứng', '512GB SSD'),
(35, 47, 'Màn hình', '144Hz'),
(36, 48, 'CPU', 'Ryzen 7'),
(37, 48, 'GPU', 'RTX 4060'),
(38, 48, 'RAM', '16GB'),
(39, 48, 'Ổ cứng', '512GB SSD'),
(40, 48, 'Màn hình', '165Hz'),
(41, 49, 'CPU', 'Intel Core i5'),
(42, 49, 'GPU', 'RTX 4060'),
(43, 49, 'RAM', '16GB'),
(44, 49, 'Ổ cứng', '1TB SSD'),
(45, 49, 'Nguồn', '650W'),
(46, 50, 'CPU', 'Intel Core i7'),
(47, 50, 'GPU', 'RTX 4070'),
(48, 50, 'RAM', '32GB'),
(49, 50, 'Ổ cứng', '1TB SSD'),
(50, 50, 'Nguồn', '750W'),
(51, 51, 'CPU', 'Intel Core i3'),
(52, 51, 'GPU', 'GTX 1660'),
(53, 51, 'RAM', '16GB'),
(54, 51, 'Ổ cứng', '512GB SSD'),
(55, 51, 'Nguồn', '550W'),
(56, 52, 'CPU', 'Intel Core i7'),
(57, 52, 'GPU', 'RTX 4070'),
(58, 52, 'RAM', '32GB'),
(59, 52, 'Ổ cứng', '1TB SSD'),
(60, 52, 'Nguồn', '750W'),
(61, 53, 'Kích thước', '24 inch'),
(62, 53, 'Tấm nền', 'IPS'),
(63, 53, 'Tần số quét', '165Hz'),
(64, 53, 'Độ phân giải', 'Full HD'),
(65, 53, 'Cổng kết nối', 'HDMI, DisplayPort'),
(66, 54, 'Kích thước', '27 inch'),
(67, 54, 'Tấm nền', 'IPS'),
(68, 54, 'Tần số quét', '170Hz'),
(69, 54, 'Độ phân giải', 'Full HD'),
(70, 54, 'Cổng kết nối', 'HDMI, DP'),
(71, 55, 'Kích thước', '27 inch'),
(72, 55, 'Tấm nền', 'IPS'),
(73, 55, 'Tần số quét', '180Hz'),
(74, 55, 'Độ phân giải', '2K'),
(75, 55, 'Cổng kết nối', 'HDMI, DP'),
(76, 56, 'Kích thước', '24 inch'),
(77, 56, 'Tấm nền', 'IPS'),
(78, 56, 'Độ phân giải', 'Full HD'),
(79, 56, 'Tần số quét', '75Hz'),
(80, 56, 'Cổng kết nối', 'HDMI'),
(81, 57, 'Loại bàn phím', 'Cơ'),
(82, 57, 'Switch', 'AKKO Red'),
(83, 57, 'LED', 'RGB'),
(84, 57, 'Kết nối', 'USB'),
(85, 57, 'Layout', 'TKL'),
(86, 58, 'Loại bàn phím', 'Cơ'),
(87, 58, 'Switch', 'Razer Green'),
(88, 58, 'LED', 'RGB'),
(89, 58, 'Kết nối', 'USB'),
(90, 58, 'Layout', 'Fullsize'),
(91, 59, 'Loại bàn phím', 'Cơ'),
(92, 59, 'Switch', 'GX Blue'),
(93, 59, 'LED', 'RGB'),
(94, 59, 'Kết nối', 'USB'),
(95, 59, 'Layout', 'TKL'),
(96, 60, 'Loại bàn phím', 'Cơ'),
(97, 60, 'Switch', 'Blue'),
(98, 60, 'LED', 'Rainbow'),
(99, 60, 'Kết nối', 'USB'),
(100, 61, 'DPI', '8000'),
(101, 61, 'LED', 'RGB'),
(102, 61, 'Kết nối', 'USB'),
(103, 61, 'Trọng lượng', '85g'),
(104, 62, 'DPI', '16000'),
(105, 62, 'Kết nối', 'USB'),
(106, 62, 'Trọng lượng', '96g'),
(107, 62, 'Cảm biến', 'Optical'),
(108, 63, 'DPI', '8500'),
(109, 63, 'Kết nối', 'USB'),
(110, 63, 'Trọng lượng', '77g'),
(111, 63, 'Cảm biến', 'TrueMove'),
(112, 64, 'DPI', '25600'),
(113, 64, 'Kết nối', 'Wireless'),
(114, 64, 'Trọng lượng', '63g'),
(115, 64, 'Pin', '70 giờ'),
(116, 65, 'Dung lượng', '16GB'),
(117, 65, 'Chuẩn', 'DDR4'),
(118, 65, 'Bus', '3200MHz'),
(119, 65, 'Tản nhiệt', 'Nhôm'),
(120, 66, 'Dung lượng', '1TB'),
(121, 66, 'Chuẩn', 'NVMe'),
(122, 66, 'Tốc độ đọc', '3500MB/s'),
(123, 66, 'Tốc độ ghi', '3000MB/s'),
(124, 67, 'Dung lượng', '32GB'),
(125, 67, 'Chuẩn', 'DDR4'),
(126, 67, 'Bus', '3600MHz'),
(127, 67, 'Tản nhiệt', 'Nhôm'),
(128, 68, 'Dung lượng', '2TB'),
(129, 68, 'Chuẩn', 'NVMe Gen4'),
(130, 68, 'Tốc độ đọc', '7000MB/s'),
(131, 68, 'Tốc độ ghi', '6500MB/s'),
(132, 69, 'Chất liệu', 'Da PU'),
(133, 69, 'Khung', 'Thép'),
(134, 69, 'Ngả lưng', '180°'),
(135, 69, 'Tải trọng', '150kg'),
(136, 70, 'Chất liệu', 'Da PU'),
(137, 70, 'Khung', 'Thép'),
(138, 70, 'Ngả lưng', '170°'),
(139, 70, 'Tải trọng', '150kg'),
(140, 71, 'Chất liệu', 'Gỗ MDF'),
(141, 71, 'Khung', 'Thép'),
(142, 71, 'LED', 'RGB'),
(143, 71, 'Kích thước', '120cm'),
(144, 72, 'Chất liệu', 'Gỗ MDF'),
(145, 72, 'Khung', 'Thép'),
(146, 72, 'Kích thước', '140cm'),
(147, 72, 'Tải trọng', '120kg'),
(148, 73, 'Âm thanh', '7.1 Surround'),
(149, 73, 'Kết nối', '3.5mm'),
(150, 73, 'Trọng lượng', '250g'),
(151, 73, 'Micro', 'Có'),
(152, 74, 'Âm thanh', 'Surround'),
(153, 74, 'Kết nối', 'Wireless'),
(154, 74, 'Pin', '29 giờ'),
(155, 74, 'Trọng lượng', '278g'),
(156, 75, 'Âm thanh', '7.1'),
(157, 75, 'Kết nối', 'USB'),
(158, 75, 'Trọng lượng', '275g'),
(159, 75, 'Micro', 'Có'),
(160, 76, 'Âm thanh', 'Surround'),
(161, 76, 'Kết nối', 'Wireless'),
(162, 76, 'Pin', '24 giờ'),
(163, 76, 'Micro', 'Có'),
(164, 77, 'Kích thước', 'XXL'),
(165, 77, 'Chất liệu', 'Vải'),
(166, 77, 'Đế', 'Cao su'),
(167, 77, 'LED', 'RGB'),
(168, 78, 'Độ phân giải', '1080p'),
(169, 78, 'FPS', '30fps'),
(170, 78, 'Micro', 'Stereo'),
(171, 78, 'Kết nối', 'USB'),
(172, 79, 'Số cổng', '6'),
(173, 79, 'Chuẩn', 'USB-C'),
(174, 79, 'Cổng', 'HDMI, USB, SD'),
(175, 79, 'Chất liệu', 'Nhôm'),
(176, 80, 'Quạt', '2 quạt'),
(177, 80, 'LED', 'RGB'),
(178, 80, 'Kết nối', 'USB'),
(179, 80, 'Kích thước', '15.6 inch');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `order_item_id` int DEFAULT NULL,
  `rating` int DEFAULT NULL,
  `comment` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `product_id`, `order_item_id`, `rating`, `comment`, `created_at`) VALUES
(1, 1, 54, 9, 4, '', '2026-04-12 18:56:39'),
(2, 1, 54, 15, 5, 'Sản phẩm dùng tốt\r\n', '2026-04-12 19:24:44'),
(3, 1, 44, 10, 3, 'Lỗi thiết bị đã ib shop sẽ sửa lại đánh giá sau khi đc hỗ trợ', '2026-04-12 19:32:18');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role` enum('admin','user','quanly','tuvan') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`) VALUES
(1, 'admin', '1234', NULL, 'admin'),
(2, 'user1', '1234', NULL, 'user'),
(4, 'Quanly1', '1234', 'tdc@gmail.com', 'quanly'),
(6, 'user2', '1234', 'co@mail.com', 'user'),
(7, 'Tuvan1', '1234', 'ko@mail.com', 'tuvan');

-- --------------------------------------------------------

--
-- Table structure for table `voucher`
--

CREATE TABLE `voucher` (
  `id` int NOT NULL,
  `voucher` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `discount_type` enum('percent','fixed') COLLATE utf8mb4_general_ci NOT NULL,
  `discount_value` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `voucher`
--

INSERT INTO `voucher` (`id`, `voucher`, `discount_type`, `discount_value`) VALUES
(1, 'NGUOIMOI', 'percent', 20),
(2, 'KIPEEDA10', 'percent', 10),
(3, 'KIPEEDA20K', 'fixed', 20000),
(4, 'LAPTOP50K', 'fixed', 50000),
(5, 'PCBUILD5', 'percent', 5),
(6, 'GAMING10', 'percent', 10),
(7, 'LINHKIEN30K', 'fixed', 30000),
(8, 'KIPEEDA100K', 'fixed', 100000),
(9, 'TECH15', 'percent', 15),
(10, 'SALECUOITUAN', 'percent', 12);

-- --------------------------------------------------------

--
-- Table structure for table `warranties`
--

CREATE TABLE `warranties` (
  `id` int NOT NULL,
  `order_item_id` int DEFAULT NULL,
  `serial_number` varchar(100) DEFAULT NULL,
  `warranty_start` date DEFAULT NULL,
  `warranty_end` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `warranties`
--

INSERT INTO `warranties` (`id`, `order_item_id`, `serial_number`, `warranty_start`, `warranty_end`) VALUES
(1, 20, 'SN69F5D9B55B969', '2026-05-02', '2028-05-02'),
(2, 21, 'SN69F5DD70E3011', '2026-05-02', '2027-05-02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_categories_product` (`category_id`);

--
-- Indexes for table `product_specs`
--
ALTER TABLE `product_specs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_specs_products` (`product_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_review` (`order_item_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `voucher`
--
ALTER TABLE `voucher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `warranties`
--
ALTER TABLE `warranties`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `serial_number` (`serial_number`),
  ADD KEY `order_item_id` (`order_item_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `product_specs`
--
ALTER TABLE `product_specs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `voucher`
--
ALTER TABLE `voucher`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `warranties`
--
ALTER TABLE `warranties`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_categories_product` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_specs`
--
ALTER TABLE `product_specs`
  ADD CONSTRAINT `fk_specs_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `warranties`
--
ALTER TABLE `warranties`
  ADD CONSTRAINT `warranties_ibfk_1` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
