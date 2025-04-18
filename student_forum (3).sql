-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2025 at 04:16 PM
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
-- Database: `student_forum`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `post_id`, `user_id`, `content`, `created_at`) VALUES
(11, 20, 26, '&lt;h1&gt; no injection &lt;/h1&gt;', '2025-04-06 09:00:52'),
(12, 21, 26, '&lt;h1&gt;con cac\r\n &lt;/h1&gt;', '2025-04-12 15:51:02');

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `module_id` int(11) NOT NULL,
  `module_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`module_id`, `module_name`, `created_at`) VALUES
(1, 'COMP1841', '2025-02-26 09:17:34'),
(2, 'COMP1772', '2025-04-06 09:33:54');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `module_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `user_id`, `module_id`, `title`, `content`, `image`, `created_at`) VALUES
(20, 26, 1, '&lt;h1&gt; no injection &lt;/h1&gt;', 'LOREM ISPSUMMMMMM &lt;h1&gt; no injection &lt;/h1&gt;', 'public/uploads/1743929682_Screenshot (160).png', '2025-03-31 15:57:07'),
(21, 26, NULL, 'con chim non', 'aaaaa', NULL, '2025-04-06 09:37:55'),
(26, 26, 1, 'tung tung tung sahur', 'tung tung tung sahur', 'public/uploads/1744701717_tungtungtungsahur.png', '2025-04-15 07:21:57'),
(27, 26, NULL, '&lt;button&gt; hacked &lt;/button&gt;', '&lt;button&gt; hacked &lt;/button&gt;', NULL, '2025-04-16 06:06:07'),
(28, 26, NULL, 'a', 'aaaaa', 'public/uploads/1744983451_RobloxScreenShot20250414_203325210.png', '2025-04-16 06:07:19'),
(29, 26, NULL, 'aaa', 'aaaa', NULL, '2025-04-18 13:45:31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','student') DEFAULT 'student',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(11, 'dadada', 'hoangtuan079699106a@gmail.com', '$2y$10$Mzk9eI4pfE3SedZntuK9QeNOodBZiTBCeSSd1pkRIlAH5X355Axiq', 'student', '2025-02-24 14:28:43'),
(14, 'accclnone', 'hoangtuan0796991061aa@gmail.com', '$2y$10$e8SxloUAr.guzXBum2Q9rONKpjNbpU5M2mbU3MrQLiAmo0Y30oV4m', 'student', '2025-03-04 12:32:56'),
(26, 'TuanAdmin', 'hoangtuan0796991061@gmail.com', '$2y$10$gNgUBp8JhsDL6W9HNKds2OAqPRkci3AElxzHtQ5MGHDEdubXpDohi', 'admin', '2025-03-31 15:52:57'),
(28, 'User1', 'tuanthhgcs230462@fpt.edu.vn', '$2y$10$v/s0hjQcKq0zGy/CqUi23ex5Pno7gJLsoQC3lgyxHHpgd3/3OOrgG', 'student', '2025-04-15 17:30:22'),
(29, 'aaa', 'hoangtuan0796991061@aa.com', '$2y$10$nQmrIbqXoSKJpLBNz/Hf6eVOqywxv0qDt8fGAodQrAamDZQnILfm6', 'student', '2025-04-15 17:38:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`module_id`),
  ADD UNIQUE KEY `module_name` (`module_name`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `module_id` (`module_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`module_id`) REFERENCES `modules` (`module_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
