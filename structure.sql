SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

CREATE DATABASE IF NOT EXISTS `DB2787277` DEFAULT CHARACTER SET latin1 COLLATE latin1_german1_ci;
USE `DB2787277`;

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` text COLLATE latin1_german1_ci,
  `receiver_id` text COLLATE latin1_german1_ci,
  `parent_comment` int(11) DEFAULT NULL,
  `text` text COLLATE latin1_german1_ci,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci COMMENT='latin1_german1_ci' AUTO_INCREMENT=19 ;

INSERT INTO `comments` (`cid`, `owner_id`, `receiver_id`, `parent_comment`, `text`) VALUES
(5, 'LukaNagel99', NULL, 0, 'asdasdasda'),
(6, 'LukaNagel99', NULL, 0, 'asdsadasd'),
(7, 'LukaNagel99', NULL, 0, 'zrrze'),
(8, 'LukaNagel99', 'LukaNagel99', NULL, 'asfasfas'),
(9, 'LukaNagel99', 'NULL', 8, 'fsafasf'),
(10, 'LukaNagel99', 'NULL', 8, 'fasfasf'),
(11, 'LukaNagel99', 'LukaNagel99', NULL, 'fasffasf'),
(12, 'LukaNagel99', 'LukaNagel99', NULL, 'Du Pimmelgesicht'),
(13, 'LukaNagel99', 'LukaNagel99', NULL, 'dgsdsdg'),
(14, 'LukaNagel99', 'keviwilhel97', NULL, 'Du Otze'),
(15, 'LukaNagel99', 'NULL', 9, 'Fick dioch\r\n'),
(16, 'LukaNagel99', 'AbigToews98', NULL, 'Ey du nutte'),
(17, 'LukaNagel99', 'NULL', 16, 'sag doch sowas mnciht'),
(18, 'LukaNagel99', 'NULL', 17, '*nicht');

DROP TABLE IF EXISTS `group_meta`;
CREATE TABLE IF NOT EXISTS `group_meta` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci' AUTO_INCREMENT=10 ;



DROP TABLE IF EXISTS `group_participants`;
CREATE TABLE IF NOT EXISTS `group_participants` (
  `group_participants_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `user_id` text NOT NULL,
  `mod` tinyint(1) NOT NULL,
  PRIMARY KEY (`group_participants_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci' AUTO_INCREMENT=62 ;



DROP TABLE IF EXISTS `log`;
CREATE TABLE IF NOT EXISTS `log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `content` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci' AUTO_INCREMENT=1162 ;


DROP TABLE IF EXISTS `login_admin`;
CREATE TABLE IF NOT EXISTS `login_admin` (
  `uselesscol` int(11) NOT NULL AUTO_INCREMENT,
  `login_admin_id` text NOT NULL,
  PRIMARY KEY (`uselesscol`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci' AUTO_INCREMENT=46 ;

INSERT INTO `login_admin` (`uselesscol`, `login_admin_id`) VALUES (41, 'LukaNagel99');

DROP TABLE IF EXISTS `login_info`;
CREATE TABLE IF NOT EXISTS `login_info` (
  `id` text NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci';


DROP TABLE IF EXISTS `login_tokens`;
CREATE TABLE IF NOT EXISTS `login_tokens` (
  `user_id` text NOT NULL,
  `token` text NOT NULL,
  `expires` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci';

DROP TABLE IF EXISTS `profile_meta_fields`;
CREATE TABLE IF NOT EXISTS `profile_meta_fields` (
  `field_id` int(11) NOT NULL AUTO_INCREMENT,
  `field_title` text,
  `field_type` int(11) DEFAULT NULL,
  `field_opt` text,
  `field_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`field_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci' AUTO_INCREMENT=16 ;

INSERT INTO `profile_meta_fields` (`field_id`, `field_title`, `field_type`, `field_opt`, `field_order`) VALUES
(1, 'Geburtstag', 1, NULL, 1),
(2, 'Leistungskurse', 1, NULL, 2),
(3, 'Lieblingsfach', 1, NULL, 3),
(4, 'Lieblingslehrer', 1, NULL, 4),
(5, 'Peinlichste (Schul-)aktion', 4, NULL, 5),
(6, 'Zukunftstr&auml;ume', 4, NULL, 6),
(7, 'Lieblingsflachwitz', 4, NULL, 7),
(8, 'Welcher Schauspieler w&uuml;rde dich in deiner Biographie darstellen?', 1, NULL, 8),
(9, 'Welches Lied beschreibt dein Schulleben am besten? ', 1, NULL, 9),
(10, 'Lieblingspausensnack', 1, NULL, 10),
(13, 'Dein &Uuml;berlebenstipp', 4, NULL, 13),
(14, 'Worte zum Abschied', 4, NULL, 14),
(15, 'Spitzname', 1, NULL, 0);

DROP TABLE IF EXISTS `profile_user_fields`;
CREATE TABLE IF NOT EXISTS `profile_user_fields` (
  `uf_id` int(11) NOT NULL AUTO_INCREMENT,
  `meta_field_id` int(11) DEFAULT NULL,
  `user_id` text,
  `value` text,
  PRIMARY KEY (`uf_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci' AUTO_INCREMENT=930 ;


DROP TABLE IF EXISTS `profiles`;
CREATE TABLE IF NOT EXISTS `profiles` (
  `user_id` text NOT NULL,
  `FName` text NOT NULL,
  `LName` text NOT NULL,
  `avatar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci';



DROP TABLE IF EXISTS `survey_meta`;
CREATE TABLE IF NOT EXISTS `survey_meta` (
  `survey_meta_id` int(11) NOT NULL AUTO_INCREMENT,
  `survey_title` text NOT NULL,
  `survey_description` text NOT NULL,
  `survey_visible` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`survey_meta_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci' AUTO_INCREMENT=85 ;


DROP TABLE IF EXISTS `survey_questions`;
CREATE TABLE IF NOT EXISTS `survey_questions` (
  `survey_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `question_title` text NOT NULL,
  PRIMARY KEY (`question_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci' AUTO_INCREMENT=10612 ;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
