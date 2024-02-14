-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 14, 2024 at 04:41 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`) VALUES
(3, 'Bob Johnson Tom2', 'bob.johnson@example.com', '555-123-4567'),
(5, 'Charlie Brown', 'charlie.brown@example.com', '333-888-5555'),
(6, 'Eva Davis', 'eva.davis@example.com', '111-222-3333'),
(7, 'Frank Miller', 'frank.miller@example.com', '777-444-8888'),
(9, 'Henry Wilson', 'henry.wilson@example.com', '999-000-7777'),
(10, 'Ivy Turner', 'ivy.turner@example.com', '444-555-6666'),
(12, 'Jane Smith', 'jane@example.com', '987-654-3210'),
(13, 'John Doe', 'john.doe@example.com', '123-456-7890'),
(14, 'Jane Smith', 'jane.smith@example.com', '987-654-3210'),
(15, 'Bob Johnson', 'bob.johnson@example.com', '555-123-4567'),
(16, 'Alice Williams', 'alice.williams@example.com', '789-456-1230'),
(17, 'Charlie Brown', 'charlie.brown@example.com', '333-888-5555'),
(18, 'Eva Davis Larner', 'eva.davis@example.com', '111-222-3333'),
(19, 'Frank Miller', 'frank.miller@example.com', '777-444-8888'),
(20, 'Grace Lee', 'grace.lee@example.com', '222-111-9999'),
(24, 'Masud Alam', 'masud.eden@gmail.com', '01722817591'),
(25, 'Muhibbullah', 'suhib@gmail.com', '01755884456'),
(26, 'Sohel Alam', 'sohel@gmail.com', '01722817591'),
(27, 'Sumon Halder', 'sujon@gmail.com', '01722817591'),
(29, 'Mamnun', 'mamnun@mail.com', '465464654');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
