
CREATE TABLE `error` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `line_number` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `created_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4299 DEFAULT CHARSET=latin1;
