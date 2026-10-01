-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2026 at 06:17 PM
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
-- Database: `qr_attendance`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `qr_code_data` varchar(255) NOT NULL,
  `scan_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Present','Absent') DEFAULT 'Present'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `student_id`, `qr_code_data`, `scan_time`, `status`) VALUES
(1, 3, 'SESSION-20260927-61065', '2026-09-27 09:48:05', 'Present'),
(2, 3, 'SESSION-20260927-90736', '2026-09-27 11:39:06', 'Present');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'Piyumi Nisansala', 'npiyumi20612@gmail.com', 'Send Message', '2026-09-27 08:28:54');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `lecturer_id` int(11) NOT NULL,
  `qr_code` varchar(255) NOT NULL,
  `session_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `lecturer_id`, `qr_code`, `session_date`, `start_time`, `end_time`, `created_at`) VALUES
(1, 4, 'SESSION-20260927-97462', '2026-09-27', '11:43:45', '12:43:45', '2026-09-27 09:43:45'),
(2, 4, 'SESSION-20260927-61065', '2026-09-27', '11:47:02', '12:47:02', '2026-09-27 09:47:02'),
(3, 4, 'SESSION-20260927-33293', '2026-09-27', '11:59:16', '12:59:16', '2026-09-27 09:59:16'),
(4, 6, 'SESSION-20260927-90736', '2026-09-27', '13:38:40', '14:38:40', '2026-09-27 11:38:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','lecturer') DEFAULT 'student',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Admin', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'lecturer', '2026-09-27 07:52:19'),
(2, 'Student1', 'student@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', '2026-09-27 07:52:19'),
(3, 'Piyumi Nisansala', 'npiyumi20612@gmail.com', '$2y$10$h/TDoJl.6uGrMpbf4qV1UuZCgcZF16BYPeCY2CN6JjS6i5a4bCIdS', 'student', '2026-09-27 08:00:16'),
(4, 'Ajith Bandara', 'ajith@example.com', '$2y$10$VYCLBZeTdcxr6A.DDHni3OPW/12LFssgbVLKs9n5LZNoYRnzjq.AO', 'lecturer', '2026-09-27 09:19:20'),
(5, 'Malisha', 'malisha@gmail.com', '$2y$10$MAfn/E9fst9ZLl2pTz81B.BeruFPWB3tRU560dQO7nOYKgNyEs7ea', 'student', '2026-09-27 11:29:27'),
(6, 'Upul Weerasinghe', 'upul20@gmail.com', '$2y$10$KgbfOI/QIwu//dV1ae1mSugX/c47I9M6ZHqaAjoxwpWzFGBgabASW', 'lecturer', '2026-09-27 11:32:25'),
(7, 'john', 'john@gmail.com', '$2y$10$.mqvwqdJcZoIP7e7iEBtEeRWDpIUmlybkRJNdzEg7/Xgd5fWawCR2', 'student', '2026-09-27 13:32:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
