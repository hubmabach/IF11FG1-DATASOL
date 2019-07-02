-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 01. Jul 2019 um 19:33
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

--
-- Daten für Tabelle `address`
--

INSERT INTO `address` (`AddressId`, `Street`, `PostalCode`, `City`, `Country`, `TelNo`, `MobilNo`, `FaxNo`, `MailAddress`) VALUES
(5, '2077 Vel, Av.', '22151', 'Konstanz', 'Germany', '(08657) 1782939', '(449) 494-3243', '(804) 859-8978', 'Morbi@aliquetProin.net'),
(9, '1752 Purus. Street', '78779', 'Zwickau', 'Germany', '(051) 35935584', '(787) 405-1583', '(984) 682-3280', 'viverra@dui.com'),
(654, '213-4233 Diam. Avenue', '34046', 'Andernach', 'Germany', '(0982) 31693233', '(421) 234-6016', '(484) 624-3642', 'auctor.ullamcorper@eleifend.com'),
(18546443, 'Ap #545-2788 Nullam Ave', '91881', 'Bad Neuenahr-Ahrweiler', 'Germany', '(01095) 6064220', '(238) 127-8714', '(801) 614-9089', 'orci@risusa.edu'),
(35059218, '9882 Cursus Road', '27316', 'Zweibrücken', 'Germany', '(0959) 24830831', '(678) 922-8155', '(666) 538-7841', 'pellentesque.massa@ornare.com'),
(35059219, '304-208 Dictum Ave', '85277', 'Bielefeld', 'Germany', '(07793) 1360604', '(559) 707-8268', '(693) 117-9418', 'egestas.hendrerit@arcu.co.uk'),
(35059220, 'P.O. Box 903, 2199 Sed St.', '63695', 'Wadgassen', 'Germany', '(077) 79692388', '(509) 940-2739', '(999) 694-6160', 'Cras.eu@porttitoreros.com'),
(35059221, 'P.O. Box 119, 2852 Amet, Rd.', '41464', 'Dreieich', 'Germany', '(04953) 4558522', '(969) 811-1831', '(782) 184-6418', 'at.arcu.Vestibulum@enimgravida.net'),
(35059222, 'P.O. Box 152, 5924 Nullam Road', '65607', 'Tübingen', 'Germany', '(037255) 333664', '(798) 743-2987', '(229) 915-0875', 'nulla.ante.iaculis@atiaculisquis.net'),
(2147483647, 'P.O. Box 207, 7610 Egestas. Road', '80957', 'Goslar', 'Germany', '(038599) 226477', '(181) 535-6080', '(152) 707-2735', 'Proin.vel.nisl@Inlorem.net');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `componentattributes`
--

CREATE TABLE `componentattributes` (
  `AttributeId` int(11) NOT NULL,
  `AttributeName` varchar(25) COLLATE latin1_german1_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

--
-- Daten für Tabelle `componentattributes`
--

INSERT INTO `componentattributes` (`AttributeId`, `AttributeName`) VALUES
(1, 'Festplatte '),
(2, 'Grafikkarte'),
(6, 'Arbeitsspeicher'),
(7, 'Monitor'),
(10, 'Anschlüsse'),
(11, 'Kabel');

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

--
-- Daten für Tabelle `componenthasvalues`
--

INSERT INTO `componenthasvalues` (`ComponentValueId`, `ComponentId`, `AttributeId`, `AttributeValue`) VALUES
(1, 8, 1, 'SSD 250 GB'),
(3, 8, 10, '3 x PCI 16\r\n5 x USB 3.0\r\nAudioJack\r\n1 x HDMI \r\n2 x VGa');

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

--
-- Daten für Tabelle `components`
--

INSERT INTO `components` (`ComponentId`, `ComponentName`, `SupplierId`, `ComponentPurchaseDate`, `ComponentWarranty`, `ComponentNotes`, `ComponentVendorId`, `ComponentTypeId`, `ComponentReceipt`) VALUES
(8, 'Think Center 12020', 1, '0000-00-00', 2, '2 Jahre Garantie', 902, 1, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `componentsinroom`
--

CREATE TABLE `componentsinroom` (
  `ComponentRoomId` int(11) NOT NULL,
  `ComponentId` int(11) DEFAULT NULL,
  `RoomId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

--
-- Daten für Tabelle `componentsinroom`
--

INSERT INTO `componentsinroom` (`ComponentRoomId`, `ComponentId`, `RoomId`) VALUES
(1, 8, 100);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `componenttypehasattributes`
--

CREATE TABLE `componenttypehasattributes` (
  `ComponentTypeAttributeId` int(11) NOT NULL,
  `ComponentTypeId` int(11) DEFAULT NULL,
  `AttributeId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

--
-- Daten für Tabelle `componenttypehasattributes`
--

INSERT INTO `componenttypehasattributes` (`ComponentTypeAttributeId`, `ComponentTypeId`, `AttributeId`) VALUES
(1, 1, 10),
(2, 1, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `componenttypes`
--

CREATE TABLE `componenttypes` (
  `ComponentTypeId` int(11) NOT NULL,
  `ComponentTypeName` varchar(45) COLLATE latin1_german1_ci DEFAULT NULL,
  `IsSoftware` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

--
-- Daten für Tabelle `componenttypes`
--

INSERT INTO `componenttypes` (`ComponentTypeId`, `ComponentTypeName`, `IsSoftware`) VALUES
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
-- Tabellenstruktur für Tabelle `rooms`
--

CREATE TABLE `rooms` (
  `RoomId` int(11) NOT NULL,
  `RoomNo` varchar(20) COLLATE latin1_german1_ci DEFAULT NULL,
  `RoomName` varchar(45) COLLATE latin1_german1_ci DEFAULT NULL,
  `RoomNodes` longtext COLLATE latin1_german1_ci
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

--
-- Daten für Tabelle `rooms`
--

INSERT INTO `rooms` (`RoomId`, `RoomNo`, `RoomName`, `RoomNodes`) VALUES
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
-- Tabellenstruktur für Tabelle `supplier`
--

CREATE TABLE `supplier` (
  `SupplierId` int(11) NOT NULL,
  `SupplierCompanyName` varchar(45) COLLATE latin1_german1_ci DEFAULT NULL,
  `AddressId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

--
-- Daten für Tabelle `supplier`
--

INSERT INTO `supplier` (`SupplierId`, `SupplierCompanyName`, `AddressId`) VALUES
(1, 'HardwareFix Gbr', 5),
(2, 'SuperGünstig', 35059222);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `table 12`
--

CREATE TABLE `table 12` (
  `COL 1` varchar(10) DEFAULT NULL,
  `COL 2` varchar(28) DEFAULT NULL,
  `COL 3` int(5) DEFAULT NULL,
  `COL 4` varchar(25) DEFAULT NULL,
  `COL 5` varchar(8) DEFAULT NULL,
  `COL 6` varchar(18) DEFAULT NULL,
  `COL 7` varchar(16) DEFAULT NULL,
  `COL 8` varchar(18) DEFAULT NULL,
  `COL 9` varchar(26) DEFAULT NULL,
  `COL 10` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `table 12`
--

INSERT INTO `table 12` (`COL 1`, `COL 2`, `COL 3`, `COL 4`, `COL 5`, `COL 6`, `COL 7`, `COL 8`, `COL 9`, `COL 10`) VALUES
('', 'Breslauer Str. 174 ', 86922, ' Sankt Ottilien ', ' Germany', ' 08193 / 920816 ', ' 0169 / 1315628 ', ' 08193 / 76676849 ', ' marieke.grant@mail.xyz ', ' '),
('', 'D?sseldorfer Str. 137 ', 14469, ' Potsdam ', ' Germany', ' 0331 / 74588651 ', ' 0162 / 2655685 ', ' 0331 / 22341773 ', ' bruno.mitchell@mail.xyz ', ' '),
('', 'Im Draum 101a ', 54340, ' Bekond ', ' Germany', ' 06502 / 30436495 ', ' 0154 / 5228004 ', ' 06502 / 45276937 ', ' jolina.carstens@mail.xyz ', ' '),
('', 'Landoisstr. 26 ', 31079, ' Almstedt ', ' Germany', ' 05065 / 9339083 ', ' 0162 / 8565501 ', ' 05065 / 30532294 ', ' anthony.seidl@mail.xyz ', ' '),
('', 'Papenbusch 130a ', 53859, ' Niederkassel ', ' Germany', ' 02208 / 41939515 ', ' 0157 / 3295055 ', ' 02208 / 311625 ', ' a.hertel@mail.xyz ', ' '),
('', 'Goebenstr. 147 ', 67822, ' Oberhausen an der Appel ', ' Germany', ' 06362 / 70998296 ', ' 0174 / 6752087 ', ' 06362 / 48954369 ', ' gabriele.zeller@mail.xyz ', ' '),
('', 'Florentine-Eichlzer-Str. 94 ', 24105, ' Kiel ', ' Germany', ' 0431 / 72206953 ', ' 0157 / 9676809 ', ' 0431 / 63407768 ', ' m.gebhart@mail.xyz ', ' '),
('', 'Mariendorfer Str. 100 ', 4910, ' Elsterwerda ', ' Germany', ' 03533 / 335609 ', ' 0162 / 2303651 ', ' 03533 / 25311859 ', ' k.unger@mail.xyz ', ' '),
('', 'Janningsweg 79 ', 66887, ' Horschbach ', ' Germany', ' 06381 / 67190945 ', ' 0178 / 2602717 ', ' 06381 / 69046595 ', ' aaron.witt@mail.xyz ', ' '),
('', 'Oberschlesier Str. 93 ', 97348, ' Markt Einersheim ', ' Germany', ' 09326 / 3994619 ', ' 0163 / 3733371 ', ' 09326 / 62136887 ', ' s.kuhlmann@mail.xyz ', ' '),
('', 'Nieland 26 ', 57539, ' Bitzen ', ' Germany', ' 02682 / 46034691 ', ' 0155 / 1441018 ', ' 02682 / 33632653 ', ' h.sandmann@mail.xyz ', ' '),
('', 'Sch?tzenstr. 71 ', 83112, ' Frasdorf ', ' Germany', ' 08052 / 81572481 ', ' 0177 / 5368544 ', ' 08052 / 6387702 ', ' m.resch@mail.xyz ', ' '),
('', 'Gropiusstr. 191 ', 24994, ' Jardelund ', ' Germany', ' 04639 / 48921233 ', ' 0152 / 8921039 ', ' 04639 / 64695460 ', ' e.karl@mail.xyz ', ' '),
('', 'Dorotheenstr. 29 ', 83737, ' Irschenberg ', ' Germany', ' 08025 / 70427239 ', ' 0152 / 8627055 ', ' 08025 / 10777270 ', ' henning.gerdes@mail.xyz ', ' '),
('', 'Meckmannweg 160 ', 56295, ' Lonnig ', ' Germany', ' 02654 / 77322583 ', ' 0161 / 9512068 ', ' 02654 / 27117372 ', ' oscar.dresler@mail.xyz ', ' ');

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
  `UserPassword` varchar(250) COLLATE latin1_german1_ci DEFAULT NULL,
  `IsAdmin` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`UserId`, `UserEmail`, `UserName`, `UserFirstName`, `UserLastName`, `UserPassword`, `IsAdmin`) VALUES
(1, 'Admin@b3-fuerth.de', 'Admin', 'Admin', 'Admin', 'e3afed0047b08059d0fada10f400c1e5', 1),
(3, 'benutzer@b3-fuerth.de', 'Benutzer', 'Ben', 'Utzer', 'b15b7b0340f52d448dc6191fc9317f3a', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `vendor`
--

CREATE TABLE `vendor` (
  `VendorId` int(11) NOT NULL,
  `VendorName` varchar(45) COLLATE latin1_german1_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

--
-- Daten für Tabelle `vendor`
--

INSERT INTO `vendor` (`VendorId`, `VendorName`) VALUES
(901, 'Microsoft'),
(902, 'Lenovo');

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
  MODIFY `AddressId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2147483647;

--
-- AUTO_INCREMENT für Tabelle `componentattributes`
--
ALTER TABLE `componentattributes`
  MODIFY `AttributeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT für Tabelle `componenthasvalues`
--
ALTER TABLE `componenthasvalues`
  MODIFY `ComponentValueId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `components`
--
ALTER TABLE `components`
  MODIFY `ComponentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT für Tabelle `componentsinroom`
--
ALTER TABLE `componentsinroom`
  MODIFY `ComponentRoomId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `componenttypehasattributes`
--
ALTER TABLE `componenttypehasattributes`
  MODIFY `ComponentTypeAttributeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `componenttypes`
--
ALTER TABLE `componenttypes`
  MODIFY `ComponentTypeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT für Tabelle `rooms`
--
ALTER TABLE `rooms`
  MODIFY `RoomId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT für Tabelle `supplier`
--
ALTER TABLE `supplier`
  MODIFY `SupplierId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `vendor`
--
ALTER TABLE `vendor`
  MODIFY `VendorId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=905;

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
