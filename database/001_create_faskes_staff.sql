CREATE TABLE IF NOT EXISTS `faskes_staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `region_code` varchar(20) NOT NULL,
  `required_staff` int(11) NOT NULL DEFAULT 0,
  `current_staff` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
