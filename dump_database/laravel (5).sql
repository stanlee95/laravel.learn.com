-- phpMyAdmin SQL Dump
-- version 4.0.10.6
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 13 2016 г., 13:19
-- Версия сервера: 5.6.22-log
-- Версия PHP: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `laravel`
--

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `published` tinyint(1) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=20 ;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `name`, `path`, `published`, `parent_id`, `created_at`, `updated_at`) VALUES
(2, 'Test2', NULL, 1, NULL, NULL, NULL),
(3, 'Test3', NULL, 1, NULL, NULL, NULL),
(4, 'Test4', NULL, 1, NULL, NULL, NULL),
(10, 'tweqwdasd', NULL, 0, 4, '2016-04-29 01:13:04', NULL),
(11, 'fdgfg', NULL, 1, 6, '2016-04-29 01:37:20', NULL),
(12, 'test11', NULL, 1, 11, '2016-04-29 01:43:06', NULL),
(13, 'sdsad', NULL, 1, 12, '2016-04-29 02:06:35', NULL),
(14, 'test6', NULL, 1, NULL, '2016-04-30 01:49:18', NULL),
(16, 'Test34', NULL, 0, NULL, '2016-05-05 00:44:49', NULL),
(17, 'Testsdsad', NULL, 1, 0, '2016-05-05 13:30:57', '2016-05-05 13:30:57'),
(18, 'sadasd', NULL, 1, 17, '2016-05-05 13:31:04', '2016-05-05 13:31:04'),
(19, 'sadasd', NULL, 1, 18, '2016-05-05 13:31:09', '2016-05-05 13:31:09');

-- --------------------------------------------------------

--
-- Структура таблицы `category_sub`
--

CREATE TABLE IF NOT EXISTS `category_sub` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `published` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `category_sub`
--

INSERT INTO `category_sub` (`id`, `name`, `category_id`, `published`, `created_at`, `updated_at`) VALUES
(1, 'test1', 1, 1, NULL, NULL),
(2, 'test2', 1, 1, NULL, NULL),
(3, 'test3', 2, 1, '2016-04-28 16:46:44', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ext` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `post_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2016_04_04_180025_create_posts_table', 1),
('2016_04_26_124722_create_photos_table', 2),
('2016_04_27_123322_create_files_table', 3),
('2016_04_28_162603_create_category_table', 4),
('2016_04_28_162647_create_sub_category_table', 4);

-- --------------------------------------------------------

--
-- Структура таблицы `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('bond9555@gmail.com', 'e568d5340fe95eff5fc99dd4aec414765e6a2ace47289e36111c1826d599ce06', '2016-05-03 13:35:52'),
('bond_95@mail.ru', 'de327a182f18c4d587db72092a1c81d6b7b874e3f54b20b4cc20fcd5c87a3158', '2016-05-03 13:40:38');

-- --------------------------------------------------------

--
-- Структура таблицы `photos`
--

CREATE TABLE IF NOT EXISTS `photos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `ext` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumbnail_path` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=177 ;

--
-- Дамп данных таблицы `photos`
--

INSERT INTO `photos` (`id`, `name`, `path`, `post_id`, `ext`, `thumbnail_path`, `created_at`, `updated_at`) VALUES
(176, 'dyqylPITu1l7CPj9IczM.jpg', 'uploads/44/dyqylPITu1l7CPj9IczM.jpg', 44, 'jpg', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8_unicode_ci,
  `content` text COLLATE utf8_unicode_ci,
  `parent_id` int(11) DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `published_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `category_id` int(11) DEFAULT NULL,
  `category_sub_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=45 ;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`id`, `title`, `user_name`, `excerpt`, `content`, `parent_id`, `photo`, `published_at`, `published`, `category_id`, `category_sub_id`, `created_at`, `updated_at`) VALUES
(34, 'erwer', 'Stan', NULL, 'sdfdsfsdfd', NULL, 'uploads/user_image/Stan.jpg', '2016-05-06 01:16:55', 1, 2, 0, '2016-05-06 01:16:55', '2016-05-06 01:16:55'),
(36, 'test', 'StaN Stas', NULL, 'test', NULL, NULL, '2016-05-06 01:37:14', 1, 4, 0, '2016-05-06 01:37:14', '2016-05-06 01:37:14'),
(38, NULL, 'Stan', NULL, ' sadasdasdasd', 36, NULL, '2016-05-06 01:37:34', 1, NULL, NULL, '2016-05-06 01:37:33', '2016-05-06 01:37:33'),
(39, NULL, 'Stan', NULL, 'Hey? there', 34, NULL, '2016-05-06 11:21:21', 1, NULL, NULL, '2016-05-06 11:21:21', '2016-05-06 11:21:21'),
(40, 'sdasd', 'sdasd', NULL, 'sdasd', NULL, NULL, '2016-05-06 21:19:40', 0, NULL, NULL, NULL, NULL),
(41, 'sdasd', 'Guest', NULL, ' sadsadsadsadasdasd', NULL, NULL, '2016-05-06 21:42:10', 1, 2, 0, '2016-05-06 21:42:10', '2016-05-06 21:42:10'),
(42, 'Test2', 'stanislav@xarisma.by', NULL, 'Testtsadsadsadasdasdsad', NULL, NULL, '2016-05-06 22:12:42', 1, 2, 0, '2016-05-06 22:12:42', '2016-05-06 22:12:42'),
(43, NULL, 'Guest', NULL, 'Dkdkashdkhskdhjasd', 41, NULL, '2016-05-09 15:50:35', 1, NULL, NULL, '2016-05-09 15:50:35', '2016-05-09 15:50:35'),
(44, 'Hello', 'StaN Stas', NULL, 'Hello World!', NULL, NULL, '2016-05-09 15:52:16', 1, 2, 0, '2016-05-09 15:52:16', '2016-05-09 15:52:16');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'user',
  `avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `google_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `yandex_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mail_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `odno_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=41 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `avatar`, `facebook_id`, `google_id`, `yandex_id`, `mail_id`, `odno_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(14, 'StaN Stas', 'bond9555@gmail.com', '', NULL, NULL, '', '116789892121952183627', '', '', '', '9WTnBqMgwTBmIVoHR4SHRmIun9uEPP5BX0KHkAom8XfBEhU0GrLhnZ5g651e', '2016-04-27 00:21:15', '2016-05-05 12:28:35'),
(15, 'Станислав', 'stanislav@xarisma.by', '', NULL, NULL, '1130000020728291', '', '', '', '', 'typD3PQ7XpFeZl8brpQh6e2Ybcr3eIJpR5BFRtKDKVGOFybVXZCDfGIrMLSn', '2016-04-27 09:32:30', '2016-04-27 09:33:23'),
(16, 'stanislav@xarisma.by', 'stanislav@xarisma.by', '', NULL, NULL, '', '', '1130000020728291', '', '', 'lofOBI4Y97pAmeuCsh27MFwj3Db2kScsJS2ZE9Dw3VbuPL6seWCDevGPYHB7', '2016-04-27 09:33:38', '2016-04-28 17:38:01'),
(19, 'bond', 'bond_95@mail.ru', '$2y$10$CsbarnTF3h.zCQKhtNqzUuTwurNr/XrPQT/3wUlKBbKUmKlNa7xx2', NULL, 'uploads/user_image/FCrhodBJG2G7vhaJTrsS.jpg', '', '', '', '', '', 'Zu5HJ8tbYzj22P9EYHG3Qm7iwlplhm8G25Q0v1O0dpSBGxCsbFOd6UwdjaJ2', '2016-05-02 12:25:56', '2016-05-02 12:55:34'),
(20, 'sdasd', 'bond9555@gmail.com5', '$2y$10$MTfH8L53C7CwFZolErWQ/uY4Thhn/5u.IBQ5aVIdcjp.damixiZkG', NULL, 'uploads/user_image/Y9ZIopugrEAaWiEeuDcM.jpg', '', '', '', '', '', 'CTwgQXBjgdL55hfjsDYipnTIUcZ6QaErPxzRZHjrDX207qPS4OLD2n9xC9Jp', '2016-05-02 13:20:37', '2016-05-02 13:32:39'),
(33, 'Stan', 'bond_95@mail.ru', '', 'admin', 'uploads/user_image/Stan.jpg', '0', '', '', '', '573631072900', 'WXPeBiiMLWRGPWu6t6oRXUy23VcU2nZizsrMoQe6EJ8hGbLi4Voe4IbkVinj', '2016-05-03 12:52:21', '2016-05-10 14:25:10'),
(34, '^StAsiK^', 'bond_95@mail.ru', '', NULL, NULL, '', '', '', '15381682036374048564', '', 'NZLNI7oSRCSiWbP2oBHRZsNmYeDdGcou6tPoNXGHRsqpxsrFN2XGnm96yYiF', '2016-05-03 12:56:33', '2016-05-03 12:56:51'),
(40, 'Stan Kharlap', 'bond9555@gmail.com', '', NULL, 'https://graph.facebook.com/v2.5/116659982073429/picture?type=normal', '116659982073429', '', '', '', '0', NULL, '2016-05-03 13:41:54', '2016-05-03 13:41:54');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
