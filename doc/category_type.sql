-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2016-10-31 17:17:05
-- 服务器版本： 10.1.16-MariaDB
-- PHP Version: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `z_Industry`
--

-- --------------------------------------------------------

--
-- 表的结构 `z_category_type`
--
DROP TABLE IF EXISTS `z_category_type`;
CREATE TABLE `z_category_type` (
  `tid` tinyint(5) NOT NULL COMMENT '栏目类型ID',
  `name` varchar(20) NOT NULL COMMENT '栏目类型名称',
  `ename` varchar(20) NOT NULL COMMENT '栏目类型英文名称'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `z_category_type`
--

INSERT INTO `z_category_type` (`tid`, `name`, `ename`) VALUES
(1, '列表页面', 'List'),
(2, '封面页面', 'Page'),
(3, '产品页面', 'Product'),
(4, '联系页面', 'Contact');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `z_category_type`
--
ALTER TABLE `z_category_type`
  ADD PRIMARY KEY (`tid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
