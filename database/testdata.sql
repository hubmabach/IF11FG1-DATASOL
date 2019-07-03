-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server Version:               10.3.16-MariaDB - mariadb.org binary distribution
-- Server Betriebssystem:        Win64
-- HeidiSQL Version:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
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
	(5, '9882 Cursus Road', '27316', 'Zweibrücken', 'Germany', '(0959) 24830831', '(678) 922-8155', '(666) 538-7841', 'pellentesque.massa@ornare.com'),
	(6, '304-208 Dictum Ave', '85277', 'Bielefeld', 'Germany', '(07793) 1360604', '(559) 707-8268', '(693) 117-9418', 'egestas.hendrerit@arcu.co.uk'),
	(7, 'P.O. Box 903, 2199 Sed St.', '63695', 'Wadgassen', 'Germany', '(077) 79692388', '(509) 940-2739', '(999) 694-6160', 'Cras.eu@porttitoreros.com'),
	(8, 'P.O. Box 119, 2852 Amet, Rd.', '41464', 'Dreieich', 'Germany', '(04953) 4558522', '(969) 811-1831', '(782) 184-6418', 'at.arcu.Vestibulum@enimgravIDa.net'),
	(9, 'P.O. Box 152, 5924 Nullam Road', '65607', 'Tübingen', 'Germany', '(037255) 333664', '(798) 743-2987', '(229) 915-0875', 'nulla.ante.iaculis@atiaculisquis.net'),
	(10, 'P.O. Box 207, 7610 Egestas. Road', '80957', 'Goslar', 'Germany', '(038599) 226477', '(181) 535-6080', '(152) 707-2735', 'Proin.vel.nisl@Inlorem.net');
/*!40000 ALTER TABLE `address` ENABLE KEYS */;

-- Exportiere Daten aus Tabelle gruppe1db.componentattributes: ~6 rows (ungefähr)
/*!40000 ALTER TABLE `componentattributes` DISABLE KEYS */;
INSERT INTO `componentattributes` (`AttributeID`, `AttributeName`) VALUES
	(1, 'Festplatte '),
	(2, 'Grafikkarte'),
	(3, 'Arbeitsspeicher'),
	(4, 'Monitor'),
	(5, 'Anschlüsse'),
	(6, 'Kabel');
/*!40000 ALTER TABLE `componentattributes` ENABLE KEYS */;

-- Exportiere Daten aus Tabelle gruppe1db.componenthasvalues: ~2 rows (ungefähr)
/*!40000 ALTER TABLE `componenthasvalues` DISABLE KEYS */;
INSERT INTO `componenthasvalues` (`ComponentValueID`, `ComponentID`, `AttributeID`, `AttributeValue`) VALUES
	(1, 1, 1, 'SSD 250 GB'),
	(2, 1, 5, '3 x PCI 16, 5 x USB 3.0, AudioJack, 1 x HDMI, 2 x VGa');
/*!40000 ALTER TABLE `componenthasvalues` ENABLE KEYS */;

-- Exportiere Daten aus Tabelle gruppe1db.components: ~0 rows (ungefähr)
/*!40000 ALTER TABLE `components` DISABLE KEYS */;
INSERT INTO `components` (`ComponentID`, `ComponentName`, `SupplierID`, `ComponentPurchaseDate`, `ComponentWarranty`, `ComponentNotes`, `ComponentVendorID`, `ComponentTypeID`, `ComponentReceipt`) VALUES
	(1, 'Think Center 12020', 1, '0000-00-00', 2, '2 Jahre Garantie', 902, 1, NULL);
/*!40000 ALTER TABLE `components` ENABLE KEYS */;

-- Exportiere Daten aus Tabelle gruppe1db.componentsinroom: ~0 rows (ungefähr)
/*!40000 ALTER TABLE `componentsinroom` DISABLE KEYS */;
INSERT INTO `componentsinroom` (`ComponentRoomID`, `ComponentID`, `RoomID`) VALUES
	(1, 1, 100);
/*!40000 ALTER TABLE `componentsinroom` ENABLE KEYS */;

-- Exportiere Daten aus Tabelle gruppe1db.componenttypehasattributes: ~2 rows (ungefähr)
/*!40000 ALTER TABLE `componenttypehasattributes` DISABLE KEYS */;
INSERT INTO `componenttypehasattributes` (`ComponentTypeAttributeID`, `ComponentTypeID`, `AttributeID`) VALUES
	(1, 1, 5),
	(2, 1, 1);
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
	(100, '101', 'Sekretäriat', NULL),
	(102, '102', 'Kopierer Raum', 'Raum zum kopieren'),
	(105, '103', 'Besenkammer', 'Raum für Besen und Heulsusen '),
	(107, '104', 'Lehrer Zimmer', NULL),
	(111, '105', 'Lager', 'Lagerraum'),
	(113, '106', 'Besprechungzimmer', NULL),
	(115, '107', 'Büro 001', NULL),
	(117, '108', 'Büro  002', NULL);
/*!40000 ALTER TABLE `rooms` ENABLE KEYS */;

-- Exportiere Daten aus Tabelle gruppe1db.supplier: ~2 rows (ungefähr)
/*!40000 ALTER TABLE `supplier` DISABLE KEYS */;
INSERT INTO `supplier` (`SupplierID`, `SupplierCompanyName`, `AddressID`) VALUES
	(1, 'HardwareFix Gbr', 5),
	(2, 'SuperGünstig', 8);
/*!40000 ALTER TABLE `supplier` ENABLE KEYS */;

-- Exportiere Daten aus Tabelle gruppe1db.users: ~0 rows (ungefähr)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`UserID`, `UserEmail`, `UserName`, `UserFirstName`, `UserLastName`, `UserPassword`, `IsAdmin`) VALUES
	(1, 'Admin@b3-fuerth.de', 'Admin', 'Admin', 'Admin', 'e3afed0047b08059d0fada10f400c1e5', 1),
	(2, 'benutzer@b3-fuerth.de', 'Benutzer', 'Ben', 'Utzer', 'b15b7b0340f52d448dc6191fc9317f3a', 0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Exportiere Daten aus Tabelle gruppe1db.vendor: ~0 rows (ungefähr)
/*!40000 ALTER TABLE `vendor` DISABLE KEYS */;
INSERT INTO `vendor` (`VendorID`, `VendorName`) VALUES
	(901, 'Microsoft'),
	(902, 'Lenovo');
/*!40000 ALTER TABLE `vendor` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
