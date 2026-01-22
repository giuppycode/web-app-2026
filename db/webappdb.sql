-- GENERATED SQL DUMP
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- DROP EXISTING TABLES
DROP TABLE IF EXISTS project_applications;
DROP TABLE IF EXISTS project_members;
DROP TABLE IF EXISTS project_news;
DROP TABLE IF EXISTS project_roles;
DROP TABLE IF EXISTS project_stars;
DROP TABLE IF EXISTS project_tags;
DROP TABLE IF EXISTS user_tags;
DROP TABLE IF EXISTS projects;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS tags;

-- CREATE TABLES

CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(50) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `faculty` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL UNIQUE,
  `email` varchar(100) NOT NULL UNIQUE,
  `number` varchar(15) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL,
  `biography` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(100) NOT NULL,
  `intro` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `total_slots` int(11) NOT NULL DEFAULT 1,
  `occupied_slots` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `project_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `project_id` int(11) NOT NULL,
  `role_name` varchar(100) NOT NULL,
  FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `project_members` (
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `membership_type` enum('founder','member') DEFAULT 'member',
  `role_id` int(11) DEFAULT NULL,
  `joined_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`project_id`,`user_id`),
  FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (role_id) REFERENCES project_roles(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `project_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `project_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
  FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `project_stars` (
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`project_id`),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `project_tags` (
  `project_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`project_id`,`tag_id`),
  FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
  FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `user_tags` (
  `user_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`tag_id`),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `project_applications` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `status` enum('pending','accepted','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (role_id) REFERENCES project_roles(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- INSERT DATA

INSERT INTO `tags` (`name`) VALUES 
('Web Development'),
('AI'),
('Cybersecurity'),
('Game Dev'),
('Data Science'),
('Mobile'),
('DevOps'),
('UI/UX'),
('Cloud'),
('Blockchain'),
('IoT'),
('Fintech');

INSERT INTO `users` (`firstname`, `lastname`, `faculty`, `username`, `email`, `number`, `password`, `biography`) VALUES 
('Alice', 'Smith', 'Informatica', 'alice', 'alice@test.com', '3331238349', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Frontend dev'),
('Bob', 'Johnson', 'Ingegneria', 'bob', 'bob@test.com', '3337444753', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Backend dev'),
('Carol', 'Williams', 'Data Science', 'carol', 'carol@test.com', '3334843234', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'AI enthusiast'),
('Dave', 'Brown', 'DevOps', 'dave', 'dave@test.com', '3332413407', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Cloud expert'),
('Eva', 'Davis', 'Design', 'eva', 'eva@test.com', '3333747140', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'UI/UX Designer'),
('Patricia', 'Rodriguez', 'Psicologia', 'patricia.rodriguez0', 'patricia.rodriguez0@test.com', '3337600904', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Psicologia, interested in tech.'),
('William', 'Garcia', 'Matematica', 'william.garcia1', 'william.garcia1@test.com', '3333245855', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Matematica, interested in tech.'),
('William', 'Martin', 'Psicologia', 'william.martin2', 'william.martin2@test.com', '3331704431', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Psicologia, interested in tech.'),
('Elizabeth', 'Martinez', 'Lettere', 'elizabeth.martinez3', 'elizabeth.martinez3@test.com', '3334335001', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Lettere, interested in tech.'),
('Susan', 'Lee', 'Fisica', 'susan.lee4', 'susan.lee4@test.com', '3336713963', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Fisica, interested in tech.'),
('Joseph', 'Moore', 'Design', 'joseph.moore5', 'joseph.moore5@test.com', '3333155236', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Design, interested in tech.'),
('Michael', 'Jackson', 'Fisica', 'michael.jackson6', 'michael.jackson6@test.com', '3334148279', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Fisica, interested in tech.'),
('Joseph', 'Hernandez', 'Lettere', 'joseph.hernandez7', 'joseph.hernandez7@test.com', '3339218093', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Lettere, interested in tech.'),
('Michael', 'Hernandez', 'Informatica', 'michael.hernandez8', 'michael.hernandez8@test.com', '3339956337', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Informatica, interested in tech.'),
('John', 'White', 'Ingegneria', 'john.white9', 'john.white9@test.com', '3337808500', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Ingegneria, interested in tech.'),
('Michael', 'Anderson', 'Informatica', 'michael.anderson10', 'michael.anderson10@test.com', '3336909786', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Informatica, interested in tech.'),
('Michael', 'Davis', 'Informatica', 'michael.davis11', 'michael.davis11@test.com', '3332666606', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Informatica, interested in tech.'),
('Charles', 'Lopez', 'Economia', 'charles.lopez12', 'charles.lopez12@test.com', '3339805448', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Economia, interested in tech.'),
('Joseph', 'Perez', 'Matematica', 'joseph.perez13', 'joseph.perez13@test.com', '3331181450', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Matematica, interested in tech.'),
('John', 'Garcia', 'Matematica', 'john.garcia14', 'john.garcia14@test.com', '3335886970', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Matematica, interested in tech.'),
('Karen', 'Martin', 'Lettere', 'karen.martin15', 'karen.martin15@test.com', '3338972511', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Lettere, interested in tech.'),
('Elizabeth', 'Moore', 'Design', 'elizabeth.moore16', 'elizabeth.moore16@test.com', '3333537232', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Design, interested in tech.'),
('Jessica', 'Davis', 'Economia', 'jessica.davis17', 'jessica.davis17@test.com', '3336138957', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Economia, interested in tech.'),
('James', 'Gonzalez', 'Fisica', 'james.gonzalez18', 'james.gonzalez18@test.com', '3338714525', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Fisica, interested in tech.'),
('James', 'Hernandez', 'Statistica', 'james.hernandez19', 'james.hernandez19@test.com', '3333100870', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Statistica, interested in tech.'),
('Michael', 'Wilson', 'Informatica', 'michael.wilson20', 'michael.wilson20@test.com', '3333825859', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Informatica, interested in tech.'),
('Patricia', 'Lopez', 'Psicologia', 'patricia.lopez21', 'patricia.lopez21@test.com', '3332955593', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Psicologia, interested in tech.'),
('James', 'Perez', 'Informatica', 'james.perez22', 'james.perez22@test.com', '3334072422', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Informatica, interested in tech.'),
('James', 'Hernandez', 'Fisica', 'james.hernandez23', 'james.hernandez23@test.com', '3331406916', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Fisica, interested in tech.'),
('Linda', 'White', 'Biologia', 'linda.white24', 'linda.white24@test.com', '3339741144', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Biologia, interested in tech.'),
('Michael', 'Lopez', 'Statistica', 'michael.lopez25', 'michael.lopez25@test.com', '3339435423', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Statistica, interested in tech.'),
('Barbara', 'Miller', 'Statistica', 'barbara.miller26', 'barbara.miller26@test.com', '3332830949', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Statistica, interested in tech.'),
('James', 'Taylor', 'Fisica', 'james.taylor27', 'james.taylor27@test.com', '3335167403', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Fisica, interested in tech.'),
('Robert', 'Moore', 'Design', 'robert.moore28', 'robert.moore28@test.com', '3337688616', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Design, interested in tech.'),
('Barbara', 'Lopez', 'Biologia', 'barbara.lopez29', 'barbara.lopez29@test.com', '3331645317', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Biologia, interested in tech.'),
('Elizabeth', 'Thomas', 'Ingegneria', 'elizabeth.thomas30', 'elizabeth.thomas30@test.com', '3336173821', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Ingegneria, interested in tech.'),
('Karen', 'White', 'Design', 'karen.white31', 'karen.white31@test.com', '3333968798', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Design, interested in tech.'),
('William', 'Hernandez', 'Biologia', 'william.hernandez32', 'william.hernandez32@test.com', '3337655938', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Biologia, interested in tech.'),
('Karen', 'Martinez', 'Design', 'karen.martinez33', 'karen.martinez33@test.com', '3338306754', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Design, interested in tech.'),
('William', 'Perez', 'Psicologia', 'william.perez34', 'william.perez34@test.com', '3334077889', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Psicologia, interested in tech.'),
('Thomas', 'Harris', 'Fisica', 'thomas.harris35', 'thomas.harris35@test.com', '3332803894', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Fisica, interested in tech.'),
('Elizabeth', 'Miller', 'Matematica', 'elizabeth.miller36', 'elizabeth.miller36@test.com', '3338017176', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Matematica, interested in tech.'),
('Jessica', 'White', 'Statistica', 'jessica.white37', 'jessica.white37@test.com', '3335245477', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Statistica, interested in tech.'),
('Michael', 'Lopez', 'Biologia', 'michael.lopez38', 'michael.lopez38@test.com', '3331403390', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Biologia, interested in tech.'),
('Sarah', 'Miller', 'Economia', 'sarah.miller39', 'sarah.miller39@test.com', '3336177160', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Economia, interested in tech.'),
('John', 'Martin', 'Design', 'john.martin40', 'john.martin40@test.com', '3335288394', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Design, interested in tech.'),
('Karen', 'White', 'Biologia', 'karen.white41', 'karen.white41@test.com', '3334654767', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Biologia, interested in tech.'),
('Karen', 'Thomas', 'Informatica', 'karen.thomas42', 'karen.thomas42@test.com', '3336503476', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Informatica, interested in tech.'),
('Joseph', 'Martinez', 'Matematica', 'joseph.martinez43', 'joseph.martinez43@test.com', '3333072754', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Matematica, interested in tech.'),
('Mary', 'Moore', 'Psicologia', 'mary.moore44', 'mary.moore44@test.com', '3339668692', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Student of Psicologia, interested in tech.');

INSERT INTO `projects` (`name`, `intro`, `description`, `image_url`, `total_slots`, `occupied_slots`) VALUES 
('CollabLearn', 'Study platform', 'A platform for collaborative learning.', 'https://picsum.photos/400/200?1', 5, 1),
('SmartBudget', 'Finance app', 'Track expenses with AI.', 'https://picsum.photos/400/200?2', 4, 1),
('SecureCloud', 'Security tool', 'Cloud vulnerability scanner.', 'https://picsum.photos/400/200?3', 6, 1),
('IndieQuest', 'RPG Game', 'Indie RPG game development.', 'https://picsum.photos/400/200?4', 5, 1),
('EcoTrack', 'Green app', 'Track carbon footprint.', 'https://picsum.photos/400/200?5', 5, 1),
('CryptoDash', 'Crypto tool', 'Realtime crypto dashboard.', 'https://picsum.photos/400/200?6', 3, 1),
('UniEat', 'Social food', 'Find lunch buddies.', 'https://picsum.photos/400/200?7', 6, 1),
('RoboArm', 'Robotics', '3D printed robot arm.', 'https://picsum.photos/400/200?8', 4, 1),
('MusicMatch', 'Music social', 'Tinder for musicians.', 'https://picsum.photos/400/200?9', 4, 1),
('VR Museum', 'Virtual Reality', 'Visit museums from home.', 'https://picsum.photos/400/200?10', 8, 1),
('HealthPlus', 'Health app', 'Monitor vital signs.', 'https://picsum.photos/400/200?11', 5, 1),
('EduGame', 'Educational Game', 'Learn math playing.', 'https://picsum.photos/400/200?12', 4, 1),
('AutoHome', 'IoT Home', 'Home automation system.', 'https://picsum.photos/400/200?13', 5, 1),
('MarketPlace', 'Local market', 'Buy and sell locally.', 'https://picsum.photos/400/200?14', 6, 1),
('TravelBuddy', 'Travel app', 'Find travel companions.', 'https://picsum.photos/400/200?15', 4, 1);

INSERT INTO `project_roles` (`project_id`, `role_name`) VALUES 
(1, 'Analyst'),
(1, 'Frontend Dev'),
(1, 'Designer'),
(1, 'Manager'),
(2, 'Designer'),
(2, 'Manager'),
(2, 'Backend Dev'),
(3, 'Manager'),
(3, 'Designer'),
(3, 'Frontend Dev'),
(3, 'Analyst'),
(4, 'Analyst'),
(4, 'Frontend Dev'),
(5, 'Manager'),
(5, 'Backend Dev'),
(5, 'Designer'),
(6, 'Manager'),
(6, 'Designer'),
(7, 'Designer'),
(7, 'Frontend Dev'),
(7, 'Backend Dev'),
(8, 'Analyst'),
(8, 'Designer'),
(8, 'Manager'),
(8, 'Backend Dev'),
(9, 'Backend Dev'),
(9, 'Designer'),
(9, 'Manager'),
(10, 'Analyst'),
(10, 'Designer'),
(11, 'Designer'),
(11, 'Backend Dev'),
(11, 'Manager'),
(12, 'Frontend Dev'),
(12, 'Manager'),
(13, 'Manager'),
(13, 'Analyst'),
(13, 'Designer'),
(14, 'Manager'),
(14, 'Backend Dev'),
(14, 'Analyst'),
(14, 'Frontend Dev'),
(15, 'Frontend Dev'),
(15, 'Backend Dev'),
(15, 'Designer');

INSERT INTO `project_members` (`project_id`, `user_id`, `membership_type`, `role_id`) VALUES 
(1, 1, 'founder', NULL),
(1, 15, 'member', 2),
(1, 5, 'member', 4),
(1, 20, 'member', 2),
(2, 20, 'founder', NULL),
(2, 7, 'member', 7),
(2, 47, 'member', 5),
(3, 35, 'founder', NULL),
(3, 36, 'member', 10),
(3, 17, 'member', 8),
(3, 21, 'member', 8),
(3, 42, 'member', 10),
(3, 32, 'member', 11),
(4, 37, 'founder', NULL),
(5, 36, 'founder', NULL),
(5, 23, 'member', 16),
(6, 43, 'founder', NULL),
(6, 50, 'member', 18),
(7, 31, 'founder', NULL),
(7, 9, 'member', 20),
(7, 49, 'member', 19),
(7, 35, 'member', 19),
(8, 44, 'founder', NULL),
(8, 13, 'member', 23),
(8, 18, 'member', 23),
(9, 10, 'founder', NULL),
(9, 46, 'member', 26),
(10, 33, 'founder', NULL),
(10, 24, 'member', 29),
(10, 15, 'member', 29),
(11, 25, 'founder', NULL),
(11, 35, 'member', 31),
(11, 20, 'member', 31),
(11, 46, 'member', 32),
(12, 34, 'founder', NULL),
(12, 10, 'member', 34),
(12, 1, 'member', 35),
(13, 36, 'founder', NULL),
(14, 38, 'founder', NULL),
(14, 6, 'member', 42),
(14, 18, 'member', 39),
(14, 5, 'member', 42),
(14, 44, 'member', 39),
(14, 34, 'member', 41),
(15, 3, 'founder', NULL),
(15, 18, 'member', 43),
(15, 38, 'member', 44);

INSERT INTO `project_tags` (`project_id`, `tag_id`) VALUES 
(1, 5),
(1, 9),
(1, 4),
(2, 10),
(2, 9),
(3, 11),
(3, 2),
(4, 6),
(4, 5),
(5, 6),
(6, 7),
(6, 9),
(6, 6),
(7, 6),
(8, 2),
(8, 8),
(8, 1),
(9, 1),
(9, 10),
(9, 4),
(10, 9),
(10, 6),
(11, 10),
(11, 4),
(11, 1),
(12, 5),
(12, 3),
(12, 8),
(13, 1),
(14, 9),
(14, 2),
(15, 6),
(15, 1),
(15, 2);

INSERT INTO `project_news` (`project_id`, `author_id`, `description`, `image_url`) VALUES 
(1, 1, 'Project started!', NULL),
(3, 35, 'Project started!', NULL),
(5, 36, 'Project started!', NULL),
(8, 44, 'Project started!', NULL),
(9, 10, 'Project started!', NULL),
(10, 33, 'Project started!', NULL),
(10, 33, 'First milestone reached.', NULL),
(11, 25, 'Project started!', NULL),
(12, 34, 'Project started!', NULL),
(13, 36, 'Project started!', NULL),
(13, 36, 'First milestone reached.', NULL),
(14, 38, 'Project started!', NULL),
(15, 3, 'Project started!', NULL);

INSERT INTO `user_tags` (`user_id`, `tag_id`) VALUES 
(1, 11),
(2, 1),
(3, 10),
(3, 2),
(3, 4),
(4, 12),
(4, 6),
(4, 1),
(5, 7),
(6, 12),
(6, 1),
(6, 2),
(6, 7),
(7, 5),
(7, 11),
(8, 2),
(8, 12),
(8, 10),
(8, 11),
(9, 4),
(9, 9),
(9, 2),
(9, 3),
(10, 3),
(10, 12),
(10, 9),
(10, 8),
(11, 9),
(11, 2),
(11, 11),
(12, 6),
(13, 5),
(13, 2),
(13, 12),
(14, 10),
(14, 1),
(14, 3),
(14, 8),
(15, 10),
(15, 7),
(16, 12),
(17, 3),
(17, 9),
(17, 7),
(17, 10),
(18, 12),
(18, 10),
(19, 5),
(19, 9),
(19, 12),
(20, 10),
(20, 8),
(20, 12),
(21, 4),
(21, 11),
(22, 6),
(22, 1),
(23, 2),
(23, 5),
(23, 9),
(24, 4),
(24, 9),
(24, 7),
(24, 5),
(25, 11),
(25, 1),
(25, 5),
(26, 8),
(26, 7),
(26, 2),
(27, 3),
(27, 5),
(28, 2),
(28, 6),
(28, 7),
(28, 12),
(29, 12),
(29, 11),
(30, 5),
(31, 8),
(31, 10),
(31, 1),
(32, 8),
(33, 7),
(33, 3),
(34, 5),
(34, 10),
(35, 9),
(36, 1),
(36, 2),
(37, 2),
(37, 6),
(38, 6),
(38, 12),
(38, 2),
(39, 12),
(39, 4),
(39, 6),
(40, 3),
(40, 5),
(41, 1),
(41, 4),
(41, 10),
(42, 12),
(43, 7),
(43, 1),
(43, 12),
(44, 7),
(45, 9),
(45, 11),
(46, 4),
(46, 12),
(46, 3),
(47, 3),
(47, 5),
(48, 4),
(49, 7),
(50, 3),
(50, 4);

INSERT INTO `project_stars` (`user_id`, `project_id`) VALUES 
(3, 10),
(4, 14),
(12, 1),
(15, 7),
(18, 8),
(21, 9),
(23, 14),
(25, 7),
(28, 5),
(30, 8),
(31, 6),
(36, 7),
(43, 2),
(44, 6),
(46, 1),
(48, 6);

INSERT INTO `project_applications` (`project_id`, `user_id`, `role_id`, `status`) VALUES 
(1, 42, 3, 'pending'),
(3, 14, 11, 'pending'),
(4, 47, 12, 'pending'),
(7, 18, 20, 'pending'),
(8, 42, 22, 'pending'),
(10, 8, 29, 'pending'),
(12, 42, 34, 'pending');

COMMIT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

