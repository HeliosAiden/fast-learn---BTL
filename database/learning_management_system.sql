CREATE TABLE `users` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `username` VARCHAR(255) UNIQUE NOT NULL,
  `password_hash` VARCHAR(255) UNIQUE NOT NULL,
  `role` ENUM ('Student', 'Teacher', 'Admin') DEFAULT 'Student',
  `user_info` INT,
  `state` ENUM ('Active', 'Inactive', 'Removed') DEFAULT 'Inactive'
);

CREATE TABLE `user_infos` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `firstname` VARCHAR(255),
  `lastname` VARCHAR(255),
  `fullname` VARCHAR(511),
  `email` VARCHAR(255),
  `gender` ENUM ('Male', 'Female', 'Others'),
  `phone_number` VARCHAR(20),
  `date_of_birth` DATE
);

CREATE TABLE `subjects` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL
);

CREATE TABLE `courses` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT,
  `fee` DECIMAL(10,2) DEFAULT 0,
  `subject_id` INT NOT NULL,
  `teacher_id` INT NOT NULL,
  `start_date` DATE,
  `end_date` DATE
);

CREATE TABLE `course_feedbacks` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `course_id` INT NOT NULL,
  `student_id` INT NOT NULL,
  `feedback` TEXT,
  `rating` INT,
  `feedback_date` DATE
);

CREATE TABLE `course_questions` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `student_id` INT NOT NULL,
  `course_id` INT NOT NULL,
  `question` TEXT NOT NULL,
  `state` ENUM ('Open', 'Closed', 'Hidden') DEFAULT 'Open'
);

CREATE TABLE `answers` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `replier_id` INT NOT NULL,
  `answer` TEXT NOT NULL,
  `question_id` INT NOT NULL
);

CREATE TABLE `course_materials` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `course_id` INT NOT NULL,
  `name` VARCHAR(255),
  `content` TEXT,
  `link` VARCHAR(511),
  `state` ENUM ('Creating', 'Hidden', 'Visible') DEFAULT 'Creating'
);

ALTER TABLE `users` ADD CONSTRAINT `fk_user_info` FOREIGN KEY (`user_info`) REFERENCES `user_infos` (`id`);

ALTER TABLE `courses` ADD CONSTRAINT `fk_subject_id` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`);

ALTER TABLE `courses` ADD CONSTRAINT `fk_teacher_id` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`);

ALTER TABLE `course_feedbacks` ADD CONSTRAINT `fk_course_id` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

ALTER TABLE `course_feedbacks` ADD CONSTRAINT `fk_student_id` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`);

ALTER TABLE `course_questions` ADD CONSTRAINT `fk_question_student_id` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`);

ALTER TABLE `answers` ADD CONSTRAINT `fk_replier_id` FOREIGN KEY (`replier_id`) REFERENCES `users` (`id`);

ALTER TABLE `answers` ADD CONSTRAINT `fk_question_id` FOREIGN KEY (`question_id`) REFERENCES `course_questions` (`id`);

ALTER TABLE `course_materials` ADD CONSTRAINT `fk_course_material_course_id` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

ALTER TABLE `course_questions` ADD FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);
