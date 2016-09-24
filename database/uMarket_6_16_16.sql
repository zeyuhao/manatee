-- phpMyAdmin SQL Dump
-- version 4.4.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 16, 2016 at 06:13 PM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `uMarket`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_pages`
--

CREATE TABLE IF NOT EXISTS `account_pages` (
  `id` mediumint(9) NOT NULL,
  `slug` varchar(300) NOT NULL,
  `label` varchar(100) NOT NULL,
  `title` varchar(200) NOT NULL,
  `header` varchar(300) NOT NULL,
  `body` longtext NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_pages`
--

INSERT INTO `account_pages` (`id`, `slug`, `label`, `title`, `header`, `body`) VALUES
(3, 'login', 'Login', 'Login', 'Login Page', ''),
(4, 'signup', 'Signup', 'Signup', 'Signup Page', ''),
(5, 'account', 'Account', 'Account', 'Account Page', '');

-- --------------------------------------------------------

--
-- Table structure for table `item_listings`
--

CREATE TABLE IF NOT EXISTS `item_listings` (
  `id` int(11) NOT NULL,
  `name` varchar(300) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(50) NOT NULL,
  `cond` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `description` varchar(300) NOT NULL,
  `thumbnail_path` tinytext NOT NULL,
  `picture_path` tinytext NOT NULL,
  `owner_email` varchar(300) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_listings`
--

INSERT INTO `item_listings` (`id`, `name`, `price`, `category`, `cond`, `date`, `description`, `thumbnail_path`, `picture_path`, `owner_email`) VALUES
(1, 'asdfa', '1233.00', 'battle-scarred', 'battle-scarred', '2016-01-27', '12313', 'images/cat.jpg', '', 'vkang1@jhu.edu');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` mediumint(9) NOT NULL,
  `slug` varchar(300) NOT NULL,
  `label` varchar(100) NOT NULL,
  `title` varchar(200) NOT NULL,
  `header` varchar(300) NOT NULL,
  `body` longtext NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `slug`, `label`, `title`, `header`, `body`) VALUES
(1, 'home', 'Home', 'Home', 'Welcome to uMarket', ''),
(2, 'listings', 'Listings', 'Listings', 'Listings', 'Here, you will find all the item listings currently on the UMarket.'),
(3, 'login', 'Login', 'Login', 'Login to uMarket', ''),
(4, 'signup', 'Signup', 'Signup', 'Signup for uMarket', ''),
(5, 'account-settings', 'Account Settings', 'Account Settings', 'Account Settings', ''),
(6, 'sell', 'Sell', 'Create Listing', 'Create a Listing', ''),
(7, 'account-listings', 'Account Listings', 'Listings', 'Your Listings', '');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` varchar(200) NOT NULL,
  `label` varchar(200) NOT NULL,
  `value` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `label`, `value`) VALUES
('debug-status', 'Debug Status', '1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` mediumint(9) NOT NULL,
  `first` varchar(200) NOT NULL,
  `last` varchar(200) NOT NULL,
  `email` varchar(300) NOT NULL,
  `password` varchar(200) NOT NULL,
  `phone_primary` varchar(15) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `picture_path` tinytext NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first`, `last`, `email`, `password`, `phone_primary`, `status`, `picture_path`) VALUES
(1, 'Zeyu', 'Hao', 'zhao7@jhu.edu', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '240-291-7664', 1, ''),
(2, 'Justin', 'Oh', 'joh26@jhu.edu', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '291-766-4444', 1, ''),
(3, 'George', 'Kammar', 'georgekammar@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 1, ''),
(4, 'Alex', 'Kearns', 'akearns1@jhu.edu', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '240-291-8744', 1, ''),
(5, 'Katie', 'Lin', 'ljia4@jhu.edu', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '101-010-1010', 1, ''),
(6, 'test', 'test', 'test@jhu.edu', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', '', 1, ''),
(7, 'Zhen', 'Hao', 'hzhen@jhu.edu', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 1, ''),
(8, 'Jian-Jiang', 'Hao', 'jjh@jhu.edu', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 1, ''),
(9, 'Tiity', 'Fucker', 'gkammar1@jhu.edu', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '240-123-1231', 1, ''),
(10, 'Victor', 'Kang', 'vkang1@jhu.edu', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 1, ''),
(11, 'Lauren Peru', 'Fang', 'lfang6@jhu.edu', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 1, ''),
(12, 'Helen', 'Zhang', 'hzhang@jhu.edu', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', 1, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_pages`
--
ALTER TABLE `account_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_listings`
--
ALTER TABLE `item_listings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_pages`
--
ALTER TABLE `account_pages`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `item_listings`
--
ALTER TABLE `item_listings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
