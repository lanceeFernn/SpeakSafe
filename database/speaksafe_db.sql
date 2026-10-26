-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 21, 2026 at 01:13 PM
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
-- Database: `speaksafe_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `incidents_reports`
--

CREATE TABLE `incidents_reports` (
  `report_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(100) NOT NULL,
  `incident_date` datetime NOT NULL,
  `is_anonymous` tinyint(1) DEFAULT 0,
  `status` enum('Pending','Under Review','Resolved') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `incidents_reports`
--

INSERT INTO `incidents_reports` (`report_id`, `user_id`, `title`, `description`, `location`, `incident_date`, `is_anonymous`, `status`, `created_at`) VALUES
(1, 1, 'Bullying', 'They bully me because of my blah blah blah.', 'New Building, Ground Floor', '2026-10-19 19:09:00', 0, 'Pending', '2026-10-19 11:09:31'),
(2, 1, 'Harassment', 'They harassed me because of blah blah blah.', 'CRMC Main Building, Classroom 204', '2026-10-19 19:11:00', 1, 'Pending', '2026-10-19 11:11:09'),
(3, 1, 'Bullying', 'They bullied me because...', 'CRMC Maxwell, Room 204', '2026-10-21 19:01:00', 1, 'Pending', '2026-10-21 11:01:28');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','admin','council') DEFAULT 'student',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'lance', 'fernandez', 'fernandez@gmail.com', '$2y$10$G.EGNnvOiI72yywjTixoi.8Bck7dOABWYbqXZh..m2AH/kQLewXN6', 'student', '2026-10-19 10:53:43'),
(2, 'Chloey Lyca', 'Jurcales', 'jurcales@gmail.com', '$2y$10$GehcmUgPMqYjWxsEXDtM.u.FxLzoC6EFdK5il/3qavjiqwLZQGErG', 'student', '2026-10-21 10:08:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `incidents_reports`
--
ALTER TABLE `incidents_reports`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `incidents_reports`
--
ALTER TABLE `incidents_reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `incidents_reports`
--
ALTER TABLE `incidents_reports`
  ADD CONSTRAINT `incidents_reports_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
