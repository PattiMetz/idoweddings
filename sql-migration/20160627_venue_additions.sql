-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Июн 27 2016 г., 12:12
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
-- Структура таблицы `vendor_type`
--

CREATE TABLE IF NOT EXISTS `vendor_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `vendor_type`
--

INSERT INTO `vendor_type` (`id`, `name`) VALUES
(3, 'Coordinator'),
(4, 'Florist'),
(5, 'Photographer'),
(6, 'Videographer'),
(7, 'Musician-Ceremony'),
(8, 'Musician-Reception'),
(9, 'Officiant'),
(10, 'Tour-Excursion'),
(11, 'Transportation'),
(12, 'Other');

-- --------------------------------------------------------

--
-- Структура таблицы `venue_tax`
--

CREATE TABLE IF NOT EXISTS `venue_tax` (
  `venue_id` int(11) NOT NULL,
  `tax` double DEFAULT NULL,
  `service_rate` double DEFAULT NULL,
  `our_service_rate` double DEFAULT NULL,
  `agency_service_rate` double DEFAULT NULL,
  `comment` text NOT NULL,
  `commission_type` int(11) NOT NULL DEFAULT '0',
  `commission` double DEFAULT NULL,
  `commission_package` double DEFAULT NULL,
  `commission_food` double DEFAULT NULL,
  `commission_items` double DEFAULT NULL,
  `accommodation_commission_type` int(11) NOT NULL,
  `accommodation_commission` double DEFAULT NULL,
  `accomodation_wholesale` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `venue_tax`
--

INSERT INTO `venue_tax` (`venue_id`, `tax`, `service_rate`, `our_service_rate`, `agency_service_rate`, `comment`, `commission_type`, `commission`, `commission_package`, `commission_food`, `commission_items`, `accommodation_commission_type`, `accommodation_commission`, `accomodation_wholesale`) VALUES
(96, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(97, 10, 20, 30, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(98, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(99, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(108, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(114, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(117, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(123, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(124, 0, 15, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(125, 0, 15, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(126, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(127, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(129, 0.10000000149011612, 0.15, 0, 0, '', 1, 0, 0, 0, 0, 1, 0, '0'),
(130, 0, 0, 6, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(131, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(132, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(133, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(134, 0, 0, 0, 0, '', 1, 0, 0, 0, 0, 0, 0, '0'),
(135, 10, 15, 15, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(136, 10, 15, 15, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(137, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(138, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(139, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(140, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(141, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(143, 10, 15, 15, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(144, 11, 15, 15, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(145, 0.15000000596046448, 0.15, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(146, 10, 15, 15, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(147, 0.10000000149011612, 0.15, 0.15, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(149, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(150, 10, 15, 15, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(151, 0.10000000149011612, 0.15, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(152, 10, 15, 15, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(153, 5, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(154, 10, 15, 15, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(155, 10, 15, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(159, 10, 15, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(160, 10, 15, 15, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(161, 10, 15, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(163, 10, 15, 15, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(164, 10, 15, 15, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(165, 10, 15, 15, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(166, 12, 15, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(167, 10, 15, 15, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(168, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(169, 10, 15, 15, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(170, 10, 15, 15, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(171, 10, 15, 15, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(172, 10, 15, 15, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(173, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(176, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(177, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(178, 10, 15, 15, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(179, 10, 15, 15, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(180, 16, 10, 15, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(181, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(182, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(183, 10, 15, 15, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(184, 10, 15, 15, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(185, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(186, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(187, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(188, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(189, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(190, 10, 15, 15, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(191, 10, 15, 15, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(192, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(193, 10, 15, 15, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(194, 4.170000076293945, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(195, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(196, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(197, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(198, 0, 0, 15, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(199, 15, 15, 15, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(200, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(201, 10, 15, 15, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(202, 10.5, 10, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(203, 7.5, 0, 0, 0, 'Economy Pa', 1, 20, 0, 0, 0, 0, 0, '0'),
(204, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(205, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(206, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(207, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(208, 0, 0, 0, 0, '', 1, 0, 0, 0, 0, 0, 0, '0'),
(209, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, '0'),
(210, 0.2, NULL, NULL, NULL, '', 0, NULL, NULL, NULL, NULL, 0, NULL, '0');

-- --------------------------------------------------------

--
-- Структура таблицы `venue_website`
--

CREATE TABLE IF NOT EXISTS `venue_website` (
  `id` int(11) NOT NULL,
  `venue_id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `font_settings` text NOT NULL,
  `logo_type` int(11) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `navigation_pos` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `venue_website`
--

INSERT INTO `venue_website` (`id`, `venue_id`, `url`, `font_settings`, `logo_type`, `logo`, `navigation_pos`) VALUES
(1, 96, 'sunscape_the_beach', 'a:7:{s:5:"title";a:3:{s:4:"font";s:1:"0";s:4:"size";s:1:"4";s:5:"color";s:7:"#fce5cd";}s:8:"subtitle";a:3:{s:4:"font";s:0:"";s:4:"size";s:0:"";s:5:"color";s:7:"#f6b26b";}s:7:"content";a:3:{s:4:"font";s:0:"";s:4:"size";s:0:"";s:5:"color";s:7:"#ff0000";}s:4:"menu";a:3:{s:4:"font";s:0:"";s:4:"size";s:0:"";s:5:"color";s:0:"";}s:7:"submenu";a:3:{s:4:"font";s:0:"";s:4:"size";s:0:"";s:5:"color";s:0:"";}s:6:"button";a:4:{s:4:"font";s:0:"";s:4:"size";s:0:"";s:5:"color";s:0:"";s:10:"background";s:0:"";}s:4:"name";a:3:{s:4:"font";s:0:"";s:4:"size";s:0:"";s:5:"color";s:0:"";}}', 1, '', 1),
(2, 210, 'newvenue', '', 0, '', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `vendor_type`
--
ALTER TABLE `vendor_type`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `venue_tax`
--
ALTER TABLE `venue_tax`
  ADD UNIQUE KEY `venue_id_2` (`venue_id`), ADD KEY `venue_id` (`venue_id`);

--
-- Индексы таблицы `venue_website`
--
ALTER TABLE `venue_website`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `vendor_type`
--
ALTER TABLE `vendor_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT для таблицы `venue_website`
--
ALTER TABLE `venue_website`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `venue_tax`
--
ALTER TABLE `venue_tax`
ADD CONSTRAINT `venue_tax_ibfk_1` FOREIGN KEY (`venue_id`) REFERENCES `venue` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
