drop database if exists DB_NAME;
create database DB_NAME character set utf8 collate utf8_general_ci;
alter database DB_NAME character set utf8 collate utf8_general_ci;
use DB_NAME;


CREATE TABLE `user` (
  `id` int(11) UNSIGNED NOT NULL primary key auto_increment,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `city` varchar(50) DEFAULT NULL,
  `street` varchar(150) DEFAULT NULL
);

CREATE TABLE `image` (
  `id` int(11) NOT NULL primary key auto_increment,
  `name` varchar(200) NOT NULL,
  `path` longtext NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL
);


CREATE TABLE `token` (
  `id` int(11) NOT NULL primary key auto_increment,
  `selector` char(12) NOT NULL,
  `token` char(64) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `expires` datetime NOT NULL
);


ALTER TABLE `image`
  ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;


ALTER TABLE `token`
  ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;