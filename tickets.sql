-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server-Version:               10.4.32-MariaDB - mariadb.org binary distribution
-- Server-Betriebssystem:        Win64
-- HeidiSQL Version:             12.10.0.7000
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Exportiere Datenbank-Struktur für tickets
CREATE DATABASE IF NOT EXISTS `tickets` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `tickets`;

-- Exportiere Struktur von Tabelle tickets.ticket
CREATE TABLE IF NOT EXISTS `ticket` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `titel` varchar(50) NOT NULL,
  `beschreibung` varchar(255) NOT NULL,
  `priorität` varchar(10) NOT NULL,
  `datum` date NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Exportiere Daten aus Tabelle tickets.ticket: ~4 rows (ungefähr)
INSERT INTO `ticket` (`tid`, `titel`, `beschreibung`, `priorität`, `datum`) VALUES
	(1, 'CSS-Probleme', 'Die CSS-Datei wird wohl nicht richtig geladen', 'Hoch', '2025-02-23'),
	(2, 'Server nicht erreichbar', 'Server tot', 'Hoch', '2026-01-07'),
	(3, 'Seite lädt langsam', 'Irgendwas stimmt mit der Kapazität des Server nicht weil es ewig lädt', 'Mittel', '2026-01-07'),
	(6, 'Schnee schieben', 'Der Hof muss vom Schnee befreit werden, Dringend', 'Hoch', '2026-01-09');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
