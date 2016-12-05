SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

CREATE DATABASE IF NOT EXISTS `yearbook` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `yearbook`;

DROP TABLE IF EXISTS `group_meta`;
CREATE TABLE IF NOT EXISTS `group_meta` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci' AUTO_INCREMENT=6 ;

DROP TABLE IF EXISTS `group_participants`;
CREATE TABLE IF NOT EXISTS `group_participants` (
  `group_participants_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `user_id` text NOT NULL,
  `mod` tinyint(1) NOT NULL,
  PRIMARY KEY (`group_participants_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci' AUTO_INCREMENT=43 ;

DROP TABLE IF EXISTS `log`;
CREATE TABLE IF NOT EXISTS `log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `content` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci' AUTO_INCREMENT=141 ;

DROP TABLE IF EXISTS `login_admin`;
CREATE TABLE IF NOT EXISTS `login_admin` (
  `uselesscol` int(11) NOT NULL AUTO_INCREMENT,
  `login_admin_id` text NOT NULL,
  PRIMARY KEY (`uselesscol`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci' AUTO_INCREMENT=10 ;

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

DROP TABLE IF EXISTS `profiles`;
CREATE TABLE IF NOT EXISTS `profiles` (
  `user_id` text NOT NULL,
  `FName` text NOT NULL,
  `LName` text NOT NULL,
  `avatar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci';

DROP TABLE IF EXISTS `profile_meta_fields`;
CREATE TABLE IF NOT EXISTS `profile_meta_fields` (
  `field_id` int(11) NOT NULL AUTO_INCREMENT,
  `field_title` text,
  `field_type` int(11) DEFAULT NULL,
  `field_opt` text,
  `field_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`field_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci' AUTO_INCREMENT=12 ;

DROP TABLE IF EXISTS `profile_user_fields`;
CREATE TABLE IF NOT EXISTS `profile_user_fields` (
  `uf_id` int(11) NOT NULL AUTO_INCREMENT,
  `meta_field_id` int(11) DEFAULT NULL,
  `user_id` text,
  `value` text,
  PRIMARY KEY (`uf_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci' AUTO_INCREMENT=23 ;

DROP TABLE IF EXISTS `survey_meta`;
CREATE TABLE IF NOT EXISTS `survey_meta` (
  `survey_meta_id` int(11) NOT NULL AUTO_INCREMENT,
  `survey_title` text NOT NULL,
  `survey_description` text NOT NULL,
  `survey_visible` smallint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`survey_meta_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci' AUTO_INCREMENT=8 ;

DROP TABLE IF EXISTS `survey_questions`;
CREATE TABLE IF NOT EXISTS `survey_questions` (
  `survey_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `question_title` text NOT NULL,
  PRIMARY KEY (`question_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci' AUTO_INCREMENT=11 ;

DROP TABLE IF EXISTS `survey_votes`;
CREATE TABLE IF NOT EXISTS `survey_votes` (
  `vote_id` int(11) NOT NULL AUTO_INCREMENT,
  `vote_value` int(11) NOT NULL,
  `vote_user` text NOT NULL,
  `vote_question` int(11) NOT NULL,
  `survey__id` int(11) NOT NULL,
  PRIMARY KEY (`vote_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci' AUTO_INCREMENT=8 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
