-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2023 at 09:42 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `un_project`
--
CREATE DATABASE IF NOT EXISTS `un_project` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `un_project`;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `cat_id` int(10) NOT NULL,
  `cat_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cat_id`, `cat_name`, `username`) VALUES
(19, 'watches category', 'karim95'),
(20, 'shoes', 'karim95'),
(21, ' smart cameras', 'neama94'),
(22, 'headphones', 'karim95');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `prd_id` int(10) NOT NULL,
  `title` varchar(150) NOT NULL,
  `prd_date` date NOT NULL,
  `prd_license` varchar(250) NOT NULL,
  `prd_dimension` varchar(100) NOT NULL,
  `image_formate` varchar(50) NOT NULL,
  `is_active` enum('Yes','No') NOT NULL,
  `prd_image` varchar(200) NOT NULL,
  `username` varchar(100) NOT NULL,
  `cat_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`prd_id`, `title`, `prd_date`, `prd_license`, `prd_dimension`, `image_formate`, `is_active`, `prd_image`, `username`, `cat_id`) VALUES
(26, 'watch code145', '2023-10-20', 'License', '50*30', 'jpg', 'Yes', 'img1.jpg', 'karim95', 19),
(28, 'watch2', '2023-10-20', 'License', '50*60', 'jpg', 'Yes', 'img4.jpg', 'karim95', 19),
(31, 'white shoes', '2023-10-22', 'License', '50*20', 'jpg', 'Yes', 'pexels-jens-mahnke-1161528.jpg', 'neama94', 20),
(32, 'cameraa', '2023-10-22', 'License', '50*60', 'jpg', 'Yes', 'pexels-fox-225157.jpg', 'neama94', 21),
(33, 'women shoes', '2023-10-22', 'License', '25*14', 'jpg', 'Yes', 'pexels-pixabay-267301.jpg', 'neama94', 20),
(34, 'watch brown', '2023-10-23', 'License', '50*30', 'jpg', 'Yes', 'img3.jpg', 'karim95', 19),
(35, 'camera photo ', '2023-10-23', 'License', '50*30', 'jpg', 'No', 'pexels-dominika-roseclay-688689.jpg', 'karim95', 21),
(36, 'headphone', '2023-10-23', 'License', '10*60', 'JPEG', 'Yes', 'images (4).jpeg', 'karim95', 22),
(37, 'sport shoes', '2023-10-24', 'License', '45*50', 'jpg', 'Yes', 'images_(4)[1].jpeg', 'karim95', 20),
(38, ' bluetooth headphone ', '2023-10-23', 'License', '50*60', 'jpg', 'Yes', 'images (6).jpeg', 'karim95', 22);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `full_name` varchar(150) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `is_admin` enum('Yes','No') NOT NULL DEFAULT 'No',
  `password` varchar(100) NOT NULL,
  `user_image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`full_name`, `username`, `email`, `is_admin`, `password`, `user_image`) VALUES
('karim ahmed', 'karim95', 'karim1995@yahoo.com', 'No', '25295         ', 'gjgp_rsvk_210901.jpg'),
('neama abdelzaher mohamed', 'neama94', 'neama@gmail.com', 'Yes', '121294        ', 'np9f_leld_220705.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cat_id`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`prd_id`),
  ADD KEY `username` (`username`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `cat_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `prd_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `category_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`cat_id`) REFERENCES `category` (`cat_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
