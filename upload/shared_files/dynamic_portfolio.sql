-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 11, 2020 at 04:55 AM
-- Server version: 5.7.24
-- PHP Version: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dynamic_portfolio`
--

-- --------------------------------------------------------

--
-- Table structure for table `about`
--

CREATE TABLE `about` (
  `id` int(11) NOT NULL,
  `img_dir` varchar(255) NOT NULL,
  `details` varchar(255) NOT NULL,
  `progress_topic` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `about`
--

INSERT INTO `about` (`id`, `img_dir`, `details`, `progress_topic`) VALUES
(1, 'banner_img2.png', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rerum, sed repudiandae odit deserunt, quas quibusdam necessitatibus nesciunt eligendi esse sit non reprehenderit quisquam asperiores maxime blanditiis culpa vitae velit. Numquam!', 'EDUCATION');

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `city` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id`, `city`, `address`, `phone`, `email`) VALUES
(1, 'NEW YORK', 'Event Center park WT 22 New York', '+9 125 645 8654', 'info@exemple.com');

-- --------------------------------------------------------

--
-- Table structure for table `banner_img`
--

CREATE TABLE `banner_img` (
  `id` int(11) NOT NULL,
  `img_dir` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `banner_img`
--

INSERT INTO `banner_img` (`id`, `img_dir`) VALUES
(1, 'banner_img.png');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `img_dir` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `img_dir`, `status`) VALUES
(1, 'brand_img189020184.png', 1),
(2, 'brand_img1765930587.png', 1),
(4, 'brand_img1951450376.png', 1),
(5, 'brand_img1521195910.png', 1),
(6, 'brand_img2116383513.png', 1),
(10, 'brand_img555706429.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `copyright`
--

CREATE TABLE `copyright` (
  `id` int(11) NOT NULL,
  `copyright_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `copyright`
--

INSERT INTO `copyright` (`id`, `copyright_name`) VALUES
(1, 'Bogura');

-- --------------------------------------------------------

--
-- Table structure for table `fact_areas`
--

CREATE TABLE `fact_areas` (
  `id` int(11) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `project_numbers` varchar(11) NOT NULL,
  `project_topic` varchar(100) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fact_areas`
--

INSERT INTO `fact_areas` (`id`, `icon`, `project_numbers`, `project_topic`, `status`) VALUES
(5, 'fas fa-award', '245', 'FEATURE ITEM', 1),
(6, 'far fa-thumbs-up', '345', 'ACTIVE PRODUCTS', 1),
(8, 'fas fa-female', '3000', 'OUR CLIENTS', 1);

-- --------------------------------------------------------

--
-- Table structure for table `header`
--

CREATE TABLE `header` (
  `id` int(11) NOT NULL,
  `header_title` varchar(100) NOT NULL,
  `header_desp` varchar(255) NOT NULL,
  `cta_btn` varchar(100) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `header`
--

INSERT INTO `header` (`id`, `header_title`, `header_desp`, `cta_btn`, `status`) VALUES
(3, 'I AM MD RIAZ', 'Professional web developer with long time experience in this field​.', 'SEE PORTFOLIOS', 1),
(6, 'WebkitScrollbarCusto', 'The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested.', 'WHY?', 0);

-- --------------------------------------------------------

--
-- Table structure for table `logo`
--

CREATE TABLE `logo` (
  `id` int(11) NOT NULL,
  `main_img` varchar(100) NOT NULL,
  `secondary_img` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `logo`
--

INSERT INTO `logo` (`id`, `main_img`, `secondary_img`) VALUES
(1, 'logo.png', 's_logo.png');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `message`, `status`) VALUES
(1, 'MD RIAZ', 'riazmd582@gmail.com', 'Hi this is just for testing', 1),
(3, 'established', 'established@hotmail.com', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `portfolio`
--

CREATE TABLE `portfolio` (
  `id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `desp` text NOT NULL,
  `img_dir` varchar(100) DEFAULT NULL,
  `img_dir2` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `portfolio`
--

INSERT INTO `portfolio` (`id`, `category`, `project_name`, `title`, `desp`, `img_dir`, `img_dir2`, `status`) VALUES
(1, 'DESIGN', 'HAMBLE TRIANGLE', 'CONSECTETUR NEQUE ELIT QUIS NUNC CRAS ELEMENTUM', 'Express dolor sit amet, consectetur adipiscing elit. Cras sollicitudin, tellus vitae condimem egestliberos dolor auctor tellus, eu consectetur neque e...', 'p1.jpg', 'portfolio_details1.jpg', 1),
(2, 'VIDEO', 'DARK BEAUTY', 'CONSECTETUR NEQUE ELIT QUIS NUNC CRAS ELEMENTUM', 'Express dolor sit amet, consectetur adipiscing elit. Cras sollicitudin, tellus vitae condimem egestliberos dolor auctor tellus, eu consectetur neque e...', 'p2.jpg', 'portfolio_details2.jpg', 1),
(4, 'DESIGN', 'IPSUM WHICH', 'CONSECTETUR NEQUE ELIT QUIS NUNC CRAS ELEMENTUM', 'Express dolor sit amet, consectetur adipiscing elit. Cras sollicitudin, tellus vitae condimem egestliberos dolor auctor tellus, eu consectetur neque e...', 'p4.jpg', 'portfolio_details4.jpg', 0),
(5, 'CREATIVE', 'EIUSMOD TEMPOR', 'CONSECTETUR NEQUE ELIT QUIS NUNC CRAS ELEMENTUM', 'Express dolor sit amet, consectetur adipiscing elit. Cras sollicitudin, tellus vitae condimem egestliberos dolor auctor tellus, eu consectetur neque e...', 'p5.jpg', 'portfolio_details5.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `service_icon` varchar(20) NOT NULL,
  `service_title` varchar(50) NOT NULL,
  `service_details` varchar(255) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `service_icon`, `service_title`, `service_details`, `status`) VALUES
(1, 'fas fa-ad', 'Digital Marketing', 'Digital marketing is the component of marketing that utilizes internet and online based digital technologies such as desktop computers, mobile phones and other digital media and platforms to promote products and services.Digital marketing is the component', 1),
(4, 'fab fa-artstation', 'Graphics Design', 'Graphic design is the process of visual communication and problem-solving through the use of typography, photography, and illustration.', 1),
(6, 'far fa-browser', 'Web Design', 'Web design encompasses many different skills and disciplines in the production and maintenance of websites.', 1),
(8, 'fas fa-database', 'Database Managment', 'A database is an organized collection of data, generally stored and accessed electronically from a computer system.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `skillbar`
--

CREATE TABLE `skillbar` (
  `id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `skill_name` varchar(200) NOT NULL,
  `value` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `skillbar`
--

INSERT INTO `skillbar` (`id`, `year`, `skill_name`, `value`, `status`) VALUES
(2, 2020, 'PHD of Interaction Design &amp; Animation', 65, 1),
(3, 2016, 'Master of Database Administration', 75, 1),
(4, 2010, 'Bachelor of Computer Engineering', 85, 1),
(5, 2005, 'Diploma of Computer', 90, 1);

-- --------------------------------------------------------

--
-- Table structure for table `social`
--

CREATE TABLE `social` (
  `id` int(11) NOT NULL,
  `fb` varchar(255) NOT NULL DEFAULT '#',
  `twitter` varchar(255) NOT NULL DEFAULT '#',
  `insta` varchar(255) NOT NULL DEFAULT '#',
  `pinterest` varchar(255) NOT NULL DEFAULT '#'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `social`
--

INSERT INTO `social` (`id`, `fb`, `twitter`, `insta`, `pinterest`) VALUES
(1, 'https://www.facebook.com/', '#', '#', '#');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `img_dir` varchar(100) DEFAULT NULL,
  `msg` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `img_dir`, `msg`, `name`, `designation`, `status`) VALUES
(1, 'testi_avatar1.jpg', 'An event is a message sent by an object to signal the occur rence of an action. The action can causd user interaction such as a button click, or it can result', 'tonoy jakson', 'head of idea', 1),
(5, 'testi_avatar5.png', 'An event is a message sent by an object to signal the occur rence of an action. The action can causd user interaction such as a button click, or it can result', 'Terrye Brotheridge', 'Head of Managment', 1),
(6, 'testi_avatar6.png', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'MD RIAZ', 'head of idea', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `usernames` varchar(255) NOT NULL,
  `img_dir` varchar(255) DEFAULT NULL,
  `emails` varchar(255) NOT NULL,
  `names` varchar(255) NOT NULL,
  `university` varchar(255) NOT NULL,
  `passwords` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `about` text,
  `role` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `usernames`, `img_dir`, `emails`, `names`, `university`, `passwords`, `gender`, `about`, `role`) VALUES
(3, 'mdriaz', NULL, 'riazmd582@gmail.com', 'MD RIAZ', 'MD RIAZ', '$2y$10$bWLMsDRkk0aD/MdjTh434.RRhGkEotYsQJsW.4Ur5NvVGnpbq1oOm', 'Male', NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about`
--
ALTER TABLE `about`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banner_img`
--
ALTER TABLE `banner_img`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `copyright`
--
ALTER TABLE `copyright`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fact_areas`
--
ALTER TABLE `fact_areas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `header`
--
ALTER TABLE `header`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logo`
--
ALTER TABLE `logo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `portfolio`
--
ALTER TABLE `portfolio`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skillbar`
--
ALTER TABLE `skillbar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social`
--
ALTER TABLE `social`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about`
--
ALTER TABLE `about`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `banner_img`
--
ALTER TABLE `banner_img`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `copyright`
--
ALTER TABLE `copyright`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fact_areas`
--
ALTER TABLE `fact_areas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `header`
--
ALTER TABLE `header`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `logo`
--
ALTER TABLE `logo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `portfolio`
--
ALTER TABLE `portfolio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `skillbar`
--
ALTER TABLE `skillbar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `social`
--
ALTER TABLE `social`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
