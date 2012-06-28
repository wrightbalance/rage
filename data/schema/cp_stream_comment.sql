CREATE TABLE IF NOT EXISTS `cp_stream_comment` (
  `csid` int(11) NOT NULL AUTO_INCREMENT,
  `sid` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `c_created` datetime NOT NULL,
  `c_status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`csid`),
  KEY `sid` (`sid`,`account_id`,`c_status`)
) ENGINE=InnoDB
