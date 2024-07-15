-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           5.7.33 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour photo-network
CREATE DATABASE IF NOT EXISTS `photo-network` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `photo-network`;

-- Listage de la structure de la table photo-network. comment
CREATE TABLE IF NOT EXISTS `comment` (
  `id_comment` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `creationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedDate` datetime DEFAULT NULL,
  `photo_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_comment`),
  KEY `FK_comment_photo` (`photo_id`),
  KEY `FK_comment_user` (`user_id`),
  CONSTRAINT `FK_comment_photo` FOREIGN KEY (`photo_id`) REFERENCES `photo` (`id_photo`),
  CONSTRAINT `FK_comment_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

-- Listage des données de la table photo-network.comment : ~18 rows (environ)
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
INSERT INTO `comment` (`id_comment`, `content`, `creationDate`, `modifiedDate`, `photo_id`, `user_id`) VALUES
	(7, 'L&#039;agencement est tr&egrave;s bien fait, bravo !', '2022-12-15 05:48:38', NULL, 16, 3),
	(8, 'Tr&egrave;s jolie galerie', '2022-12-15 05:49:36', NULL, 16, 12),
	(9, 'Merci !!', '2022-12-15 05:50:46', NULL, 16, 2),
	(10, 'Tr&egrave;s belle photo', '2022-12-15 05:53:24', NULL, 16, NULL),
	(11, 'Les couleurs rendent bien', '2022-12-17 06:25:10', NULL, 16, 17),
	(12, 'O&ugrave; a &eacute;t&eacute; prise la photo ?', '2022-12-17 06:26:35', NULL, 16, 9),
	(13, 'C&#039;est le Big Ben en Angleterre', '2022-12-17 06:37:11', NULL, 16, 8),
	(14, 'Big Ben est le surnom de la grande cloche de 13,5 tonnes se trouvant au sommet de la tour &Eacute;lisabeth, la tour horloge du palais de Westminster, qui est le si&egrave;ge du Parlement britannique, &agrave; Londres. La tour a &eacute;t&eacute; renomm&eacute;e &agrave; l&#039;occasion du jubil&eacute; de diamant d&#039;&Eacute;lisabeth II en 2012.', '2022-12-17 06:38:43', NULL, 16, 6),
	(15, 'C&#039;est bien le Big Ben', '2022-12-17 06:40:28', NULL, 16, 2),
	(16, 'Jolie photo !', '2022-12-17 06:41:36', NULL, 16, 7),
	(17, 'Quel type d&#039;appareil photo as-tu utilis&eacute; ?', '2022-12-17 06:43:46', NULL, 16, 11),
	(18, 'J&#039;ai utilis&eacute; un Nikon D850', '2022-12-17 06:44:48', '2022-12-17 06:45:56', 16, 2),
	(19, 'Superbe prise de vue !', '2022-12-17 06:48:00', NULL, 16, 18),
	(20, 'Bravo pour cette magnifique photo!', '2022-12-17 06:57:43', NULL, 16, 17);
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;

-- Listage de la structure de la table photo-network. follow
CREATE TABLE IF NOT EXISTS `follow` (
  `userSource_id` int(11) NOT NULL,
  `userTarget_id` int(11) NOT NULL,
  KEY `FK__user_2` (`userTarget_id`),
  KEY `FK__user` (`userSource_id`) USING BTREE,
  CONSTRAINT `FK__user` FOREIGN KEY (`userSource_id`) REFERENCES `user` (`id_user`),
  CONSTRAINT `FK__user_2` FOREIGN KEY (`userTarget_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table photo-network.follow : ~23 rows (environ)
/*!40000 ALTER TABLE `follow` DISABLE KEYS */;
INSERT INTO `follow` (`userSource_id`, `userTarget_id`) VALUES
	(12, 2),
	(3, 15),
	(17, 12),
	(17, 6),
	(17, 4),
	(17, 15),
	(17, 13),
	(17, 9),
	(17, 8),
	(17, 3),
	(17, 16),
	(6, 8),
	(6, 9),
	(6, 17),
	(6, 3),
	(6, 12),
	(6, 2),
	(12, 6),
	(12, 15),
	(12, 4),
	(17, 2);
/*!40000 ALTER TABLE `follow` ENABLE KEYS */;

-- Listage de la structure de la table photo-network. like
CREATE TABLE IF NOT EXISTS `like` (
  `photo_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `like` tinyint(4) DEFAULT NULL,
  `dislike` tinyint(4) DEFAULT NULL,
  KEY `FK_photo_like` (`photo_id`),
  KEY `FK_user_like` (`user_id`),
  CONSTRAINT `FK_photo_like` FOREIGN KEY (`photo_id`) REFERENCES `photo` (`id_photo`),
  CONSTRAINT `FK_user_like` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table photo-network.like : ~0 rows (environ)
/*!40000 ALTER TABLE `like` DISABLE KEYS */;
/*!40000 ALTER TABLE `like` ENABLE KEYS */;

-- Listage de la structure de la table photo-network. photo
CREATE TABLE IF NOT EXISTS `photo` (
  `id_photo` int(11) NOT NULL AUTO_INCREMENT,
  `fileName` varchar(1000) NOT NULL,
  `releaseDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `description` text,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `town_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_photo`),
  KEY `FK_town_photo` (`town_id`),
  KEY `FK_user_photo` (`user_id`),
  CONSTRAINT `FK_town_photo` FOREIGN KEY (`town_id`) REFERENCES `town` (`id_town`),
  CONSTRAINT `FK_user_photo` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

-- Listage des données de la table photo-network.photo : ~32 rows (environ)
/*!40000 ALTER TABLE `photo` DISABLE KEYS */;
INSERT INTO `photo` (`id_photo`, `fileName`, `releaseDate`, `description`, `status`, `town_id`, `user_id`) VALUES
	(1, '63969a66c5db79.22807143.jpeg', '2022-12-12 04:05:10', '', 1, 5, 12),
	(2, '63969a7b662391.35662365.jpeg', '2022-12-12 04:05:31', '', 1, 5, 12),
	(3, '63969aa1243319.92008276.jpeg', '2022-12-12 04:06:09', '', 1, 5, 12),
	(4, '63969aa96db7f5.42354352.jpeg', '2022-12-12 04:06:17', '', 1, 5, 12),
	(5, '63969ab94ea370.76447524.jpeg', '2022-12-12 04:06:33', 'La statue de la libert&eacute;', 1, 5, 12),
	(6, '63969ade0ecc69.63842143.jpeg', '2022-12-12 04:07:10', 'One World Trade Center', 1, 5, 12),
	(7, '63969c975a38d2.42877755.jpg', '2022-12-12 04:14:31', '', 1, 4, 13),
	(8, '63969c9dd823d8.28393083.jpg', '2022-12-12 04:14:37', '', 1, 4, 13),
	(9, '63969caa5cae23.47369782.jpg', '2022-12-12 04:14:50', '', 1, 4, 13),
	(10, '63969cb1099a82.64890426.jpg', '2022-12-12 04:14:57', '', 1, 4, 13),
	(12, '63969cbd1e3563.87288394.jpg', '2022-12-12 04:15:09', '', 1, 4, 13),
	(13, '63969e206849c3.87657054.jpg', '2022-12-12 04:21:04', '', 1, 6, 2),
	(14, '63969e27174389.14527457.jpg', '2022-12-12 04:21:11', '', 1, 6, 2),
	(15, '63969e2d6a7e90.88470898.jpg', '2022-12-12 04:21:17', '', 1, 6, 2),
	(16, '63969e33a75411.52594089.jpg', '2022-12-12 04:21:23', '', 1, 6, 2),
	(17, '63969e44efe063.02915227.jpg', '2022-12-12 04:21:40', '', 1, 6, 2),
	(18, '63969e4aa875d4.09394898.jpg', '2022-12-12 04:21:46', '', 1, 6, 2),
	(19, '63969fc6f39b57.22431684.jpg', '2022-12-12 04:28:07', '', 1, 1, NULL),
	(20, '63969fd28481a8.77845192.jpg', '2022-12-12 04:28:18', '', 1, 1, NULL),
	(21, '63969fdd2256a3.22731025.jpg', '2022-12-12 04:28:29', '', 1, 1, NULL),
	(22, '6396a0104ca239.70958798.jpg', '2022-12-12 04:29:20', '', 1, 1, NULL),
	(23, '6396a01ba34e72.61115755.jpg', '2022-12-12 04:29:31', 'lampe typique japonaise', 1, 1, NULL),
	(24, '6396a0358feff9.06911966.jpg', '2022-12-12 04:29:57', '', 1, 1, NULL),
	(25, '6396a03b8f62b7.54817756.jpg', '2022-12-12 04:30:03', '', 1, 1, NULL),
	(26, '6396acd1a09223.76611320.jpg', '2022-12-12 05:23:45', '', 1, 3, 15),
	(27, '6396acd7814ec3.16084108.jpg', '2022-12-12 05:23:51', '', 1, 3, 15),
	(28, '6396acdd5ee981.71710086.jpg', '2022-12-12 05:23:57', '', 1, 3, 15),
	(29, '6396ace550d909.70720291.jpg', '2022-12-12 05:24:05', '', 1, 3, 15),
	(30, '6396aceab89aa2.35982441.jpg', '2022-12-12 05:24:10', '', 1, 3, 15),
	(31, '6396acf075a884.52203578.jpg', '2022-12-12 05:24:16', '', 1, 3, 15),
	(36, '63a08b2e8383a1.23916277.jpg', '2022-12-19 17:02:54', '', 1, 6, 17),
	(38, '63a976a183ec57.59389225.jpg', '2022-12-26 11:25:37', '', 1, 2, 17);
/*!40000 ALTER TABLE `photo` ENABLE KEYS */;

-- Listage de la structure de la table photo-network. town
CREATE TABLE IF NOT EXISTS `town` (
  `id_town` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(90) NOT NULL DEFAULT '',
  `postalCode` varchar(15) NOT NULL,
  `country` varchar(60) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY (`id_town`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Listage des données de la table photo-network.town : ~6 rows (environ)
/*!40000 ALTER TABLE `town` DISABLE KEYS */;
INSERT INTO `town` (`id_town`, `name`, `postalCode`, `country`, `image`, `description`) VALUES
	(1, 'Tokyo', '100 0000', 'Japon', 'tokyo.jpg', NULL),
	(2, 'Paris', '75 000', 'France', 'paris.jpg', NULL),
	(3, 'Heidelberg', '69 100', 'Allemagne', 'heidelberg.jpg', NULL),
	(4, 'Colmar', '68 000', 'France', 'colmar.jpg', NULL),
	(5, 'New-York', '10 000', 'Etats-Unis', 'new-york.jpg', NULL),
	(6, 'Londres', 'SW1V', 'Angleterre', 'londres.jpg', NULL);
/*!40000 ALTER TABLE `town` ENABLE KEYS */;

-- Listage de la structure de la table photo-network. user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `pseudonym` varchar(80) NOT NULL,
  `signupDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `image` varchar(255) DEFAULT NULL,
  `roles` json NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

-- Listage des données de la table photo-network.user : ~15 rows (environ)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id_user`, `email`, `password`, `pseudonym`, `signupDate`, `status`, `image`, `roles`) VALUES
	(2, 'anna@test.fr', '$2y$10$aVNhr/0lEb8NdNyuE7Ru1O8/kktTx9ZtXjE1rUtjWdZxYhjL83w6.', 'anna', '2022-12-12 03:07:59', 0, '63969e0a7c1f27.82209684.jpg', '["ROLE_ADMIN", "ROLE_USER"]'),
	(3, 'julien@test.fr', '$2y$10$LIp2cfLKB3MKitXG.cbd6u04aFv7M4NutVHpYwa.pHJjjya9P8rdy', 'julien', '2022-12-12 03:08:14', 1, '639ba65b4f9829.18531553.jpg', '["ROLE_USER"]'),
	(4, 'dalibor@test.fr', '$2y$10$BZtvC20ax4SS7DbM32j9cuMvXWy8x8wZDnJI6uyO/sBIWFbBtHkEy', 'dalibor', '2022-12-12 03:08:28', 1, NULL, '["ROLE_USER"]'),
	(5, 'marie@test.fr', '$2y$10$ganiMLBVGOqciLujsMXes.O/BIwEBL4qXRqeclwK4nWRYagVKtpiG', 'marie', '2022-12-12 03:08:37', 1, NULL, '["ROLE_USER"]'),
	(6, 'antoine@test.fr', '$2y$10$HVEJMNKIRhaoVSCOgOr59O7TtOEOH0QlkPrUqVlTeJqMnjfj4JPuC', 'antoine', '2022-12-12 03:09:26', 1, '639d55f7651e65.74839277.jpg', '["ROLE_USER"]'),
	(7, 'nicolas@test.fr', '$2y$10$N2CZajSITvhvPRFuOjFx6OaqSLmUtT.UAA5mNiqgTm.HlKGwgO9Ni', 'nicolas', '2022-12-12 03:09:35', 1, '639d566dcf2385.10918718.jpg', '["ROLE_USER"]'),
	(8, 'julie@test.fr', '$2y$10$Uk8en35b1DgOZ6eKFdYEKeJjnTuI5/cs.firDzvqwYkiOwA42u3ju', 'julie', '2022-12-12 03:09:46', 1, '639d559fccf701.61424507.jpg', '["ROLE_USER"]'),
	(9, 'jean-francois@test.fr', '$2y$10$kH9c9FfnhUFGwyb61CcxRu6cIGJNBimiOwMu9ZQvLiD6XRXuIWqRO', 'jean-francois', '2022-12-12 03:10:16', 1, NULL, '["ROLE_USER"]'),
	(11, 'manivone@test.fr', '$2y$10$sDvKnG9RBNMRoYF9XakE8.VWjBOkomhJSonQJdKqcpd9xM4dm7S/y', 'manivone', '2022-12-12 03:48:53', 1, '639d56bf56b772.86113768.jpg', '["ROLE_USER"]'),
	(12, 'anne@test.fr', '$2y$10$FRdhBP5QmiiMsGPwgDDVneZGKeosjLTAhN9Q6N4bD30mdUr7auNOi', 'anne', '2022-12-12 03:59:13', 1, '639699b2d23650.33929038.jpg', '["ROLE_USER"]'),
	(13, 'jean@test.fr', '$2y$10$vlNw.BtzPOenXIWoXJRuAOFNqqdpSVdpOy.6.opbI6MAMlrBpQxli', 'jean', '2022-12-12 04:10:15', 1, '63969bc9279ec1.68729497.jpg', '["ROLE_USER"]'),
	(15, 'gretta@test.fr', '$2y$10$w7tK1TCa1AQVakszWxWyUuTUuRUCRlaYT/SK4zIugkXnltpcOSo1q', 'gretta', '2022-12-12 05:23:20', 1, NULL, '["ROLE_USER"]'),
	(16, 'mickael@test.fr', '$2y$10$8vJJuOv55AWduoiNVrYX9uBBeS4yVgY7lmvgJgHcWLv6iTxy122Ra', 'mickael', '2022-12-13 15:25:31', 1, '63988bf6f3bbe4.37752221.jpg', '["ROLE_USER"]'),
	(17, 'max@test.fr', '$2y$10$T84SlaDNOqVBN8jefLJFou6T3FgwZTax08W.wcOYAaMLeLzzy04nm', 'max', '2022-12-16 04:00:14', 1, '639be2546e1314.43596295.jpg', '["ROLE_ADMIN", "ROLE_USER"]'),
	(18, 'thomas@test.fr', '$2y$10$yI492qDDfZwW0OYwhUO19eYk4eqlUqOqCGiPuvFldob8KOrPiVwn2', 'thomas', '2022-12-17 06:46:58', 1, '639d57ed78b2a4.47183789.jpg', '["ROLE_USER"]');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
