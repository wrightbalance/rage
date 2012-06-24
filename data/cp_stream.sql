CREATE TABLE IF NOT EXISTS `cp_stream` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) DEFAULT NULL,
  `content` text NOT NULL,
  `s_type` tinyint(4) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `s_status` tinyint(2) NOT NULL DEFAULT '1',
  `updated` datetime NOT NULL,
  PRIMARY KEY (`sid`),
  KEY `account_id` (`account_id`,`s_status`),
  KEY `s_type` (`s_type`)
) ENGINE=InnoDB
