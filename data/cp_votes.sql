CREATE TABLE IF NOT EXISTS `cp_votes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `banner_id` int(10) unsigned NOT NULL,
  `account_id` int(10) unsigned NOT NULL,
  `credits` int(10) unsigned NOT NULL,
  `vote_date` datetime NOT NULL,
  `vote_ip` varchar(15) NOT NULL,
  `mac_address` varchar(60) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `banner_id` (`banner_id`,`account_id`)
) ENGINE=InnoDB;
