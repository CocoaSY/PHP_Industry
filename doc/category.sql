-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2016-10-31 17:09:31
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
-- 表的结构 `z_category`
--
DROP TABLE IF EXISTS `z_category`;
CREATE TABLE `z_category` (
  `cid` int(11) NOT NULL COMMENT '栏目ID',
  `name` varchar(20) NOT NULL COMMENT '栏目名称',
  `ename` varchar(20) NOT NULL COMMENT '栏目英文名称',
  `pic` varchar(200) NOT NULL COMMENT '栏目图片',
  `keywords` varchar(200) NOT NULL COMMENT '栏目关键词',
  `description` text NOT NULL COMMENT '栏目描述',
  `nav` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否作为导航',
  `type` tinyint(5) NOT NULL COMMENT '栏目类型',
  `pid` int(5) NOT NULL DEFAULT '0' COMMENT '父级栏目',
  `content` text NOT NULL COMMENT '栏目内容'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `z_category`
--

INSERT INTO `z_category` (`cid`, `name`, `ename`, `pic`, `keywords`, `description`, `nav`, `type`, `pid`, `content`) VALUES
(1, '关于我们', 'ABOUT US', '/www/PHP_Industry/Public/Uploads/CategoryImage/20161028/581351f913b7e.jpg', '', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolores quae porro consequatur aliquam, incidunt', 1, 2, 0, '&amp;lt;h3&amp;gt;Lorem Ipsum Dolor sit&amp;lt;/h3&amp;gt;&amp;lt;p&amp;gt;Sed ut perspiciaatis unde omnis iste \r\nnatus error sit voluptatem accusantium doloremque laudantium, totam rem \r\naperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto\r\n beatae vitae dicta sunt explicabo. Vivamus suscipit tortor eget felis \r\nporttitor volutpat. Cras ultricies ligula sed magna dictum porta. Mauris\r\n blandit aliquet elit, eget tincidunt nibh pulvinar.&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;Sed ut perspiciaatis unde omnis iste \r\nnatus error sit voluptatem accusantium doloremque laudantium, totam rem \r\naperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto\r\n beatae vitae dicta sunt explicabo..&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;Sed ut perspiciaatis unde omnis iste \r\nnatus error sit voluptatem accusantium doloremque laudantium, totam rem \r\naperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto\r\n beatae vitae dicta sunt explicabo..&amp;lt;/p&amp;gt;'),
(2, '服务', 'SERVICE', '/www/Industry/Public/Uploads2016-10-08/57f7cb57e2184.jpg', '', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolores quae porro consequatur aliquam, incidunt eius magni provident, doloribus omnis minus ovident, doloribus omnis minus temporibus perferendis nesciunt..', 1, 1, 0, '&lt;h3&gt;Voluptatem Accusantium Doloremque&lt;/h3&gt;&lt;p&gt;Sed ut perspiciaatis unde omnis iste natus error sit \r\nvoluptatem accusantium doloremque laudantium, totam rem aperiam, eaque \r\nipsa quae ab illo inventore veritatis et quasi architecto beatae vitae \r\ndicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas&lt;/p&gt;&lt;p&gt;Sed ut perspiciaatis unde omnis \r\niste natus error sit voluptatem accusantium doloremque laudantium, totam\r\n rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi \r\narchitecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem\r\n quia voluptas&lt;/p&gt;'),
(3, '代表作品集', 'Portfolio', '/www/Industry/Public/Uploads2016-10-08/57f7cb6e0eb50.jpg', '', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolores quae porro consequatur aliquam, incidunt', 1, 3, 0, '&lt;h3&gt;Voluptatem Accusantium Doloremque&lt;/h3&gt;&lt;p&gt;Sed ut perspiciaatis unde omnis iste natus error sit \r\nvoluptatem accusantium doloremque laudantium, totam rem aperiam, eaque \r\nipsa quae ab illo inventore veritatis et quasi architecto beatae vitae \r\ndicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas&lt;/p&gt;&lt;p&gt;Sed ut perspiciaatis unde omnis \r\niste natus error sit voluptatem accusantium doloremque laudantium, totam\r\n rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi \r\narchitecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem\r\n quia voluptas&lt;/p&gt;'),
(4, '价格', 'Pricing', '/www/Industry/Public/Uploads2016-10-08/57f7cb8b12775.png', '', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolores quae porro consequatur aliquam, incidunt', 1, 1, 0, '&lt;h3&gt;Voluptatem Accusantium Doloremque&lt;/h3&gt;&lt;p&gt;Sed ut perspiciaatis unde omnis iste natus error sit \r\nvoluptatem accusantium doloremque laudantium, totam rem aperiam, eaque \r\nipsa quae ab illo inventore veritatis et quasi architecto beatae vitae \r\ndicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas&lt;/p&gt;&lt;p&gt;Sed ut perspiciaatis unde omnis \r\niste natus error sit voluptatem accusantium doloremque laudantium, totam\r\n rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi \r\narchitecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem\r\n quia voluptas&lt;/p&gt;'),
(5, '联系我们', 'CONTACT', '/www/Industry/Public/Uploads2016-10-08/57f7cb9db1573.jpg', '', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do tempor.', 1, 4, 0, '&lt;h3&gt;Voluptatem Accusantium Doloremque&lt;/h3&gt;&lt;p&gt;Sed ut perspiciaatis unde omnis iste natus error sit \r\nvoluptatem accusantium doloremque laudantium, totam rem aperiam, eaque \r\nipsa quae ab illo inventore veritatis et quasi architecto beatae vitae \r\ndicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas&lt;/p&gt;&lt;p&gt;Sed ut perspiciaatis unde omnis \r\niste natus error sit voluptatem accusantium doloremque laudantium, totam\r\n rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi \r\narchitecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem\r\n quia voluptas&lt;/p&gt;'),
(6, '企业新闻', 'Industry News', '/www/PHP_Industry/Public/Uploads/CategoryImage/20161028/5813522560b0d.jpg', '', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolores quae porro consequatur aliquam, incidunt', 0, 1, 0, ''),
(7, '我们的组织', 'Our Organization', '/www/PHP_Industry/Public/Uploads/CategoryImage/20161028/58135289c566c.jpg', '', 'Curabitur aliquet quam id dui posuere blandit. Donec sollicitudin molestie malesuada Pellentesque &amp;lt;br&amp;gt;ipsum id orci porta dapibus. Vivamus suscipit tortor eget felis porttitor volutpat.', 0, 2, 0, ''),
(11, '公司', 'COMPANY', '/www/PHP_Industry/Public/Uploads/CategoryImage/20161028/5813520794fdf.jpg', '', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolores quae porro consequatur aliquam, incidunt', 0, 2, 1, '&amp;lt;h3&amp;gt;Lorem Ipsum Dolor sit&amp;lt;/h3&amp;gt;&amp;lt;p&amp;gt;Sed ut perspiciaatis unde omnis iste \r\nnatus error sit voluptatem accusantium doloremque laudantium, totam rem \r\naperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto\r\n beatae vitae dicta sunt explicabo. Vivamus suscipit tortor eget felis \r\nporttitor volutpat. Cras ultricies ligula sed magna dictum porta. Mauris\r\n blandit aliquet elit, eget tincidunt nibh pulvinar.&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;Sed ut perspiciaatis unde omnis iste \r\nnatus error sit voluptatem accusantium doloremque laudantium, totam rem \r\naperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto\r\n beatae vitae dicta sunt explicabo..&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;&amp;lt;br/&amp;gt;&amp;lt;/p&amp;gt;'),
(12, '团队', 'OUR TEAM', '/www/PHP_Industry/Public/Uploads/CategoryImage/20161028/581352152ded2.jpg', '', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolores quae porro consequatur aliquam, incidunt', 0, 1, 1, '&amp;lt;p&amp;gt; \r\n							&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;&amp;lt;br/&amp;gt;&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;&amp;lt;br/&amp;gt;&amp;lt;/p&amp;gt;&amp;lt;h3&amp;gt;Voluptatem Accusantium Doloremque&amp;lt;/h3&amp;gt;&amp;lt;p&amp;gt;&amp;lt;br/&amp;gt;&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;Sed ut perspiciaatis unde omnis iste natus error sit \r\nvoluptatem accusantium doloremque laudantium, totam rem aperiam, eaque \r\nipsa quae ab illo inventore veritatis et quasi architecto beatae vitae \r\ndicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;&amp;amp;nbsp; &amp;amp;nbsp; &amp;amp;nbsp; &amp;amp;nbsp; &amp;amp;nbsp; &amp;amp;nbsp; &amp;amp;nbsp; &amp;amp;nbsp; &amp;amp;nbsp; &amp;amp;nbsp; &amp;amp;nbsp; &amp;amp;nbsp; &amp;amp;nbsp; &amp;amp;nbsp; &amp;amp;nbsp; &amp;amp;nbsp; &amp;amp;nbsp; &amp;amp;nbsp;	&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;Sed ut perspiciaatis unde omnis \r\niste natus error sit voluptatem accusantium doloremque laudantium, totam\r\n rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi \r\narchitecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem\r\n quia voluptas&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;&amp;lt;br/&amp;gt;&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;&amp;amp;nbsp;							&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;&amp;lt;br/&amp;gt;&amp;lt;/p&amp;gt;&amp;lt;p&amp;gt;&amp;lt;br/&amp;gt;&amp;lt;/p&amp;gt;'),
(13, '新闻', 'NEWS', '/www/Industry/Public/Uploads2016-10-08/57f7cb3a6c419.jpg', '', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolores quae porro consequatur aliquam, incidunt', 0, 1, 1, '&lt;p&gt; \r\n							&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;h3&gt;Voluptatem Accusantium Doloremque&lt;/h3&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;Sed ut perspiciaatis unde omnis iste natus error sit \r\nvoluptatem accusantium doloremque laudantium, totam rem aperiam, eaque \r\nipsa quae ab illo inventore veritatis et quasi architecto beatae vitae \r\ndicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas&lt;/p&gt;&lt;p&gt;&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;	&lt;/p&gt;&lt;p&gt;Sed ut perspiciaatis unde omnis \r\niste natus error sit voluptatem accusantium doloremque laudantium, totam\r\n rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi \r\narchitecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem\r\n quia voluptas&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;&amp;nbsp;							&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;'),
(14, '投资者', 'INVESTORS', '/www/Industry/Public/Uploads2016-10-08/57f7cb4be9662.jpg', '', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolores quae porro consequatur aliquam, incidunt', 0, 1, 1, '&lt;p&gt; \r\n							&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;h3&gt;Voluptatem Accusantium Doloremque&lt;/h3&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;Sed ut perspiciaatis unde omnis iste natus error sit \r\nvoluptatem accusantium doloremque laudantium, totam rem aperiam, eaque \r\nipsa quae ab illo inventore veritatis et quasi architecto beatae vitae \r\ndicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas&lt;/p&gt;&lt;p&gt;&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;	&lt;/p&gt;&lt;p&gt;Sed ut perspiciaatis unde omnis \r\niste natus error sit voluptatem accusantium doloremque laudantium, totam\r\n rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi \r\narchitecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem\r\n quia voluptas&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;&amp;nbsp;							&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;'),
(61, '程序', 'Programes', '/www/PHP_Industry/Public/Uploads/CategoryImage/20161028/581352526ebb9.jpg', '', 'Sed ut perspiciaatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium', 0, 2, 6, '&amp;lt;p&amp;gt;Sed ut perspiciaatis unde omnis iste natus error sit voluptatem \r\naccusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab\r\n illo inventore veritatis et quasi architecto beatae vitae dicta sunt \r\nexplicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur. &amp;lt;br/&amp;gt;&amp;lt;br/&amp;gt;Sed ut perspiciaatis iste natus error sit voluptatem probably haven&amp;amp;#39;t heard of them accusamus.&amp;lt;/p&amp;gt;'),
(62, '最近新闻', 'Latest News', '/www/PHP_Industry/Public/Uploads/CategoryImage/20161028/58135263d709a.jpg', '', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolores quae porro consequatur aliquam, incidunt', 0, 1, 6, ''),
(63, '获奖', 'Testimonials', '/www/Industry/Public/Uploads2016-10-07/57f6811071892.jpg', '', 'Lorem ipsum dolor met consectetur adipisicing. Aorem psum dolor met consectetur adipisicing sit amet, consectetur adipisicing elit, of them jean shorts sed magna aliqua. Lorem ipsum dolor met.', 0, 2, 6, '&lt;p&gt;&lt;span class=&quot;testimonials-name&quot;&gt;Marc Cooper&lt;/span&gt;&lt;/p&gt;&lt;p&gt;Technical Director&lt;br/&gt;&lt;/p&gt;'),
(64, '新技术', 'New Technolege', '/www/PHP_Industry/Public/Uploads/CategoryImage/20161028/5813527a2438a.jpg', '', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolores quae porro consequatur aliquam, incidunt', 0, 2, 6, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `z_category`
--
ALTER TABLE `z_category`
  ADD PRIMARY KEY (`cid`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `z_category`
--
ALTER TABLE `z_category`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT COMMENT '栏目ID', AUTO_INCREMENT=65;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
