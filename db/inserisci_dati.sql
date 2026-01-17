USE webappdb;

-- -----------------------------
-- TAGS
-- -----------------------------
INSERT INTO tags (name) VALUES
('Web Development'),
('AI'),
('Cybersecurity'),
('Game Dev'),
('Data Science'),
('Mobile'),
('DevOps'),
('UI/UX');

-- -----------------------------
-- USERS
-- password = "password" hashata con bcrypt (placeholder realistico)
-- -----------------------------
INSERT INTO users (username, email, password, biography) VALUES
('alice', 'alice@test.com', '$2y$10$abcdefghijklmnopqrstuv', 'Frontend developer appassionata di UX'),
('bob', 'bob@test.com', '$2y$10$abcdefghijklmnopqrstuv', 'Backend developer PHP/MySQL'),
('carol', 'carol@test.com', '$2y$10$abcdefghijklmnopqrstuv', 'AI engineer e data scientist'),
('dave', 'dave@test.com', '$2y$10$abcdefghijklmnopqrstuv', 'DevOps e cloud engineer'),
('eva', 'eva@test.com', '$2y$10$abcdefghijklmnopqrstuv', 'Game designer');

-- -----------------------------
-- USER_TAGS
-- -----------------------------
INSERT INTO user_tags (user_id, tag_id) VALUES
(1, 1), (1, 8),
(2, 1), (2, 7),
(3, 2), (3, 5),
(4, 7), (4, 3),
(5, 4), (5, 8);

-- -----------------------------
-- PROJECTS
-- -----------------------------
INSERT INTO projects (name, intro, description, image_url, total_slots, occupied_slots) VALUES
('CollabLearn', 'Piattaforma di studio collaborativo', 'Web app per studenti che vogliono studiare insieme e condividere risorse.', 'https://picsum.photos/400/200?1', 5, 3),
('SmartBudget', 'Gestione spese intelligente', 'App per il tracciamento automatico delle spese con AI.', 'https://picsum.photos/400/200?2', 4, 2),
('SecureCloud', 'Monitoraggio sicurezza cloud', 'Dashboard per il monitoraggio di vulnerabilità su infrastrutture cloud.', 'https://picsum.photos/400/200?3', 6, 4),
('IndieQuest', 'Gioco RPG indie', 'Gioco di ruolo sviluppato da team indie.', 'https://picsum.photos/400/200?4', 5, 2);

-- -----------------------------
-- PROJECT_TAGS
-- -----------------------------
INSERT INTO project_tags (project_id, tag_id) VALUES
(1, 1), (1, 8),
(2, 2), (2, 5),
(3, 3), (3, 7),
(4, 4), (4, 8);

-- -----------------------------
-- PROJECT_ROLES
-- -----------------------------
INSERT INTO project_roles (project_id, role_name) VALUES
(1, 'Frontend Developer'),
(1, 'Backend Developer'),
(1, 'UX Designer'),
(2, 'Data Scientist'),
(2, 'Mobile Developer'),
(3, 'Security Engineer'),
(3, 'DevOps Engineer'),
(4, 'Game Developer'),
(4, 'Level Designer');

-- -----------------------------
-- PROJECT_MEMBERS
-- -----------------------------
INSERT INTO project_members (project_id, user_id, membership_type) VALUES
(1, 1, 'founder'),
(1, 2, 'member'),
(1, 5, 'member'),

(2, 3, 'founder'),
(2, 2, 'member'),

(3, 4, 'founder'),
(3, 2, 'member'),
(3, 3, 'member'),
(3, 1, 'member'),

(4, 5, 'founder'),
(4, 1, 'member');

-- -----------------------------
-- PROJECT_STARS
-- -----------------------------
INSERT INTO project_stars (user_id, project_id) VALUES
(1, 2),
(1, 4),
(2, 1),
(3, 1),
(3, 3),
(4, 2),
(5, 1),
(5, 3);

-- -----------------------------
-- PROJECT_NEWS
-- -----------------------------
INSERT INTO project_news (project_id, author_id, description, image_url) VALUES
(1, 1, 'Abbiamo pubblicato la prima versione della homepage!', NULL),
(1, 2, 'Implementata l’autenticazione JWT lato backend.', NULL),
(2, 3, 'Completato il primo modello di classificazione spese.', NULL),
(3, 4, 'Configurata pipeline CI/CD su ambiente cloud.', NULL),
(4, 5, 'Completato il primo prototipo di gameplay.', NULL);
