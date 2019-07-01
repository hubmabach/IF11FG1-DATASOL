-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 01. Jul 2019 um 16:46
-- Server-Version: 10.1.37-MariaDB
-- PHP-Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `gruppe1db`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `address`
--

CREATE TABLE `address` (
  `AddressId` int(11) NOT NULL,
  `Street` varchar(255) COLLATE latin1_german1_ci DEFAULT NULL,
  `PostalCode` varchar(10) COLLATE latin1_german1_ci DEFAULT NULL,
  `City` varchar(45) COLLATE latin1_german1_ci DEFAULT NULL,
  `Country` varchar(45) COLLATE latin1_german1_ci DEFAULT NULL,
  `TelNo` varchar(20) COLLATE latin1_german1_ci DEFAULT NULL,
  `MobilNo` varchar(20) COLLATE latin1_german1_ci DEFAULT NULL,
  `FaxNo` varchar(20) COLLATE latin1_german1_ci DEFAULT NULL,
  `MailAddress` varchar(45) COLLATE latin1_german1_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `componentattributes`
--

CREATE TABLE `componentattributes` (
  `AttributeId` int(11) NOT NULL,
  `AttributeName` varchar(25) COLLATE latin1_german1_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `componenthasvalues`
--

CREATE TABLE `componenthasvalues` (
  `ComponentValueId` int(11) NOT NULL,
  `ComponentId` int(11) DEFAULT NULL,
  `AttributeId` int(11) DEFAULT NULL,
  `AttributeValue` longtext COLLATE latin1_german1_ci
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `components`
--

CREATE TABLE `components` (
  `ComponentId` int(11) NOT NULL,
  `ComponentName` varchar(100) COLLATE latin1_german1_ci DEFAULT NULL,
  `SupplierId` int(11) DEFAULT NULL,
  `ComponentPurchaseDate` date DEFAULT NULL,
  `ComponentWarranty` int(11) DEFAULT NULL,
  `ComponentNotes` longtext COLLATE latin1_german1_ci,
  `ComponentVendorId` int(11) DEFAULT NULL,
  `ComponentTypeId` int(11) DEFAULT NULL,
  `ComponentReceipt` varchar(150) COLLATE latin1_german1_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `componentsinroom`
--

CREATE TABLE `componentsinroom` (
  `ComponentRoomId` int(11) NOT NULL,
  `ComponentId` int(11) DEFAULT NULL,
  `RoomId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `componenttypehasattributes`
--

CREATE TABLE `componenttypehasattributes` (
  `ComponentTypeAttributeId` int(11) NOT NULL,
  `ComponentTypeId` int(11) DEFAULT NULL,
  `AttributeId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `componenttypes`
--

CREATE TABLE `componenttypes` (
  `ComponentTypeId` int(11) NOT NULL,
  `ComponentTypeName` varchar(45) COLLATE latin1_german1_ci DEFAULT NULL,
  `IsSoftware` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rooms`
--

CREATE TABLE `rooms` (
  `RoomId` int(11) NOT NULL,
  `RoomNo` varchar(20) COLLATE latin1_german1_ci DEFAULT NULL,
  `RoomName` varchar(45) COLLATE latin1_german1_ci DEFAULT NULL,
  `RoomNodes` longtext COLLATE latin1_german1_ci
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `supplier`
--

CREATE TABLE `supplier` (
  `SupplierId` int(11) NOT NULL,
  `SupplierCompanyName` varchar(45) COLLATE latin1_german1_ci DEFAULT NULL,
  `AddressId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `UserId` int(11) NOT NULL,
  `UserEmail` varchar(100) COLLATE latin1_german1_ci DEFAULT NULL,
  `UserName` varchar(100) COLLATE latin1_german1_ci DEFAULT NULL,
  `UserFirstName` varchar(100) COLLATE latin1_german1_ci DEFAULT NULL,
  `UserLastName` varchar(100) COLLATE latin1_german1_ci DEFAULT NULL,
  `UserPasswort` varchar(250) COLLATE latin1_german1_ci DEFAULT NULL,
  `IsAdmin` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `vendor`
--

CREATE TABLE `vendor` (
  `VendorId` int(11) NOT NULL,
  `VendorName` varchar(45) COLLATE latin1_german1_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`AddressId`);

--
-- Indizes für die Tabelle `componentattributes`
--
ALTER TABLE `componentattributes`
  ADD PRIMARY KEY (`AttributeId`);

--
-- Indizes für die Tabelle `componenthasvalues`
--
ALTER TABLE `componenthasvalues`
  ADD PRIMARY KEY (`ComponentValueId`),
  ADD KEY `F_ComponentHasValues` (`ComponentId`),
  ADD KEY `F_ComponentHasValues_2` (`AttributeId`);

--
-- Indizes für die Tabelle `components`
--
ALTER TABLE `components`
  ADD PRIMARY KEY (`ComponentId`),
  ADD KEY `F_Components` (`SupplierId`),
  ADD KEY `F_ComponentVendorId` (`ComponentVendorId`),
  ADD KEY `F_ComponentTypeId` (`ComponentTypeId`);

--
-- Indizes für die Tabelle `componentsinroom`
--
ALTER TABLE `componentsinroom`
  ADD PRIMARY KEY (`ComponentRoomId`),
  ADD KEY `ComponentId` (`ComponentId`,`RoomId`),
  ADD KEY `RoomId` (`RoomId`);

--
-- Indizes für die Tabelle `componenttypehasattributes`
--
ALTER TABLE `componenttypehasattributes`
  ADD PRIMARY KEY (`ComponentTypeAttributeId`),
  ADD KEY `F_ComponentTypeHasAttributes` (`ComponentTypeId`),
  ADD KEY `F_AttributeId` (`AttributeId`);

--
-- Indizes für die Tabelle `componenttypes`
--
ALTER TABLE `componenttypes`
  ADD PRIMARY KEY (`ComponentTypeId`);

--
-- Indizes für die Tabelle `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`RoomId`);

--
-- Indizes für die Tabelle `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`SupplierId`),
  ADD KEY `F_Supplier` (`AddressId`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserId`);

--
-- Indizes für die Tabelle `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`VendorId`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `address`
--
ALTER TABLE `address`
  MODIFY `AddressId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `componentattributes`
--
ALTER TABLE `componentattributes`
  MODIFY `AttributeId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `componenthasvalues`
--
ALTER TABLE `componenthasvalues`
  MODIFY `ComponentValueId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `components`
--
ALTER TABLE `components`
  MODIFY `ComponentId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `componentsinroom`
--
ALTER TABLE `componentsinroom`
  MODIFY `ComponentRoomId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `componenttypehasattributes`
--
ALTER TABLE `componenttypehasattributes`
  MODIFY `ComponentTypeAttributeId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `componenttypes`
--
ALTER TABLE `componenttypes`
  MODIFY `ComponentTypeId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `rooms`
--
ALTER TABLE `rooms`
  MODIFY `RoomId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `supplier`
--
ALTER TABLE `supplier`
  MODIFY `SupplierId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `vendor`
--
ALTER TABLE `vendor`
  MODIFY `VendorId` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `componenthasvalues`
--
ALTER TABLE `componenthasvalues`
  ADD CONSTRAINT `F_ComponentHasValues` FOREIGN KEY (`ComponentId`) REFERENCES `components` (`ComponentId`),
  ADD CONSTRAINT `F_ComponentHasValues_2` FOREIGN KEY (`AttributeId`) REFERENCES `componentattributes` (`AttributeId`);

--
-- Constraints der Tabelle `components`
--
ALTER TABLE `components`
  ADD CONSTRAINT `F_ComponentTypeId` FOREIGN KEY (`ComponentTypeId`) REFERENCES `componenttypes` (`ComponentTypeId`),
  ADD CONSTRAINT `F_ComponentVendorId` FOREIGN KEY (`ComponentVendorId`) REFERENCES `vendor` (`VendorId`),
  ADD CONSTRAINT `F_Components` FOREIGN KEY (`SupplierId`) REFERENCES `supplier` (`SupplierId`);

--
-- Constraints der Tabelle `componentsinroom`
--
ALTER TABLE `componentsinroom`
  ADD CONSTRAINT `F_ComponentID` FOREIGN KEY (`ComponentId`) REFERENCES `components` (`ComponentId`),
  ADD CONSTRAINT `F_RoomId` FOREIGN KEY (`RoomId`) REFERENCES `rooms` (`RoomId`);

--
-- Constraints der Tabelle `componenttypehasattributes`
--
ALTER TABLE `componenttypehasattributes`
  ADD CONSTRAINT `F_AttributeId` FOREIGN KEY (`AttributeId`) REFERENCES `componentattributes` (`AttributeId`),
  ADD CONSTRAINT `F_ComponentTypeHasAttributes` FOREIGN KEY (`ComponentTypeId`) REFERENCES `componenttypes` (`ComponentTypeId`);

--
-- Constraints der Tabelle `supplier`
--
ALTER TABLE `supplier`
  ADD CONSTRAINT `F_Supplier` FOREIGN KEY (`AddressId`) REFERENCES `address` (`AddressId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
