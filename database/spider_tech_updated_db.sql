-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 17, 2025 at 11:02 AM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spider_tech_updated_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_info`
--

DROP TABLE IF EXISTS `about_info`;
CREATE TABLE IF NOT EXISTS `about_info` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about_info`
--

INSERT INTO `about_info` (`id`, `title`, `details`, `image`) VALUES
(1, 'Who We Are', '<span style=\"color: rgb(121, 121, 121); font-family: &quot;Open Sans&quot;, sans-serif; font-size: 14px;\">Offering IT solutions with a focus on excellence and dependability, making us your top choice for technology services.</span>', '1027161136.jpg'),
(2, 'We are Professional', '<span style=\"color: rgb(121, 121, 121); font-family: &quot;Open Sans&quot;, sans-serif; font-size: 14px;\">Delivering top-notch IT solutions with unmatched expertise and dedication. Trust us for innovative and reliable services.</span>', ''),
(3, 'High-Ranking Company', '<span style=\"color: rgb(121, 121, 121); font-family: &quot;Open Sans&quot;, sans-serif; font-size: 14px;\">Our company is serviced by licensed professionals and experts, ensuring quality delivery of service.</span>', ''),
(4, 'Licensed and Certified', '<span style=\"color: rgb(121, 121, 121); font-family: &quot;Open Sans&quot;, sans-serif; font-size: 14px;\">Offering IT solutions with a focus on excellence and dependability, making us your top choice for technology services.</span>', ''),
(5, 'Leading Provider', '<span style=\"color: rgb(121, 121, 121); font-family: &quot;Open Sans&quot;, sans-serif; font-size: 14px;\">We excel as a top provider, offering outstanding IT solutions with exceptional performance and trustworthiness.</span>', '');

-- --------------------------------------------------------

--
-- Table structure for table `about_mission`
--

DROP TABLE IF EXISTS `about_mission`;
CREATE TABLE IF NOT EXISTS `about_mission` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `icon` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about_mission`
--

INSERT INTO `about_mission` (`id`, `title`, `details`, `icon`) VALUES
(1, 'Our Mission', 'Uncover and develop potentially useful and marketable solutions across the globe through youths’ engagement.', 'flat flaticon-plane');

-- --------------------------------------------------------

--
-- Table structure for table `about_value`
--

DROP TABLE IF EXISTS `about_value`;
CREATE TABLE IF NOT EXISTS `about_value` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `icon` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about_value`
--

INSERT INTO `about_value` (`id`, `title`, `details`, `icon`) VALUES
(1, 'Our Value', 'Spider offers custom solutions tailored to your specific needs, unlike generic bundles from product-focused companies. As a vendor-independent provider, we choose the best options to minimize your Total Cost of Ownership and maximize Quality of Service.', 'fas fa-gem');

-- --------------------------------------------------------

--
-- Table structure for table `about_vision`
--

DROP TABLE IF EXISTS `about_vision`;
CREATE TABLE IF NOT EXISTS `about_vision` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `icon` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about_vision`
--

INSERT INTO `about_vision` (`id`, `title`, `details`, `icon`) VALUES
(1, 'Our Vision', '                                                                                                                Become a leading innovation hub in Africa that equip young talents to produce and manage cutting edge technologies across the globe, and to become number one IT solutions provider across Africa.                                                                                                        ', 'fas fa-eye');

-- --------------------------------------------------------

--
-- Table structure for table `admin_tb`
--

DROP TABLE IF EXISTS `admin_tb`;
CREATE TABLE IF NOT EXISTS `admin_tb` (
  `admin_id` int NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(100) NOT NULL,
  `admin_password` varchar(30) NOT NULL,
  `privilege` varchar(20) NOT NULL,
  `lastlogin` datetime NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_tb`
--

INSERT INTO `admin_tb` (`admin_id`, `admin_name`, `admin_password`, `privilege`, `lastlogin`) VALUES
(1, 'admin', 'admin', 'Super Admin', '2024-10-08 01:17:21'),
(2, 'adminnn', 'adminn', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `banners_tb`
--

DROP TABLE IF EXISTS `banners_tb`;
CREATE TABLE IF NOT EXISTS `banners_tb` (
  `banner_id` int NOT NULL AUTO_INCREMENT,
  `banner_title` varchar(100) NOT NULL,
  `banner_image` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`banner_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `banners_tb`
--

INSERT INTO `banners_tb` (`banner_id`, `banner_title`, `banner_image`) VALUES
(1, 'Homepage slider image 1', '998808547.jpg'),
(2, 'Homepage slider image 2', '143167605.jpg'),
(3, 'Homepage slider image 3', '1426021047.jpg'),
(4, 'Homepage slider image 4', '1460642200.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `bootcamp_application`
--

DROP TABLE IF EXISTS `bootcamp_application`;
CREATE TABLE IF NOT EXISTS `bootcamp_application` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lastname` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_no` varchar(20) NOT NULL,
  `age` int NOT NULL,
  `gender` varchar(16) NOT NULL,
  `business_name` text NOT NULL,
  `reason` text NOT NULL,
  `apply_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bootcamp_application`
--

INSERT INTO `bootcamp_application` (`id`, `lastname`, `firstname`, `middlename`, `email`, `phone_no`, `age`, `gender`, `business_name`, `reason`, `apply_date`) VALUES
(1, 'Danjuma', 'Zakiyya', '', 'zakiyyadanjuma@gmail.com', '09052986555', 21, 'Female', '', 'Advertise My Business,Advertise for Others', '2024-09-18 11:43:51'),
(2, 'Danjuma', 'Zakiyya', '', 'zakiyya@gmail.com', '08563796367', 21, 'Female', '', 'Advertise for Others', '2024-09-19 13:42:07'),
(3, 'Sunusi', 'Abdulhalim', '', 'ahalim.sunusi@gmail.com', '07776712401', 24, 'Female', '', 'Advertise My Business,Advertise for Others,Improve Sales,Boost Productivity', '2024-09-21 00:34:20'),
(4, 'Sunusi', 'Abdulhalim', '', 'ahalim@gmail.com', '07776712400', 24, 'Female', '', 'Advertise My Business,Advertise for Others', '2024-09-21 02:46:53'),
(5, 'Salisu', 'Abdulhalim', 'Sunusi', 'get2abdulhalim@yahoo.com', '87654321234', 24, 'Female', '', 'Advertise My Business', '2024-09-21 02:50:52'),
(6, 'Sunusi', 'Abdulhalim', '', 'ahalimsunusi@gmail.com', '07776712000', 24, 'Female', '', 'Advertise My Business,Advertise for Others', '2024-09-21 14:35:22'),
(7, 'Sunusi', 'Abdulhalim', '', 'ahalimsi@gmail.com', '07776712477', 27, 'Female', '', 'Advertise My Business', '2024-09-21 16:43:01'),
(8, 'Sunusi', 'Abdulhalim', '', 'ahalim.si@gmail.com', '07776712488', 23, 'Female', '', 'Boost Productivity', '2024-09-21 17:51:29');

-- --------------------------------------------------------

--
-- Table structure for table `contact_details`
--

DROP TABLE IF EXISTS `contact_details`;
CREATE TABLE IF NOT EXISTS `contact_details` (
  `contact_id` int NOT NULL AUTO_INCREMENT,
  `contact_address` varchar(200) NOT NULL,
  `contact_email` varchar(50) NOT NULL,
  `contact_pno` varchar(15) NOT NULL,
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_details`
--

INSERT INTO `contact_details` (`contact_id`, `contact_address`, `contact_email`, `contact_pno`) VALUES
(1, 'Flat 3, Left Wing, Abinsa House, Zaria Road, Kano', 'info@spidertech.com.ng', '+234 9116265708');

-- --------------------------------------------------------

--
-- Table structure for table `dse_application`
--

DROP TABLE IF EXISTS `dse_application`;
CREATE TABLE IF NOT EXISTS `dse_application` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lastname` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_no` varchar(20) NOT NULL,
  `age` int NOT NULL,
  `gender` varchar(16) NOT NULL,
  `business_name` text NOT NULL,
  `business_sector` varchar(30) NOT NULL,
  `registration_type` varchar(10) NOT NULL,
  `years` varchar(20) NOT NULL,
  `business_website` varchar(255) DEFAULT NULL,
  `business_location` text NOT NULL,
  `digital_transformation` varchar(10) NOT NULL,
  `apply_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dse_application`
--

INSERT INTO `dse_application` (`id`, `lastname`, `firstname`, `middlename`, `email`, `phone_no`, `age`, `gender`, `business_name`, `business_sector`, `registration_type`, `years`, `business_location`, `digital_transformation`, `apply_date`) VALUES
(1, 'Salisu', 'Abdulhalim', 'Sunusi', 'ahalim.sunusi@gmail.com', '07061324718', 19, 'Female', 'Spider Tech', 'Fashion', 'CAC', 3, 'Spider Tech', 'Yes', '2024-10-08 13:01:03');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `event_id` int NOT NULL AUTO_INCREMENT,
  `event_title` varchar(300) NOT NULL,
  `event_content` text NOT NULL,
  `event_detail` text NOT NULL,
  `event_date` date NOT NULL,
  `event_date2` date DEFAULT NULL,
  `event_time` varchar(100) NOT NULL,
  `event_address` varchar(100) NOT NULL,
  `event_status` varchar(10) NOT NULL DEFAULT 'upcoming',
  `event_img` varchar(64) NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `event_title`, `event_content`, `event_detail`, `event_date`, `event_date2`, `event_time`, `event_address`, `event_status`, `event_img`) VALUES
(10, 'Leveraging Digital Space for Brand Marketing', 'ThemeLeveraging Digital Space for Brand MarketingPurposeThis programme is designed to equip younger women with digital marketing skills. ', '<h4 style=\"--title-font: \"><font color=\"#000000\"> Course Content</font></h4><p style=\"--title-font: ;\"><font color=\"#000000\">      <font color=\"#000000\"><span style=\"text-indent: -0.25in; font-size: 10.5pt; font-family: Wingdings;\">Ø<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">  </span></span><span style=\"text-indent: -0.25in; font-size: 10.5pt; font-family: Helvetica, \" sans-serif\";\"=\"\"><font color=\"#000000\">Digital\r\nMarketing Strategy</font></span></font></font></p>\r\n\r\n<p style=\"margin: 0in 0in 0.0001pt 0.5in; text-indent: -0.25in; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; --title-font: ;\"><!--[if !supportLists]--><font color=\"#000000\"><span style=\"font-size: 10.5pt; font-family: Wingdings;\">Ø<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\"> \r\n</span></span><!--[endif]--><span style=\"font-size: 10.5pt; font-family: Helvetica, \" sans-serif\";\"=\"\">Content Marketing<o:p></o:p></span></font></p>\r\n\r\n<p style=\"margin: 0in 0in 0.0001pt 0.5in; text-indent: -0.25in; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; --title-font: ;\"><!--[if !supportLists]--><font color=\"#000000\"><span style=\"font-size: 10.5pt; font-family: Wingdings;\">Ø<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\"> \r\n</span></span><!--[endif]--><span style=\"font-size: 10.5pt; font-family: Helvetica, \" sans-serif\";\"=\"\">Branding & Messaging<o:p></o:p></span></font></p>\r\n\r\n<p style=\"margin: 0in 0in 0.0001pt 0.5in; text-indent: -0.25in; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; --title-font: ;\"><!--[if !supportLists]--><font color=\"#000000\"><span style=\"font-size: 10.5pt; font-family: Wingdings;\">Ø<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\"> \r\n</span></span><!--[endif]--><span style=\"font-size: 10.5pt; font-family: Helvetica, \" sans-serif\";\"=\"\">Email Marketing<o:p></o:p></span></font></p>\r\n\r\n<p style=\"margin: 0in 0in 0.0001pt 0.5in; text-indent: -0.25in; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; --title-font: ;\"><!--[if !supportLists]--><font color=\"#000000\"><font color=\"#000000\"><span style=\"font-size: 10.5pt; font-family: Wingdings;\">Ø<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\"> \r\n</span></span><!--[endif]--></font><span style=\"font-size: 10.5pt; font-family: Helvetica, \" sans-serif\";\"=\"\"><font color=\"#000000\">Social Media Ads</font><o:p></o:p></span></font></p>\r\n\r\n<p class=\"MsoNormal\"><o:p><font color=\"#000000\"> </font></o:p></p><p style=\"--title-font: ;\"><font color=\"#000000\"> </font></p><h4 style=\"--title-font: \"><font color=\"#000000\">Sat July 27, 2024</font></h4><ul class=\"crumb\" style=\"--title-font: \" plus=\"\" jakarta=\"\" sans\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" --title-font-weight:=\"\" 600;=\"\" --title-font-color:=\"\" #1d1d1f;=\"\" --body-font:=\"\" \"inter=\"\" tight\",=\"\" --border-default:=\"\" solid=\"\" 1px=\"\" rgba(30,=\"\" 30,=\"\" 1);=\"\" --bg-color-even:=\"\" #e8e8e8;=\"\" --bg-color-odd:=\"\" #f4f4f4;=\"\" --bg-dark-1:=\"\" #484646;=\"\" --bg-dark-2:=\"\" #232627;=\"\" --bg-dark-3:=\"\" #303030;=\"\" --bg-grey:=\"\" #f0f1f3;=\"\" --bg-gradient-1:=\"\" 0deg,=\"\" rgba(var(--primary-color-rgb),=\"\" .1)=\"\" 0%,=\"\" rgba(var(--secondary-color-rgb),=\"\" .2)=\"\" 100%;=\"\" --body-font-color:=\"\" --dark-body-font-color:=\"\" #f5f5f7;=\"\" --swiper-theme-color:=\"\" var(--secondary-color);=\"\" padding-top:=\"\" 10px;=\"\" margin-bottom:=\"\" -50px;=\"\" font-size:=\"\" 18px;=\"\" color:=\"\" rgb(119,=\"\" 119,=\"\" 119);=\"\" font-family:=\"\" sans-serif;\"=\"\"><li style=\"--title-font: \" plus=\"\" jakarta=\"\" sans\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" --title-font-weight:=\"\" 600;=\"\" --title-font-color:=\"\" #1d1d1f;=\"\" --body-font:=\"\" \"inter=\"\" tight\",=\"\" --border-default:=\"\" solid=\"\" 1px=\"\" rgba(30,=\"\" 30,=\"\" 1);=\"\" --bg-color-even:=\"\" #e8e8e8;=\"\" --bg-color-odd:=\"\" #f4f4f4;=\"\" --bg-dark-1:=\"\" #484646;=\"\" --bg-dark-2:=\"\" #232627;=\"\" --bg-dark-3:=\"\" #303030;=\"\" --bg-grey:=\"\" #f0f1f3;=\"\" --bg-gradient-1:=\"\" 0deg,=\"\" rgba(var(--primary-color-rgb),=\"\" .1)=\"\" 0%,=\"\" rgba(var(--secondary-color-rgb),=\"\" .2)=\"\" 100%;=\"\" --body-font-color:=\"\" --dark-body-font-color:=\"\" #f5f5f7;=\"\" --swiper-theme-color:=\"\" var(--secondary-color);=\"\" display:=\"\" inline;=\"\" letter-spacing:=\"\" 0px;\"=\"\"><b style=\"--title-font: ;\"><font color=\"#000000\">Registration closed</font></b></li><font color=\"#000000\"> </font><li class=\"active\" style=\"--title-font: \" plus=\"\" jakarta=\"\" sans\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" --title-font-weight:=\"\" 600;=\"\" --title-font-color:=\"\" #1d1d1f;=\"\" --body-font:=\"\" \"inter=\"\" tight\",=\"\" --border-default:=\"\" solid=\"\" 1px=\"\" rgba(30,=\"\" 30,=\"\" 1);=\"\" --bg-color-even:=\"\" #e8e8e8;=\"\" --bg-color-odd:=\"\" #f4f4f4;=\"\" --bg-dark-1:=\"\" #484646;=\"\" --bg-dark-2:=\"\" #232627;=\"\" --bg-dark-3:=\"\" #303030;=\"\" --bg-grey:=\"\" #f0f1f3;=\"\" --bg-gradient-1:=\"\" 0deg,=\"\" rgba(var(--primary-color-rgb),=\"\" .1)=\"\" 0%,=\"\" rgba(var(--secondary-color-rgb),=\"\" .2)=\"\" 100%;=\"\" --body-font-color:=\"\" --dark-body-font-color:=\"\" #f5f5f7;=\"\" --swiper-theme-color:=\"\" var(--secondary-color);=\"\" display:=\"\" inline;=\"\" letter-spacing:=\"\" 0px;\"=\"\"><span style=\"--title-font: ;\"><font color=\"#000000\">#SpiderTechEmpowers</font></span></li><li class=\"active\" style=\"--title-font: \" plus=\"\" jakarta=\"\" sans\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" --title-font-weight:=\"\" 600;=\"\" --title-font-color:=\"\" #1d1d1f;=\"\" --body-font:=\"\" \"inter=\"\" tight\",=\"\" --border-default:=\"\" solid=\"\" 1px=\"\" rgba(30,=\"\" 30,=\"\" 1);=\"\" --bg-color-even:=\"\" #e8e8e8;=\"\" --bg-color-odd:=\"\" #f4f4f4;=\"\" --bg-dark-1:=\"\" #484646;=\"\" --bg-dark-2:=\"\" #232627;=\"\" --bg-dark-3:=\"\" #303030;=\"\" --bg-grey:=\"\" #f0f1f3;=\"\" --bg-gradient-1:=\"\" 0deg,=\"\" rgba(var(--primary-color-rgb),=\"\" .1)=\"\" 0%,=\"\" rgba(var(--secondary-color-rgb),=\"\" .2)=\"\" 100%;=\"\" --body-font-color:=\"\" --dark-body-font-color:=\"\" #f5f5f7;=\"\" --swiper-theme-color:=\"\" var(--secondary-color);=\"\" display:=\"\" inline;=\"\" letter-spacing:=\"\" 0px;\"=\"\"><span style=\"--title-font: ;\"><font color=\"#000000\"><br></font></span></li><li class=\"active\" style=\"--title-font: \" plus=\"\" jakarta=\"\" sans\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" --title-font-weight:=\"\" 600;=\"\" --title-font-color:=\"\" #1d1d1f;=\"\" --body-font:=\"\" \"inter=\"\" tight\",=\"\" --border-default:=\"\" solid=\"\" 1px=\"\" rgba(30,=\"\" 30,=\"\" 1);=\"\" --bg-color-even:=\"\" #e8e8e8;=\"\" --bg-color-odd:=\"\" #f4f4f4;=\"\" --bg-dark-1:=\"\" #484646;=\"\" --bg-dark-2:=\"\" #232627;=\"\" --bg-dark-3:=\"\" #303030;=\"\" --bg-grey:=\"\" #f0f1f3;=\"\" --bg-gradient-1:=\"\" 0deg,=\"\" rgba(var(--primary-color-rgb),=\"\" .1)=\"\" 0%,=\"\" rgba(var(--secondary-color-rgb),=\"\" .2)=\"\" 100%;=\"\" --body-font-color:=\"\" --dark-body-font-color:=\"\" #f5f5f7;=\"\" --swiper-theme-color:=\"\" var(--secondary-color);=\"\" display:=\"\" inline;=\"\" letter-spacing:=\"\" 0px;\"=\"\"><h4 style=\"--title-font: \"><font color=\"#000000\">Overview</font></h4><p style=\"--title-font: \" plus=\"\" jakarta=\"\" sans\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" --title-font-weight:=\"\" 600;=\"\" --title-font-color:=\"\" #1d1d1f;=\"\" --body-font:=\"\" \"inter=\"\" tight\",=\"\" --border-default:=\"\" solid=\"\" 1px=\"\" rgba(30,=\"\" 30,=\"\" 1);=\"\" --bg-color-even:=\"\" #e8e8e8;=\"\" --bg-color-odd:=\"\" #f4f4f4;=\"\" --bg-dark-1:=\"\" #484646;=\"\" --bg-dark-2:=\"\" #232627;=\"\" --bg-dark-3:=\"\" #303030;=\"\" --bg-grey:=\"\" #f0f1f3;=\"\" --bg-gradient-1:=\"\" 0deg,=\"\" rgba(var(--primary-color-rgb),=\"\" .1)=\"\" 0%,=\"\" rgba(var(--secondary-color-rgb),=\"\" .2)=\"\" 100%;=\"\" --body-font-color:=\"\" --dark-body-font-color:=\"\" #f5f5f7;=\"\" --swiper-theme-color:=\"\" var(--secondary-color);=\"\" margin-bottom:=\"\" 20px;=\"\" font-family:=\"\" font-size:=\"\" 16px;\"=\"\"><font color=\"#000000\">This programme is designed to equip younger females with basic digital marketing skills. It covers areas of digital marketing strategy; branding and mzessaging; social media Ads - covering practical knowledge of setting up and managing social media pages such as Facebook and Instagram; creating paid Ads; content creation; email marketing. Interaction method is employed to allow smooth flow of ideas among the beneficiaries and the facilitators</font></p><p style=\"--title-font: \" plus=\"\" jakarta=\"\" sans\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" --title-font-weight:=\"\" 600;=\"\" --title-font-color:=\"\" #1d1d1f;=\"\" --body-font:=\"\" \"inter=\"\" tight\",=\"\" --border-default:=\"\" solid=\"\" 1px=\"\" rgba(30,=\"\" 30,=\"\" 1);=\"\" --bg-color-even:=\"\" #e8e8e8;=\"\" --bg-color-odd:=\"\" #f4f4f4;=\"\" --bg-dark-1:=\"\" #484646;=\"\" --bg-dark-2:=\"\" #232627;=\"\" --bg-dark-3:=\"\" #303030;=\"\" --bg-grey:=\"\" #f0f1f3;=\"\" --bg-gradient-1:=\"\" 0deg,=\"\" rgba(var(--primary-color-rgb),=\"\" .1)=\"\" 0%,=\"\" rgba(var(--secondary-color-rgb),=\"\" .2)=\"\" 100%;=\"\" --body-font-color:=\"\" --dark-body-font-color:=\"\" #f5f5f7;=\"\" --swiper-theme-color:=\"\" var(--secondary-color);=\"\" margin-bottom:=\"\" 20px;=\"\" font-family:=\"\" font-size:=\"\" 16px;\"=\"\"><font color=\"#000000\">The overall objective of this programme is to equip young females with digital marketing skills necessary to upscale their businesses. It is however formulated for two sets of Yong females: those that own businesses and require social media skills to increase sales, create awareness about their products or service; those that want to venture into managing social media adverts for other businesses.</font></p><p style=\"--title-font: \" plus=\"\" jakarta=\"\" sans\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" --title-font-weight:=\"\" 600;=\"\" --title-font-color:=\"\" #1d1d1f;=\"\" --body-font:=\"\" \"inter=\"\" tight\",=\"\" --border-default:=\"\" solid=\"\" 1px=\"\" rgba(30,=\"\" 30,=\"\" 1);=\"\" --bg-color-even:=\"\" #e8e8e8;=\"\" --bg-color-odd:=\"\" #f4f4f4;=\"\" --bg-dark-1:=\"\" #484646;=\"\" --bg-dark-2:=\"\" #232627;=\"\" --bg-dark-3:=\"\" #303030;=\"\" --bg-grey:=\"\" #f0f1f3;=\"\" --bg-gradient-1:=\"\" 0deg,=\"\" rgba(var(--primary-color-rgb),=\"\" .1)=\"\" 0%,=\"\" rgba(var(--secondary-color-rgb),=\"\" .2)=\"\" 100%;=\"\" --body-font-color:=\"\" --dark-body-font-color:=\"\" #f5f5f7;=\"\" --swiper-theme-color:=\"\" var(--secondary-color);=\"\" margin-bottom:=\"\" 20px;=\"\" font-family:=\"\" font-size:=\"\" 16px;\"=\"\"><font color=\"#000000\">The programme has a follow-up session purposefully created to provide continuous support to the training participants until a desired result is observed.</font></p><p style=\"--title-font: \" plus=\"\" jakarta=\"\" sans\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" --title-font-weight:=\"\" 600;=\"\" --title-font-color:=\"\" #1d1d1f;=\"\" --body-font:=\"\" \"inter=\"\" tight\",=\"\" --border-default:=\"\" solid=\"\" 1px=\"\" rgba(30,=\"\" 30,=\"\" 1);=\"\" --bg-color-even:=\"\" #e8e8e8;=\"\" --bg-color-odd:=\"\" #f4f4f4;=\"\" --bg-dark-1:=\"\" #484646;=\"\" --bg-dark-2:=\"\" #232627;=\"\" --bg-dark-3:=\"\" #303030;=\"\" --bg-grey:=\"\" #f0f1f3;=\"\" --bg-gradient-1:=\"\" 0deg,=\"\" rgba(var(--primary-color-rgb),=\"\" .1)=\"\" 0%,=\"\" rgba(var(--secondary-color-rgb),=\"\" .2)=\"\" 100%;=\"\" --body-font-color:=\"\" --dark-body-font-color:=\"\" #f5f5f7;=\"\" --swiper-theme-color:=\"\" var(--secondary-color);=\"\" margin-bottom:=\"\" 20px;=\"\" font-family:=\"\" font-size:=\"\" 16px;\"=\"\"><font color=\"#000000\"><br></font></p><h4 style=\"--title-font: \"><font color=\"#000000\">Objectives</font></h4><ol class=\"ol-style-1\" style=\"--title-font: \" plus=\"\" jakarta=\"\" sans\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" --title-font-weight:=\"\" 600;=\"\" --title-font-color:=\"\" #1d1d1f;=\"\" --body-font:=\"\" \"inter=\"\" tight\",=\"\" --border-default:=\"\" solid=\"\" 1px=\"\" rgba(30,=\"\" 30,=\"\" 1);=\"\" --bg-color-even:=\"\" #e8e8e8;=\"\" --bg-color-odd:=\"\" #f4f4f4;=\"\" --bg-dark-1:=\"\" #484646;=\"\" --bg-dark-2:=\"\" #232627;=\"\" --bg-dark-3:=\"\" #303030;=\"\" --bg-grey:=\"\" #f0f1f3;=\"\" --bg-gradient-1:=\"\" 0deg,=\"\" rgba(var(--primary-color-rgb),=\"\" .1)=\"\" 0%,=\"\" rgba(var(--secondary-color-rgb),=\"\" .2)=\"\" 100%;=\"\" --body-font-color:=\"\" --dark-body-font-color:=\"\" #f5f5f7;=\"\" --swiper-theme-color:=\"\" var(--secondary-color);=\"\" margin-left:=\"\" 50px;=\"\" font-size:=\"\" 16px;=\"\" list-style-type:=\"\" none;=\"\" counter-reset:=\"\" ordered=\"\" 0;=\"\" font-family:=\"\" sans-serif;\"=\"\"><p class=\"MsoListParagraphCxSpFirst\" style=\"text-indent:-.25in;mso-list:l0 level1 lfo1\"><!--[if !supportLists]--><font color=\"#000000\">1.<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">      \r\n</span><!--[endif]-->To promote self-reliance among female\r\nentrepreneurs.<o:p></o:p></font></p>\r\n\r\n<p class=\"MsoListParagraphCxSpMiddle\" style=\"text-indent:-.25in;mso-list:l0 level1 lfo1\"><!--[if !supportLists]--><font color=\"#000000\">2.<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">      \r\n</span><!--[endif]-->To provide female entrepreneurs with necessary\r\nskills for easy adaptability in today’s world.<o:p></o:p></font></p>\r\n\r\n<p class=\"MsoListParagraphCxSpMiddle\" style=\"text-indent:-.25in;mso-list:l0 level1 lfo1\"><!--[if !supportLists]--><font color=\"#000000\">3.<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">      \r\n</span><!--[endif]-->To Bridge the Gender Gap in Technology.<o:p></o:p></font></p>\r\n\r\n<p class=\"MsoListParagraphCxSpMiddle\" style=\"text-indent:-.25in;mso-list:l0 level1 lfo1\"><!--[if !supportLists]--><font color=\"#000000\">4.<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">      \r\n</span><!--[endif]-->To enhance Creativity and Innovation among\r\nfemale entrepreneurs.<o:p></o:p></font></p>\r\n\r\n<p class=\"MsoListParagraphCxSpLast\" style=\"text-indent:-.25in;mso-list:l0 level1 lfo1\"><!--[if !supportLists]--><font color=\"#000000\">5.<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\">      \r\n</span><!--[endif]-->To encourage Community Building and Social\r\nImpact create role models.<o:p></o:p></font></p><li style=\"--title-font: \" plus=\"\" jakarta=\"\" sans\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" --title-font-weight:=\"\" 600;=\"\" --title-font-color:=\"\" #1d1d1f;=\"\" --body-font:=\"\" \"inter=\"\" tight\",=\"\" --border-default:=\"\" solid=\"\" 1px=\"\" rgba(30,=\"\" 30,=\"\" 1);=\"\" --bg-color-even:=\"\" #e8e8e8;=\"\" --bg-color-odd:=\"\" #f4f4f4;=\"\" --bg-dark-1:=\"\" #484646;=\"\" --bg-dark-2:=\"\" #232627;=\"\" --bg-dark-3:=\"\" #303030;=\"\" --bg-grey:=\"\" #f0f1f3;=\"\" --bg-gradient-1:=\"\" 0deg,=\"\" rgba(var(--primary-color-rgb),=\"\" .1)=\"\" 0%,=\"\" rgba(var(--secondary-color-rgb),=\"\" .2)=\"\" 100%;=\"\" --body-font-color:=\"\" --dark-body-font-color:=\"\" #f5f5f7;=\"\" --swiper-theme-color:=\"\" var(--secondary-color);=\"\" display:=\"\" table;=\"\" counter-increment:=\"\" item=\"\" 1;=\"\" margin-bottom:=\"\" 20px;=\"\" font-size:=\"\" 18px;\"=\"\"><font color=\"#000000\" style=\"\">.<br></font></li></ol></li></ul>', '2024-07-27', '2024-07-27', '10:00:00', 'Flat 3, Left Wing, Abinsa House, Zaria Road, Kano', 'Past', '../images/pictures/1089947516.jpg'),
(11, 'Digital Marketing Bootcamp', 'This bootcamp is a free programme designed to empower young women with the skills and strategies needed to effectively market their brands online.', '<h4>\r\n  Bootcamp Overview:\r\n</h4>\r\n\r\n<p>\r\nThis bootcamp is a free, two-day programme that will teach participants the key skills required to create and manage successful digital marketing campaigns.</p><div class=\"navigations\"><ul>\r\n</ul>\r\n</div>\r\n<h4>\r\nAudience: Females aged 18–35\r\n</h4>\r\n', '2024-09-28', '2024-09-29', '10:00:00', 'Flat 3, Left Wing, Abinsa House, Zaria Road, Kano', 'Past', '../images/pictures/1164363137.jpg'),
(12, 'DIGITAL SKILLS FOR ENTREPRENEURS', 'Join our free programme designed for women entrepreneurs who want to master essential digital skills and take their businesses to the next level.', '<h3 style=\"font-family: \'Poppins\', sans-serif; color: #262626; font-size: 12pt; margin-bottom: 5px;\">\r\n    Master the Digital Skills Every Entrepreneur Needs to Succeed!\r\n</h3>\r\n\r\n<p style=\"font-family: \'Open Sans\', sans-serif; color: #797979; font-size: 12pt; margin: 0;\">\r\n    Are you a woman entrepreneur looking to digitize your business in today’s fast-paced, technology-driven world?\r\n</p>\r\n\r\n<p style=\"font-family: \'Open Sans\', sans-serif; color: #797979; font-size: 12pt; margin: 0;\">\r\n    Join our Digital Skills for Entrepreneurs programme and unlock the tools to grow your business in today’s digital world!\r\n</p>\r\n\r\n<p style=\"font-family: \'Open Sans\', sans-serif; color: #262626; font-size: 12pt; margin: 0;\">\r\n    <strong>What You’ll Learn:</strong>\r\n</p>\r\n\r\n<ul style=\"font-family: \'Open Sans\', sans-serif; color: #797979; font-size: 12pt; padding-left: 20px; margin-top: 0; margin-bottom: 10px;\">\r\n    <li style=\"list-style-type: disc;\">Digital Marketing strategies to reach your target audience</li>\r\n    <li style=\"list-style-type: disc;\">Social Media Management to build your online presence</li>\r\n    <li style=\"list-style-type: disc;\">E-commerce Solutions to sell your products and services online</li>\r\n    <li style=\"list-style-type: disc;\">Cybersecurity Essentials to protect your business online</li>\r\n</ul>\r\n\r\n<p style=\"font-family: \'Open Sans\', sans-serif; color: #262626; font-size: 12pt; margin: 0;\">\r\n    <strong>Why Attend?</strong>\r\n</p>\r\n\r\n<ul style=\"font-family: \'Open Sans\', sans-serif; color: #797979; font-size: 12pt; padding-left: 20px; margin-top: 0; margin-bottom: 10px;\">\r\n    <li style=\"list-style-type: disc;\">Gain hands-on experience with the latest digital tools</li>\r\n    <li style=\"list-style-type: disc;\">Learn from industry experts and entrepreneurs</li>\r\n    <li style=\"list-style-type: disc;\">Get insights on growing your business online</li>\r\n    <li style=\"list-style-type: disc;\">Network with like-minded business owners and professionals</li>\r\n</ul>\r\n\r\n<p style=\"font-family: \'Open Sans\', sans-serif; color: #262626; font-size: 12pt; margin: 0;\">\r\n    <strong>Who Should Join?</strong>\r\n</p>\r\n\r\n<ul style=\"font-family: \'Open Sans\', sans-serif; color: #797979; font-size: 12pt; padding-left: 20px; margin-top: 0; margin-bottom: 10px;\">\r\n    <li style=\"list-style-type: disc;\">Entrepreneurs</li>\r\n    <li style=\"list-style-type: disc;\">Startups</li>\r\n    <li style=\"list-style-type: disc;\">Anyone looking to enhance their digital skills</li></ul><ul style=\"font-family: \'Open Sans\', sans-serif; color: #797979; font-size: 12pt; padding-left: 20px; margin-top: 0; margin-bottom: 10px;\">\r\n</ul>\r\n\r\n<p style=\"font-family: \'Open Sans\', sans-serif; color: #797979; font-size: 12pt; margin: 0;\">\r\n    <strong>#wedigitize</strong>\r\n</p>\r\n', '2024-10-14', '2024-12-21', '8:00am -1:00pm', 'Flat 3, Abinsa House, Zaria road, Kano', 'Upcoming', '../images/pictures/374893450.png');

-- --------------------------------------------------------

--
-- Table structure for table `events_media`
--

DROP TABLE IF EXISTS `events_media`;
CREATE TABLE IF NOT EXISTS `events_media` (
  `event_pics_id` int NOT NULL AUTO_INCREMENT,
  `event_id` int NOT NULL,
  `event_pics_name` varchar(64) NOT NULL,
  PRIMARY KEY (`event_pics_id`),
  KEY `event_id` (`event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events_media`
--

INSERT INTO `events_media` (`event_pics_id`, `event_id`, `event_pics_name`) VALUES
(1, 10, '../images/pictures/175225623.jpg'),
(3, 10, '../images/pictures/601710103.jpg'),
(4, 10, '../images/pictures/906416457.jpg'),
(5, 10, '../images/pictures/1047879069.jpg'),
(6, 10, '../images/pictures/1099143277.jpg'),
(7, 10, '../images/pictures/1807910089.jpg'),
(8, 10, '../images/pictures/116040314.jpg'),
(10, 10, '../images/pictures/863446199.jpg'),
(11, 10, '../images/pictures/116491656.jpg'),
(12, 10, '../images/pictures/504521187.jpg'),
(13, 10, '../images/pictures/1142771818.jpg'),
(14, 10, '../images/pictures/80862142.jpg'),
(19, 11, '../images/pictures/696484822.jpg'),
(20, 11, '../images/pictures/1421188371.jpg'),
(21, 11, '../images/pictures/1550077593.jpg'),
(22, 11, '../images/pictures/1447211523.jpg'),
(23, 11, '../images/pictures/1109050306.jpg'),
(24, 11, '../images/pictures/1245123722.jpg'),
(25, 11, '../images/pictures/999010276.jpg'),
(26, 11, '../images/pictures/37930283.jpg'),
(27, 11, '../images/pictures/806901615.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `faq_tb`
--

DROP TABLE IF EXISTS `faq_tb`;
CREATE TABLE IF NOT EXISTS `faq_tb` (
  `faq_id` int NOT NULL AUTO_INCREMENT,
  `faq_question` varchar(400) NOT NULL,
  `faq_answer` text NOT NULL,
  PRIMARY KEY (`faq_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faq_tb`
--

INSERT INTO `faq_tb` (`faq_id`, `faq_question`, `faq_answer`) VALUES
(1, 'How does your company ensure the security of its software products?', '<p>Security is a top priority for us. We implement multiple layers of security measures throughout the development process, including:</p><p><br></p><p><b>Secure Coding Practices:</b> Our developers follow industry best practices for secure coding to minimize vulnerabilities.</p><p><b>Regular Security Audits:</b> We conduct regular security audits and vulnerability assessments to identify and address potential risks.</p><p><b>Data Encryption:</b> All sensitive data is encrypted both in transit and at rest to protect it from unauthorized access.</p><p><b>Compliance:</b> We ensure our solutions comply with relevant industry standards and regulations, such as GDPR, HIPAA, and ISO 27001.</p><p><b>User Authentication:</b> We implement robust user authentication and authorization mechanisms to prevent unauthorized access.</p>'),
(2, 'What is your company\'s approach to customer support?', '<p>We believe in providing exceptional customer support to ensure our clients get the most out of our services. Our approach includes:</p><p><b>Multiple Channels</b>: Clients can reach us through various channels, including phone, email, live chat, and our online ticketing system.</p><p><b>Knowledge Base:</b> We maintain a comprehensive knowledge base with FAQs, tutorials, and troubleshooting guides to help clients find answers quickly.</p><p><b>Dedicated Account Managers:</b> Each client is assigned a dedicated account manager who acts as a single point of contact for all their needs.</p><p><b>Regular Updates and Feedback:</b> We provide regular updates on the progress of support tickets and actively seek client feedback to continuously improve our services.</p>');

-- --------------------------------------------------------

--
-- Table structure for table `members_db`
--

DROP TABLE IF EXISTS `members_db`;
CREATE TABLE IF NOT EXISTS `members_db` (
  `member_id` int NOT NULL AUTO_INCREMENT,
  `member_name` varchar(100) NOT NULL,
  `member_position` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `m_profile` text NOT NULL,
  `member_picture` varchar(64) NOT NULL,
  PRIMARY KEY (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages_tb`
--

DROP TABLE IF EXISTS `messages_tb`;
CREATE TABLE IF NOT EXISTS `messages_tb` (
  `message_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_no` varchar(20) NOT NULL,
  `subject` varchar(400) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages_tb`
--

INSERT INTO `messages_tb` (`message_id`, `name`, `email`, `phone_no`, `subject`, `message`) VALUES
(1, 'zakiyya', 'zakiyyadanjuma@gmail.com', '', 'Interested in Collaborating on Web Development Projects', 'I am impressed with the work showcased on your website and believe that my skills and enthusiasm for web development could contribute positively to your projects.'),
(2, 'Zainab', 'abc@gmail.com', '08563796367', 'Appreciation for software development service', 'I hope this message finds you well. My name is Zainab, and I am keen on exploring potential collaboration opportunities with your team.'),
(3, 'Hasina Danjuma', 'abc@gmail.com', '', 'Appreciation for software development service', 'I hope this message finds you well. My name is Hasina, and I am keen on exploring potential collaboration opportunities with your team.'),
(4, 'zakiyya', 'zakiyyadanjuma@gmail.com', '', 'Titled message', 'Thank you'),
(5, 'Abdulhalim Sunusi', 'ahalim.sunusi@gmail.com', '', 'None for now', 'Message'),
(6, 'Abdulhalim Sunusi', 'ahalim.sunusi@gmail.com', '', 'None for now', 'Message'),
(7, 'Abdulhalim Sunusi', 'ahalim.sunusi@gmail.com', '', 'None for now', 'This'),
(8, 'Abdulhalim Sunusi', 'ahalim.sunusi@gmail.com', '', 'None for now', 'Message'),
(9, 'Abdulhalim Sunusi', 'ahalim.sunusi@gmail.com', '', 'None for now', 'message');

-- --------------------------------------------------------

--
-- Table structure for table `newsletter`
--

DROP TABLE IF EXISTS `newsletter`;
CREATE TABLE IF NOT EXISTS `newsletter` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(60) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `newsletter`
--

INSERT INTO `newsletter` (`id`, `email`, `created_at`) VALUES
(1, 'zakiyyadanjuma@gmail.com', '2024-07-30 11:58:27'),
(2, 'mufuda@gmail.com', '2024-08-03 12:06:30'),
(3, 'abc@gmail.com', '2024-08-03 12:31:39');

-- --------------------------------------------------------

--
-- Table structure for table `pages_tb`
--

DROP TABLE IF EXISTS `pages_tb`;
CREATE TABLE IF NOT EXISTS `pages_tb` (
  `page_id` int NOT NULL AUTO_INCREMENT,
  `page_name` varchar(50) NOT NULL,
  PRIMARY KEY (`page_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pages_tb`
--

INSERT INTO `pages_tb` (`page_id`, `page_name`) VALUES
(1, 'Home');

-- --------------------------------------------------------

--
-- Table structure for table `projects_tb`
--

DROP TABLE IF EXISTS `projects_tb`;
CREATE TABLE IF NOT EXISTS `projects_tb` (
  `project_id` int NOT NULL AUTO_INCREMENT,
  `project_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `project_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `service_id` int NOT NULL,
  `project_year` year NOT NULL,
  `project_pic` varchar(64) NOT NULL,
  PRIMARY KEY (`project_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects_tb`
--

INSERT INTO `projects_tb` (`project_id`, `project_name`, `project_description`, `service_id`, `project_year`, `project_pic`) VALUES
(2, 'Federal Ministry of Education under Sa’adatu Rimi College of Education (Revitalization Fund)-Procurement of electronic teaching aids', '<p>The \"Federal Ministry of Education under Sa’adatu Rimi College of Education (Revitalization Fund) - Procurement of Electronic Teaching Aids\" project was a strategic initiative aimed at modernizing and enhancing the educational infrastructure at Sa’adatu Rimi College of Education. This project, funded by the Federal Ministry of Education, focused on the acquisition and integration of advanced electronic teaching aids to improve the quality of education and learning experiences for students and faculty.<br></p>', 9, '2023', '../images/pictures/1206209896.jpeg'),
(3, 'Procurement & Installation of workstations at Terra Academy for the Arts Kano Lab', '<p>The project involved acquiring and installing advanced workstations at Terra Academy for the Arts’ Kano Lab. It aimed to enhance the lab\'s technological infrastructure, supporting digital arts, multimedia production, and academic research. The project included procuring high-performance desktops, installing and configuring the systems, and providing technical support. As a result, the academy\'s research and creative capabilities were significantly improved, boosting overall efficiency and productivity.<br></p>', 9, '2022', '../images/pictures/278276889.jpeg'),
(4, 'TETFUND ICT intervention – Sa’adatu Rimi College of Education, Kumbotso (System Upgrade)', '<p>The \"TETFUND ICT Intervention – Sa’adatu Rimi College of Education, Kumbotso (System Upgrade)\" project was an initiative aimed at upgrading the ICT infrastructure at Sa’adatu Rimi College of Education, Kumbotso. This project, funded by the Tertiary Education Trust Fund (TETFUND), focused on modernizing the college\'s information and communication technology systems to enhance digital capabilities and improve the overall efficiency of academic and administrative operations.<br></p>', 1, '2020', '../images/pictures/2103069771.jpg'),
(5, 'TETFUND ICT intervention – Sa’adatu Rimi College of Education, Kumbotso (eLearning Management System)', '<p>The \"TETFUND ICT Intervention – Sa’adatu Rimi College of Education, Kumbotso (eLearning Management System)\" project was an initiative aimed at implementing an advanced eLearning management system at Sa’adatu Rimi College of Education, Kumbotso. Funded by the Tertiary Education Trust Fund (TETFUND), the project focused on integrating a comprehensive digital platform designed to enhance online learning and teaching experiences. The system aimed to improve accessibility to educational resources, facilitate remote learning, and streamline academic administration.<br></p>', 1, '2022', '../images/pictures/904718497.jpeg'),
(6, 'Enthuse Entrepreneurship Secondary School (School Management System)', '<p>The \"Enthuse Entrepreneurship Secondary School (School Management System)\" project was designed to implement a comprehensive school management system at Enthuse Entrepreneurship Secondary School. The project focused on developing and integrating a digital platform to manage various aspects of school operations efficiently. The goal was to enhance the overall management of the school and improve the educational experience for all stakeholders.<br></p>', 1, '2019', '../images/pictures/428954723.jpg'),
(7, 'En-Klave - Company Website for En-Klave', '<p>The \"En-Klave - Company Website for En-Klave\" project involved the development and launch of a professional website for En-Klave. The project aimed to create an engaging and user-friendly online presence for the company, showcasing its services, products, and brand identity. The website was designed to provide visitors with comprehensive information about En-Klave, including its mission, offerings, and contact details. It featured an intuitive navigation system, responsive design, and integration with various digital tools to enhance user experience and support the company\'s online marketing efforts.<br></p>', 1, '2022', '../images/pictures/43258317.jpg'),
(8, 'Corporate Website for Intuitive Care Australia', '<p>The \"Corporate Website for Intuitive Care Australia\" project focused on designing and developing a comprehensive online platform for Intuitive Care Australia. The website was crafted to reflect the company\'s commitment to providing exceptional care services, featuring a clean and professional design. Key elements of the site included detailed information about their services, a user-friendly interface for clients to access resources and support, and integration with contact and appointment scheduling tools. The project aimed to enhance the company\'s digital presence, improve client engagement, and streamline communication between Intuitive Care Australia and its audience.<br></p>', 1, '2021', '../images/pictures/1820067676.jpg'),
(9, 'Sa\'adatu Rimi University of Education, Kumbotso (SRUOE) - School Management System', '<p>The \"Sa\'adatu Rimi University of Education, Kumbotso (SRUOE) - School Management System\" project involved the development and implementation of a comprehensive school management system for SRUOE. This system was designed to streamline administrative tasks and enhance the overall efficiency of the university\'s operations. Key features included student and faculty management, course and grade tracking, and automated scheduling. The project aimed to improve administrative workflows, facilitate better communication between students and staff, and provide a more organized and accessible platform for managing academic and administrative processes at the university.<br></p>', 1, '2022', '../images/pictures/1079035004.jpg'),
(10, 'Leveraging Digital Space for Brand Marketing', '<p><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", sans-serif;\">The overall objective of this programme is to equip young females with digital marketing skills necessary to upscale their businesses. It is however formulated for two sets of Young females: those that own businesses and require social media skills to increase sales, create awareness about their products or service; those that want to venture into managing social media adverts for other businesses.</span><br></p>', 8, '2024', '../images/pictures/400280262.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `services_tb`
--

DROP TABLE IF EXISTS `services_tb`;
CREATE TABLE IF NOT EXISTS `services_tb` (
  `id` int NOT NULL AUTO_INCREMENT,
  `service_name` varchar(50) NOT NULL,
  `service_description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `service_detail` text NOT NULL,
  `service_icon` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services_tb`
--

INSERT INTO `services_tb` (`id`, `service_name`, `service_description`, `service_detail`, `service_icon`) VALUES
(1, 'Software Development', 'Creating and maintaining functional and efficient software applications tailored to meet your specific needs.', '<ul>\r\n  <li>\r\n    <p style=\"color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      Spider Technologies is an experienced software development firm providing offshore software development services. Our cost-effective solutions are built specifically for organizations by utilizing an intimate understanding of their business and industry landscape. We offer rich, user-friendly, and robust applications in combination with any modern database system. The application can be totally standalone running in a single machine, network solutions, or internet-connected applications. Services include:\r\n    </p>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • Enterprise Applications\r\n    </p>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • Desktop Applications\r\n    </p>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • Web Application\r\n    </p>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • API and Addins\r\n    </p>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • Mobile and Tablet Apps\r\n    </p>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • Software Maintenance\r\n    </p>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • Software Re-engineering\r\n    </p>\r\n  </li>\r\n</ul>\r\n', 'fas fa-laptop-code'),
(4, 'Database Management', 'Design and implementation of efficient and scalable database solutions.', '<ul>\r\n  <li>\r\n    <p style=\"color: #797979; font-family: \'Open Sans\', sans-serif; margin: 0; line-height: 1.5;\">\r\n      We offer different types of database development services from design to reporting. Spider Technologies is experienced in standard database technologies like Oracle, Microsoft SQL Server, MySQL, PostgreSQL, and different Big Data and Cloud database systems. We maintain best practices in planning, development, maintenance, and security including ongoing monitoring and automation when needed. Services are:\r\n    </p>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -0.25in; line-height: 1.5; padding:0;\">\r\n      • Database Design\r\n    </p>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -0.25in; line-height: 1.5; padding:0;\">\r\n      • Database Development\r\n    </p>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -0.25in; line-height: 1.5; padding:0;\">\r\n      • Database Integration\r\n    </p>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -0.25in; line-height: 1.5; padding:0;\">\r\n      • Database Performance Tuning\r\n    </p>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -0.25in; line-height: 1.5; padding:0;\">\r\n      • Data Warehouse\r\n    </p>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -0.25in; line-height: 1.5; padding:0;\">\r\n      • Database Analysis &amp; Reporting\r\n    </p>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -0.25in; line-height: 1.5; padding:0;\">\r\n      • Data Security\r\n    </p>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -0.25in; line-height: 1.5; padding:0;\">\r\n      • Database Migration\r\n    </p>\r\n  </li>\r\n</ul>\r\n', 'fas fa-database'),
(5, 'Mobile Application', 'Development of mobile apps for iOS and Android platforms.', '<ul>\r\n  <li>\r\n    <p style=\"color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      Our team of experienced mobile apps developers and designers can build an app that will live up to your vision enabling you to leverage mobility to maximize productivity. Infoistic is developing business-critical solutions for mobile devices for Android, iPhone, Windows Phone, and BlackBerry, giving you and your team more flexibility when you are moving. Spider team has been developing mobile applications since 2014, using old timer PDA, Pocket PC, and Java-enabled phones.\r\n    </p>\r\n  </li>\r\n  <li>\r\n    <p style=\"color: #797979; font-family: \'Open Sans\', sans-serif; margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0;\">\r\n      Platforms:\r\n    </p>\r\n  </li>\r\n  <li>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • Android\r\n    </p>\r\n  </li>\r\n  <li>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • iOS\r\n    </p>\r\n  </li>\r\n</ul>\r\n', 'fas fa-mobile-screen'),
(6, 'IT Training', 'Comprehensive training programs for young individuals and corporate organizations.', '<ul>\r\n  <li>\r\n    <p style=\"color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      Spider Technologies offers high-end professional trainings on cutting-edge technologies. The trainings are designed and delivered by industry experts who have expertise in their respective fields. Our basic goal is to provide IT training that equips professionals not only with technical skills but also with the working capabilities using the best tools and practices in the industry. We offer training in:\r\n    </p>\r\n  </li>\r\n  <li>\r\n    <p style=\"color: #797979; font-family: \'Open Sans\', sans-serif; font-weight: bold; margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0;\">\r\n      Training Areas:\r\n    </p>\r\n  </li>\r\n  <li>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • .NET Programming\r\n    </p>\r\n  </li>\r\n  <li>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • Java Programming\r\n    </p>\r\n  </li>\r\n  <li>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • Database\r\n    </p>\r\n  </li>\r\n  <li>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • Software Quality Assurance\r\n    </p>\r\n  </li>\r\n  <li>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • Project Management\r\n    </p>\r\n  </li>\r\n  <li>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • Digital Marketing\r\n    </p>\r\n  </li>\r\n  <li>\r\n    <p style=\"color: #797979; font-family: \'Open Sans\', sans-serif; margin-top: 0; margin-bottom: 0;\">\r\n      Digital Literacy for Government Agencies, Private Organizations, and SMEs\r\n    </p>\r\n  </li>\r\n</ul>\r\n', 'fas fa-users'),
(7, 'Consultancy', 'Providing expert advice on IT strategy, technology adoption, and digital transformation.', '<p class=\"MsoNormal\" style=\"margin-top:0in;margin-right:0in;margin-bottom:6.15pt;\r\nmargin-left:0in;text-indent:0in;line-height:107%\"><font color=\"#000000\">With our versatile\r\nexperiences working with communities, our services also extend to providing\r\nconsultancy services on conflict resolution. We realise the importance of\r\nproviding lasting solution on farmer header clashes in some part of the country.\r\nWe work with government and NGOs to promote peace and conflict resolution to\r\naffected communities.<o:p></o:p></font></p>\r\n\r\n<p class=\"MsoNormal\"><o:p><font color=\"#000000\">&nbsp;</font></o:p></p>', 'flat flaticon-group-meeting'),
(8, 'Digital Marketing', 'Strategic digital marketing services to enhance your online presence.', '<ul>\r\n  <li>\r\n    <p style=\"color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      We offer a comprehensive digital marketing service that helps businesses grow their online presence and reach new customers. Our services include:\r\n    </p>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • Registering &amp; managing companies &amp; shops on local &amp; international e-commerce platforms such as Jumia, Konga, Amazon, etc.\r\n    </p>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • Search engine optimization (SEO): We help businesses improve their website\'s ranking in search engine results pages (SERPs) so they can be found by more potential customers.\r\n    </p>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • Pay-per-click (PPC) advertising: We create and manage PPC campaigns to help businesses reach their target audience with targeted ads.\r\n    </p>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • Social media marketing: We help businesses create and manage social media accounts, develop engaging content, and drive traffic to their websites.\r\n    </p>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • Content marketing: We create high-quality content that educates and engages potential customers, helping them to see your business as a trusted authority.\r\n    </p>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • Email marketing: We help businesses build email lists and send targeted, personalized emails to their customers.\r\n    </p>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • Web analytics: We track and analyze website traffic to help businesses understand how their website is performing and make improvements to increase results.\r\n    </p>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • We offer consultations to help SMEs and businesses understand their digital marketing needs and develop customized marketing plans to reach their target customers.\r\n    </p>\r\n  </li>\r\n</ul>\r\n', 'flat flaticon-digital-marketing'),
(9, 'Procurement of IT Equipment and Installation', 'Seamless IT equipment procurement and installation for uninterrupted business operations.', '<p style=\"font-family: \'Open Sans\', sans-serif; color: #797979;\">\r\n    This service entails procurement of IT &amp; related facilities including installation &amp; maintenance if required.\r\n</p>\r\n\r\n<p style=\"font-family: \'Open Sans\', sans-serif; color: #797979;\">\r\n    Our procurement process is designed to be efficient and cost-effective. We work with a network of trusted vendors to ensure that we get the best possible prices on the equipment you need.\r\n</p>\r\n\r\n<p style=\"font-family: \'Open Sans\', sans-serif; color: #797979;\">\r\n    Our installation services are comprehensive and include everything from unpacking and assembling the equipment to connecting it to your network and configuring it for your specific needs.\r\n</p>\r\n\r\n<p style=\"font-family: \'Open Sans\', sans-serif; color: #797979;\">\r\n    We also offer training and support to help you get the most out of your new equipment.\r\n</p>\r\n\r\n<p style=\"font-family: \'Open Sans\', sans-serif; color: #797979;\">\r\n    If you are looking for a reliable and affordable way to procure IT equipment and have it installed, Spider Technologies Limited is the perfect choice for you. Contact us today to learn more about our services.\r\n</p>\r\n', 'uil uil-desktop-cloud-alt'),
(10, 'Computer Networking', 'Design, implementation, and maintenance of computer networks to keep your business connected and productive.', '<ul>\r\n  <li>\r\n    <p style=\"color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      Our Computer Networking solutions aim to design &amp; implement network solutions that can help businesses of all sizes create a computer network, improve existing network performance, security, and reliability. Our Network solutions are designed to meet the specific needs of our customers, and we can provide a customized solution that meets your exact requirements.\r\n    </p>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      We offer a wide range of Networking solutions which include the following:\r\n    </p>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • Network design and implementation: We can help you design and implement a network that meets your specific needs.\r\n    </p>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • Network monitoring and management: We can monitor your network 24/7 and take action to address any issues that arise.\r\n    </p>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • Network security: We can help you secure your network from unauthorized access and attacks.\r\n    </p>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • Network disaster recovery: We can help you create a disaster recovery plan that will protect your network in the event of an outage.\r\n    </p>\r\n  </li>\r\n</ul>\r\n', 'fas fa-network-wired'),
(11, 'IT Projects Monitoring and Evaluation', 'Monitoring and evaluation services for IT projects, ensuring progress tracking and project success.', '<ul>\r\n  <li>\r\n    <p style=\"color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      We offer IT projects monitoring and evaluation services. Our team of experienced professionals have a proven track record of success in providing our clients with the insights they need to make informed decisions about their IT projects &amp; data.\r\n    </p>\r\n  </li>\r\n  <li>\r\n    <p style=\"color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      We offer a variety of IT projects monitoring and evaluation services, including:\r\n    </p>\r\n  </li>\r\n  <li>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • Project Impact Assessment\r\n    </p>\r\n  </li>\r\n  <li>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • Project scope definition and management\r\n    </p>\r\n  </li>\r\n  <li>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • Project risk assessment and mitigation\r\n    </p>\r\n  </li>\r\n  <li>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • Project budget and schedule management\r\n    </p>\r\n  </li>\r\n  <li>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • Project quality assurance and control\r\n    </p>\r\n  </li>\r\n  <li>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • Project stakeholder management\r\n    </p>\r\n  </li>\r\n  <li>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • Project communication and reporting\r\n    </p>\r\n  </li>\r\n  <li>\r\n    <p style=\"color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      We also provide our clients with a variety of tools and resources to help them monitor and evaluate their IT projects, including:\r\n    </p>\r\n  </li>\r\n  <li>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • Project management software\r\n    </p>\r\n  </li>\r\n  <li>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • Project risk management software\r\n    </p>\r\n  </li>\r\n  <li>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • Project budget and schedule management software\r\n    </p>\r\n  </li>\r\n  <li>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • Project quality assurance and control software\r\n    </p>\r\n  </li>\r\n  <li>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • Project stakeholder management software\r\n    </p>\r\n  </li>\r\n  <li>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • Project communication and reporting software\r\n    </p>\r\n  </li>\r\n  <li>\r\n    <p style=\"color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      Spider Technologies Limited is committed to providing our clients with the highest quality IT projects monitoring and evaluation services. We understand that each project is unique, and we tailor our services to meet the specific needs of our clients. We are confident that we can help our clients achieve their IT project goals and objectives.\r\n    </p>\r\n  </li>\r\n</ul>\r\n', 'flat flaticon-computer-graphic'),
(12, 'IT Busines Research, Incubation & Development', 'Research, incubation, and development services for IT businesses, fostering innovation and growth in a competitive market.', '<ul>\r\n  <li>\r\n    <p style=\"color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      We conduct research on IT Business, incubate &amp; implement the idea. We help Individual/Organisation/Companies to actualize their IT businesses in a seamless, efficient &amp; effective manner. Our Ideation identifies &amp; develops new IT businesses &amp; solutions which achieve the client’s goals &amp; objectives from ideation to implementation.\r\n    </p>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      Our IT business research and incubation service includes:\r\n    </p>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • Market research: We will conduct a comprehensive market analysis to identify potential opportunities for new IT solutions. This includes evaluating the size and growth potential of the market, the competitive landscape, and the latest trends.\r\n    </p>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • Technical feasibility analysis: We will assess the technical feasibility of your proposed IT solution. This includes evaluating the technical requirements, the availability of resources, and the risks involved.\r\n    </p>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • Business case development: We will create a detailed business case for your proposed IT solution. This will include a description of the solution, the benefits it will provide, and the costs involved.\r\n    </p>\r\n    <p style=\"margin: 0; margin-left: .5in; text-indent: -.25in; padding: 0; color: #797979; font-family: \'Open Sans\', sans-serif;\">\r\n      • Implementation support: We will provide support for the implementation of your IT solution. This includes training your staff, providing technical support, and helping you to integrate the solution into your existing IT infrastructure.\r\n    </p>\r\n  </li>\r\n</ul>\r\n', 'uil uil-file-search-alt');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials_tb`
--

DROP TABLE IF EXISTS `testimonials_tb`;
CREATE TABLE IF NOT EXISTS `testimonials_tb` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `organization` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `testimonial` text NOT NULL,
  `image` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testimonials_tb`
--

INSERT INTO `testimonials_tb` (`id`, `name`, `organization`, `title`, `testimonial`, `image`) VALUES
(2, 'Nasir Wali', 'SRCOE', 'ICT Director', '\"SpiderTech\'s IT support services have been instrumental in keeping our systems running smoothly. Their team is quick to respond, expertly resolving any issues we encounter. Knowing that they have our IT needs covered allows us to focus on our core business with confidence.\"', '../images/pictures/1682465155.png'),
(3, 'Nasir Wali', 'SRCOE', 'ICT Director', '\"SpiderTech\'s network infrastructure services have transformed our connectivity. Their expertise in designing, implementing, and maintaining our network has improved our operational efficiency and communication. Their responsive support is always just a call away.\"', '../images/pictures/1089348657.png'),
(4, 'Omar ', 'Intuitive Care Australia', 'CEO', '\"We\'ve entrusted our Website needs to SpiderTech for several years, and they\'ve consistently exceeded our expectations. Their proactive approach to managing our Website and IT infrastructure has eliminated downtime and ensured a secure, efficient environment.', '../images/pictures/924472772.png'),
(6, 'Shibai', 'en-Klave', 'CEO', '\"SpidersTech helped us to seamlessly have an online presence. Their solutions have reduced our paper work thereby reducing costs of running our business and providing easy way for clients to reach out to us within short period of time.\"', '../images/pictures/1261654621.png');

-- --------------------------------------------------------

--
-- Table structure for table `trainings_tb`
--

DROP TABLE IF EXISTS `trainings_tb`;
CREATE TABLE IF NOT EXISTS `trainings_tb` (
  `id` int NOT NULL AUTO_INCREMENT,
  `training_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `training_description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `training_details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `training_icon` varchar(64) NOT NULL,
  `training_image` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainings_tb`
--

INSERT INTO `trainings_tb` (`id`, `training_name`, `training_description`, `training_details`, `training_icon`, `training_image`) VALUES
(1, 'DIGITAL SKILLS FOR ENTREPRENEURS', 'Join our free programme designed for women entrepreneurs who want to master essential digital skills and take their businesses to the next level.', '<h3 style=\"font-family: \'Poppins\', sans-serif; color: #262626; font-size: 12pt; margin-bottom: 5px;\">\r\n    Master the Digital Skills Every Entrepreneur Needs to Succeed!\r\n</h3>\r\n\r\n<p style=\"font-family: \'Open Sans\', sans-serif; color: #797979; font-size: 12pt; margin: 0;\">\r\n    Are you a woman entrepreneur looking to digitize your business in today’s fast-paced, technology-driven world?\r\n</p>\r\n\r\n<p style=\"font-family: \'Open Sans\', sans-serif; color: #797979; font-size: 12pt; margin: 0;\">\r\n    Join our Digital Skills for Entrepreneurs programme and unlock the tools to grow your business in today’s digital world!\r\n</p>\r\n\r\n<p style=\"font-family: \'Open Sans\', sans-serif; color: #262626; font-size: 12pt; margin: 0;\">\r\n    <strong>What You’ll Learn:</strong>\r\n</p>\r\n\r\n<ul style=\"font-family: \'Open Sans\', sans-serif; color: #797979; font-size: 12pt; padding-left: 20px; margin-top: 0; margin-bottom: 10px;\">\r\n    <li style=\"list-style-type: disc;\">Digital Marketing strategies to reach your target audience</li>\r\n    <li style=\"list-style-type: disc;\">Social Media Management to build your online presence</li>\r\n    <li style=\"list-style-type: disc;\">E-commerce Solutions to sell your products and services online</li>\r\n    <li style=\"list-style-type: disc;\">Cybersecurity Essentials to protect your business online</li>\r\n</ul>\r\n\r\n<p style=\"font-family: \'Open Sans\', sans-serif; color: #262626; font-size: 12pt; margin: 0;\">\r\n    <strong>Why Attend?</strong>\r\n</p>\r\n\r\n<ul style=\"font-family: \'Open Sans\', sans-serif; color: #797979; font-size: 12pt; padding-left: 20px; margin-top: 0; margin-bottom: 10px;\">\r\n    <li style=\"list-style-type: disc;\">Gain hands-on experience with the latest digital tools</li>\r\n    <li style=\"list-style-type: disc;\">Learn from industry experts and entrepreneurs</li>\r\n    <li style=\"list-style-type: disc;\">Get insights on growing your business online</li>\r\n    <li style=\"list-style-type: disc;\">Network with like-minded business owners and professionals</li>\r\n</ul>\r\n\r\n<p style=\"font-family: \'Open Sans\', sans-serif; color: #262626; font-size: 12pt; margin: 0;\">\r\n    <strong>Who Should Join?</strong>\r\n</p>\r\n\r\n<ul style=\"font-family: \'Open Sans\', sans-serif; color: #797979; font-size: 12pt; padding-left: 20px; margin-top: 0; margin-bottom: 10px;\">\r\n    <li style=\"list-style-type: disc;\">Entrepreneurs</li>\r\n    <li style=\"list-style-type: disc;\">Small business owners</li>\r\n    <li style=\"list-style-type: disc;\">Startups</li>\r\n    <li style=\"list-style-type: disc;\">Anyone looking to enhance their digital skills</li>\r\n</ul>\r\n\r\n<p style=\"font-family: \'Open Sans\', sans-serif; color: #262626; font-size: 12pt; margin: 0;\">\r\n    <strong>Programme Details:</strong>\r\n</p>\r\n\r\n<ul style=\"font-family: \'Open Sans\', sans-serif; color: #797979; font-size: 12pt; padding-left: 20px; margin-top: 0; margin-bottom: 10px;\">\r\n    <li style=\"list-style-type: disc;\">Date: 14<sup>th</sup> October, 2024 – 5<sup>th</sup> November, 2024</li>\r\n    <li style=\"list-style-type: disc;\">Days: Mondays – Thursdays</li>\r\n    <li style=\"list-style-type: disc;\">Time: 8:00am – 1:00pm daily</li>\r\n    <li style=\"list-style-type: disc;\">Location: Flat 3, Abinsa House, Zaria road, Kano</li>\r\n</ul>\r\n\r\n<p style=\"font-family: \'Open Sans\', sans-serif; color: #797979; font-size: 12pt; margin: 0;\">\r\n    <strong>#wedigitize</strong>\r\n</p>\r\n', 'flat flaticon-digital-marketing', '../images/pictures/338527298.png');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
