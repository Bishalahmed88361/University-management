-- Individual table export from university_db.sql
-- Table: `users`

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

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

INSERT INTO `users` (`id`, `name`, `email`, `username`, `password`, `role`, `status`, `created_at`) VALUES
(1, 'Main Admin', 'admin@university.edu', 'admin', 'admin123', 'admin', 'approved', '2026-08-23 11:17:35'),
(2, 'anika', 'anika@gmail.com', 'anika', '123', 'student', 'approved', '2026-08-23 11:18:44'),
(3, 'adiba', 'adiba@gmai.com', 'adiba', '123', 'student', 'approved', '2026-08-23 11:20:25'),
(4, 'teacher01', 'teacher01@gmail.com', 'teacher01', '123', 'teacher', 'approved', '2026-08-23 11:39:12'),
(6, 'Course Admin', 'course.admin@gmail.com', 'course.admin', '123', 'course_admin', 'approved', '2026-08-23 12:19:43'),
(7, 'teacher02', 'teacher02@gmail.com', 'teacher02', '123', 'teacher', 'approved', '2026-08-23 15:43:34'),
(8, 'teacher03', 'teacher03@gamil.com', 'teacher03', '123', 'teacher', 'approved', '2026-08-23 15:46:28');

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
