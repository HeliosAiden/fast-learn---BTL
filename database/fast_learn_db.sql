-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 20, 2024 lúc 05:15 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `fast_learn_db`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `answers`
--

CREATE TABLE `answers` (
  `id` varchar(36) NOT NULL DEFAULT uuid(),
  `replier_id` varchar(36) NOT NULL,
  `answer` text NOT NULL,
  `question_id` varchar(36) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `courses`
--

CREATE TABLE `courses` (
  `id` varchar(36) NOT NULL DEFAULT uuid(),
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `fee` int(11) DEFAULT NULL,
  `subject_id` varchar(36) NOT NULL,
  `teacher_id` varchar(36) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `courses`
--

INSERT INTO `courses` (`id`, `name`, `description`, `fee`, `subject_id`, `teacher_id`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
('44e37b72-8ef5-11ef-958c-c018035abcac', 'An toàn mạng máy tính', '', 356000, '4a3ebeee-8240-11ef-b317-c018035abcac', '6243879d-8ef3-11ef-958c-c018035abcac', '2024-10-19', '2024-10-30', '2024-10-20 15:09:20', '2024-10-20 22:09:20');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `course_enrollments`
--

CREATE TABLE `course_enrollments` (
  `id` varchar(36) NOT NULL DEFAULT uuid(),
  `course_id` varchar(36) NOT NULL,
  `student_id` varchar(36) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `course_feedbacks`
--

CREATE TABLE `course_feedbacks` (
  `id` varchar(36) NOT NULL DEFAULT uuid(),
  `course_id` varchar(36) NOT NULL,
  `student_id` varchar(36) NOT NULL,
  `feedback` text DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `feedback_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `course_lessons`
--

CREATE TABLE `course_lessons` (
  `id` varchar(36) NOT NULL DEFAULT uuid(),
  `name` varchar(255) NOT NULL,
  `course_id` varchar(36) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `course_materials`
--

CREATE TABLE `course_materials` (
  `id` varchar(36) NOT NULL DEFAULT uuid(),
  `course_id` varchar(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `link` varchar(511) DEFAULT NULL,
  `state` enum('Creating','Hidden','Visible') DEFAULT 'Creating',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `file_id` varchar(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `course_questions`
--

CREATE TABLE `course_questions` (
  `id` varchar(36) NOT NULL DEFAULT uuid(),
  `student_id` varchar(36) NOT NULL,
  `course_id` varchar(36) NOT NULL,
  `question` text NOT NULL,
  `state` enum('Open','Closed','Hidden') DEFAULT 'Open',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `files`
--

CREATE TABLE `files` (
  `id` varchar(36) NOT NULL DEFAULT uuid(),
  `post_id` varchar(36) DEFAULT NULL,
  `user_id` varchar(36) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(50) NOT NULL,
  `file_size` int(11) NOT NULL,
  `file_path` varchar(511) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `posts`
--

CREATE TABLE `posts` (
  `id` varchar(36) NOT NULL DEFAULT uuid(),
  `title` varchar(255) NOT NULL,
  `author_id` varchar(36) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `file_id` varchar(36) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `subjects`
--

CREATE TABLE `subjects` (
  `id` varchar(36) NOT NULL DEFAULT uuid(),
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `created_at`, `updated_at`) VALUES
('236ad464-8479-11ef-9863-c018035abcac', 'Giải thuật 2', '2024-10-19 02:13:41', '2024-10-19 09:13:41'),
('4a3ebeee-8240-11ef-b317-c018035abcac', 'An toàn thông tin', '2024-10-19 02:13:41', '2024-10-19 09:13:41'),
('66414321-8232-11ef-b317-c018035abcac', 'Giáo dục quốc phòng', '2024-10-19 02:13:41', '2024-10-19 09:13:41'),
('ee622ab3-8201-11ef-9b9e-c018035abcac', 'Cấu trúc dữ liệu & giải thuật', '2024-10-19 02:13:41', '2024-10-19 09:13:41'),
('ef6c0383-81ff-11ef-9b9e-c018035abcac', 'Vật lí nâng cao', '2024-10-19 02:13:41', '2024-10-19 09:13:41');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` varchar(36) NOT NULL DEFAULT uuid(),
  `username` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('Student','Teacher','Admin') DEFAULT 'Student',
  `state` enum('Active','Inactive','Removed','Locked') DEFAULT 'Inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password_hash`, `email`, `role`, `state`, `created_at`, `updated_at`) VALUES
('01af8c3b-8e96-11ef-958c-c018035abcac', 'student_1', '$2y$05$gEbTQj/nH/gHfqc7QUoBXexpfwMJUQqw45w4WVLE5rpHE2d2QVWIq', 'student@school.com', 'Student', 'Active', '2024-10-20 03:47:24', '2024-10-20 18:09:50'),
('6243879d-8ef3-11ef-958c-c018035abcac', 'teacher_1', '$2y$05$az.3B4CL5ddTp7/Cl4lIm.J5.u5FC5l1H5QBAAw4a4eNvZdJ4MJvm', 'teacher@school.com', 'Teacher', 'Active', '2024-10-20 14:55:50', '2024-10-20 21:57:38'),
('67ea2e25-8dc0-11ef-bde4-c018035abcac', 'admin', '$2y$05$siswox6x6zmNy4s6FO2TF.2yCWXpsDtq5JATyC9xlL/jJqXeF4zqW', 'admin@example.com', 'Admin', 'Active', '2024-10-19 02:18:18', '2024-10-19 21:55:51'),
('6ecb6640-8ef3-11ef-958c-c018035abcac', 'teacher_2', '$2y$05$fIthE1.sWcQLMUTHWqdu3uHGmYUtru4YAgmuaIXDvJORkmMk7mFHC', 'teacher2@school.com', 'Teacher', 'Active', '2024-10-20 14:56:11', '2024-10-20 21:57:42'),
('7b1d5cd4-8e96-11ef-958c-c018035abcac', 'student_2', '$2y$05$pnqjomO8aoHtN1yOQ4/5XOn34ta.ioGIHTXo33UcF49bqozcfyizi', 'student2@school.com', 'Student', 'Active', '2024-10-20 03:50:48', '2024-10-20 18:13:40'),
('9119cc60-8e96-11ef-958c-c018035abcac', 'student_3', '$2y$05$Vsh22wjXH5Ebv6R4nsIOeuEvuFlqrvJZAAwaNqMLi0xU7PVY253ym', 'student_3@school.com', 'Student', 'Active', '2024-10-20 03:51:25', '2024-10-20 10:51:25');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_infos`
--

CREATE TABLE `user_infos` (
  `id` varchar(36) NOT NULL DEFAULT uuid(),
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `gender` enum('Male','Female','Others') DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `about` text DEFAULT NULL,
  `user_id` char(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user_infos`
--

INSERT INTO `user_infos` (`id`, `firstname`, `lastname`, `gender`, `phone_number`, `date_of_birth`, `created_at`, `updated_at`, `about`, `user_id`) VALUES
('4475060f-8e0f-11ef-958c-c018035abcac', 'Nhật Anh', 'Nguyễn', 'Male', '+84377079042', '2004-03-02', '2024-10-19 11:42:49', '2024-10-19 22:04:28', 'Tôi là 1 lập trình viên php cơ bản thôi', '67ea2e25-8dc0-11ef-bde4-c018035abcac'),
('b5ea94d9-8e96-11ef-958c-c018035abcac', 'Marry', 'Jane', 'Male', '01112222333', '2003-11-04', '2024-10-20 03:52:26', '2024-10-20 10:54:14', '', '01af8c3b-8e96-11ef-958c-c018035abcac');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_replier_id` (`replier_id`),
  ADD KEY `fk_question_id` (`question_id`);

--
-- Chỉ mục cho bảng `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_subject_id` (`subject_id`),
  ADD KEY `fk_teacher_id` (`teacher_id`);

--
-- Chỉ mục cho bảng `course_enrollments`
--
ALTER TABLE `course_enrollments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `course_id` (`course_id`),
  ADD UNIQUE KEY `student_id` (`student_id`);

--
-- Chỉ mục cho bảng `course_feedbacks`
--
ALTER TABLE `course_feedbacks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_course_id` (`course_id`),
  ADD KEY `fk_student_id` (`student_id`);

--
-- Chỉ mục cho bảng `course_lessons`
--
ALTER TABLE `course_lessons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `course_id` (`course_id`);

--
-- Chỉ mục cho bảng `course_materials`
--
ALTER TABLE `course_materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_course_material_course_id` (`course_id`),
  ADD KEY `fk_file_id` (`file_id`);

--
-- Chỉ mục cho bảng `course_questions`
--
ALTER TABLE `course_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_question_student_id` (`student_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Chỉ mục cho bảng `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `file_id` (`file_id`),
  ADD KEY `user_id` (`author_id`);

--
-- Chỉ mục cho bảng `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `password_hash` (`password_hash`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `user_infos`
--
ALTER TABLE `user_infos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `fk_question_id` FOREIGN KEY (`question_id`) REFERENCES `course_questions` (`id`),
  ADD CONSTRAINT `fk_replier_id` FOREIGN KEY (`replier_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `fk_subject_id` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`),
  ADD CONSTRAINT `fk_teacher_id` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `course_enrollments`
--
ALTER TABLE `course_enrollments`
  ADD CONSTRAINT `course_enrollments_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `course_enrollments_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `course_feedbacks`
--
ALTER TABLE `course_feedbacks`
  ADD CONSTRAINT `fk_course_id` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `fk_student_id` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `course_lessons`
--
ALTER TABLE `course_lessons`
  ADD CONSTRAINT `course_lessons_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `course_materials`
--
ALTER TABLE `course_materials`
  ADD CONSTRAINT `fk_course_material_course_id` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `fk_file_id` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `course_questions`
--
ALTER TABLE `course_questions`
  ADD CONSTRAINT `course_questions_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `fk_question_student_id` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_posts_file_id` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `user_infos`
--
ALTER TABLE `user_infos`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
