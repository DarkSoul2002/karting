-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2021 at 06:07 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `karting`
--

-- --------------------------------------------------------

--
-- Table structure for table `activiteiten`
--

CREATE TABLE `activiteiten` (
  `id` int(11) NOT NULL,
  `soort_id` int(11) DEFAULT NULL,
  `datum` date NOT NULL,
  `tijd` time NOT NULL,
  `max_deelnemers` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activiteiten`
--

INSERT INTO `activiteiten` (`id`, `soort_id`, `datum`, `tijd`, `max_deelnemers`) VALUES
(4, 1, '2021-05-27', '07:30:00', 1),
(5, 1, '2022-05-27', '06:30:00', 1),
(6, 3, '2023-05-27', '07:30:00', 10);

-- --------------------------------------------------------

--
-- Table structure for table `app_users`
--

CREATE TABLE `app_users` (
  `id` int(11) NOT NULL,
  `username` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `voorletters` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tussenvoegsel` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `achternaam` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adres` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postcode` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `woonplaats` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefoon` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `app_users`
--

INSERT INTO `app_users` (`id`, `username`, `password`, `email`, `roles`, `voorletters`, `tussenvoegsel`, `achternaam`, `adres`, `postcode`, `woonplaats`, `telefoon`) VALUES
(1, 'Dayton', '$argon2id$v=19$m=65536,t=4,p=1$WmdNSjN4L2N2Li9uaHVMYQ$Fj0W37VMYjJCBgreQxMS+lGQOL55Cz1V7LUQ3vjckG4', 'dayton@email.com', '[\"ROLE_ADMIN\"]', 'D B', NULL, 'Boone', 'De Brink 1016', '2553HX', 'Den Haag', '0644221558'),
(2, 'User', '$argon2id$v=19$m=65536,t=4,p=1$VFJBZ3k2dEpKVC9pQTBpbQ$tQSBOG8sXLtmUFuh/VTTLnnhRPoHv/YfJ4Qc4E1RTTY', 'user@email.com', '[\"ROLE_USER\"]', 'U', NULL, 'U', 'user 1', 'USER 11', 'Den Haag', '06123'),
(3, 'User2', '$argon2id$v=19$m=65536,t=4,p=1$OU9YenFORExqUkdGWjFDSQ$0oXGf5vyrLVb5qz1B0QNlJEJ8/X6rRyFSF28PODg4Lo', 'user2@mail.com', '[\"ROLE_USER\"]', 'u', 's', 'er', 'user 10', 'user11', 'Den Haag', '061234567');

-- --------------------------------------------------------

--
-- Table structure for table `deelnames`
--

CREATE TABLE `deelnames` (
  `user_id` int(11) NOT NULL,
  `activiteit_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deelnames`
--

INSERT INTO `deelnames` (`user_id`, `activiteit_id`) VALUES
(2, 5),
(3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20210311105627', '2021-03-11 11:56:56', 98),
('DoctrineMigrations\\Version20210405194053', '2021-04-05 21:41:12', 60),
('DoctrineMigrations\\Version20210408075337', '2021-04-08 09:53:55', 73);

-- --------------------------------------------------------

--
-- Table structure for table `soortactiviteiten`
--

CREATE TABLE `soortactiviteiten` (
  `id` int(11) NOT NULL,
  `naam` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `min_leeftijd` int(11) NOT NULL,
  `tijdsduur` int(11) NOT NULL,
  `prijs` decimal(6,2) NOT NULL,
  `beschrijving` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `soortactiviteiten`
--

INSERT INTO `soortactiviteiten` (`id`, `naam`, `min_leeftijd`, `tijdsduur`, `prijs`, `beschrijving`) VALUES
(1, 'Korte race', 12, 36, '25.00', '2 Heats'),
(3, 'Normale race', 12, 80, '50.00', '5 Heats');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activiteiten`
--
ALTER TABLE `activiteiten`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_1C50895F3DEE50DF` (`soort_id`);

--
-- Indexes for table `app_users`
--
ALTER TABLE `app_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_C2502824F85E0677` (`username`);

--
-- Indexes for table `deelnames`
--
ALTER TABLE `deelnames`
  ADD PRIMARY KEY (`user_id`,`activiteit_id`),
  ADD KEY `IDX_ED2478E7A76ED395` (`user_id`),
  ADD KEY `IDX_ED2478E75A8A0A1` (`activiteit_id`);

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `soortactiviteiten`
--
ALTER TABLE `soortactiviteiten`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activiteiten`
--
ALTER TABLE `activiteiten`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `app_users`
--
ALTER TABLE `app_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `soortactiviteiten`
--
ALTER TABLE `soortactiviteiten`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activiteiten`
--
ALTER TABLE `activiteiten`
  ADD CONSTRAINT `FK_1C50895F3DEE50DF` FOREIGN KEY (`soort_id`) REFERENCES `soortactiviteiten` (`id`);

--
-- Constraints for table `deelnames`
--
ALTER TABLE `deelnames`
  ADD CONSTRAINT `FK_ED2478E75A8A0A1` FOREIGN KEY (`activiteit_id`) REFERENCES `activiteiten` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_ED2478E7A76ED395` FOREIGN KEY (`user_id`) REFERENCES `app_users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
