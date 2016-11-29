-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 09. Nov 2016 um 21:43
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

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `login_info`
--

DROP TABLE IF EXISTS `login_info`;
CREATE TABLE IF NOT EXISTS `login_info` (
  `id` text NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci';

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
