-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 28, 2019 at 03:29 AM
-- Server version: 5.7.27
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hm-bookstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE IF NOT EXISTS `book` (
  `id` int(11) NOT NULL,
  `code` varchar(45) DEFAULT NULL COMMENT 'Mã sách',
  `name` varchar(225) DEFAULT NULL COMMENT 'Tên sách',
  `group_id` int(11) DEFAULT NULL COMMENT 'ID nhóm sách',
  `class_id` tinyint(1) DEFAULT NULL COMMENT 'Lớp (1-12)',
  `attachs` varchar(100) DEFAULT NULL COMMENT 'File hdsd',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Ngày tạo',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT 'Ngày sửa',
  `created_by` varchar(45) DEFAULT NULL COMMENT 'Người tạo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `book_group`
--

CREATE TABLE IF NOT EXISTS `book_group` (
  `id` int(11) NOT NULL,
  `code` varchar(5) DEFAULT NULL COMMENT 'Mã nhóm',
  `name` varchar(45) DEFAULT NULL COMMENT 'Tên nhóm',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Ngày tạo',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT 'Ngày sửa',
  `created_by` varchar(45) DEFAULT NULL COMMENT 'Người tạo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `book_teacher`
--

CREATE TABLE IF NOT EXISTS `book_teacher` (
  `id` int(11) NOT NULL,
  `book_code` varchar(45) DEFAULT NULL,
  `teacher_code` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `history_republish`
--

CREATE TABLE IF NOT EXISTS `history_republish` (
  `id` int(11) NOT NULL,
  `book_code` varchar(45) DEFAULT NULL COMMENT 'Mã sách',
  `message` varchar(225) DEFAULT NULL COMMENT 'Mô tả lịch sử'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `republish`
--

CREATE TABLE IF NOT EXISTS `republish` (
  `id` int(11) NOT NULL,
  `book_code` varchar(45) DEFAULT NULL COMMENT 'Mã sách',
  `code_item` varchar(45) DEFAULT NULL COMMENT 'Mã sách tái bản',
  `republish` int(11) DEFAULT NULL COMMENT 'Lần tái bản'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sms_book`
--

CREATE TABLE IF NOT EXISTS `sms_book` (
  `id` int(11) NOT NULL,
  `phone` varchar(15) DEFAULT NULL COMMENT 'Số điện thoại đăng ký',
  `email` varchar(50) DEFAULT NULL COMMENT 'Email đăng ký',
  `code` varchar(45) DEFAULT NULL COMMENT 'Mã sách tái bản',
  `publish` int(1) DEFAULT '0' COMMENT 'Trạng thái',
  `send_mail` int(11) DEFAULT '0' COMMENT 'Số lần gửi mail',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Ngày tạo',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT 'Ngày sửa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE IF NOT EXISTS `teacher` (
  `id` int(11) NOT NULL,
  `code` varchar(45) DEFAULT NULL COMMENT 'Mã giáo viên',
  `fullname` varchar(225) DEFAULT NULL COMMENT 'Tên đầy đủ',
  `phone` varchar(15) DEFAULT NULL COMMENT 'Số điện thoại',
  `email` varchar(50) DEFAULT NULL COMMENT 'Email',
  `address` varchar(150) DEFAULT NULL COMMENT 'Địa chỉ',
  `facebook` varchar(225) DEFAULT NULL COMMENT 'Facebook',
  `youtube_chanel` varchar(225) DEFAULT NULL COMMENT 'Kênh youtube',
  `publish` tinyint(1) DEFAULT '0' COMMENT 'Trạng thái',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Ngày tạo',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT 'Ngày sửa',
  `created_by` varchar(45) DEFAULT NULL COMMENT 'Người tạo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `username` varchar(45) DEFAULT NULL COMMENT 'Mã nhân viên',
  `fullname` varchar(100) DEFAULT NULL COMMENT 'Họ và tên',
  `email` varchar(50) DEFAULT NULL COMMENT 'Email',
  `phone` varchar(15) DEFAULT NULL COMMENT 'Số điện thoại',
  `address` varchar(100) DEFAULT NULL,
  `password` varchar(150) DEFAULT NULL COMMENT 'Mật khẩu',
  `role` tinyint(4) DEFAULT '0' COMMENT 'Vai trò',
  `position` tinyint(4) DEFAULT '0' COMMENT 'Chức vụ',
  `department` varchar(50) DEFAULT NULL COMMENT 'Phòng ban',
  `publish` tinyint(4) DEFAULT '1' COMMENT 'Trạng thái',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Ngày tạo',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT 'Ngày sửa',
  `created_by` varchar(45) DEFAULT NULL COMMENT 'Người tạo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `book_group`
--
ALTER TABLE `book_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `book_teacher`
--
ALTER TABLE `book_teacher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history_republish`
--
ALTER TABLE `history_republish`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `republish`
--
ALTER TABLE `republish`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_book`
--
ALTER TABLE `sms_book`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
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
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `book_group`
--
ALTER TABLE `book_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `book_teacher`
--
ALTER TABLE `book_teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `history_republish`
--
ALTER TABLE `history_republish`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `republish`
--
ALTER TABLE `republish`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sms_book`
--
ALTER TABLE `sms_book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
