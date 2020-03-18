-- phpMyAdmin SQL Dump
-- version 5.0.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 11, 2020 at 09:54 AM
-- Server version: 5.7.29-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `agora`	
--

-- --------------------------------------------------------

--
-- Table structure for table `Awards`
--

CREATE TABLE `Awards` (
  `AwardID` int(11) NOT NULL,
  `Name` varchar(25) NOT NULL,
  `Type` enum('Medal','Badge') NOT NULL,
  `ImageURL` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `Awards`:
--

-- --------------------------------------------------------

--
-- Table structure for table `FireteamMembers`
--

CREATE TABLE `FireteamMembers` (
  `UserID` int(11) NOT NULL,
  `FireteamID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `FireteamMembers`:
--   `UserID`
--       `Users` -> `UserID`
--   `FireteamID`
--       `Fireteams` -> `FireteamID`
--

-- --------------------------------------------------------

--
-- Table structure for table `Fireteams`
--

CREATE TABLE `Fireteams` (
  `FireteamID` int(11) NOT NULL,
  `ParentID` int(11) DEFAULT NULL,
  `Name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `Fireteams`:
--   `ParentID`
--       `Fireteams` -> `FireteamID`
--

-- --------------------------------------------------------

--
-- Table structure for table `Groups`
--

CREATE TABLE `Groups` (
  `GroupID` int(11) NOT NULL,
  `Name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `Groups`:
--

--
-- Dumping data for table `Groups`
--

INSERT INTO `Groups` (`GroupID`, `Name`) VALUES(1, 'Administrators');
INSERT INTO `Groups` (`GroupID`, `Name`) VALUES(2, 'Moderators');
INSERT INTO `Groups` (`GroupID`, `Name`) VALUES(3, 'Member');

-- --------------------------------------------------------

--
-- Table structure for table `GroupUsers`
--

CREATE TABLE `GroupUsers` (
  `UserID` int(11) NOT NULL,
  `GroupID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `GroupUsers`:
--   `UserID`
--       `Users` -> `UserID`
--   `GroupID`
--       `Groups` -> `GroupID`
--

-- --------------------------------------------------------

--
-- Table structure for table `OperationAttendance`
--

CREATE TABLE `OperationAttendance` (
  `UserID` int(11) NOT NULL,
  `OperationID` int(11) NOT NULL,
  `ExpectedAttendance` enum('Yes','No') NOT NULL,
  `RealAttendance` enum('Yes','No','Unsure') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `OperationAttendance`:
--   `OperationID`
--       `OperationInfo` -> `OperationID`
--   `UserID`
--       `Users` -> `UserID`
--

-- --------------------------------------------------------

--
-- Table structure for table `OperationInfo`
--

CREATE TABLE `OperationInfo` (
  `OperationID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `StartDateTime` datetime NOT NULL,
  `EndDateTime` datetime NOT NULL,
  `ExpectedAttendance` enum('Mandatory','Optional','None') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `OperationInfo`:
--

-- --------------------------------------------------------

--
-- Table structure for table `Permissions`
--

CREATE TABLE `Permissions` (
  `PermissionID` varchar(25) NOT NULL,
  `Name` varchar(25) NOT NULL,
  `Description` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `Permissions`:
--

--
-- Dumping data for table `Permissions`
--

INSERT INTO `Permissions` (`PermissionID`, `Name`, `Description`) VALUES(
	'administration', 
	'Administration', 
	'Allows the user to see the administration panel on their home page as well as access the administration portal.');

INSERT INTO `Permissions` (`PermissionID`, `Name`, `Description`) VALUES(
	'awardAdministration',
	'Award Administration', 
	'Allows the user to add and remove awards from the system, as well as assign them to members.');

INSERT INTO `Permissions` (`PermissionID`, `Name`, `Description`) VALUES(
	'fireteamAdministration',
	'Fireteam Administration',
	'Allows the user access to fire team administration (i.e creating, removing and updating fire team information.)');

INSERT INTO `Permissions` (`PermissionID`, `Name`, `Description`) VALUES(
	'groupAdministration',
	'Group Administration',
	'Gives the user access to create, update and delete permission groups.');

INSERT INTO `Permissions` (`PermissionID`, `Name`, `Description`) VALUES(
	'operationAdministration',
	'Operation Administration',
	'Allows the user to add and remove operations');

INSERT INTO `Permissions` (`PermissionID`, `Name`, `Description`) VALUES(
	'operationModeration',
	'Operation Moderation', 
	'Allows for the user to change the attendance of other members.');

INSERT INTO `Permissions` (`PermissionID`, `Name`, `Description`) VALUES(
	'rankAdministration',
	'Rank Administration',
	'Allows the user to add and remove ranks to the system, as well as assign them to users.');

INSERT INTO `Permissions` (`PermissionID`, `Name`, `Description`) VALUES(
	'recommendationManagement',
	'Recommendation Management',
	'Allows the user to give and delete recommendations.');

INSERT INTO `Permissions` (`PermissionID`, `Name`, `Description`) VALUES(
	'userAdministration',
	'User Administration',
	'This permission group is used to determine if the user has access to add, remove and update user information.');

INSERT INTO `Permissions` (`PermissionID`, `Name`, `Description`) VALUES(
	'viewProfiles',
	'View Profiles',
	'Permission required to view profiles other than ones own.');

-- --------------------------------------------------------

--
-- Table structure for table `PermissionValues`
--

CREATE TABLE `PermissionValues` (
  `GroupID` int(11) NOT NULL,
  `PermissionID` varchar(25) NOT NULL,
  `Value` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `PermissionValues`:
--   `GroupID`
--       `Groups` -> `GroupID`
--   `PermissionID`
--       `Permissions` -> `PermissionID`
--

--
-- Dumping data for table `PermissionValues`
--

INSERT INTO `PermissionValues` (`GroupID`, `PermissionID`, `Value`) VALUES(1, 'administration',			1);
INSERT INTO `PermissionValues` (`GroupID`, `PermissionID`, `Value`) VALUES(1, 'awardAdministration',		1);
INSERT INTO `PermissionValues` (`GroupID`, `PermissionID`, `Value`) VALUES(1, 'fireteamAdministration',		1);
INSERT INTO `PermissionValues` (`GroupID`, `PermissionID`, `Value`) VALUES(1, 'groupAdministration',		1);
INSERT INTO `PermissionValues` (`GroupID`, `PermissionID`, `Value`) VALUES(1, 'operationAdministration',	1);
INSERT INTO `PermissionValues` (`GroupID`, `PermissionID`, `Value`) VALUES(1, 'operationModeration',		1);
INSERT INTO `PermissionValues` (`GroupID`, `PermissionID`, `Value`) VALUES(1, 'rankAdministration',		1);
INSERT INTO `PermissionValues` (`GroupID`, `PermissionID`, `Value`) VALUES(1, 'recommendationManagement',	1);
INSERT INTO `PermissionValues` (`GroupID`, `PermissionID`, `Value`) VALUES(1, 'userAdministration',		1);
INSERT INTO `PermissionValues` (`GroupID`, `PermissionID`, `Value`) VALUES(1, 'viewProfiles',			1);

INSERT INTO `PermissionValues` (`GroupID`, `PermissionID`, `Value`) VALUES(2, 'administration',			1);
INSERT INTO `PermissionValues` (`GroupID`, `PermissionID`, `Value`) VALUES(2, 'awardAdministration',		0);
INSERT INTO `PermissionValues` (`GroupID`, `PermissionID`, `Value`) VALUES(2, 'fireteamAdministration',		0);
INSERT INTO `PermissionValues` (`GroupID`, `PermissionID`, `Value`) VALUES(2, 'groupAdministration',		0);
INSERT INTO `PermissionValues` (`GroupID`, `PermissionID`, `Value`) VALUES(2, 'operationAdministration',	0);
INSERT INTO `PermissionValues` (`GroupID`, `PermissionID`, `Value`) VALUES(2, 'operationModeration',		1);
INSERT INTO `PermissionValues` (`GroupID`, `PermissionID`, `Value`) VALUES(2, 'rankAdministration',		0);
INSERT INTO `PermissionValues` (`GroupID`, `PermissionID`, `Value`) VALUES(2, 'recommendationManagement',	0);
INSERT INTO `PermissionValues` (`GroupID`, `PermissionID`, `Value`) VALUES(2, 'userAdministration',		0);
INSERT INTO `PermissionValues` (`GroupID`, `PermissionID`, `Value`) VALUES(2, 'viewProfiles',			1);
-- --------------------------------------------------------

--
-- Table structure for table `Ranks`
--

CREATE TABLE `Ranks` (
  `RankID` int(11) NOT NULL,
  `Name` varchar(25) NOT NULL,
  `Abbreviation` varchar(25) NOT NULL,
  `ImageURL` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `Ranks`:
--

-- --------------------------------------------------------

--
-- Table structure for table `Recommendations`
--

CREATE TABLE `Recommendations` (
  `RecommendationID` int(11) NOT NULL,
  `RecipientID` int(11) NOT NULL,
  `GiverID` int(11) NOT NULL,
  `PointValue` int(11) NOT NULL,
  `Description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `Recommendations`:
--   `GiverID`
--       `Users` -> `UserID`
--   `RecipientID`
--       `Users` -> `UserID`
--

-- --------------------------------------------------------

--
-- Table structure for table `UserAwards`
--

CREATE TABLE `UserAwards` (
  `UserID` int(11) NOT NULL,
  `AwardID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `UserAwards`:
--   `UserID`
--       `Users` -> `UserID`
--   `AwardID`
--       `Awards` -> `AwardID`
--

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `UserID` int(11) NOT NULL,
  `RankID` int(11) NOT NULL DEFAULT '0',
  `Username` varchar(25) NOT NULL,
  `Password` varchar(64) NOT NULL,
  `First Name` varchar(25) NOT NULL,
  `Last Name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONSHIPS FOR TABLE `Users`:
--   `RankID`
--       `Ranks` -> `RankID`
--

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Awards`
--
ALTER TABLE `Awards`
  ADD PRIMARY KEY (`AwardID`);

--
-- Indexes for table `FireteamMembers`
--
ALTER TABLE `FireteamMembers`
  ADD KEY `UserID` (`UserID`),
  ADD KEY `FireteamID` (`FireteamID`);

--
-- Indexes for table `Fireteams`
--
ALTER TABLE `Fireteams`
  ADD PRIMARY KEY (`FireteamID`),
  ADD KEY `ParentID` (`ParentID`);

--
-- Indexes for table `Groups`
--
ALTER TABLE `Groups`
  ADD PRIMARY KEY (`GroupID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `GroupUsers`
--
ALTER TABLE `GroupUsers`
  ADD UNIQUE KEY `UserGroupID` (`UserID`,`GroupID`) USING BTREE,
  ADD KEY `GroupID` (`GroupID`);

--
-- Indexes for table `OperationAttendance`
--
ALTER TABLE `OperationAttendance`
  ADD UNIQUE KEY `UserOperationID` (`UserID`,`OperationID`),
  ADD KEY `OperationID` (`OperationID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `OperationInfo`
--
ALTER TABLE `OperationInfo`
  ADD PRIMARY KEY (`OperationID`);

--
-- Indexes for table `Permissions`
--
ALTER TABLE `Permissions`
  ADD PRIMARY KEY (`PermissionID`);

--
-- Indexes for table `PermissionValues`
--
ALTER TABLE `PermissionValues`
  ADD PRIMARY KEY (`GroupID`,`PermissionID`) USING BTREE,
  ADD KEY `PermissionID` (`PermissionID`);

--
-- Indexes for table `Ranks`
--
ALTER TABLE `Ranks`
  ADD PRIMARY KEY (`RankID`);

--
-- Indexes for table `Recommendations`
--
ALTER TABLE `Recommendations`
  ADD PRIMARY KEY (`RecommendationID`),
  ADD KEY `RecipientID` (`RecipientID`),
  ADD KEY `GiverID` (`GiverID`);

--
-- Indexes for table `UserAwards`
--
ALTER TABLE `UserAwards`
  ADD UNIQUE KEY `UserID` (`UserID`,`AwardID`) USING BTREE,
  ADD KEY `AwardID` (`AwardID`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD KEY `RankID` (`RankID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Awards`
--
ALTER TABLE `Awards`
  MODIFY `AwardID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Fireteams`
--
ALTER TABLE `Fireteams`
  MODIFY `FireteamID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Groups`
--
ALTER TABLE `Groups`
  MODIFY `GroupID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `OperationInfo`
--
ALTER TABLE `OperationInfo`
  MODIFY `OperationID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Ranks`
--
ALTER TABLE `Ranks`
  MODIFY `RankID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Recommendations`
--
ALTER TABLE `Recommendations`
  MODIFY `RecommendationID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `FireteamMembers`
--
ALTER TABLE `FireteamMembers`
  ADD CONSTRAINT `FireteamMembers_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FireteamMembers_ibfk_2` FOREIGN KEY (`FireteamID`) REFERENCES `Fireteams` (`FireteamID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Fireteams`
--
ALTER TABLE `Fireteams`
  ADD CONSTRAINT `Fireteams_ibfk_1` FOREIGN KEY (`ParentID`) REFERENCES `Fireteams` (`FireteamID`) ON UPDATE CASCADE;

--
-- Constraints for table `GroupUsers`
--
ALTER TABLE `GroupUsers`
  ADD CONSTRAINT `GroupUsers_ibfk_3` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `GroupUsers_ibfk_4` FOREIGN KEY (`GroupID`) REFERENCES `Groups` (`GroupID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `OperationAttendance`
--
ALTER TABLE `OperationAttendance`
  ADD CONSTRAINT `OperationAttendance_ibfk_3` FOREIGN KEY (`OperationID`) REFERENCES `OperationInfo` (`OperationID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `OperationAttendance_ibfk_4` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `PermissionValues`
--
ALTER TABLE `PermissionValues`
  ADD CONSTRAINT `PermissionValues_ibfk_2` FOREIGN KEY (`GroupID`) REFERENCES `Groups` (`GroupID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `PermissionValues_ibfk_3` FOREIGN KEY (`PermissionID`) REFERENCES `Permissions` (`PermissionID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Recommendations`
--
ALTER TABLE `Recommendations`
  ADD CONSTRAINT `Recommendations_ibfk_1` FOREIGN KEY (`GiverID`) REFERENCES `Users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Recommendations_ibfk_2` FOREIGN KEY (`RecipientID`) REFERENCES `Users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `UserAwards`
--
ALTER TABLE `UserAwards`
  ADD CONSTRAINT `UserAwards_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `UserAwards_ibfk_2` FOREIGN KEY (`AwardID`) REFERENCES `Awards` (`AwardID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Users`
--
ALTER TABLE `Users`
  ADD CONSTRAINT `Users_ibfk_1` FOREIGN KEY (`RankID`) REFERENCES `Ranks` (`RankID`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

