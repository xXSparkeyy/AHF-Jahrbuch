-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 09. Nov 2016 um 21:44
-- Server Version: 5.5.53-0ubuntu0.14.04.1
-- PHP-Version: 5.5.9-1ubuntu4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `yearbook`
--
CREATE DATABASE IF NOT EXISTS `yearbook` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `yearbook`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `login_admin`
--

DROP TABLE IF EXISTS `login_admin`;
CREATE TABLE IF NOT EXISTS `login_admin` (
  `uselesscol` int(11) NOT NULL AUTO_INCREMENT,
  `login_admin_id` text NOT NULL,
  PRIMARY KEY (`uselesscol`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci' AUTO_INCREMENT=3 ;

--
-- TRUNCATE Tabelle vor dem Einfügen `login_admin`
--

TRUNCATE TABLE `login_admin`;
--
-- Daten für Tabelle `login_admin`
--

INSERT INTO `login_admin` (`uselesscol`, `login_admin_id`) VALUES
(2, 'LukaNagel99');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `login_info`
--

DROP TABLE IF EXISTS `login_info`;
CREATE TABLE IF NOT EXISTS `login_info` (
  `id` text NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci';

--
-- TRUNCATE Tabelle vor dem Einfügen `login_info`
--

TRUNCATE TABLE `login_info`;
--
-- Daten für Tabelle `login_info`
--

INSERT INTO `login_info` (`id`, `password`) VALUES
('LukaNagel99', 'D3@ahfs4csv!');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `login_tokens`
--

DROP TABLE IF EXISTS `login_tokens`;
CREATE TABLE IF NOT EXISTS `login_tokens` (
  `user_id` text NOT NULL,
  `token` text NOT NULL,
  `expires` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci';

--
-- TRUNCATE Tabelle vor dem Einfügen `login_tokens`
--

TRUNCATE TABLE `login_tokens`;
--
-- Daten für Tabelle `login_tokens`
--

INSERT INTO `login_tokens` (`user_id`, `token`, `expires`) VALUES
('LukaNagel99', '1baf0f38f4d23f66bad8594996a8d051', '2016-11-01 20:50:59'),
('LukaNagel99', '237202c19117e58bf8553df6915f6926', '2016-11-09 21:41:05'),
('LukaNagel99', '89fb85eb75b4745abd9050c3fa902729', '2016-11-09 21:44:00');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `profiles`
--

DROP TABLE IF EXISTS `profiles`;
CREATE TABLE IF NOT EXISTS `profiles` (
  `user_id` text NOT NULL,
  `FName` text NOT NULL,
  `LName` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci';

--
-- TRUNCATE Tabelle vor dem Einfügen `profiles`
--

TRUNCATE TABLE `profiles`;
--
-- Daten für Tabelle `profiles`
--

INSERT INTO `profiles` (`user_id`, `FName`, `LName`) VALUES
('LukaNagel99', 'Lukas der', 'Nagel 2');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `profile_meta_fields`
--

DROP TABLE IF EXISTS `profile_meta_fields`;
CREATE TABLE IF NOT EXISTS `profile_meta_fields` (
  `field_id` int(11) NOT NULL AUTO_INCREMENT,
  `field_title` text,
  `field_type` int(11) DEFAULT NULL,
  `field_opt` text,
  `field_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`field_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci' AUTO_INCREMENT=5 ;

--
-- TRUNCATE Tabelle vor dem Einfügen `profile_meta_fields`
--

TRUNCATE TABLE `profile_meta_fields`;
--
-- Daten für Tabelle `profile_meta_fields`
--

INSERT INTO `profile_meta_fields` (`field_id`, `field_title`, `field_type`, `field_opt`, `field_order`) VALUES
(1, 'TEST', 4, '', 4),
(2, 'RadioButtonsMulti', 3, 'OPT1|OPT2|OPT3|OPT4', 3),
(3, 'RadioButtons', 2, 'OPT1|OPT2|OPT3|OPT4', 2),
(4, 'Input', 1, '', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `profile_user_fields`
--

DROP TABLE IF EXISTS `profile_user_fields`;
CREATE TABLE IF NOT EXISTS `profile_user_fields` (
  `uf_id` int(11) NOT NULL AUTO_INCREMENT,
  `meta_field_id` int(11) DEFAULT NULL,
  `user_id` text,
  `value` text,
  PRIMARY KEY (`uf_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci' AUTO_INCREMENT=6 ;

--
-- TRUNCATE Tabelle vor dem Einfügen `profile_user_fields`
--

TRUNCATE TABLE `profile_user_fields`;
--
-- Daten für Tabelle `profile_user_fields`
--

INSERT INTO `profile_user_fields` (`uf_id`, `meta_field_id`, `user_id`, `value`) VALUES
(1, 1, 'LukaNagel99', 'Du Kleiner\r\nHurensohn\r\nPisser nutÃ¶Ã¶Ã¶'),
(3, 3, 'LukaNagel99', 'OPT3'),
(4, 4, 'LukaNagel99', 'ejoooo'),
(5, 2, 'LukaNagel99', 'OPT1|OPT2|OPT3');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `survey_meta`
--

DROP TABLE IF EXISTS `survey_meta`;
CREATE TABLE IF NOT EXISTS `survey_meta` (
  `survey_meta_id` int(11) NOT NULL AUTO_INCREMENT,
  `survey_title` text NOT NULL,
  `survey_description` text NOT NULL,
  `survey_visible` smallint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`survey_meta_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci' AUTO_INCREMENT=6 ;

--
-- TRUNCATE Tabelle vor dem Einfügen `survey_meta`
--

TRUNCATE TABLE `survey_meta`;
--
-- Daten für Tabelle `survey_meta`
--

INSERT INTO `survey_meta` (`survey_meta_id`, `survey_title`, `survey_description`, `survey_visible`) VALUES
(1, 'TEST SURVEY', 'FIRST SURVEY EVER', 1),
(2, 'TEST SURVEY', 'FIRST SURVEY EVER', 1),
(3, 'The third survey', 'But the first one to be edited', 0),
(5, 'Man kann keine Surveys lÃ¶schen', 'Is aber kein Problem', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `survey_questions`
--

DROP TABLE IF EXISTS `survey_questions`;
CREATE TABLE IF NOT EXISTS `survey_questions` (
  `survey_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `question_title` text NOT NULL,
  PRIMARY KEY (`question_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci' AUTO_INCREMENT=26 ;

--
-- TRUNCATE Tabelle vor dem Einfügen `survey_questions`
--

TRUNCATE TABLE `survey_questions`;
--
-- Daten für Tabelle `survey_questions`
--

INSERT INTO `survey_questions` (`survey_id`, `question_id`, `question_title`) VALUES
(1, 1, 'TEST'),
(1, 2, 'HALLO'),
(1, 3, 'HALLO'),
(1, 4, 'HALLO'),
(1, 5, 'HALLO'),
(1, 6, 'fasfasf'),
(1, 7, 'fasfasf'),
(1, 8, 'fasfasf'),
(1, 9, 'fasfasf'),
(1, 10, 'fasfasf'),
(1, 11, 'fasfasf'),
(1, 12, 'fasfasf'),
(1, 13, 'fasfasf'),
(1, 14, 'fasfasf'),
(1, 15, 'fasfasf'),
(3, 20, 'Wonderful one'),
(3, 22, 'Sucks'),
(3, 23, 'Boring'),
(3, 24, 'Exciting'),
(3, 25, 'Cool');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `survey_votes`
--

DROP TABLE IF EXISTS `survey_votes`;
CREATE TABLE IF NOT EXISTS `survey_votes` (
  `vote_id` int(11) NOT NULL AUTO_INCREMENT,
  `vote_value` int(11) NOT NULL,
  `vote_user` text NOT NULL,
  `vote_question` int(11) NOT NULL,
  PRIMARY KEY (`vote_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci' AUTO_INCREMENT=34 ;

--
-- TRUNCATE Tabelle vor dem Einfügen `survey_votes`
--

TRUNCATE TABLE `survey_votes`;
--
-- Daten für Tabelle `survey_votes`
--

INSERT INTO `survey_votes` (`vote_id`, `vote_value`, `vote_user`, `vote_question`) VALUES
(1, 1, 'LukaNagel99', 1),
(2, -1, 'NOUSER', 1),
(3, 1, 'NOUSER2', 1),
(4, -1, 'NOUSER', 2),
(5, -1, 'LukaNagel99', 2),
(6, 1, 'LukaNagel99', 3),
(7, -1, 'LukaNagel99', 8),
(8, -1, 'LukaNagel99', 4),
(9, -1, 'LukaNagel99', 5),
(10, -1, 'LukaNagel99', 6),
(11, -1, 'LukaNagel99', 7),
(12, -1, 'LukaNagel99', 9),
(13, -1, 'LukaNagel99', 10),
(14, -1, 'LukaNagel99', 11),
(15, -1, 'LukaNagel99', 12),
(16, -1, 'LukaNagel99', 13),
(17, -1, 'LukaNagel99', 15),
(18, -1, 'LukaNagel99', 14),
(19, 0, 'INITVOTE', 16),
(20, 0, 'INITVOTE', 17),
(21, 0, 'INITVOTE', 18),
(22, 0, 'INITVOTE', 19),
(23, 0, 'INITVOTE', 20),
(24, 0, 'INITVOTE', 21),
(25, 0, 'INITVOTE', 22),
(26, 0, 'INITVOTE', 23),
(27, 0, 'INITVOTE', 24),
(28, 0, 'INITVOTE', 25),
(29, 1, 'LukaNagel99', 20),
(30, -1, 'LukaNagel99', 22),
(31, -1, 'LukaNagel99', 23),
(32, 1, 'LukaNagel99', 24),
(33, 1, 'LukaNagel99', 25);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
