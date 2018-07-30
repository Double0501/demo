CREATE TABLE IF NOT EXISTS `zcdl` (
  `id` int(10) unsigned NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `zcdl`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `用户名不能重复` (`username`);

ALTER TABLE `zcdl`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;

