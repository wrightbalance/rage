CREATE TABLE IF NOT EXISTS `cp_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(30) NOT NULL,
  `title` varchar(100) NOT NULL,
  `body` text NOT NULL,
  `author` varchar(100) NOT NULL,
  `created_on` datetime NOT NULL,
  `modified_on` datetime DEFAULT NULL,
  `patcher` tinyint(1) NOT NULL,
  `friendly_url` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
)
