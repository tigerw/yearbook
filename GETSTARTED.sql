# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: mysql.stunningpixels.com (MySQL 5.6.25-log)
# Database: stunningpixels
# Generation Time: 2017-01-18 08:54:37 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table author_choices
# ------------------------------------------------------------

CREATE TABLE `author_choices` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pupil_rollnumber` int(11) DEFAULT NULL,
  `author_rollnumber` int(11) DEFAULT NULL,
  `text` text NOT NULL,
  `signature` text NOT NULL,
  `activity` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table award_votes
# ------------------------------------------------------------

CREATE TABLE `award_votes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `rollnumber` int(11) DEFAULT NULL,
  `award_id` int(11) DEFAULT NULL,
  `value` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table awards
# ------------------------------------------------------------

CREATE TABLE `awards` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `award` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table pupil_questions
# ------------------------------------------------------------

CREATE TABLE `pupil_questions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `question` text CHARACTER SET utf8,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table pupils
# ------------------------------------------------------------

CREATE TABLE `pupils` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) DEFAULT NULL,
  `secondname` varchar(255) DEFAULT NULL,
  `form` varchar(255) DEFAULT NULL,
  `house` varchar(255) DEFAULT NULL,
  `dateofbirth` varchar(255) DEFAULT NULL,
  `rollnumber` int(11) DEFAULT NULL,
  `currentphoto` text NOT NULL,
  `babyphoto` text NOT NULL,
  `first_question` int(11) DEFAULT NULL,
  `first_answer` text NOT NULL,
  `second_question` int(11) DEFAULT NULL,
  `second_answer` text NOT NULL,
  `yearjoined` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
