-- Individual table export from university_db.sql
-- Table: `courses`

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

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

INSERT INTO `courses` (`id`, `course_id`, `course_name`, `course_code`, `credit`, `day`, `start_time`, `end_time`, `created_at`) VALUES
(1, '01', 'ICS', '01', 1, 'Sunday', '8', '10', '2026-08-23 14:42:46'),
(2, '02', 'C++', '02', 3, 'Sunday', '10', '11', '2026-08-23 14:45:43'),
(3, '03', 'Java', '03', 3, 'Sunday', '11', '12', '2026-08-23 14:47:10'),
(8, '04', 'Database', '04', 3, 'Monday', '8', '10', '2026-08-23 14:57:35'),
(9, '05', 'Data Structure', '05', 3, 'Monday', '10', '11', '2026-08-23 14:58:23'),
(12, '06', 'C#', '06', 3, 'Monday', '11', '12', '2026-08-23 15:49:29');

ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `course_id` (`course_id`);

ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
