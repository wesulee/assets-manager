DROP TABLE IF EXISTS `assets`;

CREATE TABLE `assets` (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `name` varchar(500) NOT NULL,
 `available` tinyint(1) NOT NULL,
 `user_id` int(11) unsigned NOT NULL,
 `category_id` int(11) DEFAULT NULL,
 `room_id` int(11) DEFAULT NULL,
 `image_path` varchar(500) DEFAULT NULL,
 `note` text,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `name` varchar(100) NOT NULL,
 PRIMARY KEY (`id`),
 UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `rooms`;

CREATE TABLE `rooms` (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `name` varchar(100) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;