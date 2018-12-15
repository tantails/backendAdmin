-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- 主機: 127.0.0.1
-- 產生時間： 2018-12-15 09:55:26
-- 伺服器版本: 10.1.36-MariaDB
-- PHP 版本： 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `backendadmin`
--

-- --------------------------------------------------------

--
-- 資料表結構 `identity`
--

CREATE TABLE `identity` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 資料表的匯出資料 `identity`
--

INSERT INTO `identity` (`id`, `name`) VALUES
(1, '學生'),
(2, '社會人士'),
(3, '公務員');

-- --------------------------------------------------------

--
-- 資料表結構 `page`
--

CREATE TABLE `page` (
  `no` int(11) NOT NULL,
  `id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pgroup` int(11) NOT NULL,
  `guest` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '前後台'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 資料表的匯出資料 `page`
--

INSERT INTO `page` (`no`, `id`, `title`, `path`, `pgroup`, `guest`, `type`) VALUES
(1, 'useradmin', '使用者管理', 'user_admin.php', 1, 0, 0),
(8, 'pageadmin', '頁面管理', 'admin_pageadmin.php', 1, 0, 0),
(37, 'back_home', 'BACKEND_DEFAUFT', 'back_home.php', 0, 0, 0),
(47, 'home', 'FRONTEND_DEFAULT', 'index.php', 0, 1, 1),
(54, 'login', 'LOGIN', 'user_login.php', 0, 1, 1),
(55, 'forget', 'FORGET', 'user_forget.php', 0, 1, 1),
(56, 'reg', 'REG', 'user_reg.php', 0, 1, 1),
(57, 'front_home', 'FRONT_HOME', 'front_home.php', 0, 1, 1);

-- --------------------------------------------------------

--
-- 資料表結構 `page_group`
--

CREATE TABLE `page_group` (
  `no` int(11) NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 資料表的匯出資料 `page_group`
--

INSERT INTO `page_group` (`no`, `name`) VALUES
(1, '後台頁面'),
(8, '測試空群組1'),
(12, '測試空群組2');

-- --------------------------------------------------------

--
-- 資料表結構 `site_info`
--

CREATE TABLE `site_info` (
  `no` int(11) NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 資料表的匯出資料 `site_info`
--

INSERT INTO `site_info` (`no`, `name`, `value`) VALUES
(1, 'title', 'BackendAdmin'),
(2, 'test', 'testv'),
(3, 'sitename', 'SITE_NAME');

-- --------------------------------------------------------

--
-- 資料表結構 `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `acc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pw` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthday` date NOT NULL,
  `tel` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `addr` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `identity` int(2) UNSIGNED NOT NULL,
  `avatar` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar_small` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `permission` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ugroup` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 資料表的匯出資料 `user`
--

INSERT INTO `user` (`id`, `acc`, `pw`, `email`, `name`, `birthday`, `tel`, `addr`, `identity`, `avatar`, `avatar_small`, `permission`, `ugroup`) VALUES
(1, 'admin', '1234', 'admin1@ma.il', 'admin.name', '0000-00-00', '0000011111', 'admin.addr', 1, '', '', 'a:8:{s:9:\"useradmin\";i:1;s:9:\"pageadmin\";i:1;s:9:\"back_home\";i:1;s:4:\"home\";i:1;s:5:\"login\";i:1;s:6:\"forget\";i:1;s:3:\"reg\";i:1;s:10:\"front_home\";i:1;}', 0),
(35, 'demo', 'demo', 'demo@ema.il', 'demo', '2018-11-14', '000002', '新北市demo address', 1, '', '', 'a:2:{s:9:\"back_home\";i:1;s:4:\"home\";i:1;}', 0);

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `identity`
--
ALTER TABLE `identity`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`no`);

--
-- 資料表索引 `page_group`
--
ALTER TABLE `page_group`
  ADD PRIMARY KEY (`no`);

--
-- 資料表索引 `site_info`
--
ALTER TABLE `site_info`
  ADD PRIMARY KEY (`no`);

--
-- 資料表索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `identity`
--
ALTER TABLE `identity`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用資料表 AUTO_INCREMENT `page`
--
ALTER TABLE `page`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- 使用資料表 AUTO_INCREMENT `page_group`
--
ALTER TABLE `page_group`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- 使用資料表 AUTO_INCREMENT `site_info`
--
ALTER TABLE `site_info`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用資料表 AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
