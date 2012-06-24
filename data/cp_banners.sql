CREATE TABLE IF NOT EXISTS `cp_banners` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `hours` tinyint(2) unsigned NOT NULL,
  `credits` int(10) unsigned NOT NULL,
  `vote_url` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;
