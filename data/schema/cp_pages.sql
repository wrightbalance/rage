CREATE TABLE IF NOT EXISTS `cp_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `friendly_url` varchar(50) NOT NULL,
  `title` varchar(100) NOT NULL,
  `body` text NOT NULL,
  `created_on` datetime DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB
