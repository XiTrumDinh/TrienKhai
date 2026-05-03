-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 03, 2026 at 10:05 AM
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
(41, 'user1', 'Tư vấn sản phẩm: Laptop Dubai', '2026-05-02 08:58:41', 2, 'user', 2, 1, NULL, 'Tư vấn sản phẩm: Laptop Dubai'),
(42, 'user1', 'Tư vấn sản phẩm: Laptop Lenovo IdeaPad Slim 5', '2026-05-02 08:59:03', 2, 'user', 2, 1, NULL, 'Tư vấn sản phẩm: Laptop Lenovo IdeaPad Slim 5'),
(43, 'user1', 'Hỗ trợ đơn hàng: #13', '2026-05-02 09:16:59', 2, 'user', 2, 1, NULL, 'Hỗ trợ đơn hàng: #13'),
(44, 'user1', 'null', '2026-05-02 09:27:44', 2, 'user', 2, 1, NULL, 'null'),
(45, 'user1', 'Hỗ trợ đơn hàng: #14', '2026-05-02 09:32:10', 2, 'user', 2, 1, NULL, 'Hỗ trợ đơn hàng: #14'),
(46, 'user1', 'b', '2026-05-02 09:36:44', 2, 'user', 2, 1, NULL, 'Hỗ trợ đơn hàng: #13'),
(47, 'user2', 'Tư vấn sản phẩm: Laptop Dubai', '2026-05-02 12:10:44', 6, 'user', 6, 1, NULL, 'Tư vấn sản phẩm: Laptop Dubai'),
(48, 'Tuvan1', 'mmb', '2026-05-02 12:34:28', 2, 'tuvan', 7, 2, NULL, 'Tư vấn sản phẩm: Apple   '),
(49, 'user2', 'null', '2026-05-03 08:51:49', 6, 'user', 6, 1, NULL, 'null');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
