SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+07:00";

CREATE TABLE `tblregistration` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `firstName` varchar(150) DEFAULT NULL,
  `lastName` varchar(150) DEFAULT NULL,
  `emailId` varchar(150) DEFAULT NULL,
  `username` varchar(20) DEFAULT NULL,
  `userPassword` varchar(255) DEFAULT NULL,
  `regDate` timestamp NULL DEFAULT current_timestamp(),
  `activation_code` VARCHAR(64) DEFAULT NULL,
  `is_active` TINYINT(1) DEFAULT 0,
  `avatar` VARCHAR(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `tblcategory` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `categoryName` varchar(125) DEFAULT NULL,
  `createdBy` int(5) DEFAULT NULL,
  `creationDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `tblnotes` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `noteCategory` varchar(255) DEFAULT NULL,
  `noteTitle` varchar(255) DEFAULT NULL,
  `noteDescription` mediumtext DEFAULT NULL,
  `noteImage` varchar(255) DEFAULT NULL,
  `createdBy` int(5) DEFAULT NULL,
  `creationDate` timestamp NULL DEFAULT current_timestamp()
  `password_hash` VARCHAR(255) DEFAULT NULL;

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `tblnoteshistory` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `noteId` int(11) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `noteDetails` mediumtext DEFAULT NULL,
  `postingDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

COMMIT;
