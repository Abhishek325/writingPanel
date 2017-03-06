-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2017 at 10:17 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mediawriting`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_announcement`
--

CREATE TABLE IF NOT EXISTS `admin_announcement` (
  `aid` int(11) NOT NULL AUTO_INCREMENT,
  `announcement` varchar(500) NOT NULL,
  `user_type` char(1) NOT NULL DEFAULT 'S',
  PRIMARY KEY (`aid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `admin_announcement`
--

INSERT INTO `admin_announcement` (`aid`, `announcement`, `user_type`) VALUES
(2, 'This is a tyest announcement...be ware.This is going to be a  tyest anouncement...abhishek''''s as''This is a tyest announcement...be ware.This is going to be a  tyest anouncement...abhishek''''s as''This is a tyest announcement...be ware.This is going to be a  tyest anouncement...abhishek''''s as''''', 'S');

-- --------------------------------------------------------

--
-- Table structure for table `admin_tips`
--

CREATE TABLE IF NOT EXISTS `admin_tips` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `user_type` char(1) NOT NULL DEFAULT 'S',
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `admin_tips`
--

INSERT INTO `admin_tips` (`tid`, `title`, `content`, `user_type`) VALUES
(22, 'Testsad asd ', 'This is a tests', 'S'),
(25, 'asdsad ', 'asd asd asd sad ', 'W');

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE IF NOT EXISTS `chat` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `jid` int(11) NOT NULL,
  `user1` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `user2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `chattext` text COLLATE utf8_unicode_ci NOT NULL,
  `chattime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=193 ;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id`, `jid`, `user1`, `user2`, `chattext`, `chattime`) VALUES
(110, 30, 'abhi', 'None', 'anyone there?', '2016-10-08 18:09:02'),
(111, 30, 'abhi', 'None', '???', '2016-10-08 18:12:05'),
(112, 30, 'abhi', 'None', 'Hello??', '2016-10-08 18:20:41'),
(113, 30, 'abhi', 'None', 'Serriously??', '2016-10-08 18:23:47'),
(114, 30, 'abhi', 'None', 'Please..I have a doubt', '2016-10-08 18:28:36'),
(115, 30, 'abhi', 'None', 'De anyone today?', '2016-10-08 18:34:31'),
(116, 30, 'abhi', 'None', '??', '2016-10-08 18:37:28'),
(117, 30, 'abhi', 'None', '????????????????????????????????????????', '2016-10-08 18:39:34'),
(118, 30, 'Abhishek325', 'None', 'Hey buddy', '2016-10-08 18:50:02'),
(119, 30, 'Abhishek325', 'None', 'Tell whats your problem??', '2016-10-08 18:51:45'),
(120, 30, 'abhi', 'None', 'I am pissed at your reponse', '2016-10-08 18:51:55'),
(121, 30, 'Abhishek325', 'None', 'nice', '2016-10-08 18:52:00'),
(122, 30, 'abhi', 'None', 'what nice??', '2016-10-08 18:52:03'),
(123, 30, 'abhi', 'None', 'der??', '2016-10-08 19:02:31'),
(124, 30, 'abhi', 'None', '??', '2016-10-08 19:03:40'),
(125, 30, 'abhi', 'None', 'hello...there?', '2016-10-09 06:30:43'),
(126, 30, 'abhi', 'None', 'anyone?', '2016-10-09 06:45:19'),
(127, 30, 'abhi', 'None', 'hellllooooo??', '2016-10-09 06:47:02'),
(128, 30, 'abhi', 'None', 'Another testr', '2016-10-09 07:32:18'),
(129, 30, 'abhi', 'None', 'hello there', '2016-10-09 08:02:20'),
(130, 30, 'abhi', 'None', 'test...this is a test', '2016-10-09 08:03:31'),
(131, 30, 'Abhishek325', 'None', 'Hi there', '2016-10-09 08:10:09'),
(132, 30, 'Abhishek325', 'None', 'hjello', '2016-10-09 08:39:38'),
(133, 30, 'Abhishek325', 'None', 'Hi there', '2016-10-09 09:10:21'),
(134, 30, 'abhi', 'None', 'hello...ssup.', '2016-10-09 09:10:30'),
(135, 30, 'Abhishek325', 'None', 'Noone much..u tell', '2016-10-09 09:10:37'),
(136, 30, 'abhi', 'None', 'Cool broo..', '2016-10-09 09:10:47'),
(137, 30, 'Abhishek325', 'None', 'nice', '2016-10-09 09:10:57'),
(138, 30, 'abhi', 'None', 'Hi there', '2016-10-09 10:35:06'),
(139, 30, 'Abhishek325', 'None', 'Hello', '2016-10-09 10:42:23'),
(140, 30, 'Abhishek325', 'None', 'ssup', '2016-10-09 10:46:43'),
(141, 30, 'Abhishek325', 'None', 'hello', '2016-10-09 11:30:23'),
(142, 30, 'Abhishek325', 'None', 'hello world there', '2016-10-09 11:34:59'),
(143, 30, 'Abhishek325', 'None', 'asdasd', '2016-10-09 11:39:23'),
(144, 30, 'Abhishek325', 'None', 'asdasdas', '2016-10-09 11:43:10'),
(145, 30, 'Abhishek325', 'None', 'sa;ldfamkls kfa;l s', '2016-10-09 11:52:13'),
(146, 30, 'Abhishek325', 'None', 'hello there', '2016-10-09 11:58:05'),
(147, 30, 'Abhishek325', 'None', 'asdasd asd asd', '2016-10-09 12:00:34'),
(148, 30, 'Abhishek325', 'None', 'Hello there', '2016-10-09 12:06:58'),
(149, 30, 'Abhishek325', 'None', 'Hi', '2016-10-09 12:14:37'),
(150, 28, 'abhi', 'None', 'hello', '2016-10-09 12:32:04'),
(151, 30, 'Abhishek325', 'None', 'Hello', '2016-10-09 12:32:20'),
(152, 33, 'abhi', 'None', 'Hi there', '2016-10-09 16:12:28'),
(153, 33, 'abhi', 'None', 'Hello..', '2016-10-09 16:14:48'),
(154, 33, 'abhi', 'None', 'Hi there', '2016-10-09 16:18:19'),
(155, 33, 'abhi', 'None', 'hello', '2016-10-09 16:18:30'),
(156, 33, 'abhi', 'None', 'Hello', '2016-10-10 14:48:07'),
(157, 33, 'abhi', 'None', 'Hi', '2016-10-10 14:49:07'),
(158, 33, 'abhi', 'None', 'There?', '2016-10-10 14:51:42'),
(159, 33, 'Abhishek325', 'None', 'Yes..please tell', '2016-10-10 14:51:57'),
(160, 0, 'Abhishek325', 'None', 'hi', '2016-10-10 15:09:46'),
(161, 0, 'Abhishek325', 'None', 'Hello', '2016-10-10 15:10:23'),
(162, 33, 'abhi', 'None', 'Hello', '2016-10-10 15:15:05'),
(163, 33, 'abhi', 'None', 'hello', '2016-10-10 15:17:19'),
(164, 33, 'abhi', 'None', 'Hi there', '2016-10-10 15:18:52'),
(165, 33, 'abhi', 'None', 'testing 123', '2016-10-10 15:25:15'),
(166, 0, 'Abhishek325', 'None', 'testing123', '2016-10-10 15:26:19'),
(167, 0, 'Abhishek325', 'None', 'testing321', '2016-10-10 15:28:37'),
(168, 30, 'Abhishek325', 'None', 'Hello there', '2016-10-10 15:30:14'),
(169, 30, 'Abhishek325', 'None', 'Hi there', '2016-10-10 15:30:38'),
(170, 28, 'Abhishek325', 'None', 'hello', '2016-10-10 15:39:48'),
(171, 30, 'Abhishek325', 'None', 'Hey writer', '2016-10-10 15:48:08'),
(172, 30, 'abhi', 'None', 'Hi admin', '2016-10-10 15:54:50'),
(173, 30, 'Abhishek325', 'None', 'Hi user again', '2016-10-10 15:57:26'),
(174, 30, 'Abhishek325', 'None', 'Hi writer again', '2016-10-10 15:58:54'),
(175, 30, 'Abhishek325', 'None', 'hello', '2016-10-10 16:03:00'),
(176, 30, 'Abhishek325', 'None', 'test', '2016-10-10 16:05:15'),
(177, 30, 'Abhishek325', 'None', 'testin123', '2016-10-10 16:07:39'),
(178, 30, 'abhi', 'None', 'hello', '2016-10-10 16:08:16'),
(179, 30, 'Abhishek325', 'None', 'Hi buddddyyy', '2016-10-10 17:07:05'),
(180, 30, 'abhi', 'None', 'Hey dude..any changes?', '2016-10-10 17:17:31'),
(181, 30, 'Abhishek325', 'None', 'Nothing as such', '2016-10-10 17:17:44'),
(182, 30, 'Abhishek325', 'None', 'chill', '2016-10-10 17:17:47'),
(183, 30, 'abhi', 'None', 'haha..great..so approved rt?', '2016-10-10 17:17:56'),
(184, 30, 'Abhishek325', 'None', 'yeah kind of for now', '2016-10-10 17:18:03'),
(185, 33, 'abhi', 'None', 'Hello there', '2016-10-10 17:20:28'),
(186, 33, 'abhi', 'None', 'Hi there', '2016-10-10 17:22:10'),
(187, 33, 'abhi', 'None', 'Helllo', '2016-10-10 17:22:56'),
(188, 33, 'Abhishek325', 'None', 'Hi..nice to see you', '2016-10-10 17:23:11'),
(189, 28, 'Abhishek325', 'None', 'Hey writer', '2016-10-10 17:23:50'),
(190, 28, 'abhi', 'None', 'yes..please tell', '2016-10-10 17:24:18'),
(191, 30, 'Abhishek325', 'None', 'Hey writer...there?', '2016-10-10 17:27:48'),
(192, 30, 'abhi', 'None', 'yes..please tell', '2016-10-10 17:28:07');

-- --------------------------------------------------------

--
-- Table structure for table `employer`
--

CREATE TABLE IF NOT EXISTS `employer` (
  `eid` int(11) NOT NULL AUTO_INCREMENT,
  `ename` varchar(255) DEFAULT NULL,
  `efrom` varchar(255) NOT NULL,
  `elink` varchar(255) NOT NULL,
  `otherinfo` varchar(255) NOT NULL,
  PRIMARY KEY (`eid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `employer`
--

INSERT INTO `employer` (`eid`, `ename`, `efrom`, `elink`, `otherinfo`) VALUES
(11, 'TestEmployer', 'Canada', '', 'This is a test employer.                        '),
(12, 'TestEmployer2', 'Canada', '', 'This is another test employer                        ');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE IF NOT EXISTS `feedback` (
  `uid` int(11) DEFAULT NULL,
  `jid` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `comments` text,
  KEY `uid` (`uid`),
  KEY `jid` (`jid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`uid`, `jid`, `rating`, `comments`) VALUES
(14, 27, 4, 'Test');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE IF NOT EXISTS `jobs` (
  `jid` int(11) NOT NULL AUTO_INCREMENT,
  `jname` varchar(255) DEFAULT NULL,
  `jtype` varchar(255) DEFAULT NULL,
  `employer` varchar(255) DEFAULT NULL,
  `epay` int(11) DEFAULT NULL,
  `description` text,
  `writer_level` varchar(255) DEFAULT NULL,
  `words` int(11) DEFAULT NULL,
  `namount` int(11) DEFAULT NULL,
  `bamount` int(11) DEFAULT NULL,
  `tries` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `file` varchar(255) NOT NULL,
  PRIMARY KEY (`jid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`jid`, `jname`, `jtype`, `employer`, `epay`, `description`, `writer_level`, `words`, `namount`, `bamount`, `tries`, `created`, `file`) VALUES
(26, 'asd', 'asd', 'asd', 123, 'asdsad', 'beginner', 200, 10000, 12000, 2, '2016-10-02 17:01:01', 'Static/VA/uploads/15_file57f13d4d43ce9'),
(27, 'Test Job#2', 'Biography', 'TestEmployer2', 1200, '<p>This is a test job&nbsp;&nbsp;&nbsp;&nbsp;</p><ul><li>Test1</li><li>Test2</li></ul>', 'Beginner', 200, 1000, 1000, 2, '2016-10-03 16:28:21', ''),
(28, 'Test', 'Biography', 'TestEmployer2', 1200, '<p>This is a test job&nbsp;&nbsp;&nbsp;&nbsp;</p><ul><li>Test1</li><li>Test2</li></ul>', 'Beginner', 200, 1000, 1000, 2, '2016-10-08 19:54:49', ''),
(29, 'Test', 'Biography', 'TestEmployer2', 1200, '<p>This is a test job&nbsp;&nbsp;&nbsp;&nbsp;</p><ul><li>Test1</li><li>Test2</li></ul>', '', 200, 1000, 1000, 2, '2016-10-08 19:54:10', ''),
(30, 'Test', 'Biography', 'TestEmployer2', 1200, '<p>This is a test job&nbsp;&nbsp;&nbsp;&nbsp;</p><ul><li>Test1</li><li>Test2</li></ul>', 'Beginner', 200, 1000, 1000, 2, '2016-10-06 18:11:26', ''),
(31, 'Test Job#4', 'Biography', 'TestEmployer2', 1200, '<p>This is a test job&nbsp;&nbsp;&nbsp;&nbsp;</p><ul><li>Test1</li><li>Test2</li></ul>', 'test', 200, 1000, 1000, 2, '2016-10-08 11:52:06', ''),
(32, 'Test', 'Biography', 'TestEmployer2', 1200, '<p>This is a test job&nbsp;&nbsp;&nbsp;&nbsp;</p><ul><li>Test1</li><li>Test2</li></ul>', '', 200, 1000, 1000, 2, '2016-10-08 19:47:38', ''),
(33, 'Test', 'Biography', 'TestEmployer2', 1200, '<p>This is a test job&nbsp;&nbsp;&nbsp;&nbsp;</p><ul><li>Test1</li><li>Test2</li></ul>', 'Beginner', 200, 1000, 1000, 2, '2016-10-09 16:12:02', ''),
(45, 'Test writer assignment', 'Biography', 'TestEmployer2', 1200, '<p>This is a test job&nbsp;&nbsp;&nbsp;&nbsp;</p><ul><li>Test1</li><li>Test2</li></ul>', 'Beginner', 200, 1000, 1000, 2, '2016-10-23 11:01:16', ''),
(46, 'Test writer assignment2', 'Biography', 'TestEmployer2', 1200, '<p>This is a test job&nbsp;&nbsp;&nbsp;&nbsp;</p><ul><li>Test1</li><li>Test2</li></ul>', 'Beginner', 200, 1000, 1000, 2, '2016-10-23 11:07:07', '');

-- --------------------------------------------------------

--
-- Table structure for table `jobs_time_map`
--

CREATE TABLE IF NOT EXISTS `jobs_time_map` (
  `jid` int(11) DEFAULT NULL,
  `hour` int(11) DEFAULT NULL,
  `minute` int(11) DEFAULT NULL,
  KEY `jid` (`jid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jobs_time_map`
--

INSERT INTO `jobs_time_map` (`jid`, `hour`, `minute`) VALUES
(26, 2, 0),
(27, 20, 0),
(28, 2, 0),
(29, 2, 0),
(30, 2, 0),
(31, 20, 30),
(33, 40, 0),
(45, 1, 30),
(46, 2, 30);

-- --------------------------------------------------------

--
-- Table structure for table `jobtype`
--

CREATE TABLE IF NOT EXISTS `jobtype` (
  `jtid` int(11) NOT NULL AUTO_INCREMENT,
  `jtype` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`jtid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `jobtype`
--

INSERT INTO `jobtype` (`jtid`, `jtype`) VALUES
(1, 'testing'),
(2, 'Biography'),
(3, 'Autobiography'),
(4, 'History'),
(5, 'Literature'),
(6, 'Science'),
(7, 'Comedy'),
(9, 'Criminal cases');

-- --------------------------------------------------------

--
-- Table structure for table `job_checkout_map`
--

CREATE TABLE IF NOT EXISTS `job_checkout_map` (
  `uid` int(11) DEFAULT NULL,
  `jid` int(11) DEFAULT NULL,
  `checkout_count` int(2) DEFAULT NULL,
  KEY `uid` (`uid`),
  KEY `jid` (`jid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `job_checkout_map`
--

INSERT INTO `job_checkout_map` (`uid`, `jid`, `checkout_count`) VALUES
(27, 26, 6),
(14, 27, 2),
(14, 28, 2),
(27, 29, 2),
(14, 30, 2),
(14, 33, 2),
(14, 46, 2);

-- --------------------------------------------------------

--
-- Table structure for table `job_content_map`
--

CREATE TABLE IF NOT EXISTS `job_content_map` (
  `uid` int(11) DEFAULT NULL,
  `jid` int(11) DEFAULT NULL,
  `jobContent` text,
  `last_saved` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `uid` (`uid`),
  KEY `jid` (`jid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `job_content_map`
--

INSERT INTO `job_content_map` (`uid`, `jid`, `jobContent`, `last_saved`) VALUES
(14, 27, 'This looks good', '2016-10-08 16:10:40'),
(14, 28, '\r\n                               <p>TEST bro&nbsp;&nbsp;&nbsp;&nbsp;</p><p>see this...incorrect</p> \r\n                           ', '2016-10-10 17:24:29'),
(14, 30, '\r\n                               \r\n                               \r\n                               \r\n                               \r\n                               This is a test job....<span style="background-color: rgb(255, 255, 0);">o</span><span style="background-color: rgb(66, 66, 66);">k check this \r\n                           </span> \r\n                            \r\n                            \r\n                           ', '2016-10-10 17:16:51'),
(14, 33, '<b>\r\n                               \r\n                               \r\n                               helloz mdsfla kfa sa</b>', '2017-01-14 16:24:29');

-- --------------------------------------------------------

--
-- Table structure for table `job_payment_map`
--

CREATE TABLE IF NOT EXISTS `job_payment_map` (
  `uid` int(11) DEFAULT NULL,
  `jid` int(11) DEFAULT NULL,
  `mode` varchar(255) NOT NULL,
  `amount` int(11) DEFAULT NULL,
  `payDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `uid` (`uid`),
  KEY `jid` (`jid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `job_writer_map`
--

CREATE TABLE IF NOT EXISTS `job_writer_map` (
  `uid` int(11) DEFAULT NULL,
  `jid` int(11) DEFAULT NULL,
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `submit` char(1) NOT NULL DEFAULT 'N',
  `approved` varchar(10) NOT NULL DEFAULT 'NA',
  KEY `uid` (`uid`),
  KEY `jid` (`jid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `job_writer_map`
--

INSERT INTO `job_writer_map` (`uid`, `jid`, `time`, `submit`, `approved`) VALUES
(14, 27, '2016-10-04 16:08:23', 'Y', 'Y'),
(14, 28, '2016-10-08 12:15:09', 'Y', 'NA'),
(27, 29, '2016-10-06 18:13:06', 'N', 'NA'),
(14, 30, '2016-10-09 10:36:23', 'Y', 'NA'),
(14, 33, '2016-10-09 16:12:12', 'N', 'NA'),
(14, 46, '2017-01-14 16:24:08', 'N', 'NA');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `uid1` int(11) DEFAULT NULL,
  `uid2` int(11) DEFAULT NULL,
  `msg` text,
  `mtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`uid1`, `uid2`, `msg`, `mtime`) VALUES
(14, 15, 'Hi admin', '2016-10-03 16:46:46'),
(0, 0, '', '2016-10-03 17:24:45'),
(14, 15, '', '2016-10-03 17:25:36'),
(14, 15, '', '2016-10-03 17:25:50'),
(14, 15, '', '2016-10-03 17:26:17'),
(14, 15, '', '2016-10-03 17:28:04'),
(14, 15, '', '2016-10-03 17:28:05'),
(14, 15, '', '2016-10-03 17:28:49'),
(14, 15, '', '2016-10-03 17:28:49'),
(14, 15, 'adsscasd', '2016-10-03 17:29:26'),
(14, 15, 'adsscasd', '2016-10-03 17:29:26'),
(14, 15, 'asd', '2016-10-03 17:33:08'),
(14, 15, 'sada', '2016-10-04 17:11:15'),
(14, 15, 'sada', '2016-10-04 17:11:26');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE IF NOT EXISTS `notification` (
  `nid` int(255) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `noti` varchar(255) NOT NULL,
  PRIMARY KEY (`nid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `protesession`
--

CREATE TABLE IF NOT EXISTS `protesession` (
  `session_id` varchar(255) NOT NULL DEFAULT '',
  `session_data` text NOT NULL,
  `session_lastaccesstime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `protesession`
--

INSERT INTO `protesession` (`session_id`, `session_data`, `session_lastaccesstime`) VALUES
('4d35535autmq4ubp3i1gfi3i24', 'auth_token|s:23:"156128798157e41ebb33e40";', '2016-09-22 18:11:07');

-- --------------------------------------------------------

--
-- Table structure for table `userlevelmap`
--

CREATE TABLE IF NOT EXISTS `userlevelmap` (
  `uid` int(11) DEFAULT NULL,
  `lid` int(11) DEFAULT NULL,
  KEY `uid` (`uid`),
  KEY `lid` (`lid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE IF NOT EXISTS `user_details` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `uname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` char(1) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`uid`, `name`, `uname`, `email`, `password`, `user_type`) VALUES
(14, 'Abhishek Kumar Singh', 'abhi', 'abhishek1@gmail.com', '20da4e8cfe98a93416d61690ec53445b5f4008fb246fcf04a1f3afb0d6dab0b5397d9166d564d973972e2703414c4820256b6a2eea9a46b79cb0cb278aff4d58', 'W'),
(15, 'Abhishek', 'abhishek325', 'abhishek@gmail.coms', '20da4e8cfe98a93416d61690ec53445b5f4008fb246fcf04a1f3afb0d6dab0b5397d9166d564d973972e2703414c4820256b6a2eea9a46b79cb0cb278aff4d58', 'A'),
(25, 'testEditor@gmail.com', 'testeditor@gmail.com', 'testEditor@gmail.com', '6ed11bde3fa02c8f12e01e3ca4b1dcf4a97dadab24ed6a69eeede48afb7a5515e5a48dfd2be1ef0113b11c9c3e9958d3314313910230ffe3df2ba4cc25195ecb', 'E'),
(27, 'test', 'test', 'test@gmail.com', 'dc80915cbca1be1d23435e218059cc4c4f216746f41b908625d1f5a46c096275d3f25b97f01ef3559e5c742fae3dcb36f6e7024e216183c7b6ca5b3f67eedfae', 'W'),
(30, 'dasd', 'abhis', 'abhi@jargonsmaze.comas', '20da4e8cfe98a93416d61690ec53445b5f4008fb246fcf04a1f3afb0d6dab0b5397d9166d564d973972e2703414c4820256b6a2eea9a46b79cb0cb278aff4d58', 'E');

-- --------------------------------------------------------

--
-- Table structure for table `user_notification`
--

CREATE TABLE IF NOT EXISTS `user_notification` (
  `nid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `noti` varchar(450) NOT NULL,
  PRIMARY KEY (`nid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_status`
--

CREATE TABLE IF NOT EXISTS `user_status` (
  `uid` int(11) DEFAULT NULL,
  `status` char(1) DEFAULT 'U',
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_status`
--

INSERT INTO `user_status` (`uid`, `status`) VALUES
(14, 'U'),
(15, 'U'),
(25, 'U'),
(27, 'U'),
(30, 'U');

-- --------------------------------------------------------

--
-- Table structure for table `user_transaction`
--

CREATE TABLE IF NOT EXISTS `user_transaction` (
  `tnId` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `jid` int(11) NOT NULL,
  `tdate` date DEFAULT NULL,
  `particulars` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `amount` int(11) NOT NULL,
  PRIMARY KEY (`tnId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `user_transaction`
--

INSERT INTO `user_transaction` (`tnId`, `uid`, `jid`, `tdate`, `particulars`, `type`, `amount`) VALUES
(7, 27, 26, '2016-10-02', 'For completing Test Job#1 (id:26)', 'Income', 1000),
(8, 14, 27, '2016-10-08', 'For completing Test Job#2 (id:27)', 'Income', 1000),
(9, 14, 27, '0000-00-00', '', '', 1000),
(10, 14, 27, '2016-10-23', 'Payment done for job (id:27)', 'Payment', 1000);

-- --------------------------------------------------------

--
-- Table structure for table `writerlevel`
--

CREATE TABLE IF NOT EXISTS `writerlevel` (
  `lid` int(11) NOT NULL AUTO_INCREMENT,
  `level` varchar(255) DEFAULT NULL,
  `words` int(10) NOT NULL,
  `rank` int(10) NOT NULL,
  `hlimit` int(10) NOT NULL,
  `climit` int(10) NOT NULL,
  `btime` int(10) NOT NULL,
  `namount` int(10) NOT NULL,
  PRIMARY KEY (`lid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `writerlevel`
--

INSERT INTO `writerlevel` (`lid`, `level`, `words`, `rank`, `hlimit`, `climit`, `btime`, `namount`) VALUES
(1, 'NewOne', 0, 0, 0, 0, 0, 0),
(2, 'Beginner', 0, 0, 0, 0, 0, 0),
(3, 'Expert', 0, 0, 0, 0, 0, 0),
(4, 'test', 200, 1, 20, 200, 1, 2500),
(5, 'test2', 200, 1, 2, 22, 20, 200);

-- --------------------------------------------------------

--
-- Table structure for table `writer_job_attachment_map`
--

CREATE TABLE IF NOT EXISTS `writer_job_attachment_map` (
  `uid` int(11) DEFAULT NULL,
  `jid` int(11) DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  KEY `uid` (`uid`),
  KEY `jid` (`jid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user_details` (`uid`),
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`jid`) REFERENCES `jobs` (`jid`);

--
-- Constraints for table `jobs_time_map`
--
ALTER TABLE `jobs_time_map`
  ADD CONSTRAINT `jobs_time_map_ibfk_1` FOREIGN KEY (`jid`) REFERENCES `jobs` (`jid`);

--
-- Constraints for table `job_checkout_map`
--
ALTER TABLE `job_checkout_map`
  ADD CONSTRAINT `job_checkout_map_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user_details` (`uid`),
  ADD CONSTRAINT `job_checkout_map_ibfk_2` FOREIGN KEY (`jid`) REFERENCES `jobs` (`jid`);

--
-- Constraints for table `job_content_map`
--
ALTER TABLE `job_content_map`
  ADD CONSTRAINT `job_content_map_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user_details` (`uid`),
  ADD CONSTRAINT `job_content_map_ibfk_2` FOREIGN KEY (`jid`) REFERENCES `jobs` (`jid`);

--
-- Constraints for table `job_payment_map`
--
ALTER TABLE `job_payment_map`
  ADD CONSTRAINT `job_payment_map_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user_details` (`uid`),
  ADD CONSTRAINT `job_payment_map_ibfk_2` FOREIGN KEY (`jid`) REFERENCES `jobs` (`jid`);

--
-- Constraints for table `job_writer_map`
--
ALTER TABLE `job_writer_map`
  ADD CONSTRAINT `job_writer_map_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user_details` (`uid`),
  ADD CONSTRAINT `job_writer_map_ibfk_2` FOREIGN KEY (`jid`) REFERENCES `jobs` (`jid`);

--
-- Constraints for table `userlevelmap`
--
ALTER TABLE `userlevelmap`
  ADD CONSTRAINT `userlevelmap_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user_details` (`uid`),
  ADD CONSTRAINT `userlevelmap_ibfk_2` FOREIGN KEY (`lid`) REFERENCES `writerlevel` (`lid`);

--
-- Constraints for table `user_status`
--
ALTER TABLE `user_status`
  ADD CONSTRAINT `user_status_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user_details` (`uid`);

--
-- Constraints for table `writer_job_attachment_map`
--
ALTER TABLE `writer_job_attachment_map`
  ADD CONSTRAINT `writer_job_attachment_map_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user_details` (`uid`),
  ADD CONSTRAINT `writer_job_attachment_map_ibfk_2` FOREIGN KEY (`jid`) REFERENCES `jobs` (`jid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
