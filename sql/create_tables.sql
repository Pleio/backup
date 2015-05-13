CREATE TABLE IF NOT EXISTS `prefix_backup` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `transaction_id` varchar(36) NOT NULL,
  `site_guid` bigint(20) NOT NULL,
  `time_created` int(11) NOT NULL,
  `performed_by` bigint(20) NOT NULL,
  `type` varchar(50) NOT NULL,
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `time_created` (`time_created`),
  KEY `transaction_id` (`transaction_id`),
  KEY `performed_by` (`performed_by`)
);