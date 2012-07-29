CREATE TABLE IF NOT EXISTS `cp_login` (
  `accountid` int(11) NOT NULL,
  `nickname` varchar(30) NOT NULL,
  `created` datetime NOT NULL,
  KEY `nickname` (`nickname`),
  KEY `account_id` (`accountid`)
);

ALTER TABLE  `cp_login` ADD  `avatar` VARCHAR( 32 ) NOT NULL;
