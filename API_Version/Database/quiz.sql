-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2020 at 06:57 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ipd19`
--

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `id` int(11) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL COMMENT 'file name',
  `topic_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`id`, `answer`, `image`, `topic_id`) VALUES
(1, 'Up', 'animation/1.jpg', 1),
(2, 'Dinosaur', 'animation/2.jpg', 1),
(3, 'Ice Age', 'animation/3.jpg', 1),
(4, 'Finding Nemo', 'animation/4.jpg', 1),
(5, 'Shrek', 'animation/5.jpg', 1),
(6, 'Madagascar', 'animation/6.jpg', 1),
(7, 'Cars', 'animation/7.jpg', 1),
(8, 'WALL-E', 'animation/8.jpg', 1),
(9, 'Toy Story', 'animation/9.jpg', 1),
(10, 'Brave', 'animation/10.jpg', 1),
(11, 'Frozen', 'animation/11.jpg', 1),
(12, 'Inside Out', 'animation/12.jpg', 1),
(13, 'Despicable Me', 'animation/13.jpg', 1),
(14, 'Incredibles', 'animation/14.jpg', 1),
(15, 'Lion King', 'animation/15.jpg', 1),
(16, 'The Godfather', 'movie/1.jpg', 2),
(17, 'Casablanca', 'movie/2.jpg', 2),
(18, 'George Clooney', 'people/1.jpg', 3),
(19, 'Albert Einstein', 'people/2.jpg', 3),
(20, 'Lego', 'logo/1.png', 4),
(21, 'Audi', 'logo/2.png', 4),
(22, '90', 'puzzle/1.jpg', 5),
(23, '720', 'puzzle/2.jpg', 5),
(24, 'Dead Poets Society', 'movie/3.jpg', 2),
(25, 'Harry Potter', 'movie/4.jpg', 2),
(26, 'Silence of the Lambs', 'movie/5.jpg', 2),
(27, 'Breakfast at Tiffanys', 'movie/6.jpg', 2),
(28, 'The Sound of Music', 'movie/7.jpg', 2),
(29, 'Titanic', 'movie/8.jpg', 2),
(30, 'When Harry met Sally', 'movie/9.jpg', 2),
(31, 'Wizard of Oz', 'movie/10.jpg', 2),
(32, 'Eminem', 'people/3.jpg', 3),
(33, 'Isaac Newton', 'people/4.jpg', 3),
(34, 'J.K. Rowling', 'people/5.jpg', 3),
(35, 'Joseph Stalin', 'people/6.jpg', 3),
(36, 'Julius Caesar', 'people/7.jpg', 3),
(37, 'Kate Winslet', 'people/8.jpg', 3),
(38, 'Lionel Messi', 'people/9.jpg', 3),
(39, 'Michael Jordan', 'people/10.jpg', 3),
(40, 'Rowan Atkinson', 'people/11.jpg', 3),
(41, 'Neil Armstrong', 'people/12.jpg', 3),
(42, 'Charlie Chaplin', 'people/13.jpg', 3),
(43, 'Dreamworks', 'logo/3.png', 4),
(44, 'Nike', 'logo/4.png', 4),
(45, 'Pepsi', 'logo/5.png', 4),
(46, 'Shell', 'logo/6.png', 4),
(47, 'Volkswagen', 'logo/7.png', 4),
(48, 'Wikipedia', 'logo/8.png', 4),
(49, '11', 'puzzle/3.jpg', 5),
(50, 'Beauty and the Beast', 'animation/16.jpg', 1),
(51, '11', 'puzzle/4.jpg', 5),
(52, 'Apple', 'logo/10.png', 4),
(53, 'Coca Cola', 'logo/11.png', 4),
(54, 'Dominos Pizza', 'logo/12.png', 4),
(55, 'Dunkin Donuts', 'logo/13.png', 4),
(56, 'NBC', 'logo/14.png', 4),
(57, 'Mastercard', 'logo/15.png', 4),
(58, 'Nasa', 'logo/16.png', 4),
(59, 'Quaker Oats', 'logo/17.png', 4),
(60, 'Rolex', 'logo/18.png', 4),
(61, 'Starbucks', 'logo/19.png', 4),
(62, '8', 'puzzle/5.jpg', 5),
(63, '14', 'puzzle/6.jpg', 5),
(64, '17', 'puzzle/7.jpg', 5),
(65, '6', 'puzzle/8.jpg', 5),
(66, 'Big Hero 6', 'animation/17.jpg', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `image` (`image`),
  ADD KEY `topic_id` (`topic_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `quiz`
--
ALTER TABLE `quiz`
  ADD CONSTRAINT `quiz_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `quiz_topics` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
