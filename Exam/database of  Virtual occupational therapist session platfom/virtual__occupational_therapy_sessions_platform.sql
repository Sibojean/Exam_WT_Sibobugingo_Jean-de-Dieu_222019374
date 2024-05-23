-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2024 at 10:13 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `virtual _occupational_therapy_sessions_platform`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `activity_id` int(11) NOT NULL,
  `activity_name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `duration_minutes` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `session_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`activity_id`, `activity_name`, `description`, `duration_minutes`, `client_id`, `session_id`) VALUES
(3, 'Fitness', 'Workout session', 60, 3, 3),
(4, 'Counseling', 'Therapy session', 60, 4, 4),
(5, 'Meditation2', 'Guided maditation', 40, 4, 3),
(6, 'Massage', 'Guided maditation', 60, 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointment_id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `appointment_date` date DEFAULT NULL,
  `appointment_time` time DEFAULT NULL,
  `appointment_duration_minutes` int(11) DEFAULT NULL,
  `appointment_location` varchar(100) DEFAULT NULL,
  `appointment_purpose` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`appointment_id`, `client_id`, `appointment_date`, `appointment_time`, `appointment_duration_minutes`, `appointment_location`, `appointment_purpose`) VALUES
(2, 2, '2024-05-11', '14:30:00', 45, 'Room B', 'Therapy Session'),
(3, 3, '2024-05-12', '11:00:00', 90, 'Room C', 'Consultation'),
(4, 4, '2024-05-13', '09:00:00', 30, 'Room D', 'Follow-up Appointment'),
(6, 4, '0000-00-00', NULL, 56, 'kagamba', 'masive');

-- --------------------------------------------------------

--
-- Table structure for table `assessmentforms`
--

CREATE TABLE `assessmentforms` (
  `form_id` int(11) NOT NULL,
  `form_name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `session_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assessmentforms`
--

INSERT INTO `assessmentforms` (`form_id`, `form_name`, `description`, `created_date`, `client_id`, `session_id`) VALUES
(1, 'Depression Inventory', 'Assessment form to evaluate symptoms of depression.', '2024-05-22', 1, 1),
(2, 'Anxiety Scale', 'Assessment form to measure levels of anxiety.', '2024-05-02', 2, 2),
(3, 'Stress Test', 'Assessment form to assess stress levels.', '2024-05-03', 3, 3),
(4, 'PTSD Checklist', 'Assessment form to screen for symptoms of PTSD.', '2024-05-04', 4, 4),
(5, NULL, 'Guided maditation', '2024-05-17', 2, 5),
(56, NULL, 'Assessment form to evaluate if am Ok', '2024-05-25', 9, 67);

-- --------------------------------------------------------

--
-- Table structure for table `chathistory`
--

CREATE TABLE `chathistory` (
  `message_id` int(11) NOT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chathistory`
--

INSERT INTO `chathistory` (`message_id`, `sender_id`, `receiver_id`, `message`, `timestamp`) VALUES
(1, 1, 2, 'Hi Sibo, zariye se ngo nze?', '2024-05-02 13:27:50'),
(2, 2, 1, 'Hi nizeye! meze neza ubu kabsa. How about you?', '2024-05-02 13:27:50'),
(3, 3, 4, 'Hey Babe, do you have time for a chat?', '2024-05-02 13:27:50'),
(4, 4, 3, 'Sure, mama! ngo uraka akanyama?', '2024-05-02 13:27:50'),
(5, 5, 5, 'go throuht', '2024-05-18 15:43:00');

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `client_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`client_id`, `name`, `email`, `phone_number`, `address`) VALUES
(1, 'Jean Sibobugingo', 'sibojean@gmail.com', '0788903503', 'Rutare'),
(2, 'Eric Iraradukunda', 'irara@gmail.com', '07989020270', 'Kigali'),
(3, 'Lil Mutoni', 'mutoni@gmail.com', '0780072415', 'Musanze'),
(4, 'Jos Mutesi', 'mutesi@gmail.com', '0782452711', 'Kmonyi'),
(9, 'Tresor Nikubwayo', 'sibojeandedieu10@gmail.com', '0783509696', 'Nyamata');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `file_id` int(11) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `client_id` int(11) DEFAULT NULL,
  `session_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`file_id`, `file_name`, `file_type`, `file_size`, `upload_date`, `client_id`, `session_id`) VALUES
(1, 'document1.pdf', 'PDF', 1024, '2024-05-02 13:02:23', 9, 1),
(2, 'image1.jpg', 'JPEG', 2048, '2024-05-02 13:02:23', 2, 2),
(3, 'document2.docx', 'DOCX', 3072, '2024-05-02 13:02:23', 3, 3),
(4, 'image2.png', 'PNG', 4096, '2024-05-02 13:02:23', 4, 4),
(8, 'Image2', 'DOX', 23, '2024-05-08 22:00:00', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `client_id`, `amount`, `payment_date`) VALUES
(1, 2, 5000.00, '0000-00-00'),
(2, 2, 800.00, '2024-05-02'),
(3, 9, 400.00, '0000-00-00'),
(4, 4, 885.00, '2024-05-04'),
(5, 2, 200.00, '2024-05-16');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `session_id` int(11) NOT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`session_id`, `start_time`, `end_time`, `location`, `client_id`) VALUES
(1, '2024-05-01 10:00:00', '2024-05-01 11:00:00', 'Room 453', 9),
(2, '2024-05-02 09:30:00', '2024-05-02 10:30:00', 'Room B', 2),
(3, '2024-05-03 14:00:00', '2024-05-03 15:00:00', 'Room C7', 3),
(4, '2024-05-04 11:00:00', '2024-05-04 12:00:00', 'Room D', 4),
(5, '2024-05-10 13:13:00', '2024-05-25 13:13:00', 'Mamba B14', 2),
(67, '2024-05-17 13:14:00', '2024-05-18 13:12:00', 'Room z', 2);

-- --------------------------------------------------------

--
-- Table structure for table `therapists`
--

CREATE TABLE `therapists` (
  `therapist_id` int(10) NOT NULL,
  `therapist_first_name` varchar(10) NOT NULL,
  `therapist_last_name` varchar(8) NOT NULL,
  `specialization` varchar(9) NOT NULL,
  `experience_years` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `therapists`
--

INSERT INTO `therapists` (`therapist_id`, `therapist_first_name`, `therapist_last_name`, `specialization`, `experience_years`) VALUES
(1, 'JBAGAMBA', 'Jean nep', 'clinical ', 8),
(2, 'NSABIMANA', 'Jean pau', 'Clinical ', 7),
(3, 'TUYIZERE', 'Patric', 'Family Th', 12),
(9, 'Gelard', 'Namahirw', 'Substance', 15),
(11, 'Rebecca', 'Tuyizere', 'AGENT', 6);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `email`, `username`, `password`) VALUES
(1, 'sibo', 'jean', 'sibojeandedieu10@gmail.com', 'bonn', '$2y$10$MB2n27aJAyZAXsSqClidK.dwmoKgIXozElW.KYyI1E9RW2uaMOnl2'),
(2, '', '', '', '', '$2y$10$rf3LP0KlspflLpRx.0pRw.TjEHkl3XkyBv7ig4ZeQ0VzYt06Sv40a'),
(3, 'ITURUSHIMBABAZI', 'Theoneste', 'garadiatheo5@gmail.com', 'sinu', '$2y$10$xu0mopl1gA1bf.sxp0T1Qut0LHvdwVG9Nx1wpWOXI6SphrziUcXna'),
(4, 'ishimwe', 'fiacre', 'ishimwe@gmail.com', 'gatoya', '$2y$10$mG/tSQYW1HK.iYBVb7u4LerJrGWTngUFMh27fbkqnyirSH2PEViWW'),
(5, 'Namahirwe', 'Jerald', 'namahirwe@gmail.com', 'bisaga', '$2y$10$Z9LtRyKXGBrlAAykKqTR2emoI0vtUVCjXf6fFWPxfsGAB6mRvMHoS');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`activity_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `session_id` (`session_id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `assessmentforms`
--
ALTER TABLE `assessmentforms`
  ADD PRIMARY KEY (`form_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `session_id` (`session_id`);

--
-- Indexes for table `chathistory`
--
ALTER TABLE `chathistory`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`file_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `session_id` (`session_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `therapists`
--
ALTER TABLE `therapists`
  ADD PRIMARY KEY (`therapist_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `assessmentforms`
--
ALTER TABLE `assessmentforms`
  MODIFY `form_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `chathistory`
--
ALTER TABLE `chathistory`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `therapists`
--
ALTER TABLE `therapists`
  MODIFY `therapist_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `activities_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`client_id`),
  ADD CONSTRAINT `activities_ibfk_2` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`session_id`);

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`client_id`);

--
-- Constraints for table `assessmentforms`
--
ALTER TABLE `assessmentforms`
  ADD CONSTRAINT `assessmentforms_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`client_id`),
  ADD CONSTRAINT `assessmentforms_ibfk_2` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`session_id`);

--
-- Constraints for table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`client_id`),
  ADD CONSTRAINT `files_ibfk_2` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`session_id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`client_id`);

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`client_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
