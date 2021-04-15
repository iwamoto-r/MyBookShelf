-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2021-04-15 05:44:18
-- サーバのバージョン： 10.4.11-MariaDB
-- PHP のバージョン: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `mybookshelf`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `rental_items`
--

CREATE TABLE `rental_items` (
  `ID` int(11) NOT NULL,
  `OWNER_ID` int(11) NOT NULL,
  `LENT_ID` int(11) DEFAULT NULL,
  `ITEM_ID` int(11) NOT NULL,
  `ISBN` bigint(13) NOT NULL,
  `MEMO` varchar(200) NOT NULL,
  `LENT_START_DAY` datetime NOT NULL,
  `LENT_END_DAY` datetime DEFAULT NULL,
  `RENTAL_FLG` int(2) NOT NULL,
  `CREATED` datetime NOT NULL,
  `MODIFIED` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `rental_items`
--

INSERT INTO `rental_items` (`ID`, `OWNER_ID`, `LENT_ID`, `ITEM_ID`, `ISBN`, `MEMO`, `LENT_START_DAY`, `LENT_END_DAY`, `RENTAL_FLG`, `CREATED`, `MODIFIED`) VALUES
(5, 4, NULL, 12, 9784088707211, '', '2021-03-30 09:39:40', '2021-04-23 00:00:00', 0, '2021-03-30 09:39:40', '2021-04-12 06:22:02'),
(6, 9, NULL, 13, 9784088808727, '', '2021-04-01 09:38:42', '2021-04-09 00:00:00', 0, '2021-04-01 09:38:42', '2021-04-01 09:39:00');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `NAME` varchar(30) DEFAULT NULL,
  `MAIL` varchar(100) NOT NULL,
  `PASSWORD` varchar(500) DEFAULT NULL,
  `ROLE` int(11) NOT NULL,
  `CREATED` datetime DEFAULT NULL,
  `MODIFIED` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`ID`, `NAME`, `MAIL`, `PASSWORD`, `ROLE`, `CREATED`, `MODIFIED`) VALUES
(1, 'root', 'root@root.com', '$2y$10$RehpVfqWAV.4kHYl6.K.uOLUE9E6yLQaq5mOUyXNI/Gf6DVWOznMi', 1, '2021-03-12 16:30:04', '0000-00-00 00:00:00'),
(3, 'いわもと', 'iwa@iwa.com', '$2y$10$PoRcWwi0M4syh8C3O7zvfOSLcB89VM90cuHedu5zynbIHvN8WVGie', 0, '2021-03-13 04:52:40', '0000-00-00 00:00:00'),
(4, 'testuser0001', 'testuser0001@gmail.com', '$2y$10$TbMUBBJYvYEeLVoxW9SSvuQvDo.YOC8aeLkPIC9VsUQ0U1nQpniba', 0, '2021-03-13 15:03:55', '0000-00-00 00:00:00'),
(7, 'いわもと', 'azu7uki@gmail.com', '$2y$10$etWKvHlp42SvY7wRNb7.e.FVuex00xFpJ0jd67/qbrRihJVs9gFXi', 0, '2021-03-14 03:40:18', '2021-03-17 00:11:40'),
(9, 'test', 'test@gmail.com', '$2y$10$MqhN8vWZxRnAh8lsDXa5Eu0.yegUJbcOMruYMf3UQsXk0cxz436Ae', 0, '2021-04-01 09:36:27', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- テーブルの構造 `users_books`
--

CREATE TABLE `users_books` (
  `ID` int(11) NOT NULL,
  `USER_ID` int(11) DEFAULT NULL,
  `ISBN` bigint(13) DEFAULT NULL,
  `TITLE` varchar(200) NOT NULL,
  `AUTHOR` varchar(200) NOT NULL,
  `PUBLISHER` varchar(200) NOT NULL,
  `PUBDATE` datetime NOT NULL,
  `DESCRIPTION` varchar(1000) NOT NULL,
  `MEMO` varchar(200) NOT NULL,
  `CREATED` datetime DEFAULT NULL,
  `MODIFIED` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users_books`
--

INSERT INTO `users_books` (`ID`, `USER_ID`, `ISBN`, `TITLE`, `AUTHOR`, `PUBLISHER`, `PUBDATE`, `DESCRIPTION`, `MEMO`, `CREATED`, `MODIFIED`) VALUES
(7, 3, 9784088817804, 'チェンソーマン 1', '藤本タツキ／著', '集英社', '2019-03-04 00:00:00', '悪魔のポチタと共にデビルハンターとして借金取りにこき使われる超貧乏な少年・デンジ。ド底辺の日々は、残忍な裏切りで一変する!! 悪魔をその身に宿し、悪魔を狩る、新時代ダークヒーローアクション、開幕!', '', '2021-03-15 09:50:48', '2021-03-15 09:50:48'),
(11, 4, 9784088808727, '約束のネバーランド 1', '出水ぽすか／著 白井カイウ／原著', '集英社', '2016-12-02 00:00:00', '母と慕う彼女は親ではない。共に暮らす彼らは兄弟ではない。エマ・ノーマン・レイの三人はこの小さな孤児院で幸せな毎日を送っていた。しかし、彼らの日常はある日突然終わりを告げた。真実を知った彼らを待つ運命とは…!?\r\n\r\n\r\n', '', '2021-03-19 07:38:07', '2021-03-19 07:38:07'),
(12, 4, 9784088707211, '食戟のソーマ 1', '森崎友紀／著 附田祐斗／原著 佐伯俊／著', '集英社', '2013-04-04 00:00:00', '実家が下町の定食屋を営む中学生・幸平創真。目標である料理人の父を越える為、創真は修業の毎日を送っていた。しかし突然、父から料理学校への編入話を告げられ…!? 創造する新料理マンガ、ここに開演!!\r\n【特別読切『食戟のソーマ』を収録】\r\n\r\n\r\n', 'テスト', '2021-03-30 09:31:46', '2021-03-30 09:31:46'),
(13, 9, 9784088808727, '約束のネバーランド 1', '出水ぽすか／著 白井カイウ／原著', '集英社', '2016-12-02 00:00:00', '母と慕う彼女は親ではない。共に暮らす彼らは兄弟ではない。エマ・ノーマン・レイの三人はこの小さな孤児院で幸せな毎日を送っていた。しかし、彼らの日常はある日突然終わりを告げた。真実を知った彼らを待つ運命とは…!?\r\n\r\n\r\n', '', '2021-04-01 09:37:06', '2021-04-01 09:37:06');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `rental_items`
--
ALTER TABLE `rental_items`
  ADD PRIMARY KEY (`ID`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`,`MAIL`) USING BTREE;

--
-- テーブルのインデックス `users_books`
--
ALTER TABLE `users_books`
  ADD PRIMARY KEY (`ID`);

--
-- ダンプしたテーブルのAUTO_INCREMENT
--

--
-- テーブルのAUTO_INCREMENT `rental_items`
--
ALTER TABLE `rental_items`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- テーブルのAUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- テーブルのAUTO_INCREMENT `users_books`
--
ALTER TABLE `users_books`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
