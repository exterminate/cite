-- phpMyAdmin SQL Dump
-- version 4.1.9
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Jun 11, 2014 at 06:58 PM
-- Server version: 5.5.34
-- PHP Version: 5.5.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `cite`
--

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `email` varchar(80) NOT NULL,
  `deepLink` varchar(12) NOT NULL,
  `time` int(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `deepLink` (`deepLink`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `guestbook`
--

CREATE TABLE `guestbook` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `posted` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `guestbook`
--

INSERT INTO `guestbook` (`id`, `name`, `message`, `posted`) VALUES
(1, 'Ian COates', 'love it', '0000-00-00 00:00:00'),
(2, 'Dave Smith', 'great', '0000-00-00 00:00:00'),
(3, 'Josh', 'mint', '2014-04-22 19:07:33'),
(4, 'Josdfsdfh', 'mint', '2014-04-22 19:13:55');

-- --------------------------------------------------------

--
-- Table structure for table `links`
--

CREATE TABLE `links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stubId` varchar(8) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `email` varchar(60) NOT NULL,
  `orcid` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `datesubmitted` datetime NOT NULL,
  `doi` varchar(150) NOT NULL,
  `datedoi` datetime NOT NULL,
  `views` int(11) NOT NULL,
  `deepLink` varchar(12) NOT NULL,
  `emailUpdate` varchar(25000) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `deeplink` (`stubId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `links`
--

INSERT INTO `links` (`id`, `stubId`, `firstName`, `surname`, `email`, `orcid`, `description`, `datesubmitted`, `doi`, `datedoi`, `views`, `deepLink`, `emailUpdate`) VALUES
(28, 'b9s0aJPq', 'davo', '', 'ian.coates@gmail.com', '0000-0003-3540-6353', 'quality work', '2014-05-27 19:12:38', '10.1039/C3DT53133C', '2014-05-27 19:14:02', 2, '8559Y7Ct84qB', ''),
(29, '39w6iZo7', 'Ian', 'Coates', 'ian.coates@gmail.com', '0000-0003-3540-6353', 'adsfsdaf', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0, '', ''),
(30, 'lMIEr7fu', 'Ian', 'Coates', 'ian.coates@gmail.com', '0000-0003-3540-6353', 'adsfsdaf', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0, '', ''),
(31, 'kHRl7XTz', 'Ian', 'Coates', 'ian.coates@gmail.com', '0000-0003-3540-6353', 'adsfsdaf', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0, '', ''),
(32, 'c1W6cjy7', 'Ian', 'Coates', 'ian.coates@gmail.com', '0000-0003-3540-6353', 'adsfsdaf', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0, '', ''),
(33, 'IeF1nNLE', 'Ian', 'Coates', 'ian.coates@gmail.com', '0000-0003-3540-6353', 'adsfsdafdfsdf', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0, '', ''),
(34, 'YzbRrFTb', 'Ian', 'Coates', 'ian.coates@gmail.com', '0000-0003-3540-6353', 'sarasrsasra', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0, '', ''),
(35, '66OmbFqC', 'Ian', 'Coates', 'ian.coates@gmail.com', '0000-0003-3540-6353', 'fsdfsd', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0, '', ''),
(36, 'tfhdOLTV', 'Ian', 'Coates', 'ian.coates@gmail.com', '0000-0003-3540-6353', 'fsdfsd', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0, '', ''),
(37, '41ES2B59', 'Ian', 'Coates', 'ian.coates@gmail.com', '0000-0003-3540-6353', 'fsdfsd', '2014-06-08 14:56:56', '', '0000-00-00 00:00:00', 0, '', ''),
(38, 'O2OtziNr', 'Ian', 'Coates', 'ian.coates@gmail.com', '0000-0003-3540-6353', 'great!!', '2014-06-08 14:57:10', '', '0000-00-00 00:00:00', 0, '', ''),
(39, 'AKwce6aP', 'Ian', 'Coates', 'ian.coates@gmail.com', '0000-0003-3540-6353', 'great!!', '2014-06-08 14:58:49', '', '0000-00-00 00:00:00', 2, '', ''),
(40, 'hNJDRDsB', 'Ian', 'Coates', 'ian.coates@gmail.com', '0000-0003-3540-6353', 'awesome', '2014-06-08 14:59:28', '', '0000-00-00 00:00:00', 0, '', ''),
(41, '5D5y7MFt', 'Ian', 'Coates', 'ian.coates@gmail.com', '0000-0003-3540-6353', 'awesome cool', '2014-06-08 15:03:29', '', '0000-00-00 00:00:00', 0, '', ''),
(42, '5WJlkf3X', 'Ian', 'Coates', 'ian.coates@gmail.com', '0000-0003-3540-6353', 'cool beans', '2014-06-08 15:06:30', '', '0000-00-00 00:00:00', 0, '', ''),
(43, 'MFUMgM52', 'Ian', 'Coates', 'ian.coates@gmail.com', '0000-0003-3540-6353', 'cool beans', '2014-06-08 15:10:04', '10.1039/C3DT53133C', '2014-06-08 16:48:34', 0, 'ntzMib2JgCP2', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(10) NOT NULL,
  `lastlogin` datetime NOT NULL,
  `password` varchar(32) NOT NULL,
  `clue` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `lastlogin`, `password`, `clue`) VALUES
(1, 'iancoates', '2014-05-28 19:11:32', 'e8f025b16d7577470b65e526755fc8b8', 'e7ece74edfcf59a9c24645c5643f7a98');
