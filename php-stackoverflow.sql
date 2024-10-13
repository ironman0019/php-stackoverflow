-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 13, 2024 at 10:03 AM
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
-- Database: `php-stackoverflow`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `body` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_accepted` tinyint(4) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `question_id`, `body`, `user_id`, `is_accepted`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 'WHY ARE YOU GAE??', 1, 1, 0, '2024-09-18 10:40:39', '2024-10-03 23:20:26'),
(2, 1, 'we? there is no we..', 1, 0, 0, '2024-09-18 10:41:27', '2024-10-05 01:54:16'),
(4, 1, 'dvs', 1, 1, 1, '2024-09-18 11:17:57', '2024-10-05 03:34:57'),
(5, 1, 'IM DEADDDDDDDDDDDDDDDDDDD', 1, 0, 1, '2024-09-18 11:18:07', '2024-10-05 03:34:57');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `question_id` int(11) DEFAULT NULL,
  `answer_id` int(11) DEFAULT NULL,
  `body` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `question_id`, `answer_id`, `body`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 7, NULL, 'Don\'t talk about fight club :)', 1, '2024-09-19 17:15:24', '2024-09-19 19:18:04'),
(2, 1, NULL, 5, 'But why?? دیرتتتسنتذرسمنبئمسبکسشثب', 0, '2024-09-19 17:15:54', '2024-09-19 19:18:22'),
(3, 2, NULL, 5, 'سلام سلام صدتا سلام', 1, '2024-10-03 01:06:02', '2024-10-03 01:06:02'),
(4, 4, 1, NULL, 'این یک کامنت است!', 1, '2024-10-03 01:27:59', '2024-10-03 01:27:59'),
(5, 1, 1, NULL, 'کامنت تست کامنت تست کامنت تست کامنت تست کامنت تست', 1, '2024-10-03 01:28:48', '2024-10-03 01:28:48'),
(6, 4, NULL, 4, 'کامنت اول', 1, '2024-10-04 02:09:29', '2024-10-04 02:09:29'),
(7, 4, NULL, 5, 'بگو ای یار بگو', 1, '2024-10-04 02:10:09', '2024-10-04 02:10:09'),
(8, 4, NULL, 2, 'نه ', 1, '2024-10-04 02:10:59', '2024-10-04 02:10:59'),
(9, 4, 5, NULL, 'کامنت کامنت کامنت', 1, '2024-10-04 02:32:08', '2024-10-04 02:32:08'),
(10, 4, 12, NULL, 'عجیبه', 1, '2024-10-04 04:56:57', '2024-10-04 04:56:57');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL,
  `image` text DEFAULT NULL,
  `view` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `title`, `body`, `status`, `user_id`, `image`, `view`, `created_at`, `updated_at`) VALUES
(1, 'چطور میتوان؟', 'واقعا چه جوری میشه که؟؟؟؟', 0, 4, NULL, 359, '2024-09-16 01:05:40', '2024-10-05 03:35:38'),
(2, '55سلام من یک سوال', '000برنامه نویسی جاوا اسکریپت یا برنامه نویسی با پایتون؟؟', 2, 1, NULL, 332, '2024-09-16 01:06:38', '2024-10-05 03:24:56'),
(4, 'php question', 'php php php php', 0, 1, NULL, 24, '2024-09-17 02:54:37', '2024-10-04 03:07:35'),
(5, 'html5', 'html now or old?', 0, 1, 'public/images/2024-09-24-18-09-52-cd9157e4b37c5cf3.jpg', 70, '2024-09-17 15:53:04', '2024-10-05 03:34:39'),
(7, 'First rule of fight club?', ':)', 0, 1, 'public/images/2024-09-17-19-09-32-9184694f9715e47b.jpg', 51, '2024-09-17 21:05:32', '2024-10-05 02:38:02'),
(12, 'سوال تستی 8000', 'سلام من میخواهم بدانم', 0, 4, 'public/images/2024-10-04-23-10-37-fe2425eded79fcd4.jpg', 20, '2024-10-04 04:56:26', '2024-10-05 03:35:36');

-- --------------------------------------------------------

--
-- Table structure for table `question_images`
--

CREATE TABLE `question_images` (
  `id` int(11) NOT NULL,
  `image` text NOT NULL,
  `question_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `question_images`
--

INSERT INTO `question_images` (`id`, `image`, `question_id`, `created_at`, `updated_at`) VALUES
(5, 'public/question-images/2024-09-19-17-09-45-6a9405b3323f8c8b.jpg', 5, '2024-09-17 23:22:36', '2024-09-19 19:17:45'),
(6, 'public/question-images/2024-09-17-22-09-53-64d2f7c30f3519b3.png', 2, '2024-09-18 00:09:53', '2024-09-24 20:03:56'),
(8, 'public/question-images/2024-09-24-18-09-22-50eb106a13208a2a.jpg', 2, '2024-09-24 20:04:22', '2024-09-24 20:04:22');

-- --------------------------------------------------------

--
-- Table structure for table `question_tag`
--

CREATE TABLE `question_tag` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `question_tag`
--

INSERT INTO `question_tag` (`id`, `question_id`, `tag_id`, `created_at`, `updated_at`) VALUES
(5, 4, 2, '2024-09-17 04:03:30', '2024-09-17 04:03:30'),
(6, 4, 4, '2024-09-17 04:03:30', '2024-09-17 04:03:30'),
(20, 7, 4, '2024-09-17 21:05:32', '2024-09-17 21:05:32'),
(29, 5, 1, '2024-09-24 19:54:52', '2024-09-24 19:54:52'),
(31, 1, 1, '2024-09-25 18:30:43', '2024-09-25 18:30:43'),
(32, 1, 3, '2024-09-25 18:30:43', '2024-09-25 18:30:43'),
(33, 4, 4, '2024-10-02 00:16:16', '2024-10-02 00:16:16'),
(41, 12, 1, '2024-10-05 03:35:36', '2024-10-05 03:35:36'),
(42, 12, 3, '2024-10-05 03:35:36', '2024-10-05 03:35:36');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'html', 0, '2024-09-17 01:35:20', '2024-09-17 01:35:20'),
(2, 'php', 0, '2024-09-17 01:35:20', '2024-09-17 01:35:20'),
(3, 'js', 0, '2024-09-17 01:35:36', '2024-09-17 01:35:36'),
(4, 'laravel', 0, '2024-09-17 01:35:36', '2024-09-24 16:52:11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `type` tinyint(4) NOT NULL DEFAULT 0,
  `verify_token` text DEFAULT NULL,
  `forget_token` text DEFAULT NULL,
  `forget_token_expire` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `status`, `type`, `verify_token`, `forget_token`, `forget_token_expire`, `created_at`, `updated_at`) VALUES
(1, 'Hassan', 'test@test.com', '$2y$10$5mUsQQoZB9ineDsTp9JEE.Jud7TKcycPpzvwAZeoniNq8.mPgGpny', 1, 1, NULL, NULL, NULL, '2024-09-16 01:05:00', '2024-09-19 19:18:31'),
(2, 'emad', 'EMAD@EMAD.COM', '12345678', 0, 0, NULL, NULL, NULL, '2024-09-19 19:07:17', '2024-09-24 16:56:18'),
(4, 'emad2', 'emad.doc0019@gmail.com', '$2y$10$Mn4HcUaeYvBsroBkA2P2PeLS87mM0Z/HG3dxAf69AFnq3o5yx8FGu', 1, 0, 'd3ea91b1ea9642c66f3efea146937e0b682e3b07d46da48bb3ae36dffe39096c', '322e57704e76d3f63ba18fb77e0b94f58e1cbecbde53641456238c5e43d2e275', '2024-09-24 21:12:35', '2024-09-22 00:33:50', '2024-09-24 21:08:11');

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `question_id` int(11) DEFAULT NULL,
  `answer_id` int(11) DEFAULT NULL,
  `type` tinyint(4) NOT NULL COMMENT '0 => up\r\n1 => down',
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`id`, `user_id`, `question_id`, `answer_id`, `type`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 2, NULL, 1, 0, '2024-09-28 00:06:47', '2024-09-28 00:06:47'),
(4, 1, 7, NULL, 1, 0, '2024-09-28 00:08:05', '2024-09-28 00:08:05'),
(10, 2, 2, NULL, 0, 0, '2024-09-28 02:02:01', '2024-09-28 02:02:01'),
(12, 2, NULL, 5, 1, 0, '2024-09-29 18:47:34', '2024-09-29 18:47:34'),
(76, 1, NULL, 2, 0, 0, '2024-10-03 22:05:16', '2024-10-03 22:05:16'),
(81, 1, NULL, 5, 1, 0, '2024-10-03 22:07:05', '2024-10-03 22:07:05'),
(150, 4, 7, NULL, 1, 0, '2024-10-04 01:25:18', '2024-10-04 01:25:18'),
(177, 4, 2, NULL, 0, 0, '2024-10-04 01:45:54', '2024-10-04 01:45:54'),
(180, 4, 4, NULL, 0, 0, '2024-10-04 01:46:13', '2024-10-04 01:46:13'),
(183, 4, 5, NULL, 0, 0, '2024-10-04 02:32:46', '2024-10-04 02:32:46'),
(186, 4, 12, NULL, 0, 0, '2024-10-05 01:11:56', '2024-10-05 01:11:56'),
(189, 4, NULL, 5, 1, 0, '2024-10-05 01:21:04', '2024-10-05 01:21:04'),
(191, 1, 2, NULL, 0, 0, '2024-10-05 03:24:29', '2024-10-05 03:24:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_answer` (`user_id`),
  ADD KEY `question_id_answer` (`question_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_comments` (`user_id`),
  ADD KEY `question_id_commetns` (`question_id`),
  ADD KEY `answers_id_comments` (`answer_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_question` (`user_id`);

--
-- Indexes for table `question_images`
--
ALTER TABLE `question_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id_question_images` (`question_id`);

--
-- Indexes for table `question_tag`
--
ALTER TABLE `question_tag`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id_tag` (`question_id`),
  ADD KEY `tag_id_question` (`tag_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_vote` (`user_id`),
  ADD KEY `question_id_vote` (`question_id`),
  ADD KEY `answer_id_vote` (`answer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `question_images`
--
ALTER TABLE `question_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `question_tag`
--
ALTER TABLE `question_tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=197;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `question_id_answer` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id_answer` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `answers_id_comments` FOREIGN KEY (`answer_id`) REFERENCES `answers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `question_id_commetns` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id_comments` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `user_id_question` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `question_images`
--
ALTER TABLE `question_images`
  ADD CONSTRAINT `question_id_question_images` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `question_tag`
--
ALTER TABLE `question_tag`
  ADD CONSTRAINT `question_id_tag` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tag_id_question` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `answer_id_vote` FOREIGN KEY (`answer_id`) REFERENCES `answers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `question_id_vote` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id_vote` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
