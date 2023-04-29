-- drop database IF  EXISTS profreadb;


create database IF NOT EXISTS profreadb;
use profreadb;


--  CREATE TABLE IF  EXISTS `users`
CREATE TABLE IF NOT EXISTS `users` (
   `id` int(11) NOT NULL AUTO_INCREMENT,
   `user_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
   `password` text COLLATE utf8mb4_unicode_ci NOT NULL,
   `first_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
   `last_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
   `email` text COLLATE utf8mb4_unicode_ci NOT NULL,
   `mobileNo` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
   `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
   `landmark` text COLLATE utf8mb4_unicode_ci NOT NULL,
   `city` text COLLATE utf8mb4_unicode_ci NOT NULL,
   `state` text COLLATE utf8mb4_unicode_ci NOT NULL,
   `pinCode` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
   `rowstate` tinyint(1) DEFAULT 0,
   `insert` timestamp NOT NULL DEFAULT current_timestamp(),
   `update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
   PRIMARY KEY (`id`)
 )ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



--  CREATE TABLE IF  EXISTS `spaces`
CREATE TABLE IF NOT EXISTS `spaces` (
   `id` int(11) NOT NULL AUTO_INCREMENT,
   `owner_id` int(11) NOT NULL,
   `phone` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `hourly_charges` int(11) NOT NULL,
   `space_type` text COLLATE utf8mb4_unicode_ci NOT NULL,
   `capacity` int(11) DEFAULT NULL,
   `images` text COLLATE utf8mb4_unicode_ci NOT NULL,
   `amenities` text COLLATE utf8mb4_unicode_ci NOT NULL,
   `utility` text COLLATE utf8mb4_unicode_ci NOT NULL,
   `paid_utilities` text COLLATE utf8mb4_unicode_ci NOT NULL,
   `speciality_operating` text COLLATE utf8mb4_unicode_ci NOT NULL,
   `speciality_exclude` text COLLATE utf8mb4_unicode_ci NOT NULL,
   `speciality_exclusively` text COLLATE utf8mb4_unicode_ci NOT NULL,
   `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
   `available_day_slots` text COLLATE utf8mb4_unicode_ci NOT NULL,
   `available_time_slots` text COLLATE utf8mb4_unicode_ci NOT NULL,
   `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `locality` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `landmark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `city` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `state` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `pin_code` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `gmap_location` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `rowstate` tinyint(1) DEFAULT 0,
   `insert` timestamp NOT NULL DEFAULT current_timestamp(),
   `update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
   PRIMARY KEY (`id`),
   KEY `owner_id` (`owner_id`),
   CONSTRAINT `spaces_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`)
 )ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



--  CREATE TABLE IF  EXISTS `blog_post`
 CREATE TABLE IF NOT EXISTS `blog_post` (
   `id` int(11) NOT NULL AUTO_INCREMENT,
   `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
   `images` text COLLATE utf8mb4_unicode_ci NOT NULL,
   `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
   `category` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
   `author` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
   `email` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `mobile` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `like` int(11) NOT NULL DEFAULT 0,
   `dislike` int(11) NOT NULL DEFAULT 0,
   `views` int(11) NOT NULL DEFAULT 0,
   `rowstate` tinyint(1) DEFAULT 0,
   `insert` timestamp NOT NULL DEFAULT current_timestamp(),
   `update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
   PRIMARY KEY (`id`)
 )ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--  CREATE TABLE IF  EXISTS `faq`
CREATE TABLE  IF NOT EXISTS `faq` (
   `id` int(11) NOT NULL AUTO_INCREMENT,
   `question` text COLLATE utf8mb4_unicode_ci NOT NULL,
   `answer` text COLLATE utf8mb4_unicode_ci NOT NULL,
   `category` text COLLATE utf8mb4_unicode_ci NOT NULL,
   `rowstate` tinyint(1) DEFAULT 0,
   `insert` timestamp NOT NULL DEFAULT current_timestamp(),
   `update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
   PRIMARY KEY (`id`)
 )ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



--  CREATE TABLE IF  EXISTS `basic_info`
 CREATE TABLE  IF NOT EXISTS `basic_info` (
   `id` int(11) NOT NULL AUTO_INCREMENT,
   `unique_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
   `first_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
   `last_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
   `phone_no` text COLLATE utf8mb4_unicode_ci NOT NULL,
   `phone_no2` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `email_Id` text COLLATE utf8mb4_unicode_ci NOT NULL,
   `email_Id2` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `user_type` text COLLATE utf8mb4_unicode_ci NOT NULL,
   `locality` text COLLATE utf8mb4_unicode_ci NOT NULL,
   `landmark` text COLLATE utf8mb4_unicode_ci NOT NULL,
   `city` text COLLATE utf8mb4_unicode_ci NOT NULL,
   `locality2` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `landmark2` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `locality3` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `landmark3` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `rowstate` tinyint(1) DEFAULT 0,
   `insert` timestamp NOT NULL DEFAULT current_timestamp(),
   `update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
   `space_type` text COLLATE utf8mb4_unicode_ci NOT NULL,
   PRIMARY KEY (`id`)
 )ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



--  CREATE TABLE IF  EXISTS `space_info`
CREATE TABLE `space_info` (
   `id` int(11) NOT NULL AUTO_INCREMENT,
   `basic_info_id` int(11) NOT NULL,
   `space_type` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `city` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
   `locality` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
   `landmark` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `addresss` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
   `security_deposit` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
   `setup_rules` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `setup_desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `operating_specialty` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `utility` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `paid_utilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `amenities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `map_location` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `map_cordinates` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `ws_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `ws_available_from` date NOT NULL,
   `ws_offered_slots_mon` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `ws_offered_slots_tue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `ws_offered_slots_wed` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `ws_offered_slots_thu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `ws_offered_slots_fri` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `ws_offered_slots_sat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `ws_offered_slots_sun` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `ws_hourly_charges` int(11) NOT NULL,
   `ws_desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `ws_capacity` int(11) NOT NULL,
   `rowstate` tinyint(1) DEFAULT 0,
   `insert` timestamp NOT NULL DEFAULT current_timestamp(),
   `update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
   PRIMARY KEY (`id`),
   KEY `basic_info_id` (`basic_info_id`),
   CONSTRAINT `space_info_ibfk_1` FOREIGN KEY (`basic_info_id`) REFERENCES `basic_info` (`id`)
 )ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE `city` (
   `id` int(11) NOT NULL AUTO_INCREMENT,
   `name` varchar(255) NOT NULL,
   `rowstate` tinyint(1) DEFAULT 0,
   `insert` timestamp NOT NULL DEFAULT current_timestamp(),
   `update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
   PRIMARY KEY (`id`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
 
 
 CREATE TABLE `locality` (
   `id` int(11) NOT NULL AUTO_INCREMENT,
   `name` varchar(255) NOT NULL,
   `city_id` int(11) NOT NULL,
   `rowstate` tinyint(1) DEFAULT 0,
   `insert` timestamp NOT NULL DEFAULT current_timestamp(),
   `update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
   PRIMARY KEY (`id`),
   KEY `city_id` (`city_id`),
   CONSTRAINT `locality_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
 
 CREATE TABLE `landmark` (
   `id` int(11) NOT NULL AUTO_INCREMENT,
   `name` varchar(255) NOT NULL,
   `locality_id` int(11) NOT NULL,
   `rowstate` tinyint(1) DEFAULT 0,
   `insert` timestamp NOT NULL DEFAULT current_timestamp(),
   `update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
   PRIMARY KEY (`id`),
   KEY `locality_id` (`locality_id`),
   CONSTRAINT `landmark_ibfk_1` FOREIGN KEY (`locality_id`) REFERENCES `locality` (`id`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;



