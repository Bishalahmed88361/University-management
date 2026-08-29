-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 25, 2026 at 02:44 PM
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
-- Database: `university_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `course_id` varchar(50) NOT NULL,
  `course_name` varchar(150) NOT NULL,
  `course_code` varchar(50) NOT NULL,
  `credit` int(11) NOT NULL,
  `day` varchar(20) NOT NULL,
  `start_time` varchar(20) NOT NULL,
  `end_time` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_id`, `course_name`, `course_code`, `credit`, `day`, `start_time`, `end_time`, `created_at`) VALUES
(1, '01', 'ICS', '01', 1, 'Sunday', '8', '10', '2026-08-23 14:42:46'),
(2, '02', 'C++', '02', 3, 'Sunday', '10', '11', '2026-08-23 14:45:43'),
(3, '03', 'Java', '03', 3, 'Sunday', '11', '12', '2026-08-23 14:47:10'),
(8, '04', 'Database', '04', 3, 'Monday', '8', '10', '2026-08-23 14:57:35'),
(9, '05', 'Data Structure', '05', 3, 'Monday', '10', '11', '2026-08-23 14:58:23'),
(12, '06', 'C#', '06', 3, 'Monday', '11', '12', '2026-08-23 15:49:29');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `student_username` varchar(50) NOT NULL,
  `course_id` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `status` enum('present','absent') NOT NULL DEFAULT 'absent'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `marks`
--

CREATE TABLE `marks` (
  `id` int(11) NOT NULL,
  `student_username` varchar(50) NOT NULL,
  `course_id` varchar(50) NOT NULL,
  `marks` decimal(5,2) NOT NULL CHECK (`marks` between 0 and 100),
  `grade` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faculty_assignments`
--

CREATE TABLE `faculty_assignments` (
  `id` int(11) NOT NULL,
  `course_id` varchar(50) NOT NULL,
  `faculty_username` varchar(100) NOT NULL,
  `assigned_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty_assignments`
--

INSERT INTO `faculty_assignments` (`id`, `course_id`, `faculty_username`, `assigned_at`) VALUES
(1, '01', 'teacher01', '2026-08-23 14:43:09'),
(2, '02', 'teacher01', '2026-08-23 15:22:40'),
(3, '03', 'teacher02', '2026-08-23 15:47:15'),
(5, '04', 'teacher02', '2026-08-23 15:47:34'),
(7, '05', 'teacher03', '2026-08-23 15:48:32'),
(8, '06', 'teacher03', '2026-08-23 15:49:41');

-- --------------------------------------------------------

--
-- Table structure for table `student_enrollments`
--

CREATE TABLE `student_enrollments` (
  `id` int(11) NOT NULL,
  `course_id` varchar(50) NOT NULL,
  `student_username` varchar(100) NOT NULL,
  `enrolled_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_enrollments`
--

INSERT INTO `student_enrollments` (`id`, `course_id`, `student_username`, `enrolled_at`) VALUES
(1, '01', 'anika', '2026-08-23 14:43:19'),
(2, '01', 'adiba', '2026-08-23 14:43:24'),
(4, '02', 'adiba', '2026-08-23 14:50:01'),
(7, '02', 'anika', '2026-08-23 15:22:50');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL,
  `status` varchar(20) DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `password`, `role`, `status`, `created_at`) VALUES
(1, 'Main Admin', 'admin@university.edu', 'admin', 'admin123', 'admin', 'approved', '2026-08-23 11:17:35'),
(2, 'anika', 'anika@gmail.com', 'anika', '123', 'student', 'approved', '2026-08-23 11:18:44'),
(3, 'adiba', 'adiba@gmai.com', 'adiba', '123', 'student', 'approved', '2026-08-23 11:20:25'),
(4, 'teacher01', 'teacher01@gmail.com', 'teacher01', '123', 'teacher', 'approved', '2026-08-23 11:39:12'),
(6, 'Course Admin', 'course.admin@gmail.com', 'course.admin', '123', 'course_admin', 'approved', '2026-08-23 12:19:43'),
(7, 'teacher02', 'teacher02@gmail.com', 'teacher02', '123', 'teacher', 'approved', '2026-08-23 15:43:34'),
(8, 'teacher03', 'teacher03@gamil.com', 'teacher03', '123', 'teacher', 'approved', '2026-08-23 15:46:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_attendance` (`student_username`,`course_id`,`date`),
  ADD KEY `fk_attendance_course` (`course_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `course_id` (`course_id`);

--
-- Indexes for table `faculty_assignments`
--
ALTER TABLE `faculty_assignments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_assignment` (`course_id`,`faculty_username`),
  ADD UNIQUE KEY `course_id` (`course_id`),
  ADD KEY `fk_faculty_user` (`faculty_username`);

--
-- Indexes for table `marks`
--
ALTER TABLE `marks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_student_course` (`student_username`,`course_id`),
  ADD KEY `fk_marks_course` (`course_id`);

--
-- Indexes for table `student_enrollments`
--
ALTER TABLE `student_enrollments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_enrollment` (`course_id`,`student_username`),
  ADD KEY `fk_student_user` (`student_username`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `faculty_assignments`
--
ALTER TABLE `faculty_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `marks`
--
ALTER TABLE `marks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_enrollments`
--
ALTER TABLE `student_enrollments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `fk_attendance_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_attendance_user` FOREIGN KEY (`student_username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `faculty_assignments`
--
ALTER TABLE `faculty_assignments`
  ADD CONSTRAINT `faculty_assignments_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_faculty_user` FOREIGN KEY (`faculty_username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `marks`
--
ALTER TABLE `marks`
  ADD CONSTRAINT `fk_marks_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_marks_user` FOREIGN KEY (`student_username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_enrollments`
--
ALTER TABLE `student_enrollments`
  ADD CONSTRAINT `fk_student_user` FOREIGN KEY (`student_username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_enrollments_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
