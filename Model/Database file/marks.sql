-- Individual table export from university_db.sql
-- Table: `marks`
-- Import users.sql and courses.sql before this file.

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE TABLE `marks` (
  `id` int(11) NOT NULL,
  `student_username` varchar(50) NOT NULL,
  `course_id` varchar(50) NOT NULL,
  `marks` decimal(5,2) NOT NULL CHECK (`marks` between 0 and 100),
  `grade` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `marks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_student_course` (`student_username`,`course_id`),
  ADD KEY `fk_marks_course` (`course_id`);

ALTER TABLE `marks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `marks`
  ADD CONSTRAINT `fk_marks_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_marks_user` FOREIGN KEY (`student_username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
