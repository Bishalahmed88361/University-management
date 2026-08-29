-- Individual table export from university_db.sql
-- Table: `faculty_assignments`
-- Import 01_users.sql and 02_courses.sql before this file.

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE TABLE `faculty_assignments` (
  `id` int(11) NOT NULL,
  `course_id` varchar(50) NOT NULL,
  `faculty_username` varchar(100) NOT NULL,
  `assigned_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `faculty_assignments` (`id`, `course_id`, `faculty_username`, `assigned_at`) VALUES
(1, '01', 'teacher01', '2026-08-23 14:43:09'),
(2, '02', 'teacher01', '2026-08-23 15:22:40'),
(3, '03', 'teacher02', '2026-08-23 15:47:15'),
(5, '04', 'teacher02', '2026-08-23 15:47:34'),
(7, '05', 'teacher03', '2026-08-23 15:48:32'),
(8, '06', 'teacher03', '2026-08-23 15:49:41');

ALTER TABLE `faculty_assignments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_assignment` (`course_id`,`faculty_username`),
  ADD UNIQUE KEY `course_id` (`course_id`),
  ADD KEY `fk_faculty_user` (`faculty_username`);

ALTER TABLE `faculty_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

ALTER TABLE `faculty_assignments`
  ADD CONSTRAINT `faculty_assignments_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_faculty_user` FOREIGN KEY (`faculty_username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
