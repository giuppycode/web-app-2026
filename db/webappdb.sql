-- phpMyAdmin SQL Dump
-- version 5.2.1
-- Host: localhost
-- Generation Time: Jan 18, 2026 at 07:00 PM
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
(11, 'Blockchain'),
(10, 'Cloud'),
(3, 'Cybersecurity'),
(5, 'Data Science'),
(7, 'DevOps'),
(12, 'Fintech'),
(4, 'Game Dev'),
(13, 'IoT'),
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
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `faculty` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `biography` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `faculty`, `username`, `email`, `number`, `password`, `biography`, `created_at`) VALUES
(1, 'Alice', 'Smith', 'Informatica', 'alice', 'alice@test.com', '3331234567', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Frontend developer appassionata di UX e accessibilità.', '2026-01-17 14:32:46'),
(2, 'Bob', 'Johnson', 'Ingegneria Inf.', 'bob', 'bob@test.com', '3339876543', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Backend developer specializzato in PHP e architetture scalabili.', '2026-01-17 14:32:46'),
(3, 'Carol', 'Williams', 'Data Science', 'carol', 'carol@test.com', '3334567890', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'AI engineer, Python lover e data scientist.', '2026-01-17 14:32:46'),
(4, 'Dave', 'Brown', 'Informatica', 'dave', 'dave@test.com', '3331122334', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'DevOps e cloud engineer. Docker è la mia vita.', '2026-01-17 14:32:46'),
(5, 'Eva', 'Davis', 'DAMS', 'eva', 'eva@test.com', '3339988776', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Game designer e artista digitale.', '2026-01-17 14:32:46'),
(6, 'Mario', 'Rossi', 'Economia', 'provadb', 'probadb@studio.unibo.it', '3330000000', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Studente di economia interessato al fintech.', '2026-01-18 16:43:27'),
-- NUOVI UTENTI AGGIUNTI
(7, 'Luca', 'Bianchi', 'Informatica', 'luca.b', 'luca.b@test.com', '3331111111', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Appassionato di sicurezza informatica e reti.', '2026-01-18 17:00:00'),
(8, 'Giulia', 'Verdi', 'Design', 'giulia.v', 'giulia.v@test.com', '3332222222', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'UI Designer con focus sul minimalismo.', '2026-01-18 17:01:00'),
(9, 'Marco', 'Neri', 'Ingegneria Gest.', 'marco.n', 'marco.n@test.com', '3333333333', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Project manager in divenire.', '2026-01-18 17:02:00'),
(10, 'Sofia', 'Gialli', 'Matematica', 'sofia.g', 'sofia.g@test.com', '3334444444', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Crittografia e algoritmi complessi.', '2026-01-18 17:03:00'),
(11, 'Francesco', 'Blu', 'Fisica', 'fra.blu', 'fra.blu@test.com', '3335555555', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Simulazioni fisiche per videogiochi.', '2026-01-18 17:04:00'),
(12, 'Chiara', 'Rizzi', 'Lettere', 'chiara.r', 'chiara.r@test.com', '3336666666', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Copywriter e content creator.', '2026-01-18 17:05:00'),
(13, 'Alessandro', 'Ferrari', 'Informatica', 'alex.f', 'alex.f@test.com', '3337777777', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Full stack developer.', '2026-01-18 17:06:00'),
(14, 'Martina', 'Russo', 'Ingegneria Inf.', 'marty.r', 'marty.r@test.com', '3338888888', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Sviluppo Mobile Android/iOS.', '2026-01-18 17:07:00'),
(15, 'Davide', 'Esposito', 'Economia', 'dave.e', 'dave.e@test.com', '3339999999', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Blockchain e criptovalute.', '2026-01-18 17:08:00'),
(16, 'Sara', 'Conti', 'DAMS', 'sara.c', 'sara.c@test.com', '3331212121', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Video editor e 3D modeler.', '2026-01-18 17:09:00'),
(17, 'Matteo', 'Gallo', 'Informatica', 'matteo.g', 'matteo.g@test.com', '3331313131', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'System Administrator.', '2026-01-18 17:10:00'),
(18, 'Federica', 'Costa', 'Psicologia', 'fede.c', 'fede.c@test.com', '3331414141', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'UX Researcher specializzata in interazione uomo-macchina.', '2026-01-18 17:11:00'),
(19, 'Lorenzo', 'Giordano', 'Statistica', 'lorenzo.g', 'lorenzo.g@test.com', '3331515151', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Big Data Analyst.', '2026-01-18 17:12:00'),
(20, 'Valentina', 'Mancini', 'Design', 'vale.m', 'vale.m@test.com', '3331616161', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Graphic Designer e illustratrice.', '2026-01-18 17:13:00'),
(21, 'Andrea', 'Rizzo', 'Informatica', 'andrea.r', 'andrea.r@test.com', '3331717171', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Appassionato di IoT e domotica.', '2026-01-18 17:14:00'),
(22, 'Elisa', 'Lombardi', 'Biologia', 'elisa.l', 'elisa.l@test.com', '3331818181', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Bioinformatica.', '2026-01-18 17:15:00'),
(23, 'Giacomo', 'Moretti', 'Ingegneria Mecc.', 'jack.m', 'jack.m@test.com', '3331919191', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Robotica e automazione.', '2026-01-18 17:16:00'),
(24, 'Silvia', 'Barbieri', 'Lingue', 'silvia.b', 'silvia.b@test.com', '3332020202', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Traduzione e localizzazione software.', '2026-01-18 17:17:00'),
(25, 'Stefano', 'Fontana', 'Informatica', 'stefano.f', 'stefano.f@test.com', '3332121212', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Ethical Hacker.', '2026-01-18 17:18:00'),
(26, 'Beatrice', 'Santoro', 'Architettura', 'bea.s', 'bea.s@test.com', '3332323232', '$2y$10$TFsYhSQca0UUpEMkrKYwkeWUrjjZXvAu1LNmhRzLeFK.jYpwro.lu', 'Design di interfacce spaziali AR/VR.', '2026-01-18 17:19:00');

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
(4, 'IndieQuest', 'Gioco RPG indie', 'Gioco di ruolo sviluppato da team indie.', 'https://picsum.photos/400/200?4', 5, 2, '2026-01-17 14:32:46'),
-- NUOVI PROGETTI
(5, 'EcoTrack', 'Monitoraggio impronta ecologica', 'App mobile per calcolare e ridurre la propria impronta di carbonio giornaliera.', 'https://picsum.photos/400/200?5', 5, 3, '2026-01-18 17:30:00'),
(6, 'CryptoDash', 'Dashboard crypto realtime', 'Analisi in tempo reale delle criptovalute con previsioni ML.', 'https://picsum.photos/400/200?6', 4, 2, '2026-01-18 17:31:00'),
(7, 'UniEat', 'Social food per universitari', 'Trova compagni di pranzo in mensa o scambia ricette economiche.', 'https://picsum.photos/400/200?7', 6, 4, '2026-01-18 17:32:00'),
(8, 'RoboArm', 'Braccio robotico open source', 'Progetto hardware e software per un braccio robotico stampabile in 3D.', 'https://picsum.photos/400/200?8', 5, 2, '2026-01-18 17:33:00'),
(9, 'MusicMatch', 'Tinder per musicisti', 'Trova membri per la tua band basandoti sui gusti musicali.', 'https://picsum.photos/400/200?9', 4, 1, '2026-01-18 17:34:00'),
(10, 'VR Museum', 'Museo virtuale interattivo', 'Esperienza VR per visitare musei storici da casa.', 'https://picsum.photos/400/200?10', 8, 3, '2026-01-18 17:35:00');

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
(5, 4, 5, 'Completato il primo prototipo di gameplay.', NULL, '2026-01-17 14:32:46'),
(6, 5, 7, 'Definita la UI per la schermata principale.', NULL, '2026-01-18 18:00:00'),
(7, 5, 14, 'API per il calcolo CO2 pronta.', NULL, '2026-01-18 18:10:00'),
(8, 6, 15, 'Connessione WebSocket con Binance stabilita.', NULL, '2026-01-18 18:20:00'),
(9, 8, 23, 'Stampati i primi pezzi in 3D!', NULL, '2026-01-18 18:30:00'),
(10, 10, 26, 'Ambiente Unity configurato per VR.', NULL, '2026-01-18 18:40:00');

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
-- Table structure for table `project_applications`
--

CREATE TABLE project_applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    user_id INT NOT NULL,
    role_id INT NOT NULL,
    status ENUM('pending', 'accepted', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES project_roles(id) ON DELETE CASCADE
);

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
(9, 4, 'Level Designer'),
(10, 5, 'Sustainability Expert'),
(11, 5, 'Mobile Dev'),
(12, 6, 'Blockchain Dev'),
(13, 6, 'Data Analyst'),
(14, 7, 'Community Manager'),
(15, 8, 'Embedded Engineer'),
(16, 9, 'Marketing'),
(17, 10, '3D Artist');

-- --------------------------------------------------------

--
-- Table structure for table `project_members`
--

CREATE TABLE `project_members` (
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `membership_type` enum('founder','member') DEFAULT 'member',
  `role_id` int(11) DEFAULT NULL,
  `joined_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `project_members`
--

INSERT INTO `project_members` (`project_id`, `user_id`, `membership_type`, `role_id`, `joined_at`) VALUES
(1, 1, 'founder', NULL, '2026-01-17 14:32:46'),
(1, 2, 'member', 2, '2026-01-17 14:32:46'), -- Bob: Backend Dev
(1, 5, 'member', 3, '2026-01-17 14:32:46'), -- Eva: UX Designer
(2, 2, 'member', 5, '2026-01-17 14:32:46'), -- Bob: Mobile Dev
(2, 3, 'founder', NULL, '2026-01-17 14:32:46'),
(3, 1, 'member', 6, '2026-01-17 14:32:46'), -- Alice: Security Eng
(3, 2, 'member', 7, '2026-01-17 14:32:46'), -- Bob: DevOps
(3, 3, 'member', NULL, '2026-01-17 14:32:46'),
(3, 4, 'founder', NULL, '2026-01-17 14:32:46'),
(4, 1, 'member', 8, '2026-01-17 14:32:46'), -- Alice: Game Dev
(4, 5, 'founder', NULL, '2026-01-17 14:32:46'),
-- NUOVI MEMBRI
(5, 7, 'founder', NULL, '2026-01-18 17:30:00'), -- Luca B. founder EcoTrack
(5, 8, 'member', 11, '2026-01-18 17:30:05'), -- Giulia V: Mobile Dev
(5, 14, 'member', 10, '2026-01-18 17:30:10'), -- Martina R: Sustainability Expert
(6, 15, 'founder', NULL, '2026-01-18 17:31:00'), -- Davide E. founder CryptoDash
(6, 13, 'member', 12, '2026-01-18 17:31:05'), -- Alessandro F: Blockchain Dev
(7, 12, 'founder', NULL, '2026-01-18 17:32:00'), -- Chiara R. founder UniEat
(7, 1, 'member', 14, '2026-01-18 17:32:10'), -- Alice: Community Manager
(7, 2, 'member', NULL, '2026-01-18 17:32:15'),
(7, 20, 'member', NULL, '2026-01-18 17:32:20'),
(8, 23, 'founder', NULL, '2026-01-18 17:33:00'), -- Giacomo M. founder RoboArm
(8, 21, 'member', 15, '2026-01-18 17:33:05'), -- Andrea R: Embedded Eng
(9, 16, 'founder', NULL, '2026-01-18 17:34:00'), -- Sara C. founder MusicMatch
(10, 26, 'founder', NULL, '2026-01-18 17:35:00'), -- Beatrice S. founder VR Museum
(10, 5, 'member', 17, '2026-01-18 17:35:05'), -- Eva: 3D Artist
(10, 11, 'member', 9, '2026-01-18 17:35:10'); -- Francesco: Level Designer

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
(6, 4),
(7, 6),
(8, 5),
(10, 6),
(12, 1),
(15, 6),
(20, 10),
(22, 5),
(25, 3);

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
(4, 8),
(5, 6), -- EcoTrack: Mobile
(5, 8), -- EcoTrack: UI/UX
(6, 12), -- CryptoDash: Fintech
(6, 2),  -- CryptoDash: AI
(7, 6),  -- UniEat: Mobile
(8, 13), -- RoboArm: IoT
(9, 6),  -- MusicMatch: Mobile
(10, 4); -- VR Museum: Game Dev

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
(5, 8),
(7, 3), (7, 10), -- Luca B
(8, 8), (8, 1), -- Giulia V
(10, 5), (10, 2), -- Sofia G
(11, 4), -- Francesco B
(13, 1), (13, 10), -- Alessandro F
(14, 6), -- Martina R
(15, 11), (15, 12), -- Davide E
(16, 4), (16, 8), -- Sara C
(21, 13), -- Andrea R
(25, 3); -- Stefano F

--
-- Indexes for dumped tables
--

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `project_members`
--
ALTER TABLE `project_members`
  ADD PRIMARY KEY (`project_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `project_news`
--
ALTER TABLE `project_news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `project_roles`
--
ALTER TABLE `project_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--
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
-- Constraints for table `project_members`
--
ALTER TABLE `project_members`
  ADD CONSTRAINT `project_members_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `project_members_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;


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