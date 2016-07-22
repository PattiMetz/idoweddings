-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Июл 02 2016 г., 12:12
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
-- Структура таблицы `venue_location`
--

CREATE TABLE IF NOT EXISTS `venue_location` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `guest_capacity` int(11) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `venue_location`
--

-- --------------------------------------------------------

--
-- Структура таблицы `venue_location_group`
--

CREATE TABLE IF NOT EXISTS `venue_location_group` (
  `id` int(11) NOT NULL,
  `venue_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `one_event` enum('0','1') NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `venue_location_group`
--


-- --------------------------------------------------------

--
-- Структура таблицы `venue_location_image`
--

CREATE TABLE IF NOT EXISTS `venue_location_image` (
  `location_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `venue_location_image`
--

-- --------------------------------------------------------

--
-- Структура таблицы `venue_location_time`
--

CREATE TABLE IF NOT EXISTS `venue_location_time` (
  `location_id` int(11) NOT NULL,
  `time_from` varchar(10) NOT NULL,
  `time_to` varchar(10) NOT NULL,
  `days` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `venue_location_time`
--


--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `venue_location`
--
ALTER TABLE `venue_location`
  ADD PRIMARY KEY (`id`), ADD KEY `group_id` (`group_id`);

--
-- Индексы таблицы `venue_location_group`
--
ALTER TABLE `venue_location_group`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `venue_id_2` (`venue_id`,`name`), ADD KEY `venue_id` (`venue_id`);

--
-- Индексы таблицы `venue_location_image`
--
ALTER TABLE `venue_location_image`
  ADD PRIMARY KEY (`id`), ADD KEY `location_id` (`location_id`), ADD KEY `location_id_2` (`location_id`);

--
-- Индексы таблицы `venue_location_time`
--
ALTER TABLE `venue_location_time`
  ADD KEY `location_id` (`location_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `venue_location`
--
ALTER TABLE `venue_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `venue_location_group`
--
ALTER TABLE `venue_location_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `venue_location_image`
--
ALTER TABLE `venue_location_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `venue_location`
--
ALTER TABLE `venue_location`
ADD CONSTRAINT `venue_location_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `venue_location_group` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `venue_location_group`
--
ALTER TABLE `venue_location_group`
ADD CONSTRAINT `venue_location_group_ibfk_1` FOREIGN KEY (`venue_id`) REFERENCES `venue` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `venue_location_image`
--
ALTER TABLE `venue_location_image`
ADD CONSTRAINT `venue_location_image_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `venue_location` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `venue_location_time`
--
ALTER TABLE `venue_location_time`
ADD CONSTRAINT `venue_location_time_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `venue_location` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
