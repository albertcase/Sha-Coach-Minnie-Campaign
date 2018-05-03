# ************************************************************
# Sequel Pro SQL dump
# Version 4529
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.17-0ubuntu0.16.04.1)
# Database: coach_minnie_campaign
# Generation Time: 2018-05-03 08:39:33 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table info
# ------------------------------------------------------------

DROP TABLE IF EXISTS `info`;

CREATE TABLE `info` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cellphone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `status` int(11) DEFAULT '0',
  `created` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table old_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `old_user`;

CREATE TABLE `old_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table quota
# ------------------------------------------------------------

DROP TABLE IF EXISTS `quota`;

CREATE TABLE `quota` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `num` varchar(255) DEFAULT '0',
  `fid` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table submit
# ------------------------------------------------------------

DROP TABLE IF EXISTS `submit`;

CREATE TABLE `submit` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) DEFAULT NULL,
  `qid` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `checkin` tinyint(1) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `uid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `nickname` blob,
  `sex` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `province` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `headimgurl` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `unionid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`uid`),
  KEY `openid` (`openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
