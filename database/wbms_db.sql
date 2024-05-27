-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2024 at 06:04 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wbms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `billing_list`
--

CREATE TABLE `billing_list` (
  `id` int(30) NOT NULL,
  `client_id` int(30) NOT NULL,
  `reading_date` date NOT NULL,
  `due_date` date NOT NULL,
  `reading` float(12,2) NOT NULL DEFAULT 0.00,
  `previous` float(12,2) NOT NULL DEFAULT 0.00,
  `rate` float(12,2) NOT NULL DEFAULT 0.00,
  `total` float(12,2) NOT NULL DEFAULT 0.00,
  `penalty_option` varchar(55) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0= pending,\r\n1= paid',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `billing_list`
--

INSERT INTO `billing_list` (`id`, `client_id`, `reading_date`, `due_date`, `reading`, `previous`, `rate`, `total`, `penalty_option`, `status`, `date_created`, `date_updated`) VALUES
(1, 1, '2022-04-01', '2022-04-15', 1100.00, 1001.00, 10.75, 1064.25, '10%_per_month_after_due_date', 1, '2024-04-01 15:14:03', '2024-05-26 23:12:46'),
(2, 1, '2022-05-02', '2022-05-15', 1189.00, 1100.00, 10.75, 956.75, '10%_per_month_after_due_date', 1, '2024-03-01 15:14:27', '2024-05-26 23:12:39'),
(3, 1, '2024-05-26', '2024-05-25', 2012.00, 1189.00, 10.75, 8847.25, '10%_per_month_after_due_date', 1, '2024-03-26 14:33:17', '2024-05-27 00:49:03'),
(4, 1, '2024-05-26', '2024-05-31', 2000.00, 2000.00, 10.75, 0.00, '10%_per_month_after_due_date', 0, '2024-03-26 15:42:29', '2024-05-27 00:29:28'),
(6, 2, '2024-05-26', '2024-05-26', 100.00, 0.00, 10.75, 1075.00, '10%_per_month_after_due_date', 0, '2024-05-26 17:01:15', '2024-05-26 17:01:15'),
(7, 2, '2024-05-01', '2024-05-24', 133.00, 100.00, 10.75, 390.23, '10%_per_month_after_due_date', 0, '2024-05-27 01:52:04', '2024-05-27 01:53:34');

-- --------------------------------------------------------

--
-- Table structure for table `category_list`
--

CREATE TABLE `category_list` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category_list`
--

INSERT INTO `category_list` (`id`, `name`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(1, 'Residential', 1, 0, '2022-05-02 15:13:02', '2022-05-02 15:13:02'),
(2, 'Commercial', 1, 0, '2022-05-02 15:13:09', '2022-05-02 15:13:09');

-- --------------------------------------------------------

--
-- Table structure for table `client_list`
--

CREATE TABLE `client_list` (
  `id` int(30) NOT NULL,
  `code` varchar(100) NOT NULL,
  `category_id` int(30) NOT NULL,
  `firstname` text NOT NULL,
  `middlename` text DEFAULT NULL,
  `lastname` text NOT NULL,
  `contact` text NOT NULL,
  `address` text NOT NULL,
  `meter_code` varchar(100) NOT NULL,
  `first_reading` float(12,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client_list`
--

INSERT INTO `client_list` (`id`, `code`, `category_id`, `firstname`, `middlename`, `lastname`, `contact`, `address`, `meter_code`, `first_reading`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(1, '202205020001', 1, 'Mark', 'D', 'Cooper', '09123456789', 'Sample Address', '123456', 1001.00, 1, 0, '2022-05-02 15:13:35', '2022-05-02 15:13:35'),
(2, '202405260001', 2, 'Robertson ', '', 'Morales', '0987654321', 'Test', '123', 0.00, 1, 0, '2024-05-26 16:56:38', '2024-05-26 17:00:09');

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'Water Billing Management System'),
(6, 'short_name', 'WBMS - PHP'),
(11, 'logo', 'uploads/logo.png?v=1651282049'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/cover.png?v=1651282061'),
(15, 'rate', '10.75');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `middlename` text DEFAULT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `middlename`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `date_added`, `date_updated`) VALUES
(1, 'Adminstrator', NULL, 'Admin', 'admin', '0192023a7bbd73250516f069df18b500', 'uploads/avatars/1.png?v=1649834664', NULL, 1, '2021-01-20 14:02:37', '2022-04-13 15:24:24'),
(3, 'John', NULL, 'Smith', 'jsmith', '1254737c076cf867dc53d60a0364f38e', 'uploads/avatars/3.png?v=1650527149', NULL, 2, '2022-04-21 15:45:49', '2022-04-21 15:46:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `billing_list`
--
ALTER TABLE `billing_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `category_list`
--
ALTER TABLE `category_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client_list`
--
ALTER TABLE `client_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `billing_list`
--
ALTER TABLE `billing_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `category_list`
--
ALTER TABLE `category_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `client_list`
--
ALTER TABLE `client_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `billing_list`
--
ALTER TABLE `billing_list`
  ADD CONSTRAINT `client_id_fk_bl` FOREIGN KEY (`client_id`) REFERENCES `client_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `client_list`
--
ALTER TABLE `client_list`
  ADD CONSTRAINT `category_id_fk_cl` FOREIGN KEY (`category_id`) REFERENCES `category_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
