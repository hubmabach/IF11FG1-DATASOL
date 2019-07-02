-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 02. Jul 2019 um 11:54
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
-- Datenbank: `gruppe1_db`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `address`
--

CREATE TABLE `address` (
  `AddressID` int(11) NOT NULL,
  `Street` varchar(255) COLLATE latin1_german1_ci DEFAULT NULL,
  `PostalCode` varchar(10) COLLATE latin1_german1_ci DEFAULT NULL,
  `City` varchar(45) COLLATE latin1_german1_ci DEFAULT NULL,
  `Country` varchar(45) COLLATE latin1_german1_ci DEFAULT NULL,
  `TelNo` varchar(20) COLLATE latin1_german1_ci DEFAULT NULL,
  `MobilNo` varchar(20) COLLATE latin1_german1_ci DEFAULT NULL,
  `FaxNo` varchar(20) COLLATE latin1_german1_ci DEFAULT NULL,
  `MailAddress` varchar(45) COLLATE latin1_german1_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;



--
-- Tabellenstruktur für Tabelle `componentattributes`
--

CREATE TABLE `componentattributes` (
  `AttributeID` int(11) NOT NULL,
  `AttributeName` varchar(25) COLLATE latin1_german1_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;



--
-- Tabellenstruktur für Tabelle `componenthasvalues`
--

CREATE TABLE `componenthasvalues` (
  `ComponentValueID` int(11) NOT NULL,
  `ComponentID` int(11) DEFAULT NULL,
  `AttributeID` int(11) DEFAULT NULL,
  `AttributeValue` longtext COLLATE latin1_german1_ci
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;



--
-- Tabellenstruktur für Tabelle `components`
--

CREATE TABLE `components` (
  `ComponentID` int(11) NOT NULL,
  `ComponentName` varchar(100) COLLATE latin1_german1_ci DEFAULT NULL,
  `SupplierID` int(11) DEFAULT NULL,
  `ComponentPurchaseDate` date DEFAULT NULL,
  `ComponentWarranty` int(11) DEFAULT NULL,
  `ComponentNotes` longtext COLLATE latin1_german1_ci,
  `ComponentVendorID` int(11) DEFAULT NULL,
  `ComponentTypeID` int(11) DEFAULT NULL,
  `ComponentReceipt` varchar(150) COLLATE latin1_german1_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;


--
-- Tabellenstruktur für Tabelle `componentsinroom`
--

CREATE TABLE `componentsinroom` (
  `ComponentRoomID` int(11) NOT NULL,
  `ComponentID` int(11) DEFAULT NULL,
  `RoomID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;


--
-- Tabellenstruktur für Tabelle `componenttypehasattributes`
--

CREATE TABLE `componenttypehasattributes` (
  `ComponentTypeAttributeID` int(11) NOT NULL,
  `ComponentTypeID` int(11) DEFAULT NULL,
  `AttributeID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;



--
-- Tabellenstruktur für Tabelle `componenttypes`
--

CREATE TABLE `componenttypes` (
  `ComponentTypeID` int(11) NOT NULL,
  `ComponentTypeName` varchar(45) COLLATE latin1_german1_ci DEFAULT NULL,
  `IsSoftware` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;



--
-- Tabellenstruktur für Tabelle `rooms`
--

CREATE TABLE `rooms` (
  `RoomID` int(11) NOT NULL,
  `RoomNo` varchar(20) COLLATE latin1_german1_ci DEFAULT NULL,
  `RoomName` varchar(45) COLLATE latin1_german1_ci DEFAULT NULL,
  `RoomNodes` longtext COLLATE latin1_german1_ci
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;



--
-- Tabellenstruktur für Tabelle `supplier`
--

CREATE TABLE `supplier` (
  `SupplierID` int(11) NOT NULL,
  `SupplierCompanyName` varchar(45) COLLATE latin1_german1_ci DEFAULT NULL,
  `AddressID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;



--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `UserEmail` varchar(100) COLLATE latin1_german1_ci DEFAULT NULL,
  `UserName` varchar(100) COLLATE latin1_german1_ci DEFAULT NULL,
  `UserFirstName` varchar(100) COLLATE latin1_german1_ci DEFAULT NULL,
  `UserLastName` varchar(100) COLLATE latin1_german1_ci DEFAULT NULL,
  `UserPassword` varchar(250) COLLATE latin1_german1_ci DEFAULT NULL,
  `IsAdmin` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;



--
-- Tabellenstruktur für Tabelle `vendor`
--

CREATE TABLE `vendor` (
  `VendorID` int(11) NOT NULL,
  `VendorName` varchar(45) COLLATE latin1_german1_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;


-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`AddressID`);

--
-- Indizes für die Tabelle `componentattributes`
--
ALTER TABLE `componentattributes`
  ADD PRIMARY KEY (`AttributeID`);

--
-- Indizes für die Tabelle `componenthasvalues`
--
ALTER TABLE `componenthasvalues`
  ADD PRIMARY KEY (`ComponentValueID`),
  ADD KEY `F_ComponentHasValues` (`ComponentID`),
  ADD KEY `F_ComponentHasValues_2` (`AttributeID`);

--
-- Indizes für die Tabelle `components`
--
ALTER TABLE `components`
  ADD PRIMARY KEY (`ComponentID`),
  ADD KEY `F_Components` (`SupplierID`),
  ADD KEY `F_ComponentVendorID` (`ComponentVendorID`),
  ADD KEY `F_ComponentTypeID` (`ComponentTypeID`);

--
-- Indizes für die Tabelle `componentsinroom`
--
ALTER TABLE `componentsinroom`
  ADD PRIMARY KEY (`ComponentRoomID`),
  ADD KEY `ComponentID` (`ComponentID`,`RoomID`),
  ADD KEY `RoomID` (`RoomID`);

--
-- Indizes für die Tabelle `componenttypehasattributes`
--
ALTER TABLE `componenttypehasattributes`
  ADD PRIMARY KEY (`ComponentTypeAttributeID`),
  ADD KEY `F_ComponentTypeHasAttributes` (`ComponentTypeID`),
  ADD KEY `F_AttributeID` (`AttributeID`);

--
-- Indizes für die Tabelle `componenttypes`
--
ALTER TABLE `componenttypes`
  ADD PRIMARY KEY (`ComponentTypeID`);

--
-- Indizes für die Tabelle `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`RoomID`);

--
-- Indizes für die Tabelle `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`SupplierID`),
  ADD KEY `F_Supplier` (`AddressID`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- Indizes für die Tabelle `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`VendorID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `address`
--
ALTER TABLE `address`
  MODIFY `AddressID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT für Tabelle `componentattributes`
--
ALTER TABLE `componentattributes`
  MODIFY `AttributeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT für Tabelle `componenthasvalues`
--
ALTER TABLE `componenthasvalues`
  MODIFY `ComponentValueID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT für Tabelle `components`
--
ALTER TABLE `components`
  MODIFY `ComponentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT für Tabelle `componentsinroom`
--
ALTER TABLE `componentsinroom`
  MODIFY `ComponentRoomID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT für Tabelle `componenttypehasattributes`
--
ALTER TABLE `componenttypehasattributes`
  MODIFY `ComponentTypeAttributeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT für Tabelle `componenttypes`
--
ALTER TABLE `componenttypes`
  MODIFY `ComponentTypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT für Tabelle `rooms`
--
ALTER TABLE `rooms`
  MODIFY `RoomID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT für Tabelle `supplier`
--
ALTER TABLE `supplier`
  MODIFY `SupplierID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;


--INSERTS

--
-- Daten für Tabelle `address`
--

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

-- --------------------------------------------------------



--
-- Daten für Tabelle `componentattributes`
--

INSERT INTO `componentattributes` (`AttributeID`, `AttributeName`) VALUES
(1, 'Festplatte '),
(2, 'Grafikkarte'),
(3, 'Arbeitsspeicher'),
(4, 'Monitor'),
(5, 'Anschlüsse'),
(6, 'Kabel');

-- --------------------------------------------------------



--
-- Daten für Tabelle `componenthasvalues`
--

INSERT INTO `componenthasvalues` (`ComponentValueID`, `ComponentID`, `AttributeID`, `AttributeValue`) VALUES
(1, 1, 1, 'SSD 250 GB'),
(2, 1, 5, '3 x PCI 16\r\n5 x USB 3.0\r\nAudioJack\r\n1 x HDMI \r\n2 x VGa');

-- --------------------------------------------------------


--
-- Daten für Tabelle `components`
--

INSERT INTO `components` (`ComponentID`, `ComponentName`, `SupplierID`, `ComponentPurchaseDate`, `ComponentWarranty`, `ComponentNotes`, `ComponentVendorID`, `ComponentTypeID`, `ComponentReceipt`) VALUES
(1, 'Think Center 12020', 1, '0000-00-00', 2, '2 Jahre Garantie', 902, 1, NULL);

-- --------------------------------------------------------

--
-- Daten für Tabelle `componentsinroom`
--

INSERT INTO `componentsinroom` (`ComponentRoomID`, `ComponentID`, `RoomID`) VALUES
(1, 1, 100);

-- --------------------------------------------------------


--
-- Daten für Tabelle `componenttypehasattributes`
--

INSERT INTO `componenttypehasattributes` (`ComponentTypeAttributeID`, `ComponentTypeID`, `AttributeID`) VALUES
(1, 1, 5),
(2, 1, 1);

-- --------------------------------------------------------


--
-- Daten für Tabelle `componenttypes`
--

INSERT INTO `componenttypes` (`ComponentTypeID`, `ComponentTypeName`, `IsSoftware`) VALUES
(1, 'PC', 0),
(2, 'Switches', 0),
(3, 'Router', 0),
(8, 'Accesspoints', 0),
(10, 'Drucker', 0),
(12, 'Beamer', 0),
(14, 'Visualizer', 0),
(16, 'Software', 1);

-- --------------------------------------------------------

--
-- Daten für Tabelle `rooms`
--

INSERT INTO `rooms` (`RoomID`, `RoomNo`, `RoomName`, `RoomNodes`) VALUES
(100, '101', 'Sekretäriat', NULL),
(102, '102', 'Kopierer Raum', 'Raum zum kopieren'),
(105, '103', 'Besenkammer', 'Raum für Besen und Heulsusen '),
(107, '104', 'Lehrer Zimmer', NULL),
(111, '105', 'Lager', 'Lagerraum'),
(113, '106', 'Besprechungzimmer', NULL),
(115, '107', 'Büro 001', NULL),
(117, '108', 'Büro  002', NULL);

-- --------------------------------------------------------


--
-- Daten für Tabelle `supplier`
--

INSERT INTO `supplier` (`SupplierID`, `SupplierCompanyName`, `AddressID`) VALUES
(1, 'HardwareFix Gbr', 5),
(2, 'SuperGünstig', 8);

-- --------------------------------------------------------

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`UserID`, `UserEmail`, `UserName`, `UserFirstName`, `UserLastName`, `UserPassword`, `IsAdmin`) VALUES
(1, 'Admin@b3-fuerth.de', 'Admin', 'Admin', 'Admin', 'e3afed0047b08059d0fada10f400c1e5', 1),
(2, 'benutzer@b3-fuerth.de', 'Benutzer', 'Ben', 'Utzer', 'b15b7b0340f52d448dc6191fc9317f3a', 0);

-- --------------------------------------------------------


--
-- Daten für Tabelle `vendor`
--

INSERT INTO `vendor` (`VendorID`, `VendorName`) VALUES
(901, 'Microsoft'),
(902, 'Lenovo');

-- --------------------------------------------------------










COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;