-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2026 at 10:02 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student_record_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `AttendanceID` int(11) NOT NULL COMMENT 'Auto incremented unique identifier for each attendance record',
  `StudentID` int(11) NOT NULL COMMENT 'Links attendance record to a specific student',
  `CourseID` int(11) NOT NULL COMMENT 'Links attendance to a specific course',
  `AttendanceDate` date DEFAULT NULL COMMENT 'Date when attendance is recorded.',
  `Status` varchar(20) DEFAULT NULL COMMENT 'Attendance Status: Present, absent, late.',
  `RecordedBy` varchar(100) DEFAULT NULL COMMENT 'The name or Staff ID of the authorised teacher who recorded it',
  `IsExcused` tinyint(1) DEFAULT NULL COMMENT 'indicates if an absence or lateness is officially excused.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`AttendanceID`, `StudentID`, `CourseID`, `AttendanceDate`, `Status`, `RecordedBy`, `IsExcused`) VALUES
(1, 1, 9, '2024-09-10', 'Present', 'Samuel Agbesi', 0),
(2, 1, 10, '2024-09-11', 'Late', 'Samia Ahmed', 0),
(3, 2, 9, '2024-09-10', 'Absent', 'Samuel Agbesi', 1),
(4, 2, 11, '2024-09-11', 'Present', 'Bernice Bryan', 0),
(5, 3, 10, '2024-09-12', 'Present', 'Samia Ahmed', 0),
(6, 3, 12, '2024-09-12', 'Absent', 'Youcef Gheraibia', 0),
(7, 4, 9, '2024-09-13', 'Present', 'Samuel Agbesi', 0),
(8, 4, 13, '2024-09-13', 'Late', 'Steffen Herskind', 0),
(9, 5, 11, '2024-09-14', 'Present', 'Bernice Bryan', 0),
(10, 5, 14, '2024-09-14', 'Absent', 'Jesper Jorgensen', 1),
(11, 6, 10, '2024-09-15', 'Present', 'Samia Ahmed', 0),
(12, 7, 15, '2024-09-16', 'Present', 'Mudassar Kamal', 0),
(13, 8, 16, '2024-09-16', 'Late', 'Dimitrios Papadimitriou', 0),
(14, 9, 12, '2024-09-17', 'Absent', 'Youcef Gheraibia', 1),
(15, 10, 13, '2024-09-17', 'Present', 'Steffen Herskind', 0),
(16, 1, 9, '2024-09-18', 'Present', 'Samuel Agbesi', 0),
(17, 2, 9, '2024-09-18', 'Present', 'Samuel Agbesi', 0),
(18, 3, 10, '2024-09-18', 'Late', 'Samia Ahmed', 0),
(19, 4, 9, '2024-09-18', 'Absent', 'Samuel Agbesi', 0),
(20, 5, 11, '2024-09-18', 'Present', 'Bernice Bryan', 0);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `CourseID` int(11) NOT NULL COMMENT 'Auto-incremented unique identifier for each course',
  `CourseName` varchar(100) DEFAULT NULL COMMENT 'Full name of the course',
  `CourseCode` varchar(20) NOT NULL COMMENT 'Unique short code ',
  `CreditPoints` int(10) DEFAULT NULL COMMENT 'Number of credit points awarded for completing the course',
  `StartDate` date NOT NULL COMMENT 'The date of course officially started.',
  `IsActive` tinyint(1) NOT NULL COMMENT 'True if the course is currently active',
  `TeacherID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`CourseID`, `CourseName`, `CourseCode`, `CreditPoints`, `StartDate`, `IsActive`, `TeacherID`) VALUES
(9, 'Introduction to Programming', 'CS101', 10, '2024-09-01', 1, 1),
(10, 'Database Systems', 'CS102', 10, '2024-09-01', 1, 2),
(11, 'Web Development', 'CS103', 10, '2024-09-01', 1, 3),
(12, 'Computer Networks', 'CS104', 10, '2024-09-01', 1, 4),
(13, 'Software Engineering', 'CS105', 10, '2024-09-01', 1, 5),
(14, 'Data Structures', 'CS106', 10, '2024-09-01', 1, 6),
(15, 'Operating Systems', 'CS107', 10, '2024-09-01', 1, 7),
(16, 'Cyber Security', 'CS108', 10, '2024-09-01', 1, 8);

-- --------------------------------------------------------

--
-- Table structure for table `enrollment`
--

CREATE TABLE `enrollment` (
  `EnrollmentID` int(11) NOT NULL COMMENT 'Unique identifier for enrolment ',
  `StudentID` int(11) NOT NULL COMMENT 'References for the student who is enrolled. Links to Student. StudentID.',
  `CourseID` int(11) NOT NULL COMMENT 'References to the course the student is enrolled on. Links to Course. CourseID.',
  `EnrollDate` date NOT NULL COMMENT 'The date the student was officially enrolled on the course. System-generated.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollment`
--

INSERT INTO `enrollment` (`EnrollmentID`, `StudentID`, `CourseID`, `EnrollDate`) VALUES
(16, 1, 9, '2024-09-02'),
(17, 1, 10, '2024-09-02'),
(18, 2, 9, '2024-09-02'),
(19, 2, 11, '2024-09-02'),
(20, 3, 10, '2024-09-03'),
(21, 3, 12, '2024-09-03'),
(22, 4, 9, '2024-09-03'),
(23, 4, 13, '2024-09-03'),
(24, 5, 11, '2024-09-04'),
(25, 5, 14, '2024-09-04'),
(26, 6, 10, '2024-09-04'),
(27, 7, 15, '2024-09-05'),
(28, 8, 16, '2024-09-05'),
(29, 9, 12, '2024-09-05'),
(30, 10, 13, '2024-09-06');

-- --------------------------------------------------------

--
-- Table structure for table `grade`
--

CREATE TABLE `grade` (
  `GradeID` int(11) NOT NULL COMMENT 'Unique Identifier for each grade entry',
  `StudentID` int(11) NOT NULL COMMENT 'we',
  `CourseID` int(11) NOT NULL COMMENT 'we',
  `Marks` decimal(5,2) DEFAULT NULL COMMENT 'we',
  `GradeLetter` varchar(2) DEFAULT NULL COMMENT 'we',
  `DateRecorded` timestamp NULL DEFAULT NULL COMMENT 'we',
  `isPassed` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grade`
--

INSERT INTO `grade` (`GradeID`, `StudentID`, `CourseID`, `Marks`, `GradeLetter`, `DateRecorded`, `isPassed`) VALUES
(1, 1, 9, 85.50, 'A', '2024-12-01 09:00:00', 1),
(2, 1, 10, 78.00, 'B', '2024-12-01 09:05:00', 1),
(3, 2, 9, 65.00, 'C', '2024-12-01 09:10:00', 1),
(4, 2, 11, 55.00, 'D', '2024-12-01 09:15:00', 1),
(5, 3, 10, 40.00, 'F', '2024-12-01 09:20:00', 0),
(6, 3, 12, 72.00, 'B', '2024-12-01 09:25:00', 1),
(7, 4, 9, 90.00, 'A', '2024-12-01 09:30:00', 1),
(8, 4, 13, 88.00, 'A', '2024-12-01 09:35:00', 1),
(9, 5, 11, 67.00, 'C', '2024-12-01 09:40:00', 1),
(10, 5, 14, 49.00, 'F', '2024-12-01 09:45:00', 0),
(11, 6, 10, 74.00, 'B', '2024-12-01 09:50:00', 1),
(12, 7, 15, 82.00, 'A', '2024-12-01 09:55:00', 1),
(13, 8, 16, 59.00, 'D', '2024-12-01 10:00:00', 1),
(14, 9, 12, 77.00, 'B', '2024-12-01 10:05:00', 1),
(15, 10, 13, 69.00, 'C', '2024-12-01 10:10:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `StudentID` int(11) NOT NULL COMMENT 'Auto-incremented unique identifier for each student',
  `StudentName` varchar(100) DEFAULT NULL COMMENT 'Full anme of the student',
  `Email` varchar(100) NOT NULL COMMENT 'Unique email address used for login',
  `Level` varchar(100) DEFAULT NULL COMMENT 'Academic level e.g. Year 1, Year 2, Postgraduate',
  `DateOfBirth` date DEFAULT NULL COMMENT 'Date of birth of student',
  `DateEnrolled` datetime DEFAULT NULL COMMENT 'The date the student was registered on the system',
  `IsActive` tinyint(1) DEFAULT NULL COMMENT 'TRUE if student account is active, FALSE if deactivated'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`StudentID`, `StudentName`, `Email`, `Level`, `DateOfBirth`, `DateEnrolled`, `IsActive`) VALUES
(1, 'Rajesh Sharma', 'rajesh.sharma@gmail.com', 'Year 1', '2002-05-14', '2024-09-01 10:00:00', 1),
(2, 'Sita Thapa', 'sita.thapa@gmail.com', 'Year 2', '2001-08-22', '2023-09-01 10:00:00', 1),
(3, 'Bikash Gurung', 'bikash.gurung@gmail.com', 'Year 3', '2000-12-10', '2022-09-01 10:00:00', 1),
(4, 'Anisha Rai', 'anisha.rai@gmail.com', 'Year 1', '2003-03-18', '2024-09-01 10:00:00', 1),
(5, 'Prakash Magar', 'prakash.magar@gmail.com', 'Year 2', '2001-07-25', '2023-09-01 10:00:00', 1),
(6, 'Nabin Karki', 'nabin.karki@gmail.com', 'Year 3', '2000-11-05', '2022-09-01 10:00:00', 1),
(7, 'Pooja Adhikari', 'pooja.adhikari@gmail.com', 'Year 1', '2002-09-30', '2024-09-01 10:00:00', 1),
(8, 'Deepak Tamang', 'deepak.tamang@gmail.com', 'Year 2', '2001-01-12', '2023-09-01 10:00:00', 1),
(9, 'Sunita Lama', 'sunita.lama@gmail.com', 'Year 3', '2000-06-28', '2022-09-01 10:00:00', 1),
(10, 'Ramesh Bhandari', 'ramesh.bhandari@gmail.com', 'Year 1', '2003-04-09', '2024-09-01 10:00:00', 1),
(11, 'Test User', 'test@example.com', 'Year 1', '2000-01-01', '2026-05-05 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `TeacheID` int(11) NOT NULL,
  `TeacherName` varchar(100) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Department` varchar(50) DEFAULT NULL,
  `DateJoined` date DEFAULT NULL,
  `IsActive` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`TeacheID`, `TeacherName`, `Email`, `Department`, `DateJoined`, `IsActive`) VALUES
(1, 'Samuel Agbesi', 'samuel.agbesi@edu.nielsbrock.dk', 'Computer Science', '2022-01-10', 1),
(2, 'Samia Ahmed', 'samia.ahmed@edu.nielsbrock.dk', 'Computer Science', '2021-09-15', 1),
(3, 'Bernice Bryan', 'bernice.bryan@edu.nielsbrock.dk', 'IT', '2020-08-20', 1),
(4, 'Youcef Gheraibia', 'youcef.gheraibia@edu.nielsbrock.dk', 'Networking', '2021-03-05', 1),
(5, 'Steffen Herskind', 'steffen.herskind@edu.nielsbrock.dk', 'Software Eng', '2019-11-11', 1),
(6, 'Jesper Jorgensen', 'jesper.jorgensen@edu.nielsbrock.dk', 'Data Science', '2020-06-01', 1),
(7, 'Mudassar Kamal', 'mudassar.kamal@edu.nielsbrock.dk', 'Cyber Security', '2022-02-14', 1),
(8, 'Dimitrios Papadimitriou', 'dimitrios.p@edu.nielsbrock.dk', 'Computer Science', '2018-07-23', 1),
(9, 'Maeve Anne Paris', 'maeve.paris@edu.nielsbrock.dk', 'IT', '2021-05-30', 1),
(10, 'Arti Ranjan', 'arti.ranjan@edu.nielsbrock.dk', 'Software Eng', '2023-01-12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','teacher','student') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '1234', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`AttendanceID`),
  ADD KEY `StudentID` (`StudentID`),
  ADD KEY `CourseID` (`CourseID`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`CourseID`,`CourseCode`),
  ADD KEY `TeacherID` (`TeacherID`);

--
-- Indexes for table `enrollment`
--
ALTER TABLE `enrollment`
  ADD PRIMARY KEY (`EnrollmentID`),
  ADD KEY `CourseID` (`CourseID`),
  ADD KEY `StudentID` (`StudentID`);

--
-- Indexes for table `grade`
--
ALTER TABLE `grade`
  ADD PRIMARY KEY (`GradeID`,`StudentID`),
  ADD KEY `CourseID` (`CourseID`),
  ADD KEY `StudentID` (`StudentID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`StudentID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`TeacheID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `AttendanceID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Auto incremented unique identifier for each attendance record', AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `CourseID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Auto-incremented unique identifier for each course', AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `enrollment`
--
ALTER TABLE `enrollment`
  MODIFY `EnrollmentID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier for enrolment ', AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `grade`
--
ALTER TABLE `grade`
  MODIFY `GradeID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique Identifier for each grade entry', AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `StudentID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Auto-incremented unique identifier for each student', AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `TeacheID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`StudentID`) REFERENCES `student` (`StudentID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`CourseID`) REFERENCES `course` (`CourseID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `course_ibfk_1` FOREIGN KEY (`TeacherID`) REFERENCES `teacher` (`TeacheID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `enrollment`
--
ALTER TABLE `enrollment`
  ADD CONSTRAINT `enrollment_ibfk_1` FOREIGN KEY (`CourseID`) REFERENCES `course` (`CourseID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `enrollment_ibfk_2` FOREIGN KEY (`StudentID`) REFERENCES `student` (`StudentID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `grade`
--
ALTER TABLE `grade`
  ADD CONSTRAINT `grade_ibfk_1` FOREIGN KEY (`CourseID`) REFERENCES `course` (`CourseID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `grade_ibfk_2` FOREIGN KEY (`StudentID`) REFERENCES `student` (`StudentID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
