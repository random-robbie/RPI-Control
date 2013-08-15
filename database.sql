CREATE TABLE `texts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sender` decimal(12,0) DEFAULT NULL,
  `content` varchar(612) DEFAULT NULL,
  `inNumber` decimal(12,0) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `credits` int(11) DEFAULT NULL,
  `forward` int(1) DEFAULT '0',
  `messagesent` int(1) DEFAULT '0',
  `datereceived` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=115 DEFAULT CHARSET=latin1;