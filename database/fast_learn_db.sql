-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 24, 2024 lúc 09:12 AM
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
('23026145-8f68-11ef-8774-c018035abcac', 'Kỹ thuật phần mềm', 'Kỹ thuật phần mềm là khóa học tập trung vào cách tiếp cận có hệ thống để thiết kế, phát triển, thử nghiệm và bảo trì các hệ thống phần mềm chất lượng cao. Nó giới thiệu Vòng đời phát triển phần mềm (SDLC), bao gồm các giai đoạn như phân tích yêu cầu, thiết kế, triển khai, thử nghiệm, triển khai và bảo trì.\n\nCác chủ đề chính bao gồm:\n\nCác phương pháp linh hoạt và mô hình thác nước,\nHệ thống kiểm soát phiên bản (ví dụ: Git),\nKiến trúc phần mềm và các mẫu thiết kế,\nKỹ thuật kiểm tra và đảm bảo chất lượng,\nCông cụ cộng tác và quản lý dự án.\nHọc sinh sẽ học cách quản lý các dự án phần mềm quy mô lớn, làm việc theo nhóm và áp dụng các phương pháp hay nhất để cung cấp các giải pháp phần mềm hiệu quả, đáng tin cậy và có thể mở rộng. Khóa học nhấn mạnh cả nguyên tắc lý thuyết và kinh nghiệm thực hành trong môi trường dự án thực tế.', 424000, 'c1f33865-8f66-11ef-8774-c018035abcac', '6243879d-8ef3-11ef-958c-c018035abcac', '2024-10-01', '2024-10-27', '2024-10-21 04:51:29', '2024-10-21 11:51:29'),
('67862eaa-8f68-11ef-8774-c018035abcac', 'Phát triển Web', 'Phát triển Web là một khóa học toàn diện được thiết kế để trang bị cho sinh viên những kỹ năng cần thiết để tạo ra các trang web năng động và phản hồi nhanh. Khóa học bao gồm cả phát triển front-end và back-end, cung cấp sự hiểu biết toàn diện về toàn bộ quá trình phát triển web.\n\nCác chủ đề chính bao gồm:\n\nHTML, CSS và JavaScript để xây dựng giao diện người dùng tương tác,\nKỹ thuật thiết kế đáp ứng để đảm bảo xem tối ưu trên các thiết bị,\nCác framework như React, Angular hoặc Vue.js để phát triển front-end hiệu quả,\nLập trình phía máy chủ sử dụng các ngôn ngữ như Node.js, PHP hoặc Python,\nQuản lý cơ sở dữ liệu với cơ sở dữ liệu SQL và NoSQL.\nHọc sinh cũng sẽ tìm hiểu về lưu trữ web, triển khai và các phương pháp hay nhất về bảo mật. Đến cuối khóa học, họ sẽ có khả năng phát triển các ứng dụng web toàn diện, hiểu các nguyên tắc trải nghiệm người dùng và cộng tác hiệu quả trong các nhóm phát triển.', 300000, 'c1f33865-8f66-11ef-8774-c018035abcac', '6243879d-8ef3-11ef-958c-c018035abcac', '2024-10-02', '2024-10-30', '2024-10-21 04:53:24', '2024-10-21 11:53:24'),
('7ce6b651-8f67-11ef-8774-c018035abcac', 'Giới thiệu về lập trình (C++)', 'Giới thiệu về Lập trình (C và C++) là khóa học cơ bản giới thiệu cho sinh viên những kiến ​​thức cơ bản về lập trình máy tính bằng hai ngôn ngữ được sử dụng rộng rãi là C và C++. Khóa học nhằm mục đích phát triển các kỹ năng giải quyết vấn đề thông qua tư duy thuật toán và viết mã thực hành.\n\nTrong phần C, học sinh học các khái niệm lập trình cơ bản như:\n\nCác biến và kiểu dữ liệu\nCấu trúc điều khiển (if-else, vòng lặp),\nChức năng và\nCác thao tác vào/ra cơ bản\nC cung cấp sự hiểu biết sâu sắc về lập trình cấp thấp, bao gồm con trỏ, quản lý bộ nhớ và mô hình stack-heap, những điều cần thiết để mã hóa và quản lý tài nguyên hiệu quả.\n\nTrong phần C++, học sinh được giới thiệu về:\n\nCác nguyên tắc lập trình hướng đối tượng (OOP) như lớp, đối tượng, kế thừa, đa hình và đóng gói.\nKhái niệm về hàm tạo, hàm hủy và nạp chồng toán tử cũng được khám phá.\nC++ mở rộng trên C bằng cách cung cấp khả năng trừu tượng hóa ở cấp độ cao hơn trong khi vẫn duy trì hiệu suất và tính linh hoạt của C. Đến cuối khóa học, sinh viên sẽ nắm vững cách cấu trúc và viết các chương trình hiệu quả, có thể bảo trì. Khóa học cũng nhấn mạnh vào việc gỡ lỗi, xử lý lỗi và thực hành viết mã tốt để chuẩn bị cho sinh viên các chủ đề lập trình nâng cao.', 256000, 'c1f33865-8f66-11ef-8774-c018035abcac', '6243879d-8ef3-11ef-958c-c018035abcac', '2024-10-02', '2024-10-25', '2024-10-21 04:46:51', '2024-10-21 11:46:51'),
('c37af6fe-8f68-11ef-8774-c018035abcac', 'Cơ sở dữ liệu SQL và NoSQL', 'Cơ sở dữ liệu SQL và NoSQL là khóa học giới thiệu cho sinh viên hai loại hệ thống quản lý cơ sở dữ liệu chính, mỗi loại phục vụ các nhu cầu lưu trữ dữ liệu khác nhau.\nĐến cuối khóa học, sinh viên sẽ hiểu cách chọn loại cơ sở dữ liệu phù hợp dựa trên yêu cầu của ứng dụng và đạt được các kỹ năng thực tế trong việc thiết kế, truy vấn và quản lý cả cơ sở dữ liệu SQL và NoSQL.', 234000, 'deaf1072-8f66-11ef-8774-c018035abcac', '6ecb6640-8ef3-11ef-958c-c018035abcac', '2024-10-03', '2024-10-31', '2024-10-21 04:55:59', '2024-10-21 11:55:59'),
('c75eae96-8f67-11ef-8774-c018035abcac', 'Lập trình hướng đối tượng', 'Lập trình hướng đối tượng (OOP) là khóa học tập trung vào việc giảng dạy các nguyên tắc thiết kế và xây dựng phần mềm bằng cách sử dụng các đối tượng và lớp. Khóa học bao gồm bốn khái niệm cốt lõi của OOP:\n\nĐóng gói: Đóng gói dữ liệu và các phương thức hoạt động trên dữ liệu trong một đơn vị hoặc lớp.\nKế thừa: Tái sử dụng và mở rộng mã hiện có bằng cách tạo các lớp mới dựa trên các lớp hiện có.\nTính đa hình: Thiết kế các đối tượng để chia sẻ các hành vi và được coi như các thể hiện của lớp cha của chúng.\nTrừu tượng hóa: Đơn giản hóa các hệ thống phức tạp bằng cách mô hình hóa các lớp dựa trên các thuộc tính và phương thức có liên quan.\nHọc sinh sẽ học cách tạo mã mô-đun, có thể tái sử dụng và bảo trì thông qua các ví dụ lập trình trong thế giới thực bằng các ngôn ngữ như Java hoặc C++. Cuối cùng, họ sẽ có thể áp dụng các nguyên tắc OOP để giải quyết các vấn đề phức tạp và thiết kế các hệ thống phần mềm có thể mở rộng.', 312000, 'c1f33865-8f66-11ef-8774-c018035abcac', '6ecb6640-8ef3-11ef-958c-c018035abcac', '2024-10-04', '2024-10-25', '2024-10-21 04:48:56', '2024-10-21 11:48:56');

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

--
-- Đang đổ dữ liệu cho bảng `course_enrollments`
--

INSERT INTO `course_enrollments` (`id`, `course_id`, `student_id`, `created_at`, `updated_at`) VALUES
('5fdf067f-9056-11ef-bda9-c018035abcac', '23026145-8f68-11ef-8774-c018035abcac', '7b1d5cd4-8e96-11ef-958c-c018035abcac', '2024-10-22 09:16:52', '2024-10-22 09:16:52'),
('6eab1097-9056-11ef-bda9-c018035abcac', 'c37af6fe-8f68-11ef-8774-c018035abcac', '7b1d5cd4-8e96-11ef-958c-c018035abcac', '2024-10-22 09:17:17', '2024-10-22 09:17:17'),
('8e6bfd7c-9047-11ef-970c-c018035abcac', 'c37af6fe-8f68-11ef-8774-c018035abcac', '01af8c3b-8e96-11ef-958c-c018035abcac', '2024-10-22 07:30:47', '2024-10-22 07:30:47'),
('f755a598-908c-11ef-8d08-c018035abcac', '7ce6b651-8f67-11ef-8774-c018035abcac', '7b1d5cd4-8e96-11ef-958c-c018035abcac', '2024-10-22 15:47:39', '2024-10-22 15:47:39'),
('fd54b8b4-904b-11ef-970c-c018035abcac', '7ce6b651-8f67-11ef-8774-c018035abcac', '01af8c3b-8e96-11ef-958c-c018035abcac', '2024-10-22 08:02:31', '2024-10-22 08:02:31');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `course_feedbacks`
--

INSERT INTO `course_feedbacks` (`id`, `course_id`, `student_id`, `feedback`, `rating`, `created_at`, `updated_at`) VALUES
('0e4cb032-9091-11ef-8d08-c018035abcac', '7ce6b651-8f67-11ef-8774-c018035abcac', '7b1d5cd4-8e96-11ef-958c-c018035abcac', 'Khóa học này rất tuyệt vời! Tôi muốn đánh giá nó 5 sao!', 5, '2024-10-22 16:16:55', '2024-10-22 23:16:55'),
('1247ff14-9088-11ef-8d08-c018035abcac', '7ce6b651-8f67-11ef-8774-c018035abcac', '01af8c3b-8e96-11ef-958c-c018035abcac', 'Tôi muốn đánh giá 4 sao về khóa học', 4, '2024-10-22 15:12:36', '2024-10-22 22:12:36');

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
  `file_id` varchar(36) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `lesson_index` int(11) NOT NULL DEFAULT 1
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
  `user_id` varchar(36) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(50) NOT NULL,
  `file_size` int(11) NOT NULL,
  `file_path` varchar(511) NOT NULL,
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
('0e482887-8f67-11ef-8774-c018035abcac', 'Kiểm thử phần mềm', '2024-10-21 04:43:45', '2024-10-21 11:43:45'),
('20e36919-8f67-11ef-8774-c018035abcac', 'Trí tuệ nhân tạo và học máy', '2024-10-21 04:44:16', '2024-10-21 11:44:16'),
('c1f33865-8f66-11ef-8774-c018035abcac', 'Lập trình và phát triển phần mềm', '2024-10-21 04:41:37', '2024-10-21 11:41:37'),
('cbf96248-8f66-11ef-8774-c018035abcac', 'Khoa học máy tính', '2024-10-21 04:41:54', '2024-10-21 14:41:49'),
('deaf1072-8f66-11ef-8774-c018035abcac', 'Thiết kế hệ thống cơ sở dữ liệu', '2024-10-21 04:42:25', '2024-10-21 11:42:25'),
('e9150716-8f66-11ef-8774-c018035abcac', 'Mạng và Bảo mật', '2024-10-21 04:42:43', '2024-10-21 11:42:43'),
('ff93aa5c-8f66-11ef-8774-c018035abcac', 'Khoa học dữ liệu', '2024-10-21 04:43:20', '2024-10-21 11:43:20');

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
  ADD UNIQUE KEY `student_id` (`student_id`,`course_id`),
  ADD KEY `course_feedbacks_ibfk_1` (`course_id`);

--
-- Chỉ mục cho bảng `course_feedbacks`
--
ALTER TABLE `course_feedbacks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`,`course_id`),
  ADD KEY `course_feedbacks_ibfk_1` (`course_id`);

--
-- Chỉ mục cho bảng `course_lessons`
--
ALTER TABLE `course_lessons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `course_id` (`course_id`,`lesson_index`),
  ADD KEY `fk_course_lessons_file_id` (`file_id`);

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
  ADD CONSTRAINT `course_enrollments_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `course_feedbacks_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `course_feedbacks_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `course_lessons`
--
ALTER TABLE `course_lessons`
  ADD CONSTRAINT `course_lessons_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_course_lessons_file_id` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

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
