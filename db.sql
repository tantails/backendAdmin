-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- 主機: 127.0.0.1
-- 產生時間： 2018-12-15 05:37:13
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
-- 資料庫： `ch10_lingwei`
--
CREATE DATABASE IF NOT EXISTS `ch10_lingwei` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `ch10_lingwei`;

-- --------------------------------------------------------

--
-- 資料表結構 `acc_item`
--

CREATE TABLE `acc_item` (
  `no` int(10) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 資料表新增前先清除舊資料 `acc_item`
--

TRUNCATE TABLE `acc_item`;
--
-- 資料表的匯出資料 `acc_item`
--

INSERT INTO `acc_item` (`no`, `name`) VALUES
(1, '早餐'),
(2, '午餐'),
(4, '晚餐'),
(5, '下午茶'),
(6, '測試空項目1'),
(7, '測試空項目2'),
(11, '測試空項目3');

-- --------------------------------------------------------

--
-- 資料表結構 `identity`
--

CREATE TABLE `identity` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 資料表新增前先清除舊資料 `identity`
--

TRUNCATE TABLE `identity`;
--
-- 資料表的匯出資料 `identity`
--

INSERT INTO `identity` (`id`, `name`) VALUES
(1, '學生'),
(2, '社會人士'),
(3, '公務員');

-- --------------------------------------------------------

--
-- 資料表結構 `invoice`
--

CREATE TABLE `invoice` (
  `no` int(11) NOT NULL,
  `num` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateY` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateM` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `result` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 資料表新增前先清除舊資料 `invoice`
--

TRUNCATE TABLE `invoice`;
--
-- 資料表的匯出資料 `invoice`
--

INSERT INTO `invoice` (`no`, `num`, `dateY`, `dateM`, `result`) VALUES
(1, 'HN96363025', '2018', '9', 9),
(2, 'AB69095110', '2018', '9', 10),
(3, 'CD96745865', '2018', '9', 8),
(4, 'EF06745865', '2018', '9', 7),
(5, 'GH00745865', '2018', '9', 6),
(6, 'IJ00045865', '2018', '9', 5),
(7, 'KL00005865', '2018', '9', 4),
(8, 'MN00000865', '2018', '9', 3),
(9, 'OP00000065', '2018', '9', 11),
(10, 'QR00000292', '2018', '9', 2),
(11, 'ST00000650', '2018', '9', 2),
(12, 'UV00000230', '2018', '9', 2),
(13, 'UV00000231', '2018', '12', 0);

-- --------------------------------------------------------

--
-- 資料表結構 `invoice_prize`
--

CREATE TABLE `invoice_prize` (
  `no` int(11) NOT NULL,
  `date` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `prize` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 資料表新增前先清除舊資料 `invoice_prize`
--

TRUNCATE TABLE `invoice_prize`;
--
-- 資料表的匯出資料 `invoice_prize`
--

INSERT INTO `invoice_prize` (`no`, `date`, `prize`) VALUES
(7, '10709', 'a:3:{s:4:\"spec\";a:2:{i:0;s:8:\"96363025\";i:1;s:8:\"69095110\";}s:5:\"prize\";a:3:{i:0;s:8:\"96745865\";i:1;s:8:\"98829035\";i:2;s:8:\"45984442\";}s:6:\"prize6\";a:3:{i:0;s:3:\"292\";i:1;s:3:\"650\";i:2;s:3:\"230\";}}'),
(8, '10707', 'a:3:{s:4:\"spec\";a:2:{i:0;s:8:\"73372972\";i:1;s:8:\"22315462\";}s:5:\"prize\";a:3:{i:0;s:8:\"91903003\";i:1;s:8:\"16228722\";i:2;s:8:\"03270598\";}s:6:\"prize6\";a:3:{i:0;s:3:\"163\";i:1;s:3:\"983\";i:2;s:3:\"814\";}}'),
(10, '10711', 'a:3:{s:4:\"spec\";a:0:{}s:5:\"prize\";a:0:{}s:6:\"prize6\";a:0:{}}'),
(11, '10705', 'a:3:{s:4:\"spec\";a:2:{i:0;s:8:\"20048019\";i:1;s:8:\"02142605\";}s:5:\"prize\";a:3:{i:0;s:8:\"21240109\";i:1;s:8:\"78323535\";i:2;s:8:\"18549847\";}s:6:\"prize6\";a:0:{}}');

-- --------------------------------------------------------

--
-- 資料表結構 `journal`
--

CREATE TABLE `journal` (
  `no` int(10) UNSIGNED NOT NULL,
  `item` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `pay` int(10) NOT NULL,
  `member` int(3) NOT NULL,
  `payment` int(3) NOT NULL,
  `project` int(5) UNSIGNED NOT NULL,
  `store` int(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 資料表新增前先清除舊資料 `journal`
--

TRUNCATE TABLE `journal`;
--
-- 資料表的匯出資料 `journal`
--

INSERT INTO `journal` (`no`, `item`, `date`, `pay`, `member`, `payment`, `project`, `store`) VALUES
(2, '2', '2018-11-07 02:37:19', 2001, 30, 2, 8, 6),
(3, '1', '2018-11-08 02:37:25', 2001, 29, 1, 2, 5),
(5, '4', '2018-11-07 02:40:18', 500, 30, 2, 3, 6),
(6, '1', '2018-11-08 06:10:37', 11111, 29, 1, 2, 5),
(7, '2', '2018-11-07 06:10:45', 12000, 29, 2, 4, 5),
(8, '2', '2018-11-07 06:10:45', 11112, 29, 1, 3, 6),
(9, '1', '2018-11-14 06:11:27', 2000, 30, 1, 2, 6),
(10, '1', '2018-11-14 06:11:43', 2003, 29, 1, 2, 5),
(11, '1', '2018-11-14 06:11:55', 3500, 29, 1, 3, 6),
(16, '1', '2018-11-15 06:19:12', 2000, 29, 1, 2, 5),
(17, '1', '2018-12-14 06:19:27', 3000, 29, 1, 3, 6),
(18, '1', '2018-12-15 06:19:46', 3500, 29, 1, 2, 5),
(19, '1', '2018-12-25 06:20:03', 3999, 29, 1, 2, 5),
(20, '1', '2019-01-14 07:21:04', 5000, 29, 1, 2, 6),
(21, '1', '2019-01-30 07:21:26', 3500, 29, 1, 2, 5),
(22, '1', '2018-11-15 08:59:02', 1120, 29, 1, 2, 5),
(23, '5', '2018-11-16 04:33:15', 2000, 30, 1, 2, 5),
(24, '1', '2018-12-02 21:02:09', 1203, 30, 1, 2, 5),
(25, '1', '2018-12-10 08:37:46', 20000, 30, 1, 2, 5),
(26, '1', '2018-12-10 08:38:07', 20000, 30, 1, 2, 5);

-- --------------------------------------------------------

--
-- 資料表結構 `member`
--

CREATE TABLE `member` (
  `no` int(10) UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthday` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 資料表新增前先清除舊資料 `member`
--

TRUNCATE TABLE `member`;
--
-- 資料表的匯出資料 `member`
--

INSERT INTO `member` (`no`, `title`, `name`, `birthday`) VALUES
(29, '爸爸', '陳先生', '1970-03-06'),
(30, '媽媽', '王小姐', '1971-06-03'),
(31, '測試', '測試空白成員1', '2018-11-01'),
(32, '測試2', '測試空白成員2', '2018-12-08'),
(33, '測試3', '測試空白成員3', '2018-12-12'),
(34, '測試5', '測試空白成員5', '2018-12-19');

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
-- 資料表新增前先清除舊資料 `page`
--

TRUNCATE TABLE `page`;
--
-- 資料表的匯出資料 `page`
--

INSERT INTO `page` (`no`, `id`, `title`, `path`, `pgroup`, `guest`, `type`) VALUES
(1, 'useradmin', '使用者管理', 'user_admin.php', 1, 0, 0),
(2, 'acc_itemadmin', '記帳項目', 'acc_item.php', 2, 0, 0),
(3, 'acc_memberadmin', '成員管理', 'acc_member.php', 2, 0, 0),
(4, 'acc_storeadmin', '店家管理', 'acc_store.php', 2, 0, 0),
(5, 'acc_projectadmin', '專案管理', 'acc_project.php', 2, 0, 0),
(6, 'acc_paymentadmin', '付款方式', 'acc_payment.php', 2, 0, 0),
(7, 'acc_recordadmin', '帳務管理', 'acc_record.php', 2, 0, 0),
(8, 'pageadmin', '頁面管理', 'admin_pageadmin.php', 1, 0, 0),
(9, 'invoiceadmin', '發票兌獎', 'class_invoice.php', 3, 1, 1),
(34, 'csstest', 'CSS', 'class_test_css.php', 3, 1, 1),
(35, 'javascript', 'JAVASCRIPT', 'class_test_javascript.php', 3, 1, 1),
(36, 'store_slideadmin', '輪播圖片管理', 'store_slideadmin.php', 4, 0, 0),
(37, 'back_home', 'BACKEND_DEFAUFT', 'back_home.php', 0, 0, 0),
(38, 'store_itemadmin', '商品及商品分類管理', 'store_itemadmin.php', 4, 0, 0),
(39, 'store_shopping', '購物頁面', 'store_shopping.php', 4, 1, 1),
(40, 'flipcard', '翻牌遊戲JS', 'class_js_flipcard.php', 3, 1, 1),
(41, 'acc_home', '帳務首頁', 'acc_frontend.php', 2, 1, 1),
(42, 'acc_add', '增加紀錄', 'acc_add_recoard.php', 2, 0, 1),
(43, 'acc_static', '統計分析', 'acc_static.php', 2, 1, 1),
(44, 'acc_daily', '日明細', 'acc_detail.php', 2, 1, 1),
(45, 'acc_weekly', '周明細', 'acc_detail.php', 2, 1, 1),
(46, 'acc_monthly', '月明細', 'acc_detail.php', 2, 1, 1),
(47, 'home', 'FRONTEND_DEFAULT', 'index.php', 0, 1, 1),
(50, 'store_orderadmin', '訂單管理', 'store_orderadmin.php', 4, 0, 1),
(53, 'note', 'NOTE', 'file/page/note.php', 3, 1, 1),
(54, 'login', 'LOGIN', 'user_login.php', 0, 1, 1),
(55, 'forget', 'FORGET', 'user_forget.php', 0, 1, 1),
(56, 'reg', 'REG', 'user_reg.php', 0, 1, 1);

-- --------------------------------------------------------

--
-- 資料表結構 `page_group`
--

CREATE TABLE `page_group` (
  `no` int(11) NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 資料表新增前先清除舊資料 `page_group`
--

TRUNCATE TABLE `page_group`;
--
-- 資料表的匯出資料 `page_group`
--

INSERT INTO `page_group` (`no`, `name`) VALUES
(1, '後台頁面'),
(2, '帳務頁面'),
(3, '上課內容'),
(4, '精品電子商務'),
(7, '書曼的旅遊相簿'),
(8, '測試空群組1'),
(12, '測試空群組2'),
(13, '測試空群組2');

-- --------------------------------------------------------

--
-- 資料表結構 `payment`
--

CREATE TABLE `payment` (
  `no` int(3) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `amout` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 資料表新增前先清除舊資料 `payment`
--

TRUNCATE TABLE `payment`;
--
-- 資料表的匯出資料 `payment`
--

INSERT INTO `payment` (`no`, `name`, `amout`) VALUES
(1, '現金', 30000),
(2, '信用卡', 50000),
(3, '其他', 3006),
(4, '測試空付款方式', 25000),
(5, '測試空付款方式2', 0);

-- --------------------------------------------------------

--
-- 資料表結構 `project`
--

CREATE TABLE `project` (
  `no` int(10) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `master` int(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 資料表新增前先清除舊資料 `project`
--

TRUNCATE TABLE `project`;
--
-- 資料表的匯出資料 `project`
--

INSERT INTO `project` (`no`, `name`, `master`) VALUES
(2, '測試專案1', 30),
(3, '測試專案2', 29),
(4, '測試專案3', 30),
(8, '測試專案4', 29),
(9, '測試空專案5', 29),
(12, '測試空專案6', 30);

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
-- 資料表新增前先清除舊資料 `site_info`
--

TRUNCATE TABLE `site_info`;
--
-- 資料表的匯出資料 `site_info`
--

INSERT INTO `site_info` (`no`, `name`, `value`) VALUES
(1, 'title', 'BackendAdmin'),
(2, 'test', 'testv'),
(3, 'sitename', 'SITE_NAME');

-- --------------------------------------------------------

--
-- 資料表結構 `store`
--

CREATE TABLE `store` (
  `no` int(10) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `boss` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 資料表新增前先清除舊資料 `store`
--

TRUNCATE TABLE `store`;
--
-- 資料表的匯出資料 `store`
--

INSERT INTO `store` (`no`, `name`, `address`, `boss`, `tel`) VALUES
(5, '麥當勞', '店家地址1', '老闆1', '0100000000'),
(6, '家樂福', '店家地址2', '老闆2', '0200000000'),
(7, '測試空店家1', '', '', ''),
(8, '測試空店家2', '', '', '');

-- --------------------------------------------------------

--
-- 資料表結構 `store_item`
--

CREATE TABLE `store_item` (
  `no` int(11) NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ingroup` int(11) NOT NULL,
  `path` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `spec` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock` int(11) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `itemno` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 資料表新增前先清除舊資料 `store_item`
--

TRUNCATE TABLE `store_item`;
--
-- 資料表的匯出資料 `store_item`
--

INSERT INTO `store_item` (`no`, `name`, `ingroup`, `path`, `price`, `spec`, `stock`, `description`, `status`, `itemno`) VALUES
(1, '超薄設計男士長款真皮', 6, 'file/store/0405.jpg', 800, 'L號', 61, '基本:編織皮革對摺長款零錢包\r\n特色:最潮流最時尚的單品 \r\n顏色:黑色珠光面皮(黑色縫線)\r\n形狀:黑白格編織皮革對摺', 1, '00100601'),
(3, '手工訂製長夾', 6, 'file/store/0403.jpg', 1200, '全牛皮', 2, '手工製作長夾卡片層6*2 鈔票層 *2 零錢拉鍊層 *1 \r\n採用愛馬仕相同的雙針縫法,皮件堅固耐用不脫線 \r\n材質:直革鞣(馬鞍皮)牛皮製作  \r\n手工染色', 1, '00100603'),
(4, '測試商品1', 12, 'file/store/1543638027.JPG', 888, 'S', 15, '測試商品說明1', 0, '00901204'),
(5, '經典牛皮少女帆船鞋', 7, 'file/store/0406.jpg', 1000, 'S號', 6, '以傳統學院派風格聞名，創始近百年工藝製鞋精神\r\n共用獨家專利氣墊技術，兼具紐約工藝精神，與舒適跑格靈魂', 1, '00200705'),
(6, '經典優雅時尚流行涼鞋', 8, 'file/store/0407.jpg', 2650, 'LL', 8, '優雅流線方型楦頭設計，結合簡潔線條綴飾，\r\n獨特的弧度與曲線美，突顯年輕優雅品味，\r\n是年輕上班族不可或缺的鞋款！\r\n全新美國運回，現貨附鞋盒', 1, '00200806'),
(7, '寵愛天然藍寶女戒', 10, 'file/store/0408.jpg', 28000, '1克拉', 1, '◎典雅設計品味款\r\n◎藍寶為珍貴天然寶石之一，具有保值收藏\r\n◎專人設計製造，以貴重珠寶精緻鑲工製造', 1, '00301007'),
(8, '反折式大容量手提肩背包', 14, 'file/store/0409.jpg', 888, 'L號', 15, '特色:反折式的包口設計,釘釦的裝飾,讓簡單的包型更增添趣味性\r\n材質:棉布\r\n顏色:藍色\r\n尺寸:長50cm寬20cm高41cm\r\n產地:日本', 1, '00401408'),
(9, '男單肩包男', 14, 'file/store/0410.jpg', 650, '多功能', 7, '特色:男單肩包/電腦包/公文包/雙肩背包多用途\r\n材質:帆不\r\n顏色:黑色\r\n尺寸:深11cm寬42cm高33cm\r\n產地:香港', 1, '00401409'),
(10, '測試商品2', 12, '', 999, 'XL', 10, '測試商品說明2', 0, '009012010'),
(17, '測試商品8', 13, '', 0, '', 0, '', 0, '009013017'),
(18, '測試商品9', 13, '', 0, '', 0, '', 0, '009013018'),
(19, '兩用式磁扣腰包', 6, 'file/store/0404.jpg', 685, '中型', 18, '材質:進口牛皮\r\n顏色:黑色荔枝紋+黑色珠光面皮(黑色縫線)\r\n尺寸:15cm*14cm(高)*6cm(前後)\r\n產地:臺灣', 1, '001006019'),
(20, '測試商品10', 13, '', 500, '中型', 0, '', 0, '009013020');

-- --------------------------------------------------------

--
-- 資料表結構 `store_itemgroup`
--

CREATE TABLE `store_itemgroup` (
  `no` int(11) NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ingroup` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 資料表新增前先清除舊資料 `store_itemgroup`
--

TRUNCATE TABLE `store_itemgroup`;
--
-- 資料表的匯出資料 `store_itemgroup`
--

INSERT INTO `store_itemgroup` (`no`, `name`, `ingroup`) VALUES
(1, '流行皮件', 0),
(2, '流行鞋區', 0),
(3, '流行飾品', 0),
(4, '背包', 0),
(5, '女用皮件', 1),
(6, '男用皮件', 1),
(7, '少女鞋區', 2),
(8, '紳士流行鞋區', 2),
(9, '測試分類', 0),
(10, '時尚珠寶', 3),
(11, '時尚手錶', 3),
(12, '測試子分類A', 9),
(13, '測試子分類B', 9),
(14, '背包', 4);

-- --------------------------------------------------------

--
-- 資料表結構 `store_order`
--

CREATE TABLE `store_order` (
  `no` int(11) NOT NULL,
  `orderno` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` int(11) NOT NULL,
  `acc` int(11) NOT NULL,
  `cartname` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `cartemail` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `cartaddr` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `carttel` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ordertime` datetime NOT NULL,
  `itemlist` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 資料表新增前先清除舊資料 `store_order`
--

TRUNCATE TABLE `store_order`;
--
-- 資料表的匯出資料 `store_order`
--

INSERT INTO `store_order` (`no`, `orderno`, `total`, `acc`, `cartname`, `cartemail`, `cartaddr`, `carttel`, `ordertime`, `itemlist`) VALUES
(8, 'ORD20181210072323', 2000, 1, 'admin.name', 'admin@ma.il', 'admin.addr', '0000011111', '2018-12-10 00:00:00', 'a:2:{i:1;a:4:{s:6:\"itemno\";s:8:\"00100601\";s:4:\"name\";s:30:\"超薄設計男士長款真皮\";s:5:\"price\";s:3:\"800\";s:3:\"num\";s:1:\"1\";}i:3;a:4:{s:6:\"itemno\";s:8:\"00100603\";s:4:\"name\";s:18:\"手工訂製長夾\";s:5:\"price\";s:4:\"1200\";s:3:\"num\";s:1:\"1\";}}'),
(9, 'ORD20181210072503', 29000, 1, 'admin.name', 'admin@ma.il', 'admin.addr', '0000011111', '2018-12-10 07:25:03', 'a:2:{i:5;a:4:{s:6:\"itemno\";s:8:\"00200705\";s:4:\"name\";s:27:\"經典牛皮少女帆船鞋\";s:5:\"price\";s:4:\"1000\";s:3:\"num\";s:1:\"1\";}i:7;a:4:{s:6:\"itemno\";s:8:\"00301007\";s:4:\"name\";s:24:\"寵愛天然藍寶女戒\";s:5:\"price\";s:5:\"28000\";s:3:\"num\";s:1:\"1\";}}'),
(10, 'ORD20181210072513', 29000, 1, 'admin.name', 'admin@ma.il', 'admin.addr', '0000011111', '2018-12-10 07:25:13', 'a:2:{i:5;a:4:{s:6:\"itemno\";s:8:\"00200705\";s:4:\"name\";s:27:\"經典牛皮少女帆船鞋\";s:5:\"price\";s:4:\"1000\";s:3:\"num\";s:1:\"1\";}i:7;a:4:{s:6:\"itemno\";s:8:\"00301007\";s:4:\"name\";s:24:\"寵愛天然藍寶女戒\";s:5:\"price\";s:5:\"28000\";s:3:\"num\";s:1:\"1\";}}'),
(11, 'ORD20181211084316', 1000, 35, 'demo', 'demo@ema.il', '新北市demo address', '000002', '2018-12-11 08:43:16', 'a:1:{i:5;a:4:{s:6:\"itemno\";s:8:\"00200705\";s:4:\"name\";s:27:\"經典牛皮少女帆船鞋\";s:5:\"price\";s:4:\"1000\";s:3:\"num\";s:1:\"1\";}}');

-- --------------------------------------------------------

--
-- 資料表結構 `store_slide`
--

CREATE TABLE `store_slide` (
  `no` int(11) NOT NULL,
  `path` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 資料表新增前先清除舊資料 `store_slide`
--

TRUNCATE TABLE `store_slide`;
--
-- 資料表的匯出資料 `store_slide`
--

INSERT INTO `store_slide` (`no`, `path`) VALUES
(1, 'img/svg.php?w=800&h=400&b=000&c=fff&t=輪播圖片1'),
(2, 'img/svg.php?w=800&h=400&b=ff0&c=000&t=輪播圖片2'),
(3, 'img/svg.php?w=800&h=400&b=0ff&c=000&t=輪播圖片3'),
(4, 'img/svg.php?w=800&h=400&b=f00&t=輪播圖片4'),
(6, 'img/svg.php?w=800&h=400&b=0f0&c=000&t=輪播圖片5'),
(7, 'img/svg.php?w=800&h=400&b=00f&t=輪播圖片6');

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
-- 資料表新增前先清除舊資料 `user`
--

TRUNCATE TABLE `user`;
--
-- 資料表的匯出資料 `user`
--

INSERT INTO `user` (`id`, `acc`, `pw`, `email`, `name`, `birthday`, `tel`, `addr`, `identity`, `avatar`, `avatar_small`, `permission`, `ugroup`) VALUES
(1, 'admin', '1234aa', 'admin1@ma.il', 'admin.name', '0000-00-00', '0000011111', 'admin.addr', 1, '', '', 'a:28:{s:9:\"useradmin\";i:1;s:13:\"acc_itemadmin\";i:1;s:15:\"acc_memberadmin\";i:1;s:14:\"acc_storeadmin\";i:1;s:16:\"acc_projectadmin\";i:1;s:16:\"acc_paymentadmin\";i:1;s:15:\"acc_recordadmin\";i:1;s:9:\"pageadmin\";i:1;s:12:\"invoiceadmin\";i:1;s:7:\"csstest\";i:1;s:10:\"javascript\";i:1;s:16:\"store_slideadmin\";i:1;s:9:\"back_home\";i:1;s:15:\"store_itemadmin\";i:1;s:14:\"store_shopping\";i:1;s:8:\"flipcard\";i:1;s:8:\"acc_home\";i:1;s:7:\"acc_add\";i:1;s:10:\"acc_static\";i:1;s:9:\"acc_daily\";i:1;s:10:\"acc_weekly\";i:1;s:11:\"acc_monthly\";i:1;s:4:\"home\";i:1;s:16:\"store_orderadmin\";i:1;s:4:\"note\";i:1;s:5:\"login\";i:1;s:6:\"forget\";i:1;s:3:\"reg\";i:1;}', 0),
(32, 'accadmin', '1234', 'e@ma.il', 'name09', '2018-11-01', '0200000000', '新北市addr', 1, '1542956919.JPG', '1542956919_icon.JPG', 'a:19:{s:13:\"acc_itemadmin\";i:1;s:15:\"acc_memberadmin\";i:1;s:14:\"acc_storeadmin\";i:1;s:16:\"acc_projectadmin\";i:1;s:16:\"acc_paymentadmin\";i:1;s:15:\"acc_recordadmin\";i:1;s:7:\"csstest\";i:1;s:10:\"javascript\";i:1;s:9:\"back_home\";i:1;s:14:\"store_shopping\";i:1;s:8:\"flipcard\";i:1;s:8:\"acc_home\";i:1;s:7:\"acc_add\";i:1;s:10:\"acc_static\";i:1;s:9:\"acc_daily\";i:1;s:10:\"acc_weekly\";i:1;s:11:\"acc_monthly\";i:1;s:4:\"home\";i:1;s:16:\"store_orderadmin\";i:1;}', 0),
(33, 'storeadmin', '1234', 'e10@ma.il', 'name10', '2018-11-23', '0100000000', '新北市addr', 1, '1542957145.JPG', '1542957145_icon.JPG', 'a:9:{s:12:\"invoiceadmin\";i:1;s:7:\"csstest\";i:1;s:10:\"javascript\";i:1;s:16:\"store_slideadmin\";i:1;s:9:\"back_home\";i:1;s:15:\"store_itemadmin\";i:1;s:14:\"store_shopping\";i:1;s:8:\"flipcard\";i:1;s:4:\"home\";i:1;}', 0),
(35, 'demo', 'demo', 'demo@ema.il', 'demo', '2018-11-14', '000002', '新北市demo address', 1, '', '', 'a:9:{s:9:\"back_home\";i:1;s:14:\"store_shopping\";i:1;s:8:\"acc_home\";i:1;s:10:\"acc_static\";i:1;s:9:\"acc_daily\";i:1;s:10:\"acc_weekly\";i:1;s:11:\"acc_monthly\";i:1;s:4:\"home\";i:1;s:16:\"store_orderadmin\";i:1;}', 0),
(36, 'user02', '1234', 'newacc01@ema.il', 'newacc01', '2018-11-01', '01230000000', '新北市addr', 1, '1543638027.JPG', '1543638027_icon.JPG', 'a:3:{s:14:\"store_shopping\";i:1;s:4:\"home\";i:1;s:16:\"store_orderadmin\";i:1;}', 0),
(41, 'user03', '1234', 'admin1204@ma.il.com', 'test1204', '2018-12-01', '00000', '新北市addr', 1, '1543769198.JPG', '1543769198_icon.JPG', 'a:3:{s:14:\"store_shopping\";i:1;s:4:\"home\";i:1;s:16:\"store_orderadmin\";i:1;}', 0),
(42, 'testuser', '1234', 'test@ma.il', 'test', '2018-12-01', '01000', '新北市addr', 1, '1544846415.JPG', '1544846415_icon.JPG', 'a:2:{s:5:\"func5\";i:1;s:6:\"func10\";i:1;}', 0);

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `acc_item`
--
ALTER TABLE `acc_item`
  ADD PRIMARY KEY (`no`);

--
-- 資料表索引 `identity`
--
ALTER TABLE `identity`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`no`);

--
-- 資料表索引 `invoice_prize`
--
ALTER TABLE `invoice_prize`
  ADD PRIMARY KEY (`no`);

--
-- 資料表索引 `journal`
--
ALTER TABLE `journal`
  ADD PRIMARY KEY (`no`);

--
-- 資料表索引 `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`no`);

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
-- 資料表索引 `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`no`);

--
-- 資料表索引 `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`no`);

--
-- 資料表索引 `site_info`
--
ALTER TABLE `site_info`
  ADD PRIMARY KEY (`no`);

--
-- 資料表索引 `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`no`);

--
-- 資料表索引 `store_item`
--
ALTER TABLE `store_item`
  ADD PRIMARY KEY (`no`);

--
-- 資料表索引 `store_itemgroup`
--
ALTER TABLE `store_itemgroup`
  ADD PRIMARY KEY (`no`);

--
-- 資料表索引 `store_order`
--
ALTER TABLE `store_order`
  ADD PRIMARY KEY (`no`);

--
-- 資料表索引 `store_slide`
--
ALTER TABLE `store_slide`
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
-- 使用資料表 AUTO_INCREMENT `acc_item`
--
ALTER TABLE `acc_item`
  MODIFY `no` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- 使用資料表 AUTO_INCREMENT `identity`
--
ALTER TABLE `identity`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用資料表 AUTO_INCREMENT `invoice`
--
ALTER TABLE `invoice`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- 使用資料表 AUTO_INCREMENT `invoice_prize`
--
ALTER TABLE `invoice_prize`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- 使用資料表 AUTO_INCREMENT `journal`
--
ALTER TABLE `journal`
  MODIFY `no` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- 使用資料表 AUTO_INCREMENT `member`
--
ALTER TABLE `member`
  MODIFY `no` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- 使用資料表 AUTO_INCREMENT `page`
--
ALTER TABLE `page`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- 使用資料表 AUTO_INCREMENT `page_group`
--
ALTER TABLE `page_group`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- 使用資料表 AUTO_INCREMENT `payment`
--
ALTER TABLE `payment`
  MODIFY `no` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用資料表 AUTO_INCREMENT `project`
--
ALTER TABLE `project`
  MODIFY `no` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- 使用資料表 AUTO_INCREMENT `site_info`
--
ALTER TABLE `site_info`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用資料表 AUTO_INCREMENT `store`
--
ALTER TABLE `store`
  MODIFY `no` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 使用資料表 AUTO_INCREMENT `store_item`
--
ALTER TABLE `store_item`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- 使用資料表 AUTO_INCREMENT `store_itemgroup`
--
ALTER TABLE `store_itemgroup`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- 使用資料表 AUTO_INCREMENT `store_order`
--
ALTER TABLE `store_order`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- 使用資料表 AUTO_INCREMENT `store_slide`
--
ALTER TABLE `store_slide`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 使用資料表 AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
