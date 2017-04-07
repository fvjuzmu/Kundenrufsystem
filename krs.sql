-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 08. Apr 2017 um 00:34
-- Server-Version: 10.1.9-MariaDB
-- PHP-Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `krs`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `order`
--

CREATE TABLE `order` (
  `nr` int(11) NOT NULL,
  `begin` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `order`
--

INSERT INTO `order` (`nr`, `begin`, `end`) VALUES
(3, '2017-02-06 20:41:42', NULL),
(10, '2017-02-06 20:00:03', '2017-02-06 20:00:37'),
(123, '2017-02-06 19:52:38', '2017-02-06 19:53:24'),
(180, '2017-02-06 19:56:37', '2017-02-06 20:20:22'),
(181, '2017-02-06 19:59:53', '2017-02-06 20:20:24'),
(182, '2017-02-06 19:12:48', '2017-02-06 19:15:48'),
(183, '2017-02-06 19:25:47', '2017-02-06 19:30:15'),
(184, '2017-02-06 19:28:33', '2017-02-06 19:29:49'),
(185, '2017-02-06 19:29:17', '2017-02-06 19:30:19'),
(186, '2017-02-06 19:38:27', '2017-02-06 19:39:32'),
(187, '2017-02-06 19:41:35', '2017-02-06 19:42:13'),
(188, '2017-02-06 19:42:26', '2017-02-06 19:43:01'),
(189, '2017-02-06 19:43:10', '2017-02-06 19:43:23'),
(190, '2017-02-06 19:43:32', '2017-02-06 19:43:44'),
(191, '2017-02-06 19:45:09', '2017-02-06 19:49:51'),
(192, '2017-02-06 19:46:27', '2017-02-06 19:47:04'),
(193, '2017-02-06 19:46:59', '2017-02-06 19:47:34'),
(195, '2017-02-06 19:48:41', '2017-02-06 19:49:19'),
(196, '2017-02-06 19:49:57', '2017-02-06 19:50:20'),
(197, '2017-02-06 19:49:35', '2017-02-06 20:20:27'),
(198, '2017-02-06 19:53:53', '2017-02-06 20:20:29'),
(199, '2017-02-06 19:53:37', '2017-02-06 20:20:44'),
(200, '2017-02-06 19:51:10', '2017-02-06 20:15:26'),
(201, '2017-02-06 19:51:41', '2017-02-06 20:20:46'),
(202, '2017-02-06 19:54:04', '2017-02-06 20:21:08'),
(203, '2017-02-06 19:52:17', '2017-02-06 20:20:54'),
(204, '2017-02-06 19:54:19', '2017-02-06 20:20:51'),
(205, '2017-02-06 19:57:07', '2017-02-06 20:20:56'),
(207, '2017-02-06 20:15:14', '2017-02-06 20:20:58'),
(209, '2017-02-06 20:19:51', '2017-02-06 20:20:40'),
(210, '2017-02-06 20:18:41', '2017-02-06 20:20:17'),
(211, '2017-02-06 20:22:56', NULL);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`nr`),
  ADD UNIQUE KEY `order_nr_uindex` (`nr`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
