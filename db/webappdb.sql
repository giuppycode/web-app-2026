-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 18, 2026 at 06:34 PM
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
-- Database: `webappdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `intro` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `total_slots` int(11) NOT NULL DEFAULT 1,
  `occupied_slots` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `intro`, `description`, `image_url`, `total_slots`, `occupied_slots`, `created_at`) VALUES
(1, 'CollabLearn', 'Piattaforma di studio collaborativo', 'Web app per studenti che vogliono studiare insieme e condividere risorse.', 'https://picsum.photos/400/200?1', 5, 3, '2026-01-17 14:32:46'),
(2, 'SmartBudget', 'Gestione spese intelligente', 'App per il tracciamento automatico delle spese con AI.', 'https://picsum.photos/400/200?2', 4, 2, '2026-01-17 14:32:46'),
(3, 'SecureCloud', 'Monitoraggio sicurezza cloud', 'Dashboard per il monitoraggio di vulnerabilità su infrastrutture cloud.', 'https://picsum.photos/400/200?3', 6, 4, '2026-01-17 14:32:46'),
(4, 'IndieQuest', 'Gioco RPG indie', 'Gioco di ruolo sviluppato da team indie.', 'https://picsum.photos/400/200?4', 5, 2, '2026-01-17 14:32:46');

-- --------------------------------------------------------

--
-- Table structure for table `project_members`
--

CREATE TABLE `project_members` (
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `membership_type` enum('founder','member') DEFAULT 'member',
  `joined_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `project_members`
--

INSERT INTO `project_members` (`project_id`, `user_id`, `membership_type`, `joined_at`) VALUES
(1, 1, 'founder', '2026-01-17 14:32:46'),
(1, 2, 'member', '2026-01-17 14:32:46'),
(1, 5, 'member', '2026-01-17 14:32:46'),
(2, 2, 'member', '2026-01-17 14:32:46'),
(2, 3, 'founder', '2026-01-17 14:32:46'),
(3, 1, 'member', '2026-01-17 14:32:46'),
(3, 2, 'member', '2026-01-17 14:32:46'),
(3, 3, 'member', '2026-01-17 14:32:46'),
(3, 4, 'founder', '2026-01-17 14:32:46'),
(4, 1, 'member', '2026-01-17 14:32:46'),
(4, 5, 'founder', '2026-01-17 14:32:46');

-- --------------------------------------------------------

--
-- Table structure for table `project_news`
--

CREATE TABLE `project_news` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `project_news`
--

INSERT INTO `project_news` (`id`, `project_id`, `author_id`, `description`, `image_url`, `created_at`) VALUES
(1, 1, 1, 'Abbiamo pubblicato la prima versione della homepage!', NULL, '2026-01-17 14:32:46'),
(2, 1, 2, 'Implementata l’autenticazione JWT lato backend.', NULL, '2026-01-17 14:32:46'),
(3, 2, 3, 'Completato il primo modello di classificazione spese.', NULL, '2026-01-17 14:32:46'),
(4, 3, 4, 'Configurata pipeline CI/CD su ambiente cloud.', NULL, '2026-01-17 14:32:46'),
(5, 4, 5, 'Completato il primo prototipo di gameplay.', NULL, '2026-01-17 14:32:46');

-- --------------------------------------------------------

--
-- Table structure for table `project_roles`
--

CREATE TABLE `project_roles` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `role_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `project_roles`
--

INSERT INTO `project_roles` (`id`, `project_id`, `role_name`) VALUES
(1, 1, 'Frontend Developer'),
(2, 1, 'Backend Developer'),
(3, 1, 'UX Designer'),
(4, 2, 'Data Scientist'),
(5, 2, 'Mobile Developer'),
(6, 3, 'Security Engineer'),
(7, 3, 'DevOps Engineer'),
(8, 4, 'Game Developer'),
(9, 4, 'Level Designer');

-- --------------------------------------------------------

--
-- Table structure for table `project_stars`
--

CREATE TABLE `project_stars` (
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `project_stars`
--

INSERT INTO `project_stars` (`user_id`, `project_id`) VALUES
(2, 1),
(3, 1),
(3, 3),
(4, 2),
(5, 1),
(5, 3),
(6, 3),
(6, 4);

-- --------------------------------------------------------

--
-- Table structure for table `project_tags`
--

CREATE TABLE `project_tags` (
  `project_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `project_tags`
--

INSERT INTO `project_tags` (`project_id`, `tag_id`) VALUES
(1, 1),
(1, 8),
(2, 2),
(2, 5),
(3, 3),
(3, 7),
(4, 4),
(4, 8);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `name`) VALUES
(2, 'AI'),
(3, 'Cybersecurity'),
(5, 'Data Science'),
(7, 'DevOps'),
(4, 'Game Dev'),
(6, 'Mobile'),
(9, 'prova'),
(8, 'UI/UX'),
(1, 'Web Development');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `biography` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `biography`, `created_at`) VALUES
(1, 'alice', 'alice@test.com', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Frontend developer appassionata di UX', '2026-01-17 14:32:46'),
(2, 'bob', 'bob@test.com', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Backend developer PHP/MySQL', '2026-01-17 14:32:46'),
(3, 'carol', 'carol@test.com', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'AI engineer e data scientist', '2026-01-17 14:32:46'),
(4, 'dave', 'dave@test.com', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'DevOps e cloud engineer', '2026-01-17 14:32:46'),
(5, 'eva', 'eva@test.com', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Game designer', '2026-01-17 14:32:46'),
(6, 'provadb', 'probadb@studio.unibo.it', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'sono ghey', '2026-01-18 16:43:27');

-- --------------------------------------------------------

--
-- Table structure for table `user_tags`
--

CREATE TABLE `user_tags` (
  `user_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user_tags`
--

INSERT INTO `user_tags` (`user_id`, `tag_id`) VALUES
(1, 1),
(1, 8),
(2, 1),
(2, 7),
(3, 2),
(3, 5),
(4, 3),
(4, 7),
(5, 4),
(5, 8);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_members`
--
ALTER TABLE `project_members`
  ADD PRIMARY KEY (`project_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `project_news`
--
ALTER TABLE `project_news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `project_roles`
--
ALTER TABLE `project_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `project_stars`
--
ALTER TABLE `project_stars`
  ADD PRIMARY KEY (`user_id`,`project_id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `project_tags`
--
ALTER TABLE `project_tags`
  ADD PRIMARY KEY (`project_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_tags`
--
ALTER TABLE `user_tags`
  ADD PRIMARY KEY (`user_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `project_news`
--
ALTER TABLE `project_news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `project_roles`
--
ALTER TABLE `project_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `project_members`
--
ALTER TABLE `project_members`
  ADD CONSTRAINT `project_members_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `project_members_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `project_news`
--
ALTER TABLE `project_news`
  ADD CONSTRAINT `project_news_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `project_news_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `project_roles`
--
ALTER TABLE `project_roles`
  ADD CONSTRAINT `project_roles_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `project_stars`
--
ALTER TABLE `project_stars`
  ADD CONSTRAINT `project_stars_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `project_stars_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `project_tags`
--
ALTER TABLE `project_tags`
  ADD CONSTRAINT `project_tags_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `project_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_tags`
--
ALTER TABLE `user_tags`
  ADD CONSTRAINT `user_tags_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
