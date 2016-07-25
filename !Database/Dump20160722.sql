-- phpMyAdmin SQL Dump
-- version 4.5.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 22, 2016 at 11:32 AM
-- Server version: 5.6.30
-- PHP Version: 7.0.3-3+deb.sury.org~trusty+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `books`
--

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

DROP TABLE IF EXISTS `book`;
CREATE TABLE `book` (
  `id` int(11) NOT NULL,
  `title` varchar(45) DEFAULT NULL,
  `author` varchar(45) DEFAULT NULL,
  `available` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`id`, `title`, `author`, `available`) VALUES
(1, 'The Lord of the Rings', 'J.R.R. Tolkien', 1),
(2, 'The Great Gatsby', 'F. Scott Fitzgerald', 1),
(3, 'Jane Eyre', 'Charlotte Bronte', 1),
(4, 'The Hobbit', 'J.R.R. Tolkien', 1),
(5, 'The Catcher in the Rye', 'J.D. Salinger', 1),
(6, 'To Kill a Mockingbird', 'Harper Lee', 0),
(7, 'Pride and Prejudice', 'Jane Austin', 0),
(8, '1984', 'George Orwell', 1),
(9, 'Gitanjali', 'Rabindranath Tagore', 0),
(10, 'Main Camf', 'Adlof Hitler', 0),
(11, 'Anna Frank Diary', 'Anna Frank', 0),
(12, 'Hanchback of Noterdam', 'Victor Hugo', 0);

-- --------------------------------------------------------

--
-- Table structure for table `lending_details`
--

DROP TABLE IF EXISTS `lending_details`;
CREATE TABLE `lending_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `taken_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lending_details`
--

INSERT INTO `lending_details` (`id`, `user_id`, `book_id`, `taken_at`) VALUES
(1, 1, 1, '2016-07-07 00:00:00'),
(2, 1, 2, '2016-07-08 00:00:00'),
(3, 4, 5, '2016-07-12 00:00:00'),
(4, 5, 8, '2016-07-12 00:00:00'),
(5, 5, 3, '2016-07-13 00:00:00'),
(6, 5, 4, '2016-07-13 00:00:00'),
(10, 1, 9, '2016-07-22 09:32:45');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `salutation` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `streetnumber` varchar(45) DEFAULT NULL,
  `zip` varchar(45) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `description` text,
  `register_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `salutation`, `title`, `firstname`, `lastname`, `street`, `streetnumber`, `zip`, `city`, `description`, `register_date`) VALUES
(1, 'Mr', NULL, 'John', 'Doe', 'Main street', '1', '12345', 'Berlin', 'A very good guy', '2014-06-10 09:37:48'),
(2, 'Miss', NULL, 'Abelard', 'Ersmay', 'Meer Righstag', '145', '12345', 'Berlin', 'A testing person', '2016-07-21 11:01:46'),
(3, 'Miss', NULL, 'Emma', 'Miguels', 'kerninghan strat', '35', '12345', 'Berlin', 'Developer for this project', '2016-07-21 11:02:46'),
(4, 'Mr', 'Dr.', 'Albert', 'Einstine', 'Farow corning strat', '100', '12345', 'Berlin', 'Scientist', '2016-07-21 11:03:32'),
(5, 'Miss', NULL, 'Mark', 'Watney', 'Single rickstinget', '78', '12345', 'Berlin', 'Scholar person', '2016-07-21 11:04:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lending_details`
--
ALTER TABLE `lending_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index2` (`user_id`),
  ADD KEY `index3` (`book_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `lending_details`
--
ALTER TABLE `lending_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `lending_details`
--
ALTER TABLE `lending_details`
  ADD CONSTRAINT `fk_lending_details_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_lending_details_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
