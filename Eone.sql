-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost:3306
-- 生成日時: 2021 年 10 月 11 日 20:35
-- サーバのバージョン： 5.7.32
-- PHP のバージョン: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- データベース: `eone`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `part`
--

CREATE TABLE `part` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `part`
--

INSERT INTO `part` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, '胸', '2021-10-03 15:25:07', '2021-10-03 06:25:07'),
(2, '背中', '2021-10-03 15:25:28', '2021-10-03 06:25:28'),
(3, '肩', '2021-10-03 15:25:37', '2021-10-03 06:25:37'),
(4, '腕', '2021-10-03 15:25:48', '2021-10-03 06:25:48'),
(5, 'お腹', '2021-10-03 15:25:59', '2021-10-03 06:25:59'),
(6, 'お尻', '2021-10-03 15:26:07', '2021-10-03 06:26:07'),
(7, '脚', '2021-10-03 15:26:13', '2021-10-03 06:26:13');

-- --------------------------------------------------------

--
-- テーブルの構造 `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `part_id` int(11) NOT NULL,
  `reserve_flg` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `post`
--

INSERT INTO `post` (`id`, `start_time`, `end_time`, `user_id`, `part_id`, `reserve_flg`, `created_at`, `updated_at`) VALUES
(18, '2021-10-12 20:00:00', '2021-10-12 21:00:00', 4, 6, 1, '2021-10-07 13:29:48', '2021-10-11 10:17:38'),
(19, '2021-10-07 13:30:00', '2021-10-07 14:00:00', 4, 2, 1, '2021-10-07 13:30:10', '2021-10-07 05:02:48'),
(23, '2021-10-07 21:00:00', '2021-10-07 22:00:00', 4, 7, 1, '2021-10-07 13:32:25', '2021-10-07 07:13:45'),
(24, '2021-10-07 18:00:00', '2021-10-07 18:30:00', 2, 5, 1, '2021-10-07 13:33:16', '2021-10-07 07:42:14'),
(25, '2021-10-07 19:00:00', '2021-10-07 19:30:00', 2, 6, 0, '2021-10-07 13:33:43', '2021-10-07 04:33:43'),
(26, '2021-10-07 16:00:00', '2021-10-07 16:01:00', 2, 2, 0, '2021-10-07 16:00:22', '2021-10-07 07:00:22'),
(27, '2021-10-07 16:41:00', '2021-10-07 16:42:00', 4, 3, 0, '2021-10-07 16:41:18', '2021-10-07 07:41:18');

-- --------------------------------------------------------

--
-- テーブルの構造 `reserve`
--

CREATE TABLE `reserve` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `like_flg` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `reserve`
--

INSERT INTO `reserve` (`id`, `post_id`, `user_id`, `like_flg`, `created_at`, `updated_at`) VALUES
(13, 18, 2, 0, '2021-10-07 14:02:34', '2021-10-07 05:02:34'),
(14, 19, 2, 0, '2021-10-07 14:02:48', '2021-10-07 05:02:48'),
(15, 23, 2, 0, '2021-10-07 16:13:45', '2021-10-07 07:13:45'),
(17, 24, 4, 0, '2021-10-07 16:42:14', '2021-10-07 07:42:14');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nickname` varchar(30) NOT NULL,
  `role` int(11) NOT NULL DEFAULT '0',
  `part_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_user` int(11) DEFAULT '0',
  `temp_pass` varchar(255) DEFAULT NULL,
  `reset` int(11) NOT NULL DEFAULT '0',
  `temp_limit_time` datetime DEFAULT NULL,
  `last_change_pass_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `nickname`, `role`, `part_id`, `created_at`, `updated_at`, `is_user`, `temp_pass`, `reset`, `temp_limit_time`, `last_change_pass_time`) VALUES
(2, 'sample@sample.com', '$2y$10$kpr5NogU053PhK3J6/7rV.ivt0Fr6idqUjvn.aaNtSJOV2N2Fff86', 'サンプル', 0, NULL, '2021-10-04 00:56:48', '2021-10-03 15:56:48', 0, NULL, 0, NULL, NULL),
(4, 'host@host.com', '$2y$10$Lm0R5Y7pX6Zo/2tRbklVR.rkEBDz7WufnzU.K4Um8/xoq1gtoXIpa', 'ホスト', 1, NULL, '2021-10-04 14:04:45', '2021-10-07 03:43:03', 0, NULL, 0, NULL, NULL);

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `part`
--
ALTER TABLE `part`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`,`part_id`),
  ADD KEY `part_id` (`part_id`);

--
-- テーブルのインデックス `reserve`
--
ALTER TABLE `reserve`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mail` (`email`),
  ADD UNIQUE KEY `nickname` (`nickname`),
  ADD KEY `part_id` (`part_id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `part`
--
ALTER TABLE `part`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- テーブルの AUTO_INCREMENT `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- テーブルの AUTO_INCREMENT `reserve`
--
ALTER TABLE `reserve`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`part_id`) REFERENCES `part` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- テーブルの制約 `reserve`
--
ALTER TABLE `reserve`
  ADD CONSTRAINT `reserve_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `reserve_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- テーブルの制約 `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`part_id`) REFERENCES `part` (`id`) ON UPDATE CASCADE;