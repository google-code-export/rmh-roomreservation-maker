-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 24, 2012 at 02:56 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rmhreservationdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `emailactivity`
--

DROP TABLE IF EXISTS `emailactivity`;
CREATE TABLE IF NOT EXISTS `emailactivity` (
  `EmailActivityID` int(11) NOT NULL AUTO_INCREMENT,
  `UserLoginInfoID` varchar(50) NOT NULL,
  `EmailOut` varchar(255) NOT NULL,
  `DateSent` datetime NOT NULL,
  PRIMARY KEY (`EmailActivityID`),
  KEY `UserLoginInfoID` (`UserLoginInfoID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `emailactivity`
--

INSERT INTO `emailactivity` (`EmailActivityID`, `UserLoginInfoID`, `EmailOut`, `DateSent`) VALUES
(1, 'Tom7186562398', 'mary1@gmail.com', '2012-02-18 13:22:20'),
(2, 'Tom7186562398', 'mary1@gmail.com', '2012-02-20 20:24:22'),
(3, 'Frank2126565511', 'mary1@gmail.com', '2012-02-21 23:44:18'),
(4, 'Frank2126565511', 'mary1@gmail.com', '2012-03-01 23:44:12'),
(5, 'Frank2126565511', 'mary1@gmail.com', '2012-03-03 17:42:12'),
(6, 'Tom7186562398', 'mary1@gmail.com', '2012-02-20 14:23:13'),
(7, 'Frank2126565511', 'mary1@gmail.com', '2012-03-03 12:43:12');

-- --------------------------------------------------------

--
-- Table structure for table `familyprofile`
--

DROP TABLE IF EXISTS `familyprofile`;
CREATE TABLE IF NOT EXISTS `familyprofile` (
  `FamilyProfileID` int(11) NOT NULL AUTO_INCREMENT,
  `ParentFirstName` varchar(50) NOT NULL,
  `ParentLastName` varchar(50) NOT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Phone1` varchar(15) NOT NULL,
  `Phone2` varchar(15) DEFAULT NULL,
  `Address` varchar(100) DEFAULT NULL,
  `City` varchar(50) DEFAULT NULL,
  `State` varchar(10) DEFAULT NULL,
  `ZipCode` varchar(12) DEFAULT NULL,
  `Country` varchar(50) DEFAULT NULL,
  `PatientFirstName` varchar(50) NOT NULL,
  `PatientLastName` varchar(50) NOT NULL,
  `PatientRelation` varchar(50) DEFAULT NULL,
  `PatientBirthDate` datetime DEFAULT NULL,
  `PatientDiagnosis` text,
  `FormPDF` varchar(255) DEFAULT NULL,
  `Notes` text,
  PRIMARY KEY (`FamilyProfileID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `familyprofile`
--

INSERT INTO `familyprofile` (`FamilyProfileID`, `ParentFirstName`, `ParentLastName`, `Email`, `Phone1`, `Phone2`, `Address`, `City`, `State`, `ZipCode`, `Country`, `PatientFirstName`, `PatientLastName`, `PatientRelation`, `PatientBirthDate`, `PatientDiagnosis`, `FormPDF`, `Notes`) VALUES
(1, 'Jane', 'Smith', 'janesmith@gmail.com', '7181234455', '6465562312', '110-76 76th Avenue', 'White Plains', 'New York', '10601', 'USA', 'Joey', 'Smith', 'Mother', '1998-02-18 00:00:00', 'Pediatric Sarcomas', 'www.rmhforms.com/family1form.pdf', 'patient is allergic to peaches'),
(2, 'Scott', 'Miller', 'scottmiller@gmail.com', '7188884455', '6465562322', 'Borgartun 34', 'REYKJAV?K', 'REYKJAV?K', '105', 'Iceland', 'Nate', 'Miller', 'Father', '1997-01-14 00:00:00', 'Pediatric Leukemias', 'www.rmhforms.com/family2form.pdf', 'patient is allergic to cats');

-- --------------------------------------------------------

--
-- Table structure for table `profilechangeactivity`
--

DROP TABLE IF EXISTS `profilechangeactivity`;
CREATE TABLE IF NOT EXISTS `profilechangeactivity` (
  `ProfileChangeActivityID` int(11) NOT NULL AUTO_INCREMENT,
  `ProfileChangeRequestID` int(11) NOT NULL,
  `UserLoginInfoID` varchar(50) NOT NULL,
  `FamilyProfileID` int(11) NOT NULL,
  `Status` varchar(50) NOT NULL,
  `DateStatusSubmitted` datetime NOT NULL,
  `Notes` text,
  PRIMARY KEY (`ProfileChangeActivityID`),
  KEY `UserLoginInfoID` (`UserLoginInfoID`),
  KEY `FamilyProfileID` (`FamilyProfileID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `profilechangeactivity`
--

INSERT INTO `profilechangeactivity` (`ProfileChangeActivityID`, `ProfileChangeRequestID`, `UserLoginInfoID`, `FamilyProfileID`, `Status`, `DateStatusSubmitted`, `Notes`) VALUES
(1, 1, 'Mary7183334444', 1, 'unconfirmed', '2012-02-19 12:33:19', 'New Address'),
(2, 1, 'Tom7186562398', 1, 'confirmed', '2012-02-20 14:23:13', 'New Address'),
(3, 2, 'Mary7183334444', 2, 'unconfirmed', '2012-03-02 15:44:22', 'New Address'),
(4, 2, 'Frank2126565511', 2, 'confirmed', '2012-03-03 12:43:12', 'New Address');

-- --------------------------------------------------------

--
-- Table structure for table `requestkeynumber`
--

DROP TABLE IF EXISTS `requestkeynumber`;
CREATE TABLE IF NOT EXISTS `requestkeynumber` (
  `ProfileChangeRequestID` int(11) NOT NULL,
  `RoomReservationRequestID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rmhstaffprofile`
--

DROP TABLE IF EXISTS `rmhstaffprofile`;
CREATE TABLE IF NOT EXISTS `rmhstaffprofile` (
  `RMHStaffProfileID` int(11) NOT NULL AUTO_INCREMENT,
  `UserLoginInfoID` varchar(50) NOT NULL,
  `Title` varchar(10) DEFAULT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Phone` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`RMHStaffProfileID`),
  KEY `UserLoginInfoID` (`UserLoginInfoID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `rmhstaffprofile`
--

INSERT INTO `rmhstaffprofile` (`RMHStaffProfileID`, `UserLoginInfoID`, `Title`, `FirstName`, `LastName`, `Phone`) VALUES
(1, 'Tom7186562398', 'Mr.', 'Tom', 'Hansen', '7186562398'),
(2, 'Frank2126565511', 'Mr.', 'Frank', 'Petersen', '2126565511');

-- --------------------------------------------------------

--
-- Table structure for table `roomreservationactivity`
--

DROP TABLE IF EXISTS `roomreservationactivity`;
CREATE TABLE IF NOT EXISTS `roomreservationactivity` (
  `RoomReservationActivityID` int(11) NOT NULL AUTO_INCREMENT,
  `RoomReservationRequestID` int(11) NOT NULL,
  `UserLoginInfoID` varchar(50) NOT NULL,
  `FamilyProfileID` int(11) NOT NULL,
  `Status` varchar(50) NOT NULL,
  `DateStatusSubmitted` datetime NOT NULL,
  `BeginDate` datetime NOT NULL,
  `EndDate` datetime NOT NULL,
  `Notes` text,
  PRIMARY KEY (`RoomReservationActivityID`),
  KEY `UserLoginInfoID` (`UserLoginInfoID`),
  KEY `FamilyProfileID` (`FamilyProfileID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `roomreservationactivity`
--

INSERT INTO `roomreservationactivity` (`RoomReservationActivityID`, `RoomReservationRequestID`, `UserLoginInfoID`, `FamilyProfileID`, `Status`, `DateStatusSubmitted`, `BeginDate`, `EndDate`, `Notes`) VALUES
(1, 1, 'Mary7183334444', 1, 'applied', '2012-02-17 10:33:28', '2012-03-01 00:00:00', '2012-04-01 00:00:00', ''),
(2, 1, 'Tom7186562398', 1, 'applied-confirmed', '2012-02-18 13:22:20', '2012-03-01 00:00:00', '2012-04-01 00:00:00', ''),
(3, 2, 'Mary7183334444', 1, 'modified', '2012-02-19 12:33:19', '2012-03-17 00:00:00', '2012-04-17 00:00:00', ''),
(4, 2, 'Tom7186562398', 1, 'modified-confirmed', '2012-02-20 20:24:22', '2012-03-17 00:00:00', '2012-04-17 00:00:00', ''),
(5, 3, 'Mary7183334444', 1, 'cancelled', '2012-02-21 21:33:11', '2012-03-17 00:00:00', '2012-04-17 00:00:00', ''),
(6, 4, 'Mary7183334444', 2, 'applied', '2012-03-01 23:44:22', '2012-04-15 00:00:00', '2012-04-17 00:00:00', ''),
(7, 5, 'Mary7183334444', 2, 'applied', '2012-03-02 15:44:22', '2012-04-29 00:00:00', '2012-05-01 00:00:00', ''),
(8, 5, 'Frank2126565511', 2, 'applied-confirmed', '2012-03-03 17:42:12', '2012-04-29 00:00:00', '2012-05-01 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `socialworkerprofile`
--

DROP TABLE IF EXISTS `socialworkerprofile`;
CREATE TABLE IF NOT EXISTS `socialworkerprofile` (
  `SocialWorkerProfileID` int(11) NOT NULL AUTO_INCREMENT,
  `UserLoginInfoID` varchar(50) NOT NULL,
  `Title` varchar(10) DEFAULT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `HospitalAffiliation` varchar(50) NOT NULL,
  `Phone` varchar(15) DEFAULT NULL,
  `EmailNotification` enum('Y','N') NOT NULL,
  PRIMARY KEY (`SocialWorkerProfileID`),
  KEY `UserLoginInfoID` (`UserLoginInfoID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `socialworkerprofile`
--

INSERT INTO `socialworkerprofile` (`SocialWorkerProfileID`, `UserLoginInfoID`, `Title`, `FirstName`, `LastName`, `HospitalAffiliation`, `Phone`, `EmailNotification`) VALUES
(1, 'Mary7183334444', 'Ms.', 'Mary', 'Tove', 'Memorial Sloan-Kettering Cancer Center', '7183334444', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `userprofile`
--

DROP TABLE IF EXISTS `userprofile`;
CREATE TABLE IF NOT EXISTS `userprofile` (
  `UserLoginInfoID` varchar(50) NOT NULL,
  `UserEmail` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `UserCategory` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`UserLoginInfoID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userprofile`
--

INSERT INTO `userprofile` (`UserLoginInfoID`, `UserEmail`, `Password`, `UserCategory`) VALUES
('Frank2126565511', 'frank1@gmail.com', 'password3', 'RMH Staff Approver'),
('Mary7183334444', 'mary1@gmail.com', 'password1', 'Social Worker'),
('Tom7186562398', 'tom1@gmail.com', 'password2', 'RMH Staff Approver');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `emailactivity`
--
ALTER TABLE `emailactivity`
  ADD CONSTRAINT `emailactivity_ibfk_1` FOREIGN KEY (`UserLoginInfoID`) REFERENCES `userprofile` (`UserLoginInfoID`);

--
-- Constraints for table `profilechangeactivity`
--
ALTER TABLE `profilechangeactivity`
  ADD CONSTRAINT `profilechangeactivity_ibfk_1` FOREIGN KEY (`UserLoginInfoID`) REFERENCES `userprofile` (`UserLoginInfoID`),
  ADD CONSTRAINT `profilechangeactivity_ibfk_2` FOREIGN KEY (`FamilyProfileID`) REFERENCES `familyprofile` (`FamilyProfileID`);

--
-- Constraints for table `rmhstaffprofile`
--
ALTER TABLE `rmhstaffprofile`
  ADD CONSTRAINT `rmhstaffprofile_ibfk_1` FOREIGN KEY (`UserLoginInfoID`) REFERENCES `userprofile` (`UserLoginInfoID`);

--
-- Constraints for table `roomreservationactivity`
--
ALTER TABLE `roomreservationactivity`
  ADD CONSTRAINT `roomreservationactivity_ibfk_1` FOREIGN KEY (`UserLoginInfoID`) REFERENCES `userprofile` (`UserLoginInfoID`),
  ADD CONSTRAINT `roomreservationactivity_ibfk_2` FOREIGN KEY (`FamilyProfileID`) REFERENCES `familyprofile` (`FamilyProfileID`);

--
-- Constraints for table `socialworkerprofile`
--
ALTER TABLE `socialworkerprofile`
  ADD CONSTRAINT `socialworkerprofile_ibfk_1` FOREIGN KEY (`UserLoginInfoID`) REFERENCES `userprofile` (`UserLoginInfoID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
