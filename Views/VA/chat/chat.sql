-- phpMyAdmin SQL Dump
-- version 2.8.0.3
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Jun 26, 2006 at 02:43 PM
-- Server version: 4.1.12
-- PHP Version: 5.0.4
-- 
-- Database: `chat`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `chat`
-- 

CREATE TABLE `chat` ( 
	`id` INT(9) NOT NULL AUTO_INCREMENT , 
	`usrname` VARCHAR(255) NOT NULL , 
	`color` VARCHAR(6) NOT NULL , 
	`chattext` TEXT NOT NULL , 
	`chattime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
	PRIMARY KEY (`id`) 
) ENGINE = MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci;
