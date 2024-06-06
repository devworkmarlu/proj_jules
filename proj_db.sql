-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2024 at 10:41 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `proj`
--

-- --------------------------------------------------------

--
-- Table structure for table `class_list`
--

CREATE TABLE `class_list` (
  `table_record_id` int(11) NOT NULL,
  `teacher_id` text NOT NULL,
  `subject_id` text NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `class_list`
--

INSERT INTO `class_list` (`table_record_id`, `teacher_id`, `subject_id`, `date_added`) VALUES
(1, '23', '1', '2024-05-05 17:38:21'),
(2, '23', '4', '2024-05-05 17:46:43'),
(3, '21', '4', '2024-05-06 08:46:46'),
(4, '21', '3', '2024-05-06 08:46:52'),
(7, '21', '8', '2024-05-06 11:45:10'),
(8, '21', '7', '2024-05-06 11:45:14');

-- --------------------------------------------------------

--
-- Table structure for table `student_list`
--

CREATE TABLE `student_list` (
  `table_record_id` int(11) NOT NULL,
  `student_id` text NOT NULL,
  `class_id` text NOT NULL,
  `teacher_id` text NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_list`
--

INSERT INTO `student_list` (`table_record_id`, `student_id`, `class_id`, `teacher_id`, `date_added`) VALUES
(2, '33', '1', '23', '2024-05-06 15:37:03'),
(3, '39', '2', '23', '2024-05-08 14:15:12');

-- --------------------------------------------------------

--
-- Table structure for table `student_location`
--

CREATE TABLE `student_location` (
  `table_record_id` int(11) NOT NULL,
  `device_id` text NOT NULL,
  `location` text NOT NULL,
  `log_type` varchar(10) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_location`
--

INSERT INTO `student_location` (`table_record_id`, `device_id`, `location`, `log_type`, `date_added`) VALUES
(24, '8d74d6fbd15a2f1d', '8.5921674, 123.3487726', 'login', '2024-05-07 17:23:42'),
(25, '8d74d6fbd15a2f1d', '8.5921779, 123.3487932', 'logout', '2024-05-07 17:24:10'),
(26, '1c1103edec7908f5', '37.4220936, -122.083922', 'login', '2024-05-08 10:52:39'),
(27, '1c1103edec7908f5', '37.4220936, -122.083922', 'login', '2024-05-08 13:43:36'),
(28, '1c1103edec7908f5', '37.4220936, -122.083922', 'login', '2024-05-08 16:34:17');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `table_record_id` int(11) NOT NULL,
  `subject_name` varchar(50) NOT NULL,
  `subject_code` varchar(50) NOT NULL,
  `added_by` varchar(100) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`table_record_id`, `subject_name`, `subject_code`, `added_by`, `date_created`) VALUES
(1, 'english', 'eng101', NULL, '2024-05-04 11:37:30'),
(3, 'DESIGNING', 'DESIGNING101', NULL, '2024-05-04 11:37:30'),
(4, 'CODING', 'CODING101', NULL, '2024-05-04 11:37:30'),
(6, 'COOKING', 'COOKING101', 'superadmin', '2024-05-04 12:24:14'),
(7, 'BACKEND DEVELOPMENT', 'BACKEND101', 'ian', '2024-05-06 11:44:07'),
(8, 'BASIC NETWORKING', 'NETWORK101', 'ian', '2024-05-06 11:44:36');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `table_record_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(50) NOT NULL,
  `faculty_type` varchar(50) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `id_number` varchar(50) DEFAULT NULL,
  `grade_level` varchar(10) DEFAULT NULL,
  `device_id` text,
  `added_by` varchar(100) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`table_record_id`, `username`, `password`, `user_type`, `faculty_type`, `full_name`, `id_number`, `grade_level`, `device_id`, `added_by`, `date_created`) VALUES
(21, 'ian', 'ian', 'admin', 'teacher', 'Ian wate', '324324324', 'n/a', NULL, NULL, '2024-05-04 11:32:54'),
(22, 'superadmin', 'superadmin', 'admin', 'staff', 'Marlu Caermare', '23424234', 'n/a', NULL, NULL, '2024-05-04 11:32:54'),
(23, 'joey', 'joey', 'user', 'teacher', 'Joey Sumalpong', '31312313', '4', NULL, NULL, '2024-05-04 11:32:54'),
(31, 'mia', 'mia', 'user', 'student', 'Mia Athena Caermare', '3234324242343', '12', 'wer32423asfaf23423', NULL, '2024-05-04 11:32:54'),
(33, 'jane', 'jane', 'user', 'student', 'Olivia Jane Caermare', '23424234', '4', '23423432423', NULL, '2024-05-04 11:32:54'),
(35, '3y45hrthtrh675', 'rhh5y4t34t', 'user', 'student', 'test add student only 2', '2982987', '1', '534985395', NULL, '2024-05-04 11:32:54'),
(36, 'iopoip', 'iiopiop', 'user', 'student', 'another student only test', '43545345', '1', '3345345435', 'ian', '2024-05-04 11:39:24'),
(37, 'superuser', 'superuser', 'user', 'staff', 'Aiza Rey Caermare', '23425343', 'n/a', '', 'superadmin', '2024-05-04 11:45:44'),
(38, '9o9o9o9o', 'o9o9o9o9o', 'user', 'teacher', 'Adding of Teacher only test', '343242342', '9', '', 'superuser', '2024-05-04 11:59:07'),
(39, '663b10b37e208', '663b10b37e20c', 'user', 'student', 'Test Mobile Registraation', '123123123', '12', '1c1103edec7908f5', 'mobile_reg', '2024-05-08 13:42:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `class_list`
--
ALTER TABLE `class_list`
  ADD PRIMARY KEY (`table_record_id`);

--
-- Indexes for table `student_list`
--
ALTER TABLE `student_list`
  ADD PRIMARY KEY (`table_record_id`);

--
-- Indexes for table `student_location`
--
ALTER TABLE `student_location`
  ADD PRIMARY KEY (`table_record_id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`table_record_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`table_record_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `class_list`
--
ALTER TABLE `class_list`
  MODIFY `table_record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `student_list`
--
ALTER TABLE `student_list`
  MODIFY `table_record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `student_location`
--
ALTER TABLE `student_location`
  MODIFY `table_record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `table_record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `table_record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
