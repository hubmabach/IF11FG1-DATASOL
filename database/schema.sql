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

-- Exportiere Struktur von Tabelle gruppe1db.address
CREATE TABLE IF NOT EXISTS `address` (
  `AddressID` int(11) NOT NULL AUTO_INCREMENT,
  `Street` varchar(255) COLLATE latin1_german1_ci DEFAULT NULL,
  `PostalCode` varchar(10) COLLATE latin1_german1_ci DEFAULT NULL,
  `City` varchar(45) COLLATE latin1_german1_ci DEFAULT NULL,
  `Country` varchar(45) COLLATE latin1_german1_ci DEFAULT NULL,
  `TelNo` varchar(20) COLLATE latin1_german1_ci DEFAULT NULL,
  `MobilNo` varchar(20) COLLATE latin1_german1_ci DEFAULT NULL,
  `FaxNo` varchar(20) COLLATE latin1_german1_ci DEFAULT NULL,
  `MailAddress` varchar(45) COLLATE latin1_german1_ci DEFAULT NULL,
  PRIMARY KEY (`AddressID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle gruppe1db.componentattributes
CREATE TABLE IF NOT EXISTS `componentattributes` (
  `AttributeID` int(11) NOT NULL AUTO_INCREMENT,
  `AttributeName` varchar(25) COLLATE latin1_german1_ci DEFAULT NULL,
  PRIMARY KEY (`AttributeID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle gruppe1db.componenthasvalues
CREATE TABLE IF NOT EXISTS `componenthasvalues` (
  `ComponentValueID` int(11) NOT NULL AUTO_INCREMENT,
  `ComponentID` int(11) DEFAULT NULL,
  `AttributeID` int(11) DEFAULT NULL,
  `AttributeValue` longtext COLLATE latin1_german1_ci DEFAULT NULL,
  PRIMARY KEY (`ComponentValueID`),
  KEY `F_ComponentId` (`ComponentID`),
  KEY `F_AttributeID` (`AttributeID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle gruppe1db.components
CREATE TABLE IF NOT EXISTS `components` (
  `ComponentID` int(11) NOT NULL AUTO_INCREMENT,
  `ComponentName` varchar(100) COLLATE latin1_german1_ci DEFAULT NULL,
  `SupplierID` int(11) DEFAULT NULL,
  `ComponentPurchaseDate` date DEFAULT NULL,
  `ComponentWarranty` int(11) DEFAULT NULL,
  `ComponentNotes` longtext COLLATE latin1_german1_ci DEFAULT NULL,
  `ComponentVendorID` int(11) DEFAULT NULL,
  `ComponentTypeID` int(11) DEFAULT NULL,
  `ComponentReceipt` varchar(150) COLLATE latin1_german1_ci DEFAULT NULL,
  PRIMARY KEY (`ComponentID`),
  KEY `F_SupplierID` (`SupplierID`),
  KEY `F_ComponentVendorID` (`ComponentVendorID`),
  KEY `F_ComponentTypeID` (`ComponentTypeID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle gruppe1db.componentsinroom
CREATE TABLE IF NOT EXISTS `componentsinroom` (
  `ComponentRoomID` int(11) NOT NULL AUTO_INCREMENT,
  `ComponentID` int(11) DEFAULT NULL,
  `RoomID` int(11) DEFAULT NULL,
  PRIMARY KEY (`ComponentRoomID`),
  KEY `F_ComponentID` (`ComponentID`,`RoomID`),
  KEY `F_RoomID` (`RoomID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle gruppe1db.componenttypehasattributes
CREATE TABLE IF NOT EXISTS `componenttypehasattributes` (
  `ComponentTypeAttributeID` int(11) NOT NULL AUTO_INCREMENT,
  `ComponentTypeID` int(11) DEFAULT NULL,
  `AttributeID` int(11) DEFAULT NULL,
  PRIMARY KEY (`ComponentTypeAttributeID`),
  KEY `F_ComponentTypeID` (`ComponentTypeID`),
  KEY `F_AttributeID` (`AttributeID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle gruppe1db.componenttypes
CREATE TABLE IF NOT EXISTS `componenttypes` (
  `ComponentTypeID` int(11) NOT NULL AUTO_INCREMENT,
  `ComponentTypeName` varchar(45) COLLATE latin1_german1_ci DEFAULT NULL,
  `IsSoftware` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`ComponentTypeID`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle gruppe1db.rooms
CREATE TABLE IF NOT EXISTS `rooms` (
  `RoomID` int(11) NOT NULL AUTO_INCREMENT,
  `RoomNo` varchar(20) COLLATE latin1_german1_ci DEFAULT NULL,
  `RoomName` varchar(45) COLLATE latin1_german1_ci DEFAULT NULL,
  `RoomNodes` longtext COLLATE latin1_german1_ci DEFAULT NULL,
  PRIMARY KEY (`RoomID`)
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle gruppe1db.supplier
CREATE TABLE IF NOT EXISTS `supplier` (
  `SupplierID` int(11) NOT NULL AUTO_INCREMENT,
  `SupplierCompanyName` varchar(45) COLLATE latin1_german1_ci DEFAULT NULL,
  `AddressID` int(11) DEFAULT NULL,
  PRIMARY KEY (`SupplierID`),
  KEY `F_AddressID` (`AddressID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle gruppe1db.users
CREATE TABLE IF NOT EXISTS `users` (
  `UserID` int(11) NOT NULL,
  `UserEmail` varchar(100) COLLATE latin1_german1_ci DEFAULT NULL,
  `UserName` varchar(100) COLLATE latin1_german1_ci DEFAULT NULL,
  `UserFirstName` varchar(100) COLLATE latin1_german1_ci DEFAULT NULL,
  `UserLastName` varchar(100) COLLATE latin1_german1_ci DEFAULT NULL,
  `UserPassword` varchar(250) COLLATE latin1_german1_ci DEFAULT NULL,
  `IsAdmin` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle gruppe1db.vendor
CREATE TABLE IF NOT EXISTS `vendor` (
  `VendorID` int(11) NOT NULL,
  `VendorName` varchar(45) COLLATE latin1_german1_ci DEFAULT NULL,
  PRIMARY KEY (`VendorID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- Daten Export vom Benutzer nicht ausgewählt
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
