-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 16, 2026 at 01:35 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `task_management_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `status` enum('pending','in_progress','completed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `description`, `assigned_to`, `due_date`, `status`, `created_at`) VALUES
(1, 'Monthly Finance Preparation', 'Prepare and review the monthly financial report , including profit and loss statements ,balance sheets and cash flow analysis', 2, '0000-00-00', 'completed', '2026-07-14 13:54:41'),
(2, 'Customer Feedback Survey Analysis', 'Collect and analyze data from the latest customer feedback survey to identify areas for improvement in customer service', 3, '2026-07-16', 'pending', '2026-07-14 13:56:55'),
(3, 'Website Maintenance and Update', 'Perform regular maintenance on the company website,update content,and ensure all security patches are applied ', 5, '2026-07-14', 'in_progress', '2026-07-14 13:59:05'),
(4, 'Quartierly Inventory Audit', 'Conduct a through audit of inventory levels across all warehouses and update the inventory management system accordingly ', 2, '2026-07-15', 'in_progress', '2026-07-14 14:15:51'),
(5, 'Employee Training Program Development', 'Develop and implement a new training program focused on enhancing employee skills in project management and teamwork', 2, '2026-07-01', 'completed', '2026-07-14 14:21:19');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','employee') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'Shrouk Mohamed', 'Shrouk', '$2y$10$w9MTQExXefFQ7C0sbB4m7uj8hphPhptimRypxJBjKhrKk5zyH6Jwm', 'admin', '2026-07-13 03:32:59'),
(2, 'Ahmed Mahmoud', 'Ahmed', '$2y$10$Ef4cYr/U9Qp5OqpBtN9KO.erR9kK1H0UrnHUv3k5ZNBSDK/BpKmMe', 'employee', '2026-07-14 02:42:04'),
(3, 'Ghada Mohamed', 'Ghada', '$2y$10$LoZa7ABL4CvnbYffXxjgUuHeiROyMexHf1hoCAajx.xnSItmNWqkW', 'employee', '2026-07-14 02:42:14'),
(4, 'Hana Ehab', 'Hana', '$2y$10$ezBpkWcroY88y3oWH8OVTeBRhIJ/hkWh46jQoY82VzL4ZprQZgAOS', 'employee', '2026-07-14 02:42:32'),
(5, 'Mohamed Salah', 'Mohamed', '$2y$10$m/IBGbdiOQ1uWsUEufAILOyXRgcbGKkHN2VsQGmRIp3X72DTyaQPS', 'employee', '2026-07-14 02:42:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assigned_to` (`assigned_to`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
