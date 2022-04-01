CREATE DATABASE IF NOT EXISTS `cpy_user_accounts` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `cpy_user_accounts`;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `username` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `forename` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `surname` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `hash` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `users` (`username`, `forename`, `surname`, `email`, `hash`, `admin`) VALUES
('admin', 'Admin', 'User', 'big.boss@waimea.school.nz', '$2y$10$bUpHS3pGdMEjBqffQ30VAeOWraCZYnV7NSsZn/OGEaur4bMKR0ejm', 1),
('dave', 'Dave', 'McTavish', 'bigdave@hotmail.com', '$2y$10$WErmqyUlDr24dJem44T0Hu5LOc20TiN5rNS/C9q9QGVmkYKuBbZIy', 0),
('jimmy', 'Jim', 'Harrison', 'jimmy@guns.com', '$2y$10$fZhf9vBm5Ipgtrv1gDbVn.QX3BGJbyB2dYTW5SiNGU5PQ6syi1uRO', 0),
('steve', 'Steve', 'Copley', 'steve.copley@waimea.school.nz', '$2y$10$FOYwCUD/9pfiAyY9LxOi/eJLSvEzB6fS8mJvOsfi2p0DQkCgz.lAi', 0);


ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

