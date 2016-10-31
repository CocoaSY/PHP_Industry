-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2016-10-31 16:53:51
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
-- 表的结构 `z_film_cate`
--
DROP TABLE IF EXISTS `z_film_cate`;
CREATE TABLE `z_film_cate` (
  `cid` int(11) NOT NULL COMMENT '电影分类ID',
  `name` varchar(20) NOT NULL COMMENT '分类名称',
  `ename` varchar(20) NOT NULL COMMENT '英文名称',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父级分类',
  `description` text NOT NULL COMMENT '分类描述',
  `pic` varchar(200) NOT NULL COMMENT '图片',
  `pic50` varchar(200) NOT NULL COMMENT '缩略图50x50',
  `pic80` varchar(200) NOT NULL COMMENT '缩略图80x80',
  `pic200` varchar(200) NOT NULL COMMENT '缩略图200x200'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `z_film_cate`
--

INSERT INTO `z_film_cate` (`cid`, `name`, `ename`, `pid`, `description`, `pic`, `pic50`, `pic80`, `pic200`) VALUES
(1, '恐怖片', 'Dracula', 0, '恐怖系列', '/www/Industry/Public/Uploads/FilmCategoryImage/20161026/5810434dc9c80.jpg', '/www/Industry/Public/Uploads/FilmCategoryImage/20161026/5810434dc9c80X50.jpg', '/www/Industry/Public/Uploads/FilmCategoryImage/20161026/5810434dc9c80X80.jpg', '/www/Industry/Public/Uploads/FilmCategoryImage/20161026/5810434dc9c80X200.jpg'),
(3, '喜剧片', 'Happy', 0, '', '/www/Industry/Public/Uploads/FilmCategoryImage/20161025/580f4709a4a3c.jpg', '/www/Industry/Public/Uploads/FilmCategoryImage/20161025/580f4709a4a3cX50.jpg', '/www/Industry/Public/Uploads/FilmCategoryImage/20161025/580f4709a4a3cX80.jpg', '/www/Industry/Public/Uploads/FilmCategoryImage/20161025/580f4709a4a3cX200.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `z_film_cate`
--
ALTER TABLE `z_film_cate`
  ADD PRIMARY KEY (`cid`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `z_film_cate`
--
ALTER TABLE `z_film_cate`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT COMMENT '电影分类ID', AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
