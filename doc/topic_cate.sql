-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2016-10-31 10:26:44
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
-- 表的结构 `z_topic_cate`
--

DROP TABLE IF EXISTS `z_topic_cate`;
CREATE TABLE `z_topic_cate` (
  `cid` int(11) NOT NULL COMMENT '话题分类ID',
  `name` varchar(30) NOT NULL COMMENT '分类名称',
  `ename` varchar(30) NOT NULL COMMENT '分类英文名称',
  `pic` varchar(200) NOT NULL COMMENT '缩略图原图',
  `pic50` varchar(200) NOT NULL COMMENT '缩略图50x50',
  `pic100` varchar(200) NOT NULL COMMENT '缩略图100x100',
  `pic200` varchar(200) NOT NULL COMMENT '缩略图200x200',
  `description` text NOT NULL COMMENT '分类描述'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `z_topic_cate`
--

INSERT INTO `z_topic_cate` (`t_id`, `name`, `ename`, `pic`, `pic50`, `pic100`, `pic200`, `description`) VALUES
(1, '求助交流', 'help', '', '', '', '', ''),
(2, '技术分享', 'share', '', '', '', '', ''),
(3, '网站模板', 'template', '', '', '', '', ''),
(4, '网站源码', 'code', '', '', '', '', ''),
(5, '项目合作', 'working', '', '', '', '', ''),
(6, '招聘求职', 'job', '', '', '', '', ''),
(7, '其他', 'other', '', '', '', '', ''),
(8, '新手模块', 'new', '', '', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `z_topic_cate`
--
ALTER TABLE `z_topic_cate`
  ADD PRIMARY KEY (`t_id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `z_topic_cate`
--
ALTER TABLE `z_topic_cate`
  MODIFY `t_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '话题分类ID', AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
