-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 18, 2015 at 10:45 PM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `cr`
--
CREATE DATABASE IF NOT EXISTS `cr` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `cr`;

-- --------------------------------------------------------

--
-- Table structure for table `empires`
--

CREATE TABLE IF NOT EXISTS `empires` (
  `id` int(4) NOT NULL,
  `independent` tinyint(1) NOT NULL,
  `name` varchar(32) NOT NULL,
  `alternate` varchar(128) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `empires`
--

INSERT INTO `empires` (`id`, `independent`, `name`, `alternate`) VALUES
(1, 0, 'French Empire', 'France'),
(2, 0, 'British Empire', 'England,Britain,UK'),
(3, 0, 'Russian Empire', 'Russia,Soviet Union,CCCP,USSR,Mother'),
(4, 0, 'German Empire', 'Germany,Fatherland'),
(5, 0, 'Ottoman Empire', ''),
(6, 0, 'Austrian Empire', 'Austria'),
(7, 1, 'Italy', 'Independent'),
(8, 1, 'Spain', 'Independent'),
(9, 1, 'Scandinavia', 'Independent');

-- --------------------------------------------------------

--
-- Table structure for table `territories`
--

CREATE TABLE IF NOT EXISTS `territories` (
  `empire` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `color` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `territories`
--

INSERT INTO `territories` (`empire`, `name`, `color`) VALUES
(8, 'Barcelona', '33ee44'),
(4, 'Bavaria', 'ff9900'),
(4, 'Berlin', 'ff9900'),
(6, 'Bohemia', 'ffee00'),
(1, 'Brittany', 'ff99ff'),
(5, 'Bulgaria', '009999'),
(1, 'Burgundy', 'ff99ff'),
(9, 'Denmark', '33ee44'),
(9, 'Finland', '33ee44'),
(6, 'Galicia', 'ffee00'),
(1, 'Gascony', 'ff99ff'),
(5, 'Greece', '009999'),
(6, 'Hungary', 'ffee00'),
(2, 'Ireland', 'cc00ff'),
(3, 'Livonia', 'cc0000'),
(2, 'London', 'cc00ff'),
(8, 'Madrid', '33ee44'),
(1, 'Marseille', 'ff99ff'),
(5, 'Montenegro', '009999'),
(3, 'Moscow', 'cc0000'),
(7, 'Naples', '33ee44'),
(1, 'Netherlands', 'ff99ff'),
(9, 'Norway', '33ee44'),
(1, 'Paris', 'ff99ff'),
(3, 'Poland', 'cc0000'),
(8, 'Portugal', '33ee44'),
(4, 'Prussia', 'ff9900'),
(4, 'Rhine', 'ff9900'),
(5, 'Romania', '009999'),
(7, 'Rome', '33ee44'),
(3, 'Saint Petersburg', 'cc0000'),
(4, 'Saxony', 'ff9900'),
(2, 'Scotland', 'cc00ff'),
(5, 'Serbia', '009999'),
(3, 'Smolensk', 'cc0000'),
(9, 'Sweden', '33ee44'),
(7, 'Switzerland', '33ee44'),
(6, 'Trieste', 'ffee00'),
(5, 'Turkey', '009999'),
(3, 'Ukraine', 'cc0000'),
(7, 'Venice', '33ee44'),
(6, 'Vienna', 'ffee00'),
(2, 'Wales', 'cc00ff'),
(2, 'Yorkshire', 'cc00ff');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `empires`
--
ALTER TABLE `empires`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `territories`
--
ALTER TABLE `territories`
  ADD PRIMARY KEY (`name`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `empires`
--
ALTER TABLE `empires`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;