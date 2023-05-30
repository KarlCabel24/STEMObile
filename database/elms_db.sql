-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2023 at 02:31 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_announcement`
--

CREATE TABLE `tbl_announcement` (
  `ID` int(11) NOT NULL,
  `Announcement` varchar(255) NOT NULL,
  `SectionID` int(11) NOT NULL,
  `SubjectID` int(11) NOT NULL,
  `TeacherID` int(11) NOT NULL,
  `DateCreated` datetime NOT NULL,
  `CreatedByID` int(11) NOT NULL,
  `DateUpdated` datetime DEFAULT NULL,
  `UpdatedByID` int(11) DEFAULT NULL,
  `isDeleted` int(11) NOT NULL COMMENT '1 = deleted	'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_announcement`
--

INSERT INTO `tbl_announcement` (`ID`, `Announcement`, `SectionID`, `SubjectID`, `TeacherID`, `DateCreated`, `CreatedByID`, `DateUpdated`, `UpdatedByID`, `isDeleted`) VALUES
(1, 'test announcement 123', 1, 3, 45, '2023-05-26 15:46:00', 0, '2023-05-26 21:41:00', 0, 0),
(2, 'test 123412122111212', 5, 2, 44, '2023-05-26 16:10:00', 0, '2023-05-26 16:22:00', 0, 1),
(3, '23123123qweqweqweqw', 9, 1, 45, '2023-05-28 20:20:00', 0, NULL, NULL, 1),
(4, 'qweqweqweqwewqeqweqw', 9, 1, 45, '2023-05-28 20:21:00', 0, NULL, NULL, 1),
(5, 'qweqweqweqwe', 2, 1, 45, '2023-05-28 20:22:00', 0, NULL, NULL, 1),
(6, 'asdsadsad', 8, 3, 45, '2023-05-28 20:22:00', 0, NULL, NULL, 1),
(7, 'jhjhjjjjjjjjjjjjjjjjjjjjjj', 8, 1, 45, '2023-05-28 20:22:00', 0, '2023-05-28 20:23:00', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_assignment`
--

CREATE TABLE `tbl_assignment` (
  `ID` int(11) NOT NULL,
  `AssignmentTitle` varchar(255) NOT NULL,
  `SectionID` int(11) NOT NULL,
  `SubjectID` int(11) NOT NULL,
  `TeacherID` int(11) NOT NULL,
  `DateCreated` datetime NOT NULL,
  `CreatedByID` int(11) NOT NULL,
  `DateUpdated` datetime DEFAULT NULL,
  `UpdatedByID` int(11) DEFAULT NULL,
  `isDeleted` int(11) NOT NULL COMMENT '1 = Deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_assignment`
--

INSERT INTO `tbl_assignment` (`ID`, `AssignmentTitle`, `SectionID`, `SubjectID`, `TeacherID`, `DateCreated`, `CreatedByID`, `DateUpdated`, `UpdatedByID`, `isDeleted`) VALUES
(1, 'aaaaaaaaaaaaaaaaaaaaaaaaaa', 1, 1, 45, '2023-05-26 16:32:00', 0, NULL, NULL, 1),
(2, 'qqqqqqqqqqqqqqqqqqqqqqqqqq', 8, 3, 45, '2023-05-28 20:26:00', 45, NULL, NULL, 0),
(3, 'xsafasdasdasd', 1, 3, 45, '2023-05-28 20:27:00', 45, NULL, NULL, 0),
(4, 'grhgfhgfh', 1, 2, 45, '2023-05-28 20:30:00', 45, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_assign_choices`
--

CREATE TABLE `tbl_assign_choices` (
  `ID` int(11) NOT NULL,
  `AssignmentID` int(11) NOT NULL,
  `QuestionNumber` int(11) NOT NULL,
  `Choices` varchar(255) NOT NULL,
  `IsAnswer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_assign_choices`
--

INSERT INTO `tbl_assign_choices` (`ID`, `AssignmentID`, `QuestionNumber`, `Choices`, `IsAnswer`) VALUES
(11, 1, 1, 'q', 1),
(12, 1, 1, 'w', 0),
(13, 1, 1, 'e', 0),
(14, 1, 1, 'r', 0),
(15, 1, 2, 'q', 0),
(16, 1, 2, 'w', 1),
(17, 1, 2, 'e', 0),
(18, 1, 2, 'r', 0),
(19, 1, 3, 'q', 0),
(20, 1, 3, 'w', 0),
(21, 1, 3, 'e', 1),
(22, 1, 3, 'r', 0),
(23, 1, 4, 'q', 0),
(24, 1, 4, 'w', 0),
(25, 1, 4, 'e', 0),
(26, 1, 4, 'r', 1),
(27, 3, 1, 'q', 1),
(28, 3, 1, 'w', 0),
(29, 3, 1, 'e', 0),
(30, 3, 1, 'r', 0),
(31, 2, 1, 'qweqw', 1),
(32, 2, 1, 'eqweqwe', 0),
(33, 2, 1, 'qweqweqw', 0),
(34, 2, 1, 'ewqeqwe', 0),
(35, 4, 1, '432423423', 0),
(36, 4, 1, '423423', 0),
(37, 4, 1, '4234234', 1),
(38, 4, 1, '234234', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_assign_question`
--

CREATE TABLE `tbl_assign_question` (
  `ID` int(11) NOT NULL,
  `AssignmentID` int(11) NOT NULL,
  `QuestionNumber` int(11) NOT NULL,
  `Question` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_assign_question`
--

INSERT INTO `tbl_assign_question` (`ID`, `AssignmentID`, `QuestionNumber`, `Question`) VALUES
(4, 1, 1, 'q'),
(5, 1, 2, 'w'),
(8, 3, 1, 'q'),
(9, 2, 1, 'qwewqe'),
(10, 4, 1, '23423432');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_assign_score`
--

CREATE TABLE `tbl_assign_score` (
  `ID` int(11) NOT NULL,
  `AssignmentID` int(11) NOT NULL,
  `StudentID` int(11) NOT NULL,
  `TotalScore` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_assign_score`
--

INSERT INTO `tbl_assign_score` (`ID`, `AssignmentID`, `StudentID`, `TotalScore`) VALUES
(1, 1, 17, 0),
(2, 3, 17, 1),
(3, 4, 17, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_choices`
--

CREATE TABLE `tbl_choices` (
  `ID` int(11) NOT NULL,
  `QuizID` int(11) NOT NULL,
  `QuestionNumber` int(11) NOT NULL,
  `Choices` varchar(255) NOT NULL,
  `IsAnswer` int(11) NOT NULL COMMENT '1 = answer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_choices`
--

INSERT INTO `tbl_choices` (`ID`, `QuizID`, `QuestionNumber`, `Choices`, `IsAnswer`) VALUES
(18, 3, 1, 'Hyperlinks and Text Markup Language', 0),
(19, 3, 1, 'Home Tool Markup Language', 0),
(20, 3, 1, 'Hyper Text Markup Language', 0),
(21, 3, 1, 'How To Make Lumpia', 1),
(22, 2, 1, '1', 1),
(23, 2, 1, '2', 0),
(24, 2, 1, '3', 0),
(25, 2, 1, '4', 0),
(26, 2, 2, '5', 0),
(27, 2, 2, '6', 1),
(28, 2, 2, '7', 0),
(29, 2, 2, '8', 0),
(30, 2, 3, '9', 0),
(31, 2, 3, '10', 0),
(32, 2, 3, '11', 0),
(33, 2, 3, '12', 1),
(34, 5, 1, 'choice1', 1),
(35, 5, 1, 'choice2', 0),
(36, 5, 1, 'choice3', 0),
(37, 5, 1, 'choice4', 0),
(38, 5, 2, 'choice5', 0),
(39, 5, 2, 'choice6', 0),
(40, 5, 2, 'choice7', 0),
(41, 5, 2, 'choice8', 1),
(42, 7, 1, 'q', 1),
(43, 7, 1, 'w', 0),
(44, 7, 1, 'e', 0),
(45, 7, 1, 'r', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_class`
--

CREATE TABLE `tbl_class` (
  `ID` int(11) NOT NULL,
  `TeacherID` int(11) NOT NULL,
  `SectionID` int(11) NOT NULL,
  `StudentID` int(11) DEFAULT NULL,
  `DateCreated` datetime NOT NULL,
  `CreatedByID` int(11) NOT NULL,
  `UpdatedByID` int(11) NOT NULL,
  `DateUpdated` datetime NOT NULL,
  `isDeleted` int(11) NOT NULL COMMENT '1 = deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_class`
--

INSERT INTO `tbl_class` (`ID`, `TeacherID`, `SectionID`, `StudentID`, `DateCreated`, `CreatedByID`, `UpdatedByID`, `DateUpdated`, `isDeleted`) VALUES
(6, 44, 1, NULL, '2023-05-17 22:42:00', 0, 0, '0000-00-00 00:00:00', 0),
(7, 44, 2, NULL, '2023-05-17 22:42:00', 0, 0, '0000-00-00 00:00:00', 0),
(8, 45, 2, NULL, '2023-05-18 16:43:00', 0, 0, '0000-00-00 00:00:00', 0),
(9, 45, 1, NULL, '2023-05-18 20:55:00', 0, 0, '0000-00-00 00:00:00', 0),
(11, 0, 5, NULL, '2023-05-25 20:51:00', 0, 0, '0000-00-00 00:00:00', 0),
(12, 45, 5, NULL, '2023-05-25 20:52:00', 0, 0, '0000-00-00 00:00:00', 1),
(13, 45, 5, NULL, '2023-05-25 20:53:00', 0, 0, '0000-00-00 00:00:00', 0),
(14, 45, 4, NULL, '2023-05-27 11:58:00', 45, 0, '0000-00-00 00:00:00', 1),
(15, 45, 8, NULL, '2023-05-28 12:41:00', 45, 0, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_grade`
--

CREATE TABLE `tbl_grade` (
  `ID` int(11) NOT NULL,
  `Grade` varchar(255) NOT NULL,
  `DateCreated` datetime NOT NULL,
  `CreatedByID` int(11) NOT NULL,
  `DateUpdated` datetime DEFAULT NULL,
  `UpdatedByID` int(11) DEFAULT NULL,
  `isDeleted` int(11) NOT NULL COMMENT '1 = deleted	'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_grade`
--

INSERT INTO `tbl_grade` (`ID`, `Grade`, `DateCreated`, `CreatedByID`, `DateUpdated`, `UpdatedByID`, `isDeleted`) VALUES
(1, '11', '2023-05-12 10:53:00', 0, NULL, NULL, 1),
(2, '12', '2023-05-12 10:53:00', 0, NULL, NULL, 0),
(3, '13', '2023-05-18 09:46:00', 45, NULL, NULL, 1),
(4, '14', '2023-05-24 02:14:00', 45, NULL, NULL, 1),
(5, '15', '2023-05-24 02:15:00', 45, NULL, NULL, 1),
(6, '14', '2023-05-26 22:37:00', 0, '2023-05-26 22:37:00', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_module`
--

CREATE TABLE `tbl_module` (
  `ID` int(11) NOT NULL,
  `Module` varchar(500) NOT NULL,
  `SectionID` int(11) NOT NULL,
  `SubjectID` int(11) NOT NULL,
  `TeacherID` int(11) NOT NULL,
  `DateCreated` datetime NOT NULL,
  `CreatedByID` int(11) NOT NULL,
  `DateUpdated` datetime DEFAULT NULL,
  `UpdatedByID` int(11) DEFAULT NULL,
  `isDeleted` int(11) NOT NULL COMMENT '1 = deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_module`
--

INSERT INTO `tbl_module` (`ID`, `Module`, `SectionID`, `SubjectID`, `TeacherID`, `DateCreated`, `CreatedByID`, `DateUpdated`, `UpdatedByID`, `isDeleted`) VALUES
(1, 'THESIS-sample.xlsx', 1, 1, 44, '2023-05-22 11:08:00', 0, NULL, NULL, 0),
(2, 'Bacolod South Employee Schedule Override Report.docx', 5, 2, 46, '2023-05-22 11:21:00', 0, NULL, NULL, 0),
(5, 'THESIS-sample.xlsx', 3, 1, 45, '2023-05-24 04:08:00', 0, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_question`
--

CREATE TABLE `tbl_question` (
  `ID` int(11) NOT NULL,
  `QuizID` int(11) NOT NULL,
  `QuestionNumber` int(11) NOT NULL,
  `Question` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_question`
--

INSERT INTO `tbl_question` (`ID`, `QuizID`, `QuestionNumber`, `Question`) VALUES
(7, 3, 1, 'What does HTML stands for?'),
(8, 2, 1, 'question1'),
(9, 2, 2, 'question2'),
(10, 2, 3, 'question3'),
(11, 5, 1, 'question1'),
(12, 5, 2, 'question2'),
(13, 7, 1, 'q');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_quiz`
--

CREATE TABLE `tbl_quiz` (
  `ID` int(11) NOT NULL,
  `QuizTitle` varchar(255) NOT NULL,
  `SectionID` int(11) NOT NULL,
  `SubjectID` int(11) NOT NULL,
  `TeacherID` int(11) NOT NULL,
  `DateCreated` datetime NOT NULL,
  `CreatedByID` int(11) NOT NULL,
  `DateUpdated` datetime DEFAULT NULL,
  `UpdatedByID` int(11) DEFAULT NULL,
  `isDeleted` int(11) NOT NULL COMMENT '1 = deleted	'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_quiz`
--

INSERT INTO `tbl_quiz` (`ID`, `QuizTitle`, `SectionID`, `SubjectID`, `TeacherID`, `DateCreated`, `CreatedByID`, `DateUpdated`, `UpdatedByID`, `isDeleted`) VALUES
(2, 'test1', 1, 1, 44, '2023-05-19 16:47:00', 0, NULL, NULL, 0),
(3, 'test2', 2, 3, 46, '2023-05-22 21:05:00', 0, NULL, NULL, 0),
(4, 'test3', 6, 2, 45, '2023-05-24 16:19:00', 45, NULL, NULL, 1),
(5, 'test3', 2, 1, 45, '2023-05-24 16:21:00', 45, NULL, NULL, 0),
(6, 'test4', 1, 2, 45, '2023-05-24 16:21:00', 45, NULL, NULL, 1),
(7, 'test', 1, 1, 45, '2023-05-27 14:45:00', 45, NULL, NULL, 0),
(8, 'qqqqqqqqqwwwwwwwwwwwwww', 1, 3, 45, '2023-05-27 15:00:00', 45, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_schoolyear`
--

CREATE TABLE `tbl_schoolyear` (
  `ID` int(11) NOT NULL,
  `SchoolYear` varchar(255) NOT NULL,
  `DateCreated` datetime NOT NULL,
  `CreatedByID` int(11) NOT NULL,
  `DateUpdated` datetime DEFAULT NULL,
  `UpdatedByID` int(11) DEFAULT NULL,
  `isDeleted` int(11) NOT NULL COMMENT '1 = deleted	'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_schoolyear`
--

INSERT INTO `tbl_schoolyear` (`ID`, `SchoolYear`, `DateCreated`, `CreatedByID`, `DateUpdated`, `UpdatedByID`, `isDeleted`) VALUES
(1, '2023-2024', '2023-05-10 05:03:03', 0, NULL, NULL, 0),
(2, '2022-2023', '2023-05-10 04:10:00', 0, '2023-05-10 04:17:00', 1, 0),
(7, '2025', '2023-05-18 09:46:00', 45, NULL, NULL, 0),
(8, '2026', '2023-05-18 09:48:00', 45, NULL, NULL, 0),
(9, '2027', '2023-05-18 09:50:00', 45, NULL, NULL, 0),
(10, '2029', '2023-05-24 02:20:00', 45, '2023-05-24 02:20:00', 45, 1),
(11, '2222', '2023-05-26 10:24:00', 0, '2023-05-26 10:27:00', 0, 1),
(12, '2222', '2023-05-26 10:31:00', 0, '2023-05-26 10:32:00', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_score`
--

CREATE TABLE `tbl_score` (
  `ID` int(11) NOT NULL,
  `QuizID` int(11) NOT NULL,
  `StudentID` int(11) NOT NULL,
  `TotalScore` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_score`
--

INSERT INTO `tbl_score` (`ID`, `QuizID`, `StudentID`, `TotalScore`) VALUES
(7, 2, 17, 1),
(8, 7, 17, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_section`
--

CREATE TABLE `tbl_section` (
  `ID` int(11) NOT NULL,
  `Section` varchar(255) NOT NULL,
  `SchoolYearID` int(11) NOT NULL,
  `GradeID` int(11) NOT NULL,
  `DateCreated` datetime NOT NULL,
  `CreatedByID` int(11) NOT NULL,
  `DateUpdated` datetime DEFAULT NULL,
  `UpdatedByID` int(11) DEFAULT NULL,
  `isDeleted` int(11) NOT NULL COMMENT '1 = deleted	'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_section`
--

INSERT INTO `tbl_section` (`ID`, `Section`, `SchoolYearID`, `GradeID`, `DateCreated`, `CreatedByID`, `DateUpdated`, `UpdatedByID`, `isDeleted`) VALUES
(1, 'Explorative', 2, 2, '2023-05-12 11:12:00', 1, '2023-05-12 11:42:00', 1, 0),
(2, 'Diversity', 2, 2, '2023-05-15 21:13:00', 1, '2023-05-18 22:13:00', 45, 0),
(3, 'Diversity', 2, 2, '2023-05-15 21:13:00', 1, NULL, NULL, 1),
(4, 'Explorative', 1, 2, '2023-05-17 14:26:00', 1, NULL, NULL, 0),
(5, 'Diversity', 1, 2, '2023-05-18 22:00:00', 0, '2023-05-18 22:00:00', 0, 0),
(6, 'Diversity', 8, 3, '2023-05-24 14:44:00', 45, '2023-05-24 14:44:00', 45, 1),
(7, 'qweqweq', 8, 1, '2023-05-27 15:44:00', 45, '2023-05-27 15:45:00', 45, 1),
(8, 'test', 7, 2, '2023-05-28 12:41:00', 45, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student`
--

CREATE TABLE `tbl_student` (
  `ID` int(11) NOT NULL,
  `FirstName` varchar(255) NOT NULL,
  `MiddleName` varchar(255) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `IDnumber` bigint(20) NOT NULL,
  `Age` int(11) DEFAULT NULL,
  `Address` varchar(500) DEFAULT NULL,
  `SectionID` int(11) NOT NULL,
  `DateCreated` datetime NOT NULL,
  `CreatedByID` int(11) NOT NULL,
  `DateUpdated` datetime DEFAULT NULL,
  `UpdatedByID` int(11) DEFAULT NULL,
  `isDeleted` int(11) NOT NULL COMMENT '1 = deleted	'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_student`
--

INSERT INTO `tbl_student` (`ID`, `FirstName`, `MiddleName`, `LastName`, `IDnumber`, `Age`, `Address`, `SectionID`, `DateCreated`, `CreatedByID`, `DateUpdated`, `UpdatedByID`, `isDeleted`) VALUES
(16, 'John', 'M', 'Doe', 20231234, 18, 'Sipalay City Negros Occidental', 1, '2023-05-17 21:39:00', 0, NULL, NULL, 1),
(17, 'Jane', 'M', 'Doe', 20239112366, 18, 'Sipalay City', 1, '2023-05-18 11:31:00', 0, NULL, NULL, 0),
(18, 'fname', 'mname', 'lname', 11112222, 21, 'qweqweqweqweqwe', 5, '2023-05-24 18:25:00', 45, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student_subject`
--

CREATE TABLE `tbl_student_subject` (
  `ID` int(11) NOT NULL,
  `StudentID` int(11) NOT NULL,
  `SubjectID` int(11) NOT NULL,
  `TeacherID` int(11) NOT NULL,
  `DateCreated` datetime NOT NULL,
  `CreatedByID` int(11) NOT NULL,
  `DateUpdated` datetime DEFAULT NULL,
  `UpdatedByID` int(11) DEFAULT NULL,
  `isDeleted` int(11) NOT NULL COMMENT '1 = deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_student_subject`
--

INSERT INTO `tbl_student_subject` (`ID`, `StudentID`, `SubjectID`, `TeacherID`, `DateCreated`, `CreatedByID`, `DateUpdated`, `UpdatedByID`, `isDeleted`) VALUES
(18, 17, 3, 47, '2023-05-23 15:47:00', 0, NULL, NULL, 0),
(19, 17, 1, 45, '2023-05-23 16:14:00', 0, NULL, NULL, 0),
(20, 18, 1, 45, '2023-05-27 15:24:00', 0, NULL, NULL, 0),
(21, 18, 2, 45, '2023-05-27 15:24:00', 0, NULL, NULL, 0),
(22, 18, 3, 45, '2023-05-27 15:24:00', 0, NULL, NULL, 1),
(23, 18, 3, 45, '2023-05-27 15:27:00', 45, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subject`
--

CREATE TABLE `tbl_subject` (
  `ID` int(11) NOT NULL,
  `Subject` varchar(255) NOT NULL,
  `DateCreated` datetime NOT NULL,
  `CreatedByID` int(11) NOT NULL,
  `DateUpdated` datetime DEFAULT NULL,
  `UpdatedByID` int(11) DEFAULT NULL,
  `isDeleted` int(11) NOT NULL COMMENT '1 = deleted	'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_subject`
--

INSERT INTO `tbl_subject` (`ID`, `Subject`, `DateCreated`, `CreatedByID`, `DateUpdated`, `UpdatedByID`, `isDeleted`) VALUES
(1, 'ENG', '2023-05-12 08:36:33', 1, NULL, NULL, 0),
(2, 'FIL', '2023-05-12 14:57:00', 1, NULL, NULL, 0),
(3, 'MATH', '2023-05-15 21:09:00', 1, '2023-05-15 21:12:00', 0, 0),
(4, 'SCIENCE', '2023-05-24 14:40:00', 45, '2023-05-24 14:41:00', 45, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_teacher`
--

CREATE TABLE `tbl_teacher` (
  `ID` int(11) NOT NULL,
  `FirstName` varchar(255) DEFAULT NULL,
  `MiddleName` varchar(255) DEFAULT NULL,
  `LastName` varchar(255) DEFAULT NULL,
  `IDnumber` bigint(11) DEFAULT NULL,
  `DateCreated` datetime NOT NULL,
  `CreatedByID` int(11) NOT NULL,
  `DateUpdated` datetime DEFAULT NULL,
  `UpdatedByID` int(11) DEFAULT NULL,
  `isDeleted` int(11) NOT NULL COMMENT '1 = deleted	'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_teacher`
--

INSERT INTO `tbl_teacher` (`ID`, `FirstName`, `MiddleName`, `LastName`, `IDnumber`, `DateCreated`, `CreatedByID`, `DateUpdated`, `UpdatedByID`, `isDeleted`) VALUES
(44, 'Maria', 'M', 'Minchin', 202387000, '2023-05-17 21:47:00', 0, '2023-05-17 21:47:00', 0, 0),
(45, 'Mayton', 'G', 'Born', 123456, '2023-05-18 16:43:00', 0, '2023-05-22 13:39:00', 0, 0),
(46, 'Rei', 'D', 'Junior', 654212124, '2023-05-19 14:23:00', 0, NULL, NULL, 0),
(47, 'Woo', 'D', 'Row', 121212112, '2023-05-19 14:23:00', 0, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_teacher_subject`
--

CREATE TABLE `tbl_teacher_subject` (
  `ID` int(11) NOT NULL,
  `TeacherID` int(11) NOT NULL,
  `SubjectID` int(11) NOT NULL,
  `SectionID` int(11) DEFAULT NULL,
  `DateCreated` datetime NOT NULL,
  `CreatedByID` int(11) NOT NULL,
  `DateUpdated` datetime DEFAULT NULL,
  `UpdatedByID` int(11) DEFAULT NULL,
  `isDeleted` int(11) NOT NULL COMMENT '1 = deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_teacher_subject`
--

INSERT INTO `tbl_teacher_subject` (`ID`, `TeacherID`, `SubjectID`, `SectionID`, `DateCreated`, `CreatedByID`, `DateUpdated`, `UpdatedByID`, `isDeleted`) VALUES
(3, 44, 1, 1, '2023-05-17 22:36:00', 0, NULL, NULL, 0),
(4, 44, 2, 1, '2023-05-17 22:36:00', 0, NULL, NULL, 0),
(5, 46, 3, 5, '2023-05-19 14:29:00', 0, NULL, NULL, 0),
(6, 45, 3, 1, '2023-05-22 14:53:00', 45, NULL, NULL, 0),
(7, 45, 2, 2, '2023-05-22 15:22:00', 45, NULL, NULL, 0),
(8, 45, 1, 2, '2023-05-25 20:54:00', 45, NULL, NULL, 1),
(9, 45, 3, 2, '2023-05-25 20:54:00', 45, NULL, NULL, 0),
(10, 45, 1, 2, '2023-05-27 13:40:00', 45, NULL, NULL, 1),
(11, 45, 1, 2, '2023-05-27 13:46:00', 45, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `ID` int(11) NOT NULL,
  `StudentID` int(11) DEFAULT NULL,
  `TeacherID` int(11) DEFAULT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `DateCreated` datetime NOT NULL,
  `CreatedByID` int(11) NOT NULL,
  `DateUpdated` datetime DEFAULT NULL,
  `UpdatedByID` int(11) DEFAULT NULL,
  `isDeleted` int(11) NOT NULL COMMENT '1 = deleted	'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`ID`, `StudentID`, `TeacherID`, `Username`, `Password`, `DateCreated`, `CreatedByID`, `DateUpdated`, `UpdatedByID`, `isDeleted`) VALUES
(1, NULL, NULL, 'administrator', '!admin', '2023-05-11 07:57:47', 0, NULL, NULL, 0),
(56, 16, NULL, '20231234', 'utT7JJbUMW', '2023-05-17 21:39:00', 0, NULL, NULL, 0),
(57, NULL, 44, '202387000', 'FKN5iM1$Ng', '2023-05-17 21:47:00', 0, '2023-05-17 21:47:00', 0, 0),
(58, 17, NULL, '20239112366', 'fhytR$mxkI', '2023-05-18 11:31:00', 0, NULL, NULL, 0),
(59, NULL, 45, '123456', 'password@1234', '2023-05-18 16:43:00', 0, '2023-05-22 13:39:00', 0, 0),
(60, NULL, 46, '654212124', 'password@1234', '2023-05-19 14:23:00', 0, NULL, NULL, 0),
(61, NULL, 47, '121212112', 'password@1234', '2023-05-19 14:23:00', 0, NULL, NULL, 0),
(62, 18, NULL, '11112222', '52gn1JtirH', '2023-05-24 18:25:00', 45, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_logs`
--

CREATE TABLE `user_logs` (
  `ID` int(11) NOT NULL,
  `StudentID` int(11) DEFAULT NULL,
  `TeacherID` int(11) DEFAULT NULL,
  `Action` varchar(750) NOT NULL,
  `DateHappened` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_logs`
--

INSERT INTO `user_logs` (`ID`, `StudentID`, `TeacherID`, `Action`, `DateHappened`) VALUES
(36, NULL, 45, 'Logged on', '2023-05-28 12:38:00'),
(37, NULL, 45, 'add section', '2023-05-28 12:41:00'),
(38, NULL, 45, 'Add class', '2023-05-28 12:41:00'),
(39, 18, NULL, 'Logged on', '2023-05-28 20:11:00'),
(40, 18, NULL, 'Logout', '2023-05-28 20:13:00'),
(41, NULL, 45, 'Logged on', '2023-05-28 20:15:00'),
(42, NULL, 45, 'Add assignment', '2023-05-28 20:26:00'),
(43, 17, NULL, 'Logged on', '2023-05-28 20:26:00'),
(44, NULL, 45, 'Add assignment', '2023-05-28 20:27:00'),
(45, 17, NULL, 'Start assignment', '2023-05-28 20:27:00'),
(46, 17, NULL, 'Start assignment', '2023-05-28 20:27:00'),
(47, 17, NULL, 'finish assignment', '2023-05-28 20:27:00'),
(48, NULL, 45, 'Add assignment', '2023-05-28 20:30:00'),
(49, 17, NULL, 'Start assignment', '2023-05-28 20:30:00'),
(50, 17, NULL, 'finish assignment', '2023-05-28 20:30:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_announcement`
--
ALTER TABLE `tbl_announcement`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_assignment`
--
ALTER TABLE `tbl_assignment`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_assign_choices`
--
ALTER TABLE `tbl_assign_choices`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_assign_question`
--
ALTER TABLE `tbl_assign_question`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_assign_score`
--
ALTER TABLE `tbl_assign_score`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_choices`
--
ALTER TABLE `tbl_choices`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_class`
--
ALTER TABLE `tbl_class`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_grade`
--
ALTER TABLE `tbl_grade`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_module`
--
ALTER TABLE `tbl_module`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_question`
--
ALTER TABLE `tbl_question`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_quiz`
--
ALTER TABLE `tbl_quiz`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_schoolyear`
--
ALTER TABLE `tbl_schoolyear`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_score`
--
ALTER TABLE `tbl_score`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_section`
--
ALTER TABLE `tbl_section`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_student`
--
ALTER TABLE `tbl_student`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_student_subject`
--
ALTER TABLE `tbl_student_subject`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_subject`
--
ALTER TABLE `tbl_subject`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_teacher`
--
ALTER TABLE `tbl_teacher`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_teacher_subject`
--
ALTER TABLE `tbl_teacher_subject`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user_logs`
--
ALTER TABLE `user_logs`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_announcement`
--
ALTER TABLE `tbl_announcement`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_assignment`
--
ALTER TABLE `tbl_assignment`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_assign_choices`
--
ALTER TABLE `tbl_assign_choices`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `tbl_assign_question`
--
ALTER TABLE `tbl_assign_question`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_assign_score`
--
ALTER TABLE `tbl_assign_score`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_choices`
--
ALTER TABLE `tbl_choices`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `tbl_class`
--
ALTER TABLE `tbl_class`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_grade`
--
ALTER TABLE `tbl_grade`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_module`
--
ALTER TABLE `tbl_module`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_question`
--
ALTER TABLE `tbl_question`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_quiz`
--
ALTER TABLE `tbl_quiz`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_schoolyear`
--
ALTER TABLE `tbl_schoolyear`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_score`
--
ALTER TABLE `tbl_score`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_section`
--
ALTER TABLE `tbl_section`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_student`
--
ALTER TABLE `tbl_student`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_student_subject`
--
ALTER TABLE `tbl_student_subject`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tbl_subject`
--
ALTER TABLE `tbl_subject`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_teacher`
--
ALTER TABLE `tbl_teacher`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `tbl_teacher_subject`
--
ALTER TABLE `tbl_teacher_subject`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `user_logs`
--
ALTER TABLE `user_logs`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
