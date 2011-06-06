CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `token_index` (`token`(255))
) ENGINE=InnoDB DEFAULT CHARSET=utf8

CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `4sq_id` varchar(256) NOT NULL,
  `name` varchar(256) NOT NULL,
  `pluralName` varchar(256) NOT NULL,
  `icon` varchar(256) NOT NULL,
  `parent` int(11) DEFAULT NULL,

  PRIMARY KEY (`id`),
  KEY `4sq_id_index` (`4sq_id`(255))
) ENGINE=InnoDB DEFAULT CHARSET=utf8
