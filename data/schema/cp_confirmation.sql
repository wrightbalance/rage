CREATE TABLE IF NOT EXISTS `cp_confirmation` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `confirmed` tinyint(4) NOT NULL,
  `confirm_code` varchar(64) NOT NULL,
  `confirm_created` datetime NOT NULL,
  `confirm_expire` datetime NOT NULL,
  `confirmed_on` datetime NOT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB
