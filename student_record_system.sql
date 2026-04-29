-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2026 at 11:17 AM
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
  `IsActive` tinyint(1) NOT NULL COMMENT 'True if the course is currently active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  ADD PRIMARY KEY (`CourseID`,`CourseCode`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `AttendanceID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Auto incremented unique identifier for each attendance record';

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `CourseID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Auto-incremented unique identifier for each course';

--
-- AUTO_INCREMENT for table `enrollment`
--
ALTER TABLE `enrollment`
  MODIFY `EnrollmentID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier for enrolment ';

--
-- AUTO_INCREMENT for table `grade`
--
ALTER TABLE `grade`
  MODIFY `GradeID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique Identifier for each grade entry';

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `StudentID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Auto-incremented unique identifier for each student';

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `TeacheID` int(11) NOT NULL AUTO_INCREMENT;

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
