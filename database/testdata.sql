-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server Version:               10.3.16-MariaDB - mariadb.org binary distribution
-- Server Betriebssystem:        Win64
-- HeidiSQL Version:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
SET NAMES utf8;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Exportiere Daten aus Tabelle gruppe1db.address: ~10 rows (ungefähr)
/*!40000 ALTER TABLE `address` DISABLE KEYS */;
INSERT INTO `address` (`AddressID`, `Street`, `PostalCode`, `City`, `Country`, `TelNo`, `MobilNo`, `FaxNo`, `MailAddress`) VALUES
	(1, '2077 Vel, Av.', '22151', 'Konstanz', 'Germany', '(08657) 1782939', '(449) 494-3243', '(804) 859-8978', 'Morbi@aliquetProin.net'),
	(2, '1752 Purus. Street', '78779', 'Zwickau', 'Germany', '(051) 35935584', '(787) 405-1583', '(984) 682-3280', 'viverra@dui.com'),
	(3, '213-4233 Diam. Avenue', '34046', 'Andernach', 'Germany', '(0982) 31693233', '(421) 234-6016', '(484) 624-3642', 'auctor.ullamcorper@eleifend.com'),
	(4, 'Ap #545-2788 Nullam Ave', '91881', 'Bad Neuenahr-Ahrweiler', 'Germany', '(01095) 6064220', '(238) 127-8714', '(801) 614-9089', 'orci@risusa.edu'),
	(5, '9882 Cursus Road', '27316', 'ZweibrÃ¼cken', 'Germany', '(0959) 24830831', '(678) 922-8155', '(666) 538-7841', 'pellentesque.massa@ornare.com'),
	(6, '304-208 Dictum Ave', '85277', 'Bielefeld', 'Germany', '(07793) 1360604', '(559) 707-8268', '(693) 117-9418', 'egestas.hendrerit@arcu.co.uk'),
	(7, 'P.O. Box 903, 2199 Sed St.', '63695', 'Wadgassen', 'Germany', '(077) 79692388', '(509) 940-2739', '(999) 694-6160', 'Cras.eu@porttitoreros.com'),
	(8, 'P.O. Box 119, 2852 Amet, Rd.', '41464', 'Dreieich', 'Germany', '(04953) 4558522', '(969) 811-1831', '(782) 184-6418', 'at.arcu.Vestibulum@enimgravIDa.net'),
	(9, 'P.O. Box 152, 5924 Nullam Road', '65607', 'TÃ¼bingen', 'Germany', '(037255) 333664', '(798) 743-2987', '(229) 915-0875', 'nulla.ante.iaculis@atiaculisquis.net'),
	(10, 'P.O. Box 207, 7610 Egestas. Road', '80957', 'Goslar', 'Germany', '(038599) 226477', '(181) 535-6080', '(152) 707-2735', 'Proin.vel.nisl@Inlorem.net');
/*!40000 ALTER TABLE `address` ENABLE KEYS */;

-- Exportiere Daten aus Tabelle gruppe1db.componentattributes: ~6 rows (ungefähr)
/*!40000 ALTER TABLE `componentattributes` DISABLE KEYS */;
INSERT INTO `componentattributes` (`AttributeID`, `AttributeName`) VALUES
	(1, 'Festplatte'),
	(2, 'Grafikkarte'),
	(3, 'Arbeitsspeicher'),
	(4, 'Monitor'),
	(5, 'AnschlÃ¼sse'),
	(6, 'Kabel'),
	(7, 'Seriennummer'),
	(8, 'CPU Bezeichnung'),
	(9, 'Anzahl Ports'),
	(10, 'Uplinktyp'),
	(11, 'IP1, IP2, IP3, IP4'),
	(12, 'WLAN-Standard'),
	(13, 'Druckertyp'),
	(14, 'DruckerArt'),
	(15, 'Druckformat'),
	(16, 'Beidseitig'),
	(20, 'ANSI-Lumen'),
	(21, 'Eingang'),
	(22, 'Lautsprecher'),
	(23, 'Versionsnummer'),
	(24, 'Lizenztyp'),
	(25, 'Lizenzanzahl'),
	(26, 'Lizenzlaufzeit'),
	(27, 'Lizenzinformationen'),
	(28, 'Installationshinweise');
/*!40000 ALTER TABLE `componentattributes` ENABLE KEYS */;

-- Exportiere Daten aus Tabelle gruppe1db.componenthasvalues: ~2 rows (ungefähr)
/*!40000 ALTER TABLE `componenthasvalues` DISABLE KEYS */;
INSERT INTO `componenthasvalues` (`ComponentValueID`, `ComponentID`, `AttributeID`, `AttributeValue`) VALUES
	(1, 1, 1, 'SSD 250 GB'),
	(2, 1, 5, '3 x PCI 16, 5 x USB 3.0, AudioJack, 1 x HDMI, 2 x VGa');
/*!40000 ALTER TABLE `componenthasvalues` ENABLE KEYS */;

-- Exportiere Daten aus Tabelle gruppe1db.components: ~1 rows (ungefähr)
/*!40000 ALTER TABLE `components` DISABLE KEYS */;
INSERT INTO `components` (`ComponentID`, `ComponentName`, `SupplierID`, `ComponentPurchaseDate`, `ComponentWarranty`, `ComponentNotes`, `ComponentVendorID`, `ComponentTypeID`, `ComponentReceipt`) VALUES
	(1, 'Think Center 12020', 1, '2012-12-20', 2, '2014-12-20', 1, 1, NULL);
/*!40000 ALTER TABLE `components` ENABLE KEYS */;

-- Exportiere Daten aus Tabelle gruppe1db.componentsinroom: ~1 rows (ungefähr)
/*!40000 ALTER TABLE `componentsinroom` DISABLE KEYS */;
INSERT INTO `componentsinroom` (`ComponentRoomID`, `ComponentID`, `RoomID`) VALUES
	(1, 1, 1);
/*!40000 ALTER TABLE `componentsinroom` ENABLE KEYS */;

-- Exportiere Daten aus Tabelle gruppe1db.componenttypehasattributes: ~2 rows (ungefähr)
/*!40000 ALTER TABLE `componenttypehasattributes` DISABLE KEYS */;
INSERT INTO `componenttypehasattributes` (`ComponentTypeAttributeID`, `ComponentTypeID`, `AttributeID`) VALUES
	(1, 1, 5),
	(2, 1, 1),
	(3, 1, 3),
	(4, 1, 7),
	(5, 1, 8),
	(6, 2, 7),
	(7, 2, 9),
	(8, 2, 10),
	(9, 3, 7),
	(10, 3, 9),
	(11, 3, 11),
	(12, 8, 7),
	(13, 8, 12),
	(14, 10, 7),
	(15, 10, 13),
	(16, 10, 14),
	(17, 10, 15),
	(18, 10, 16),
	(19, 12, 7),
	(20, 12, 20),
	(21, 12, 21),
	(22, 12, 22),
	(23, 14, 5),
	(24, 14, 7),
	(25, 16, 23),
	(26, 16, 24),
	(27, 16, 25),
	(28, 16, 26),
	(29, 16, 27),
	(30, 16, 28);
/*!40000 ALTER TABLE `componenttypehasattributes` ENABLE KEYS */;

-- Exportiere Daten aus Tabelle gruppe1db.componenttypes: ~8 rows (ungefähr)
/*!40000 ALTER TABLE `componenttypes` DISABLE KEYS */;
INSERT INTO `componenttypes` (`ComponentTypeID`, `ComponentTypeName`, `IsSoftware`) VALUES
	(1, 'PC', 0),
	(2, 'Switches', 0),
	(3, 'Router', 0),
	(8, 'Accesspoints', 0),
	(10, 'Drucker', 0),
	(12, 'Beamer', 0),
	(14, 'Visualizer', 0),
	(16, 'Software', 1);
/*!40000 ALTER TABLE `componenttypes` ENABLE KEYS */;

-- Exportiere Daten aus Tabelle gruppe1db.rooms: ~8 rows (ungefähr)
/*!40000 ALTER TABLE `rooms` DISABLE KEYS */;
INSERT INTO `rooms` (`RoomID`, `RoomNo`, `RoomName`, `RoomNodes`) VALUES
	(1, '101', 'SekretÃ¤riat', ''),
	(2, '102', 'Kopierer Raum', 'Raum zum kopieren'),
	(3, '103', 'Besenkammer', 'Raum fÃ¼r Besen und Heulsusen '),
	(4, '104', 'Lehrer Zimmer', NULL),
	(5, '105', 'Lager', 'Lagerraum'),
	(6, '106', 'Besprechungzimmer', NULL),
	(7, '107', 'BÃ¼ro 001', ''),
	(8, '108', 'BÃ¼ro  002', '');
/*!40000 ALTER TABLE `rooms` ENABLE KEYS */;

-- Exportiere Daten aus Tabelle gruppe1db.supplier: ~2 rows (ungefähr)
/*!40000 ALTER TABLE `supplier` DISABLE KEYS */;
INSERT INTO `supplier` (`SupplierID`, `SupplierCompanyName`, `AddressID`) VALUES
	(1, 'HardwareFix Gbr', 5),
	(2, 'SuperGÃ¼nstig', 8);
/*!40000 ALTER TABLE `supplier` ENABLE KEYS */;

-- Exportiere Daten aus Tabelle gruppe1db.users: ~2 rows (ungefähr)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`UserID`, `UserEmail`, `UserName`, `UserFirstName`, `UserLastName`, `UserPassword`, `IsAdmin`) VALUES
	(1, 'Admin@b3-fuerth.de', 'Admin', 'Admin', 'Admin', 'e3afed0047b08059d0fada10f400c1e5', 1),
	(2, 'benutzer@b3-fuerth.de', 'Benutzer', 'Ben', 'Utzer', 'b15b7b0340f52d448dc6191fc9317f3a', 0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Exportiere Daten aus Tabelle gruppe1db.vendor: ~2 rows (ungefähr)
/*!40000 ALTER TABLE `vendor` DISABLE KEYS */;
INSERT INTO `vendor` (`VendorID`, `VendorName`) VALUES
	(1, 'Microsoft'),
	(2, 'Lenovo');
/*!40000 ALTER TABLE `vendor` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
