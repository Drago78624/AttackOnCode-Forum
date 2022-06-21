-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2022 at 05:08 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `attack_on_code`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_description` text NOT NULL,
  `category_createdat` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `category_description`, `category_createdat`) VALUES
(1, 'React', 'React is a free and open-source front-end JavaScript library for building user interfaces based on UI components. It is maintained by Meta and a community of individual developers and companies.', '2022-06-17 06:55:23'),
(2, 'PHP', 'PHP is a general-purpose scripting language geared toward web development. It was originally created by Danish-Canadian programmer Rasmus Lerdorf in 1994. The PHP reference implementation is now produced by The PHP Group. ', '2022-06-17 06:55:23'),
(3, 'JavaScript', 'JavaScript, often abbreviated JS, is a programming language that is one of the core technologies of the World Wide Web, alongside HTML and CSS. Over 97% of websites use JavaScript on the client side for web page behavior, often incorporating third-party libraries.', '2022-06-17 06:57:33'),
(4, 'Bootstrap', 'Bootstrap is a free and open-source CSS framework directed at responsive, mobile-first front-end web development. It contains HTML, CSS and JavaScript-based design templates for typography, forms, buttons, navigation, and other interface components.', '2022-06-17 06:57:33'),
(5, 'Angular', 'Angular is a TypeScript-based free and open-source web application framework led by the Angular Team at Google and by a community of individuals and corporations. Angular is a complete rewrite from the same team that built AngularJS.', '2022-06-17 07:03:51'),
(6, 'TypeScript', 'TypeScript is a programming language developed and maintained by Microsoft. It is a strict syntactical superset of JavaScript and adds optional static typing to the language. It is designed for the development of large applications and transpiles to JavaScript.', '2022-06-17 07:03:51');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `comment_content` text NOT NULL,
  `comment_code` text NOT NULL,
  `thread_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `comment_content`, `comment_code`, `thread_id`, `user_id`, `timestamp`) VALUES
(1, 'fgsfg', 'sdfsdf', 1, 1, '2022-06-19 18:50:39'),
(2, 'honoohon', 'const d = new Date(\"2015\");', 7, 1, '2022-06-19 19:16:28'),
(3, 'dafdf', 'adfda', 6, 1, '2022-06-19 20:09:54'),
(4, 'dfadf', 'dafd', 6, 1, '2022-06-19 20:10:06'),
(5, 'dfdaf', 'dfaf', 9, 1, '2022-06-19 20:10:37'),
(6, 'hono is hono', 'x = 3.14;       // This will not cause an error.\r\nmyFunction();\r\n\r\nfunction myFunction() {\r\n  \"use strict\";\r\n  y = 3.14;   // This will cause an error\r\n}', 6, 1, '2022-06-19 20:33:49');

-- --------------------------------------------------------

--
-- Table structure for table `threads`
--

CREATE TABLE `threads` (
  `thread_id` int(11) NOT NULL,
  `thread_title` varchar(255) NOT NULL,
  `thread_desc` text NOT NULL,
  `thread_code` text NOT NULL,
  `thread_cat_id` int(11) NOT NULL,
  `thread_user_id` int(11) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `threads`
--

INSERT INTO `threads` (`thread_id`, `thread_title`, `thread_desc`, `thread_code`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES
(1, 'dfda', 'dafdf', '<?php\r\n$myXMLData =\r\n\"<?xml version=\'1.0\' encoding=\'UTF-8\'?>\r\n<note>\r\n<to>Tove</to>\r\n<from>Jani</from>\r\n<heading>Reminder</heading>\r\n<body>Don\'t forget me this weekend!</body>\r\n</note>\";\r\n\r\n$xml=simplexml_load_string($myXMLData) or die(\"Error: Cannot create object\");\r\nprint_r($xml);\r\n?>', 1, 1, '2022-06-19 11:14:07'),
(3, 'dfda', 'dafdf', '<?php\r\n$myXMLData =\r\n\"<?xml version=\'1.0\' encoding=\'UTF-8\'?>\r\n<note>\r\n<to>Tove</to>\r\n<from>Jani</from>\r\n<heading>Reminder</heading>\r\n<body>Don\'t forget me this weekend!</body>\r\n</note>\";\r\n\r\n$xml=simplexml_load_string($myXMLData) or die(\"Error: Cannot create object\");\r\nprint_r($xml);\r\n?>', 1, 1, '2022-06-19 11:16:45'),
(4, 'hono', 'erer', 'const fruits = [\"Banana\", \"Orange\", \"Apple\", \"Mango\"];\r\nfruits.pop();', 1, 1, '2022-06-19 11:24:55'),
(5, 'how to install angular', '1sdd', 'daf', 1, 1, '2022-06-19 19:09:21'),
(6, 'daf', 'adf', 'aa', 2, 1, '2022-06-19 19:10:58'),
(7, 'how to install angular', 'dafdf', 'body {\r\n  background-color: lightblue;\r\n}\r\n\r\nh1 {\r\n  color: white;\r\n  text-align: center;\r\n}\r\n\r\np {\r\n  font-family: verdana;\r\n  font-size: 20px;\r\n}', 1, 1, '2022-06-19 19:15:57'),
(8, 'dafadf', 'daf', 'af', 2, 1, '2022-06-19 19:17:01'),
(9, 'how to install angular', 'dfdf', 'const d = new Date(\"2015-03\");', 2, 1, '2022-06-19 20:10:24'),
(10, 'Programmatically navigate using React router', 'With react-router I can use the Link element to create links which are natively handled by react router.\r\n\r\nI see internally it calls this.context.transitionTo(...).\r\n\r\nI want to do a navigation. Not from a link, but from a dropdown selection (as an example). How can I do this in code? What is this.context?\r\n\r\nI saw the Navigation mixin, but can I do this without mixins?', 'import { useHistory } from \"react-router-dom\";\r\n\r\nfunction HomeButton() {\r\n  const history = useHistory();\r\n\r\n  function handleClick() {\r\n    history.push(\"/home\");\r\n  }\r\n\r\n  return (\r\n    <button type=\"button\" onClick={handleClick}>\r\n      Go home\r\n    </button>\r\n  );\r\n}', 1, 1, '2022-06-19 20:11:25'),
(11, 'dfadf', 'dafdf', 'const d = new Date(\"2015-03\");\r\n', 1, 1, '2022-06-19 20:33:18');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_password` text NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_password`, `timestamp`) VALUES
(1, 'Muhammad Maaz Ahmed', 'jk@jk.com', '$2y$10$dowP1TRO9Mv77W23gj.15ul3PslnF5YgzdKfjwZQa8KIGqMqCEJs.', '2022-06-19 09:07:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `threads`
--
ALTER TABLE `threads`
  ADD PRIMARY KEY (`thread_id`);
ALTER TABLE `threads` ADD FULLTEXT KEY `thread_title` (`thread_title`,`thread_desc`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `threads`
--
ALTER TABLE `threads`
  MODIFY `thread_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
