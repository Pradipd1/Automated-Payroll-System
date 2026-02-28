-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2026 at 06:37 PM
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
-- Database: `payroll_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `check_in` datetime DEFAULT NULL,
  `check_out` datetime DEFAULT NULL,
  `latitude` varchar(50) DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `total_hours` decimal(5,2) DEFAULT NULL,
  `checkout_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `user_id`, `check_in`, `check_out`, `latitude`, `longitude`, `image_path`, `total_hours`, `checkout_image`) VALUES
(14, 2, '2026-02-27 22:45:19', '2026-02-27 22:45:32', '', '', NULL, 0.00, ''),
(15, 2, '2026-02-27 22:54:00', '2026-02-27 22:54:17', '', '', NULL, 0.00, ''),
(16, 2, '2026-02-27 22:58:01', '2026-02-27 22:58:11', '', '', NULL, 0.00, ''),
(17, 2, '2026-02-27 23:29:05', '2026-02-27 23:32:05', '', '', '', 0.05, ''),
(18, 2, '2026-02-27 23:32:23', '2026-02-27 23:32:32', '', '', 'photo_1772215343.png', 0.00, ''),
(19, 2, '2026-02-27 23:45:11', '2026-02-27 23:45:17', '', '', 'photo_1772216111.png', 0.00, 'checkout_1772216117.png'),
(20, 2, '2026-02-27 23:45:35', '2026-02-27 23:45:38', '', '', 'photo_1772216135.png', 0.00, 'checkout_1772216138.png'),
(21, 2, '2026-02-27 23:45:55', '2026-02-27 23:45:58', '', '', 'photo_1772216155.png', 0.00, 'checkout_1772216158.png'),
(22, 2, '2026-02-27 23:46:05', '2026-02-27 23:46:13', '', '', 'photo_1772216165.png', 0.00, 'checkout_1772216173.png'),
(23, 2, '2026-02-27 23:53:30', '2026-02-28 00:01:01', '', '', 'photo_1772216610.png', 0.13, 'checkout_1772217061.png'),
(24, 2, '2026-02-28 00:01:26', '2026-02-28 00:01:31', '', '', 'photo_1772217086.png', 0.00, 'checkout_1772217091.png'),
(25, 2, '2026-02-28 00:08:57', '2026-02-28 00:09:03', '', '', 'photo_1772217537.png', 0.00, 'checkout_1772217543.png'),
(26, 2, '2026-02-28 00:17:48', '2026-02-28 00:18:27', '', '', 'photo_1772218068.png', 0.01, 'checkout_1772218107.png'),
(27, 5, '2026-02-28 16:23:16', '2026-02-28 16:23:25', '', '', 'photo_1772275996.png', 0.00, 'checkout_1772276005.png'),
(28, 5, '2026-02-28 16:34:39', '2026-02-28 16:34:51', '', '', 'photo_1772276679.png', 0.00, 'checkout_1772276691.png'),
(29, 5, '2026-02-28 16:38:13', '2026-02-28 16:38:27', '', '', 'photo_1772276893.png', 0.00, 'checkout_1772276907.png');

-- --------------------------------------------------------

--
-- Table structure for table `payroll`
--

CREATE TABLE `payroll` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `month` varchar(20) DEFAULT NULL,
  `total_hours` decimal(6,2) DEFAULT NULL,
  `total_salary` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payroll`
--

INSERT INTO `payroll` (`id`, `user_id`, `month`, `total_hours`, `total_salary`) VALUES
(3, 2, '2026-02', 0.05, 15.00),
(4, 5, '2026-02', 0.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','employee') DEFAULT 'employee',
  `salary_per_hour` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `salary_per_hour`) VALUES
(1, 'pradip', 'pradipdhakal010@gmail.com', '$2y$10$LNGU9M8OhkOvNKoTNLJIPOwGHOZIW218iXucg5zwhtYT2trsYdKQK', 'admin', 500.00),
(2, 'sobha', 'sobha@gmail.com', '$2y$10$PqxiyrT5JQ82suDQ9b1cCe9xhq65dIUpzxAJctvuNspc0djMjTIRq', 'employee', 300.00),
(3, 'aarin', 'aarin@gmail.com', '$2y$10$tzp8ekJ97fIWCLc64/t0QOLeX8mjub4e3.ZoC7latzja4omxySOg6', 'employee', 500.00),
(4, 'samm', 'samm@gmail.com', '$2y$10$S0jzXaDcA2XAsqmI3JyQeOZ1yi71yGnR4ASUM94NLvsoKnS1CWygK', 'employee', 1000.00),
(5, 'sallu', 'sallu@gmail.com', '$2y$10$Mm7LzBk5McUkTGjD/M.FwuVPcBoTAskUe4QOcqhnqwgK04amRh.D.', 'employee', 1000.00),
(6, 'saurav', 'saurav@gmail.com', '$2y$10$RpJZ45mzKabXme4PPMYjUeLVsU5Ohy8OkLom8.7JygK/JFiQe93i6', 'employee', 1000.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `payroll`
--
ALTER TABLE `payroll`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `payroll`
--
ALTER TABLE `payroll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payroll`
--
ALTER TABLE `payroll`
  ADD CONSTRAINT `payroll_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
