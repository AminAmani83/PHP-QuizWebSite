-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2020 at 04:48 AM
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
-- Table structure for table `quiz_settings`
--

CREATE TABLE `quiz_settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(255) NOT NULL,
  `setting_value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quiz_settings`
--

INSERT INTO `quiz_settings` (`id`, `setting_key`, `setting_value`) VALUES
(1, 'admin_password', '$2y$10$mnAUr5QAz/D7dI2Gt/Ep0.jSUBxpJUqJb1c7BDrrym.don0SoaEgO'),
(2, 'requested_number_of_questions', '6'),
(3, 'seconds_per_question', '15'),
(4, 'placeholder_image', 'question-placeholder.jpg'),
(5, 'javascript_assist_mode', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `quiz_settings`
--
ALTER TABLE `quiz_settings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `quiz_settings`
--
ALTER TABLE `quiz_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
