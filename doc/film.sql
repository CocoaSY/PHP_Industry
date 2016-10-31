-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2016-10-31 16:55:06
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
-- 表的结构 `z_film`
--
DROP TABLE IF EXISTS `z_film`;
CREATE TABLE `z_film` (
  `fid` int(11) NOT NULL COMMENT '电影ID',
  `cid` int(11) NOT NULL COMMENT '电影分类',
  `name` varchar(20) NOT NULL COMMENT '电影名称',
  `ename` varchar(20) NOT NULL COMMENT '英文名称',
  `description` text NOT NULL COMMENT '描述',
  `video` int(11) NOT NULL COMMENT '播放源',
  `pic` varchar(200) NOT NULL COMMENT '电影图片',
  `pic50` varchar(200) NOT NULL COMMENT '缩略图50x50',
  `pic80` varchar(200) NOT NULL COMMENT '缩略图80x80',
  `pic200` varchar(200) NOT NULL COMMENT '缩略图200x200'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `z_film`
--

INSERT INTO `z_film` (`fid`, `cid`, `name`, `ename`, `description`, `video`, `pic`, `pic50`, `pic80`, `pic200`) VALUES
(1, 1, '123', '123', '123', 26, '/www/PHP_Industry/Public/Uploads/FilmImage/20161029/581467a1aa9e8.jpg', '/www/PHP_Industry/Public/Uploads/FilmImage/20161029/581467a1aa9e8X50.jpg', '/www/PHP_Industry/Public/Uploads/FilmImage/20161029/581467a1aa9e8X80.jpg', '/www/PHP_Industry/Public/Uploads/FilmImage/20161029/581467a1aa9e8X200.jpg'),
(2, 3, '1234', '1234', '1234', 27, '/www/PHP_Industry/Public/Uploads/FilmImage/20161029/581467bc81785.jpg', '/www/PHP_Industry/Public/Uploads/FilmImage/20161029/581467bc81785X50.jpg', '/www/PHP_Industry/Public/Uploads/FilmImage/20161029/581467bc81785X80.jpg', '/www/PHP_Industry/Public/Uploads/FilmImage/20161029/581467bc81785X200.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `z_film`
--
ALTER TABLE `z_film`
  ADD PRIMARY KEY (`fid`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `z_film`
--
ALTER TABLE `z_film`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT COMMENT '电影ID', AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
