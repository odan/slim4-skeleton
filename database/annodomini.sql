-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Erstellungszeit: 11. Sep 2020 um 23:02
-- Server-Version: 10.3.24-MariaDB-1:10.3.24+maria~stretch
-- PHP-Version: 7.3.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `annodomini`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `dataset_update`
--

CREATE TABLE `dataset_update` (
  `type` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `game_set`
--

CREATE TABLE `game_set` (
  `uid` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `icon` text DEFAULT NULL,
  `color` varchar(7) NOT NULL,
  `foregroundColor` varchar(7) NOT NULL,
  `create_date` bigint(20) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `additional_info` varchar(255) DEFAULT NULL,
  `title_image` mediumtext DEFAULT NULL,
  `year` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `opponent`
--

CREATE TABLE `opponent` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `level` tinyint(4) NOT NULL DEFAULT 1,
  `confident` tinyint(4) NOT NULL DEFAULT 3,
  `fortune` tinyint(4) NOT NULL DEFAULT 3,
  `education` tinyint(4) NOT NULL DEFAULT 3,
  `avatar` text DEFAULT NULL,
  `create_date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `opponent_skills`
--

CREATE TABLE `opponent_skills` (
  `id` int(11) NOT NULL,
  `opponent_id` int(11) NOT NULL,
  `set_id` int(11) NOT NULL,
  `skill` tinyint(4) NOT NULL DEFAULT 3,
  `create_date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `playing_card`
--

CREATE TABLE `playing_card` (
  `id` int(11) NOT NULL,
  `card_id` varchar(6) NOT NULL,
  `set_id` int(11) NOT NULL,
  `event` text NOT NULL,
  `event_image` mediumtext DEFAULT NULL,
  `event_date` mediumint(9) NOT NULL,
  `event_period` varchar(4) DEFAULT NULL,
  `event_around` tinyint(1) NOT NULL DEFAULT 0,
  `event_century` tinyint(1) NOT NULL DEFAULT 0,
  `event_millenium` tinyint(1) NOT NULL DEFAULT 0,
  `event_additional_info` text DEFAULT NULL,
  `create_date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `profile`
--

CREATE TABLE `profile` (
  `uid` int(11) NOT NULL,
  `device_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `last_access` int(11) NOT NULL,
  `create_date` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `profile_set`
--

CREATE TABLE `profile_set` (
  `uid` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `set_id` int(11) NOT NULL,
  `create_date` int(11) NOT NULL,
  `expiry` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `dataset_update`
--
ALTER TABLE `dataset_update`
  ADD UNIQUE KEY `type` (`type`),
  ADD KEY `type_2` (`type`),
  ADD KEY `date` (`date`);

--
-- Indizes für die Tabelle `game_set`
--
ALTER TABLE `game_set`
  ADD PRIMARY KEY (`uid`);

--
-- Indizes für die Tabelle `opponent`
--
ALTER TABLE `opponent`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `opponent_skills`
--
ALTER TABLE `opponent_skills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `opponent_id` (`opponent_id`),
  ADD KEY `set_id` (`set_id`);

--
-- Indizes für die Tabelle `playing_card`
--
ALTER TABLE `playing_card`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `card_id` (`card_id`),
  ADD KEY `set_id` (`set_id`);

--
-- Indizes für die Tabelle `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `device_id` (`device_id`);

--
-- Indizes für die Tabelle `profile_set`
--
ALTER TABLE `profile_set`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `game_set`
--
ALTER TABLE `game_set`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `opponent`
--
ALTER TABLE `opponent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `opponent_skills`
--
ALTER TABLE `opponent_skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `playing_card`
--
ALTER TABLE `playing_card`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `profile`
--
ALTER TABLE `profile`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `profile_set`
--
ALTER TABLE `profile_set`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
