-- Individual table export from university_db.sql
-- Table: `student_enrollments`
-- Import 01_users.sql and 02_courses.sql before this file.

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE TABLE `student_enrollments` (
  `id` int(11) NOT NULL,
  `course_id` varchar(50) NOT NULL,
  `student_username` varchar(100) NOT NULL,
  `enrolled_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `student_enrollments` (`id`, `course_id`, `student_username`, `enrolled_at`) VALUES
(1, '01', 'anika', '2026-08-23 14:43:19'),
(2, '01', 'adiba', '2026-08-23 14:43:24'),
(4, '02', 'adiba', '2026-08-23 14:50:01'),
(7, '02', 'anika', '2026-08-23 15:22:50');

ALTER TABLE `student_enrollments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_enrollment` (`course_id`,`student_username`),
  ADD KEY `fk_student_user` (`student_username`);

ALTER TABLE `student_enrollments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `student_enrollments`
  ADD CONSTRAINT `fk_student_user` FOREIGN KEY (`student_username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_enrollments_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
