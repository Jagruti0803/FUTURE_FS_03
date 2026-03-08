-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2026 at 10:50 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `terranew`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins_new`
--

CREATE TABLE `admins_new` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins_new`
--

INSERT INTO `admins_new` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(2, 'poi', 'poi@gmail.com', '$2y$10$XIN05bFyBCRzNd6A7ujsT./ggZqFEHHcJtr1n9y0A7VtuO3g9xSLy', '2025-09-15 11:33:49'),
(3, 'sai', 'sai@gmail.com', 'sai@123', '2026-03-08 07:58:55');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `first_name`, `last_name`, `email`, `phone`, `message`, `created_at`) VALUES
(1, 'salvi ', 'khant', 'salvi@gmail.com', '25467879845', 'good services', '2025-09-15 06:00:04'),
(3, 'neha ', 'varma', 'neha@gmail.com', '9789789879', 'nice 😍', '2025-09-15 06:07:46'),
(4, 'neha ', 'varma', 'neha@gmail.com', '4444444444444444', 'wwwwwwwwwwwwww', '2025-09-23 17:32:22'),
(5, 'neha ', 'varma', 'neha@gmail.com', '4444444444444444', 'wwwwwwwwwwwwww', '2025-09-23 17:43:59'),
(6, 'shiv', 'bora', 'shiv@gmail.com', '7777777', 'hhhhhhhhhhhhhh', '2025-09-24 03:33:57'),
(7, 'khushi', 'hadvani', 'khushali@gmail.com', '9789789879', 'good', '2025-09-29 13:05:28');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `fullname` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `wallet` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `wallet_balance` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `fullname`, `email`, `password`, `phone`, `wallet`, `status`, `wallet_balance`) VALUES
(10, 'salvi', 'salvi@gmail.com', 'salvi123', '098766455', '0.00', 'active', '0.00'),
(11, 'shiv', 'shiv@gmail.com', '$2y$10$rptYGD9jAIBa2G7raFug3eY4S/TH5/0RfjA6rKiX58IioskGomSWC', '785674653', '0.00', 'active', '0.00'),
(12, 'happy', 'happy@gmail.com', '$2y$10$fNsEyGsPGOlvJ477l2PrUO0Z6u7eTMpjSempBCTCauDW8oJ.KPJHC', '0909090909', '0.00', 'active', '0.00'),
(13, 'juhi', 'juhi@gmail.com', '$2y$10$Rz..Y8pUs9oLez8lNDKRb.4I.E5uE7PZ6Tak2WCUcYTalH4E3KB/K', '9075095', '0.00', 'active', '0.00'),
(14, 'khushali', 'khushali@gmail.com', '$2y$10$Mj3MfHZzBpvW8qHB4JE/mehb/ssMDCJ8DVulrwOJbNdcvVWHclF0S', '25467879845', '0.00', 'active', '0.00'),
(15, 'neha', 'neha@gmail.com', '$2y$10$n4fcDiRQXEOczUnng9llFewh31nihqvVCG9cG6lEBgdJvENnBFA3K', '9789789879', '0.00', 'active', '0.00'),
(16, 'kanu', 'kanu@gmail.com', '$2y$10$cH4vpz6TXokppqAOUDiYPuvPSOeuARBxPKT9zKV9w/cwUUYU0hNBe', '9999999999', '0.00', 'active', '0.00'),
(17, 'k1', 'k1@gmail.com', '$2y$10$M/91tUbD6pEoKaHYG8H/aebNYwXsxBSxbvAx5oHDbPNKrzKqTrdj6', '0987654321', '0.00', 'active', '0.00'),
(18, 'khushi', 'khushalihadvani@gmail.com', '$2y$10$7XObgzOMBendXanD7f71P.m1p4z1a67GU8h.mUO2nzCGK69vNtsVm', '9876543210', '0.00', 'active', '0.00'),
(19, 'shiya', 'shiya@gmail.com', '$2y$10$vMSCqjXHPQx.ysXTZ8MlT.uzWdiwj0jlj3fss.XzuTx/aWiEjObGO', '7777926618', '0.00', 'active', '0.00'),
(20, 'nita', 'nita@gmail.com', '$2y$10$kJ32m9AcMVC9UJVwXAa7mOSLX5pHUqZVcv5IKGm1LTs6Eu3cpih6q', '987688999', '0.00', 'active', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `get_in_touch`
--

CREATE TABLE `get_in_touch` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `message` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `get_in_touch`
--

INSERT INTO `get_in_touch` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'salvi', 'salvi@gmail.com', 'i send you the parcel but i don\'t recive the money ', '2025-09-23 13:46:19'),
(2, 'salvi', 'salvi@gmail.com', 'you services is good 😊😊', '2025-09-24 03:46:18'),
(3, 'salvi', 'salvi@gmail.com', 'eeeeeeee', '2025-09-29 16:49:04'),
(4, 'jems', 'jemi@gmail.com', 'ddd', '2025-09-30 02:20:12');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `message` text NOT NULL,
  `status` enum('unread','read') DEFAULT 'unread',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orders_new`
--

CREATE TABLE `orders_new` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders_new`
--

INSERT INTO `orders_new` (`id`, `customer_id`, `product_id`, `quantity`, `total_price`, `payment_method`, `status`, `created_at`) VALUES
(3, 15, 48, 1, '230.00', NULL, 'Pending', '2025-09-15 06:59:46'),
(4, 15, 48, 1, '230.00', NULL, 'Pending', '2025-09-15 07:00:48'),
(5, 15, 48, 1, '230.00', NULL, 'Pending', '2025-09-15 07:07:16'),
(6, 15, 48, 1, '230.00', NULL, 'Pending', '2025-09-15 09:40:00'),
(7, 15, 48, 1, '230.00', NULL, 'Pending', '2025-09-15 09:50:34'),
(8, 15, 48, 1, '230.00', NULL, 'Rejected', '2025-09-15 10:06:56'),
(9, 15, 48, 1, '230.00', NULL, 'Paid', '2025-09-15 10:07:23'),
(10, 15, 48, 1, '230.00', NULL, 'Approved', '2025-09-15 10:31:27'),
(11, 15, 45, 1, '72.00', NULL, 'Paid', '2025-09-15 11:13:37'),
(12, 15, 40, 2, '204.00', NULL, 'Paid', '2025-09-15 11:13:37'),
(13, 15, 24, 1, '85.00', NULL, 'Rejected', '2025-09-15 13:37:29'),
(14, 15, 49, 1, '120.00', NULL, 'Paid', '2025-09-15 13:37:29'),
(15, 15, 0, 0, '3530.00', 'UPI', 'Pending', '2025-09-15 15:27:03'),
(16, 15, 0, 0, '221.00', NULL, 'Pending', '2025-09-15 15:28:34'),
(17, 15, 0, 0, '421.00', NULL, 'Pending', '2025-09-23 15:21:31');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_details`
--

CREATE TABLE `purchase_details` (
  `id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `payment_method` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchase_details`
--

INSERT INTO `purchase_details` (`id`, `purchase_id`, `fullname`, `email`, `phone`, `address`, `payment_method`) VALUES
(1, 2, '888', '88@gmail.com', '8888888888888888888', 'hhhhhhhhhhhhhhhhhhhhhhh', 'Cash on Delivery'),
(2, 3, 'neha ', 'neha@gmail.com', '4444444444444444', 'ffffffffffffff', 'Cash on Delivery'),
(3, 4, 'neha', 'neha@gmail.com', '77777777777777', 'hhhhhhhhhhhhh', 'Cash on Delivery'),
(4, 5, 'juhi', 'juhi@gmail.com', '66666666666666', 'yyyyyyyyyyyyyyyy', 'Cash on Delivery'),
(5, 6, 'rutu', 'rutu@gmail.com', '800000000000', 'fffffffffffffffffffff', 'Cash on Delivery'),
(6, 7, 'neha ', 'neha@gmail.com', '0000000000000000000000000', 'ssssssssssssssssssssssssssssss', 'Cash on Delivery'),
(7, 8, 'neha ', 'neha@gmail.com', '11111111111111111111', 'dddddddddddddddddddddddddddddd', 'Cash on Delivery'),
(8, 9, 'neha ', 'neha@gmail.com', '55555555555555555555', 'yyyyyyyyyyyyyyyyy', 'Cash on Delivery'),
(9, 10, 'kanu', 'kanu@gmail.com', '33333333', 'fffffffffffffffffff', 'Cash on Delivery'),
(10, 11, 'duku ', 'duku@gmail.com', '555222333444', 'dddddddddddddddddddddddd', 'Cash on Delivery'),
(11, 12, 'shiv', 'shiv@gmail.com', '0987654321', 'rajkot', 'Cash on Delivery'),
(12, 13, 'neha ', 'neha@gmail.com', '0987654321', 'fggyutuyghjggh', 'Cash on Delivery'),
(13, 14, 'k1', 'k1@gmail.com', '0987654321', 'gondal', 'Cash on Delivery'),
(14, 15, 'khushi', 'khushali@gmail.com', '0987654321', 'rajkot', 'Cash on Delivery'),
(15, 16, 'shiya', 'shiya@gmail.com', '7777926618', 'rajkot, kotecha ', 'Cash on Delivery'),
(16, 17, 'nita ', 'nita@gmail.com', '9789789879', 'rrrrrrrfffffffffffrrrrrrrrrgggggg', 'Cash on Delivery'),
(17, 18, 'shiya', 'shiya@gmail.com', '66666666666666', 'rajkot , kalavad road ', 'Cash on Delivery'),
(18, 19, 'neha', 'neha@gmail.com', '0000000000', 'ooo', 'Cash on Delivery');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_history`
--

CREATE TABLE `purchase_history` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchase_history`
--

INSERT INTO `purchase_history` (`id`, `customer_id`, `total_price`, `status`, `created_at`) VALUES
(1, 15, '10810.00', 'Pending', '2025-09-23 15:58:18'),
(2, 15, '10810.00', 'Pending', '2025-09-23 15:59:20'),
(3, 15, '208.00', 'Pending', '2025-09-23 16:05:18'),
(4, 15, '208.00', 'Pending', '2025-09-23 16:06:40'),
(5, 15, '720.00', 'Pending', '2025-09-23 16:08:17'),
(6, 15, '120.00', 'Pending', '2025-09-23 16:25:43'),
(7, 15, '4830.00', 'Pending', '2025-09-23 16:29:22'),
(8, 15, '100.00', 'Pending', '2025-09-23 16:35:08'),
(9, 15, '422.00', 'Pending', '2025-09-23 17:54:19'),
(10, 16, '1840.00', 'Pending', '2025-09-23 18:00:36'),
(11, 16, '455.00', 'Pending', '2025-09-23 18:26:06'),
(12, 11, '302.00', 'Pending', '2025-09-24 03:32:04'),
(13, 15, '308.00', 'Pending', '2025-09-24 03:50:37'),
(14, 17, '276.00', 'Pending', '2025-09-24 03:59:49'),
(15, 18, '230.00', 'Pending', '2025-09-29 13:08:17'),
(16, 19, '933.00', 'Pending', '2025-09-30 02:33:47'),
(17, 20, '4200.00', 'Pending', '2025-09-30 11:09:59'),
(18, 19, '5644.00', 'Pending', '2025-09-30 15:45:45'),
(19, 15, '234.00', 'Pending', '2026-03-08 08:13:14');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_items`
--

CREATE TABLE `purchase_items` (
  `id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchase_items`
--

INSERT INTO `purchase_items` (`id`, `purchase_id`, `product_id`, `name`, `quantity`, `price`) VALUES
(9, 3, 32, 'DARK BLUE ', 1, '208.00'),
(10, 4, 32, 'DARK BLUE ', 1, '208.00'),
(11, 5, 49, 'TEA', 6, '120.00'),
(12, 6, 49, 'TEA', 1, '120.00'),
(13, 7, 48, 'TEA', 21, '230.00'),
(14, 8, 12, 'LIGHT PINK', 1, '100.00'),
(15, 9, 49, 'TEA', 1, '120.00'),
(16, 9, 48, 'TEA', 1, '230.00'),
(17, 9, 45, 'ORANGE', 1, '72.00'),
(18, 10, 48, 'TEA', 8, '230.00'),
(19, 11, 16, 'DARK GREEN ', 7, '65.00'),
(20, 12, 48, 'TEA', 1, '230.00'),
(21, 12, 45, 'ORANGE', 1, '72.00'),
(22, 13, 43, 'LIGHT PURPLE ', 2, '119.00'),
(23, 13, 42, 'DARK PURPLE', 1, '70.00'),
(24, 14, 40, 'LIGHT GRAY ', 2, '102.00'),
(25, 14, 34, 'DARK GREEN ', 1, '72.00'),
(26, 15, 48, 'TEA', 1, '230.00'),
(27, 16, 68, 'Orange', 1, '234.00'),
(28, 16, 67, 'Pink', 1, '231.00'),
(29, 16, 66, 'Yellow', 1, '234.00'),
(30, 16, 65, 'Tea', 1, '234.00'),
(31, 17, 66, 'Yellow', 14, '234.00'),
(32, 17, 67, 'Pink', 4, '231.00'),
(33, 18, 59, 'Orange', 34, '166.00'),
(34, 19, 68, 'Orange', 1, '234.00');

-- --------------------------------------------------------

--
-- Table structure for table `recycled_products`
--

CREATE TABLE `recycled_products` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `grade` enum('Recycled','Virgin') NOT NULL DEFAULT 'Recycled',
  `description` text,
  `category` enum('PET','HDPE') NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `recycled_products`
--

INSERT INTO `recycled_products` (`id`, `name`, `grade`, `description`, `category`, `price`, `image`, `created_at`) VALUES
(9, 'DARK PINK', 'Recycled', NULL, 'HDPE', '130.00', 'd_1.jpeg', '2025-09-13 09:42:33'),
(12, 'LIGHT PINK', 'Recycled', NULL, 'HDPE', '100.00', 'd_11.jpeg', '2025-09-13 10:00:01'),
(13, 'BLACK', 'Recycled', NULL, 'HDPE', '125.00', 'd_14.png', '2025-09-13 10:07:43'),
(14, 'DARK BLUE', 'Recycled', NULL, 'HDPE', '130.00', 'd_15.png', '2025-09-13 10:13:34'),
(15, 'LIGHT BLUE', 'Recycled', NULL, 'HDPE', '210.00', 'd_21.JPG', '2025-09-13 10:18:10'),
(16, 'DARK GREEN ', 'Recycled', NULL, 'HDPE', '65.00', 'd_2.JPEG', '2025-09-13 10:35:36'),
(17, 'LIGHT GREEN ', 'Recycled', NULL, 'HDPE', '70.00', 'd_16.PNG', '2025-09-13 10:39:03'),
(18, 'RED', 'Recycled', NULL, 'HDPE', '97.00', 'd_17.PNG', '2025-09-13 10:42:28'),
(19, ' DARK YELLOW', 'Recycled', NULL, 'HDPE', '127.00', 'd_20.PNG', '2025-09-13 10:53:42'),
(20, 'LIGHT YELLOW', 'Recycled', NULL, 'HDPE', '63.00', 'd_13.JPEG', '2025-09-13 10:55:01'),
(21, 'LIGHT GRAY', 'Recycled', NULL, 'HDPE', '149.00', 'd_9.JPEG', '2025-09-13 11:02:34'),
(22, 'DARK GRAY', 'Recycled', NULL, 'HDPE', '77.00', 'd_3.JPEG', '2025-09-13 11:03:35'),
(23, 'LIGHT GRAY', 'Recycled', NULL, 'HDPE', '149.00', 'd_9.JPEG', '2025-09-13 11:08:58'),
(24, 'WHITE', 'Recycled', NULL, 'HDPE', '85.00', 'd_19.PNG', '2025-09-13 11:12:04'),
(26, 'LIGHT PURPLE', 'Recycled', NULL, 'HDPE', '174.00', 'd_4.JPEG', '2025-09-13 11:37:48'),
(27, 'DARK PURPLE', 'Recycled', NULL, 'HDPE', '80.00', 'd_5.JPEG', '2025-09-13 11:38:30'),
(29, 'DARK PINK ', 'Virgin', NULL, 'HDPE', '239.00', 'd_1.JPEG', '2025-09-13 12:27:47'),
(30, 'LIGHT PINK ', 'Virgin', NULL, 'HDPE', '127.00', 'd_11.JPEG', '2025-09-13 12:27:47'),
(31, 'BLACK ', 'Virgin', NULL, 'HDPE', '221.00', 'd_14.PNG', '2025-09-13 12:27:47'),
(32, 'DARK BLUE ', 'Virgin', NULL, 'HDPE', '208.00', 'd_15.PNG', '2025-09-13 12:27:47'),
(33, 'LIGHT BLUE', 'Virgin', NULL, 'HDPE', '197.00', 'd_21.JPG', '2025-09-13 12:27:47'),
(34, 'DARK GREEN ', 'Virgin', NULL, 'HDPE', '72.00', 'd_2.JPEG', '2025-09-13 12:27:47'),
(35, 'LIGHT GREEN ', 'Virgin', NULL, 'HDPE', '77.00', 'd_16.PNG', '2025-09-13 12:27:47'),
(36, 'RED', 'Virgin', NULL, 'HDPE', '91.00', 'd_17.PNG', '2025-09-13 12:27:47'),
(37, 'DARK YELLOW', 'Virgin', NULL, 'HDPE', '71.00', 'd_20.PNG', '2025-09-13 12:27:47'),
(38, 'LIGHT YELLOW ', 'Virgin', NULL, 'HDPE', '102.00', 'd_13.JPEG', '2025-09-13 12:27:47'),
(39, 'DARK GRAY', 'Virgin', NULL, 'HDPE', '177.00', 'd_3.JPEG', '2025-09-13 12:27:47'),
(40, 'LIGHT GRAY ', 'Virgin', NULL, 'HDPE', '102.00', 'd_9.JPEG', '2025-09-13 12:27:47'),
(41, 'WHITE ', 'Virgin', NULL, 'HDPE', '249.00', 'd_19.PNG', '2025-09-13 12:27:47'),
(42, 'DARK PURPLE', 'Virgin', NULL, 'HDPE', '70.00', 'd_5.JPEG', '2025-09-13 12:27:47'),
(43, 'LIGHT PURPLE ', 'Virgin', NULL, 'HDPE', '119.00', 'd_4.JPEG', '2025-09-13 12:27:47'),
(44, 'ORANGE ', 'Virgin', NULL, 'HDPE', '78.00', 'd_12.JPEG', '2025-09-13 12:27:47'),
(45, 'ORANGE', 'Recycled', NULL, 'HDPE', '72.00', 'd_12.JPEG', '2025-09-14 10:38:41'),
(48, 'TEA', 'Virgin', NULL, 'HDPE', '230.00', 'd_6.JPEG', '2025-09-14 14:59:44'),
(49, 'TEA', 'Recycled', NULL, 'HDPE', '120.00', 'd_6.JPEG', '2025-09-14 14:59:44'),
(50, 'Transparant', 'Recycled', NULL, 'PET', '200.00', 'pet1.jpg', '2025-09-29 12:46:17'),
(52, 'Red', 'Recycled', NULL, 'PET', '300.00', 'pet2.jpg', '2025-09-29 12:56:31'),
(53, 'Green', 'Recycled', NULL, 'PET', '150.00', 'pet3.jpg', '2025-09-29 12:56:31'),
(54, 'Black', 'Recycled', NULL, 'PET', '250.00', 'pet5.jpg', '2025-09-29 12:56:31'),
(55, 'Blue', 'Recycled', NULL, 'PET', '300.00', 'pet6.jpg', '2025-09-29 12:56:31'),
(56, 'Tea', 'Recycled', NULL, 'PET', '225.00', 'pet7.jpg', '2025-09-29 12:56:31'),
(57, 'Yellow', 'Recycled', NULL, 'PET', '150.00', 'pet8.jpg', '2025-09-29 12:56:31'),
(58, 'Pink', 'Recycled', NULL, 'PET', '322.00', 'pet4.jpeg', '2025-09-29 12:56:31'),
(59, 'Orange', 'Recycled', NULL, 'PET', '166.00', 'pet11.jpg', '2025-09-29 12:56:31'),
(60, 'Transparant', 'Virgin', NULL, 'PET', '240.00', 'pet1.jpg', '2025-09-29 13:00:26'),
(61, 'Red', 'Virgin', NULL, 'PET', '390.00', 'pet2.jpg', '2025-09-29 13:00:26'),
(62, 'Green', 'Virgin', NULL, 'PET', '155.00', 'pet3.jpg', '2025-09-29 13:00:26'),
(63, 'Black', 'Virgin', NULL, 'PET', '153.00', 'pet5.jpg', '2025-09-29 13:00:26'),
(64, 'Blue', 'Virgin', NULL, 'PET', '224.00', 'pet6.jpg', '2025-09-29 13:00:26'),
(65, 'Tea', 'Virgin', NULL, 'PET', '234.00', 'pet7.jpg', '2025-09-29 13:00:26'),
(66, 'Yellow', 'Virgin', NULL, 'PET', '234.00', 'pet8.jpg', '2025-09-29 13:00:26'),
(67, 'Pink', 'Virgin', NULL, 'PET', '231.00', 'pet4.jpeg', '2025-09-29 13:00:26'),
(68, 'Orange', 'Virgin', NULL, 'PET', '234.00', 'pet11.jpg', '2025-09-29 13:00:26');

-- --------------------------------------------------------

--
-- Table structure for table `recycle_submissions`
--

CREATE TABLE `recycle_submissions` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `plastic_type` enum('PET','HDPE') NOT NULL,
  `weight` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `condition_status` varchar(50) DEFAULT NULL,
  `description` text,
  `delivery` varchar(50) DEFAULT NULL,
  `status` enum('pending','approved','paid') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `recycle_submissions`
--

INSERT INTO `recycle_submissions` (`id`, `customer_id`, `plastic_type`, `weight`, `amount`, `condition_status`, `description`, `delivery`, `status`, `created_at`) VALUES
(4, 9, 'HDPE', '7.00', '70.00', 'fair', 'jgiug', 'dropoff', 'pending', '2025-09-14 12:29:20'),
(5, 14, 'HDPE', '8.00', '80.00', 'good', 'hhhh', 'pickup', 'pending', '2025-09-14 14:55:21'),
(6, 11, 'PET', '5.00', '50.00', 'good', 'ggg', 'dropoff', 'pending', '2025-09-15 05:50:14'),
(7, 15, 'HDPE', '8.00', '80.00', 'poor', '', 'dropoff', 'pending', '2025-09-15 06:06:45'),
(8, 15, 'HDPE', '8.00', '80.00', 'poor', 'hguuyu', 'dropoff', 'pending', '2025-09-24 03:49:25'),
(9, 18, 'HDPE', '10.00', '100.00', 'excellent', '', 'dropoff', 'pending', '2025-09-29 13:06:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins_new`
--
ALTER TABLE `admins_new`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `get_in_touch`
--
ALTER TABLE `get_in_touch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders_new`
--
ALTER TABLE `orders_new`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_id` (`purchase_id`);

--
-- Indexes for table `purchase_history`
--
ALTER TABLE `purchase_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_items`
--
ALTER TABLE `purchase_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recycled_products`
--
ALTER TABLE `recycled_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recycle_submissions`
--
ALTER TABLE `recycle_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins_new`
--
ALTER TABLE `admins_new`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `get_in_touch`
--
ALTER TABLE `get_in_touch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders_new`
--
ALTER TABLE `orders_new`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `purchase_details`
--
ALTER TABLE `purchase_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `purchase_history`
--
ALTER TABLE `purchase_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `purchase_items`
--
ALTER TABLE `purchase_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `recycled_products`
--
ALTER TABLE `recycled_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `recycle_submissions`
--
ALTER TABLE `recycle_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD CONSTRAINT `purchase_details_ibfk_1` FOREIGN KEY (`purchase_id`) REFERENCES `purchase_history` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
