-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Июл 22 2016 г., 18:34
-- Версия сервера: 5.6.24
-- Версия PHP: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `ido`
--

-- --------------------------------------------------------

--
-- Структура таблицы `venue_page_setting`
--

CREATE TABLE IF NOT EXISTS `venue_page_setting` (
  `page_id` int(11) NOT NULL,
  `top_type` varchar(15) NOT NULL,
  `venue_name` varchar(255) NOT NULL,
  `button` varchar(255) NOT NULL,
  `slogan` varchar(255) NOT NULL,
  `h1` varchar(255) NOT NULL,
  `h2` varchar(255) NOT NULL,
  `text1` text NOT NULL,
  `text2` text NOT NULL,
  `video` varchar(255) NOT NULL,
  `default_slideshow` varchar(10) DEFAULT NULL,
  `default_image` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `venue_page_setting`
--
ALTER TABLE `venue_page_setting`
  ADD PRIMARY KEY (`page_id`), ADD KEY `page_id` (`page_id`);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `venue_page_setting`
--
ALTER TABLE `venue_page_setting`
ADD CONSTRAINT `venue_page_setting_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `venue_page` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
