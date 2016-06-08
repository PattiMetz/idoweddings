-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Июн 08 2016 г., 17:33
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
-- Структура таблицы `country`
--

CREATE TABLE IF NOT EXISTS `country` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=138 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `country`
--

INSERT INTO `country` (`id`, `name`) VALUES
(1, 'England'),
(2, 'France'),
(3, 'Germany'),
(4, 'Italy'),
(5, 'Kenya'),
(6, 'East Korea'),
(7, 'Alaska (AK)'),
(8, 'Anguilla'),
(9, 'Aruba'),
(10, 'Australia'),
(11, 'Austria'),
(12, 'Bahamas'),
(13, 'Belgium'),
(14, 'Belize'),
(15, 'Bermuda'),
(16, 'Bonaire'),
(17, 'British Virgin Islands'),
(18, 'California (CA)'),
(19, 'Cayman Islands'),
(20, 'Cook Islands'),
(21, 'Costa Rica'),
(22, 'Curacao'),
(23, 'Cyprus'),
(24, 'Czech Republic'),
(25, 'Denmark'),
(26, 'Dominica'),
(27, 'Dominican Republic'),
(28, 'Egypt'),
(29, 'Fiji'),
(30, 'Finland'),
(31, 'Florida (FL)'),
(32, 'French Polynesia'),
(33, 'Gilbraltar'),
(34, 'Greece'),
(35, 'Grenada'),
(36, 'Guam'),
(37, 'Guatamala'),
(38, 'Hawaii (HI)'),
(39, 'Hungary'),
(40, 'Iceland'),
(41, 'India'),
(42, 'Indonesia'),
(43, 'Ireland'),
(44, 'Israel'),
(45, 'Jamaica'),
(46, 'Japan'),
(47, 'Malaysia'),
(48, 'Maldives'),
(49, 'Malta'),
(50, 'Margarita Island'),
(51, 'Mauritius'),
(52, 'Monaco'),
(53, 'Morocco'),
(54, 'Nepal'),
(55, 'New Zealand'),
(56, 'Norway'),
(57, 'Poland'),
(58, 'Puerto Rico'),
(59, 'Republic of San Marino'),
(60, 'Scotland'),
(61, 'Sicily'),
(62, 'South Africa'),
(63, 'Spain'),
(64, 'St. Lucia'),
(66, 'St. Vincent'),
(67, 'Switzerland'),
(68, 'Turks and Caicos'),
(69, 'Turkey'),
(70, 'Zimbabwe'),
(72, 'Mexico'),
(73, 'Greenland'),
(75, 'Alabama (AL)'),
(76, 'Caribbean'),
(77, 'Antigua'),
(78, 'Barbados'),
(79, 'Nevada (NV)'),
(80, 'Ontario'),
(83, 'South Carolina (SC)'),
(84, 'St. Barts'),
(85, 'US Virgin Islands'),
(86, 'St. Kitts'),
(87, 'Tennessee (TN)'),
(88, 'St. Maarten/St. Martin'),
(89, 'Arizona (AZ)'),
(90, 'Arkansas (AR)'),
(91, 'Colorado (CO)'),
(92, 'Connecticut (CT)'),
(93, 'Delaware (DE)'),
(94, 'Washington DC (DC)'),
(95, 'Georgia (GA)'),
(96, 'Idaho (ID)'),
(97, 'Illinois (IL)'),
(98, 'Indiana (IN)'),
(99, 'Iowa (IA)'),
(100, 'Kansas (KS)'),
(101, 'Kentucky (KY)'),
(102, 'Louisiana (LA)'),
(103, 'Maine (ME)'),
(104, 'Maryland (MD)'),
(105, 'Massachusetts (MA)'),
(106, 'Michigan (MI)'),
(107, 'Minnesota (MN)'),
(108, 'Mississippi (MS)'),
(109, 'Missouri (MO)'),
(110, 'Montana (MT)'),
(111, 'Nebraska (NE)'),
(112, 'New Hampshire (NH)'),
(113, 'New Mexico (NM)'),
(114, 'New York (NY)'),
(115, 'North Carolina (NC)'),
(116, 'North Dakota (ND)'),
(117, 'Ohio (OH)'),
(118, 'Oklahoma (OK)'),
(119, 'Oregon (OR)'),
(120, 'Pennsylvania (PA)'),
(121, 'Rhode Island (RI)'),
(122, 'South Dakota (SD)'),
(123, 'Texas (TX)'),
(124, 'Utah (UT)'),
(125, 'Vermont (VT)'),
(126, 'Virginia (VA)'),
(127, 'Washington (WA)'),
(128, 'West Virginia (WV)'),
(129, 'Wisconsin (WI)'),
(130, 'Wyoming (WY)'),
(131, 'New Jersey (NJ)'),
(132, 'Jordan'),
(133, 'Brazil'),
(134, 'Guadeloupe'),
(135, 'Martinique'),
(136, 'Trinidad & Tobago');

-- --------------------------------------------------------

--
-- Структура таблицы `currency`
--

CREATE TABLE IF NOT EXISTS `currency` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `rate` double NOT NULL,
  `buffer` double NOT NULL,
  `control_amount` double NOT NULL,
  `short` varchar(10) NOT NULL,
  `main` enum('0','1') NOT NULL,
  `updated_at` varchar(20) NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `currency`
--

INSERT INTO `currency` (`id`, `name`, `rate`, `buffer`, `control_amount`, `short`, `main`, `updated_at`, `updated_by`) VALUES
(1, 'USD', 1, 1, 100, '$', '1', '2016/06/08 02:43:36', 0),
(3, 'Aus Dollar', 1.5674, 0.96, 100, '', '', '', 0),
(5, 'Pound', 0.5047, 0.96, 100, 'GBP', '', '', 0),
(6, 'Pesos', 12.827, 0.96, 100, '', '', '', 0),
(7, 'INR - India Rupees', 39.464, 0.96, 100, '', '', '', 0),
(8, 'CAN', 1.2659, 0.96, 100, '', '', '', 0),
(9, 'Brazilian Reais', 2, 0.96, 100, 'BRL', '', '', 0),
(10, 'EUR', 0.9129, 1.02, 100, '', '', '', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `destination`
--

CREATE TABLE IF NOT EXISTS `destination` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `region_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=140 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `destination`
--

INSERT INTO `destination` (`id`, `name`, `region_id`, `currency_id`, `active`) VALUES
(1, 'England', 6, 10, 1),
(2, 'France', 6, 10, 1),
(3, 'Germany', 6, 10, 0),
(4, 'Italy', 6, 10, 1),
(5, 'Kenya', 3, 10, 1),
(6, 'East Korea', 2, 1, 1),
(7, 'Alaska (AK)', 18, 1, 1),
(8, 'Anguilla', 9, 1, 1),
(9, 'Aruba', 9, 1, 1),
(10, 'Australia', 12, 1, 1),
(11, 'Austria', 6, 10, 1),
(12, 'Bahamas', 9, 1, 1),
(13, 'Belgium', 6, 10, 1),
(14, 'Belize', 10, 1, 1),
(15, 'Bermuda', 9, 1, 1),
(16, 'Bonaire', 9, 1, 1),
(17, 'British Virgin Islands', 9, 1, 1),
(18, 'California (CA)', 18, 1, 1),
(19, 'Cayman Islands', 9, 1, 1),
(20, 'Cook Islands', 12, 1, 1),
(21, 'Costa Rica', 10, 1, 1),
(22, 'Curacao', 9, 1, 1),
(23, 'Cyprus', 6, 10, 1),
(24, 'Czech Republic', 6, 10, 1),
(25, 'Denmark', 6, 10, 1),
(26, 'Dominica', 9, 1, 1),
(27, 'Dominican Republic', 9, 1, 1),
(28, 'Egypt', 3, 10, 1),
(29, 'Fiji', 12, 1, 1),
(30, 'Finland', 6, 10, 1),
(31, 'Florida (FL)', 19, 1, 1),
(32, 'French Polynesia', 12, 10, 1),
(33, 'Gilbraltar', 6, 10, 1),
(34, 'Greece', 6, 10, 1),
(35, 'Grenada', 9, 1, 1),
(36, 'Guam', 9, 1, 1),
(37, 'Guatamala', 10, 1, 1),
(38, 'Hawaii (HI)', 18, 1, 1),
(39, 'Hungary', 6, 10, 1),
(40, 'Iceland', 6, 10, 1),
(41, 'India', 2, 1, 1),
(42, 'Indonesia', 2, 1, 1),
(43, 'Ireland', 6, 10, 1),
(44, 'Israel', 6, 10, 1),
(45, 'Jamaica', 9, 1, 1),
(46, 'Japan', 2, 10, 1),
(47, 'Malaysia', 2, 10, 1),
(48, 'Maldives', 6, 10, 1),
(49, 'Malta', 6, 10, 1),
(50, 'Margarita Island', 9, 10, 1),
(51, 'Mauritius', 3, 10, 1),
(52, 'Monaco', 6, 10, 1),
(53, 'Morocco', 6, 10, 1),
(54, 'Nepal', 2, 10, 1),
(55, 'New Zealand', 12, 10, 1),
(56, 'Norway', 6, 10, 1),
(57, 'Poland', 6, 10, 1),
(58, 'Puerto Rico', 9, 1, 1),
(59, 'Republic of San Marino', 6, 10, 1),
(60, 'Scotland', 6, 10, 1),
(61, 'Sicily', 6, 10, 1),
(62, 'South Africa', 3, 10, 1),
(63, 'Spain', 6, 10, 1),
(64, 'St. Lucia', 9, 1, 1),
(66, 'St. Vincent', 9, 1, 1),
(67, 'Switzerland', 6, 10, 1),
(68, 'Turks and Caicos', 9, 1, 1),
(69, 'Turkey', 6, 10, 1),
(70, 'Zimbabwe', 3, 10, 1),
(72, 'Mexico', 11, 6, 1),
(73, 'Greenland', 16, 3, 1),
(75, 'Alabama (AL)', 19, 1, 1),
(76, 'Caribbean', 9, 1, 1),
(77, 'Antigua', 9, 1, 1),
(78, 'Barbados', 9, 1, 1),
(79, 'Nevada (NV)', 18, 1, 1),
(80, 'Ontario', 8, 8, 1),
(83, 'South Carolina (SC)', 19, 1, 1),
(84, 'St. Barts', 9, 1, 1),
(85, 'US Virgin Islands', 9, 1, 1),
(86, 'St. Kitts', 9, 1, 1),
(87, 'Tennessee (TN)', 19, 1, 1),
(88, 'St. Maarten/St. Martin', 9, 1, 1),
(89, 'Arizona (AZ)', 21, 1, 1),
(90, 'Arkansas (AR)', 19, 1, 1),
(91, 'Colorado (CO)', 23, 1, 1),
(92, 'Connecticut (CT)', 22, 1, 1),
(93, 'Delaware (DE)', 22, 1, 1),
(94, 'Washington DC (DC)', 22, 1, 1),
(95, 'Georgia (GA)', 19, 1, 1),
(96, 'Idaho (ID)', 23, 1, 1),
(97, 'Illinois (IL)', 20, 1, 1),
(98, 'Indiana (IN)', 23, 1, 1),
(99, 'Iowa (IA)', 20, 1, 1),
(100, 'Kansas (KS)', 20, 1, 1),
(101, 'Kentucky (KY)', 19, 1, 1),
(102, 'Louisiana (LA)', 19, 1, 1),
(103, 'Maine (ME)', 22, 1, 1),
(104, 'Maryland (MD)', 22, 1, 1),
(105, 'Massachusetts (MA)', 22, 1, 1),
(106, 'Michigan (MI)', 20, 1, 1),
(107, 'Minnesota (MN)', 20, 1, 1),
(108, 'Mississippi (MS)', 19, 1, 1),
(109, 'Missouri (MO)', 20, 1, 1),
(110, 'Montana (MT)', 23, 1, 1),
(111, 'Nebraska (NE)', 20, 1, 1),
(112, 'New Hampshire (NH)', 22, 1, 1),
(113, 'New Mexico (NM)', 21, 1, 1),
(114, 'New York (NY)', 19, 1, 1),
(115, 'North Carolina (NC)', 19, 1, 1),
(116, 'North Dakota (ND)', 20, 1, 1),
(117, 'Ohio (OH)', 20, 1, 1),
(118, 'Oklahoma (OK)', 21, 1, 1),
(119, 'Oregon (OR)', 18, 1, 1),
(120, 'Pennsylvania (PA)', 22, 1, 1),
(121, 'Rhode Island (RI)', 22, 1, 1),
(122, 'South Dakota (SD)', 20, 1, 1),
(123, 'Texas (TX)', 21, 1, 1),
(124, 'Utah (UT)', 23, 1, 1),
(125, 'Vermont (VT)', 22, 1, 1),
(126, 'Virginia (VA)', 19, 1, 1),
(127, 'Washington (WA)', 18, 1, 1),
(128, 'West Virginia (WV)', 19, 1, 1),
(129, 'Wisconsin (WI)', 20, 1, 1),
(130, 'Wyoming (WY)', 23, 1, 1),
(131, 'New Jersey (NJ)', 22, 1, 1),
(132, 'Jordan', 17, 10, 0),
(133, 'Brazil', 7, 9, 1),
(134, 'Guadeloupe', 9, 1, 1),
(135, 'Martinique', 9, 1, 1),
(136, 'Trinidad & Tobago', 9, 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `language`
--

CREATE TABLE IF NOT EXISTS `language` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `language`
--

INSERT INTO `language` (`id`, `name`) VALUES
(1, 'English');

-- --------------------------------------------------------

--
-- Структура таблицы `location`
--

CREATE TABLE IF NOT EXISTS `location` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `destination_id` int(11) NOT NULL,
  `airport` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=224 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `location`
--

INSERT INTO `location` (`id`, `name`, `destination_id`, `airport`) VALUES
(2, 'Paris ', 2, 'PAR'),
(7, 'Acapulco ', 72, 'ACA'),
(8, 'Cancun ', 72, 'CUN'),
(11, 'Antigua', 77, 'ANU'),
(12, 'Aruba ', 9, 'AUA'),
(13, 'Nassau-Paradise Island ', 12, 'PID'),
(14, 'Barbados ', 78, 'BGI'),
(15, 'Belize ', 14, 'BZE'),
(16, 'Big Island of Hawaii ', 38, 'ITO'),
(17, 'Bonaire ', 16, 'BON'),
(18, 'Cabo San Jose ', 72, 'SJD'),
(19, 'Cabo San Lucas ', 72, 'SJD'),
(20, 'Catalina Island, California', 18, ''),
(21, 'Cayman Islands ', 19, 'GCM'),
(22, 'Cefalu, Sicily ', 61, 'PMO'),
(23, 'Copper Canyon', 72, ''),
(24, 'Costa Rica', 21, ''),
(25, 'Cozumel ', 72, 'CZM'),
(26, 'Cuernavaca ', 72, 'CVJ'),
(27, 'Curacao ', 22, 'CUR'),
(28, 'Delhi ', 41, 'DEL'),
(29, 'Ensenada ', 72, 'ESE'),
(30, 'Florence/Tuscany ', 4, 'FLR'),
(31, 'Guadalajara ', 72, 'GDL'),
(32, 'Huatulco ', 72, 'HUX'),
(33, 'Ixtapa/Zihuatanejo ', 72, 'ZIH'),
(34, 'Juneau, Alaska', 7, ''),
(35, 'Kauai ', 38, 'LIH'),
(37, 'La Paz', 72, ''),
(38, 'Las Vegas, Nevada', 79, ''),
(39, 'Loreto', 72, ''),
(40, 'Malta ', 49, 'MLA'),
(41, 'Manzanillo ', 72, 'ZLO'),
(42, 'Margarita Island', 50, ''),
(43, 'Maui ', 38, 'OGG'),
(44, 'Mazatlan ', 72, 'MZT'),
(45, 'Merida ', 72, 'MID'),
(46, 'Mexico City ', 72, 'MEX'),
(47, 'Montego Bay ', 45, 'MBJ'),
(48, 'Negril  ', 45, 'NEG'),
(49, 'Niagara Falls, New York', 80, ''),
(50, 'Niagara Falls, Ontario', 80, ''),
(52, 'Nuevo Vallarta ', 72, 'PVR'),
(53, 'Oahu ', 38, 'HNL'),
(54, 'Oaxaca ', 72, 'OAX'),
(55, 'Ocho Rios ', 45, 'OCJ'),
(56, 'Orlando, Florida', 31, ''),
(57, 'Riviera Maya - Playa Del Carmen ', 72, 'CUN'),
(58, 'Positano', 4, ''),
(59, 'Puerto Angel ', 72, 'PXM'),
(60, 'Puerto Escondido ', 72, 'PXM'),
(61, 'Puerto Plata ', 27, 'POP'),
(62, 'Puerto Rico', 58, ''),
(63, 'Puerto Vallarta ', 72, 'PVR'),
(64, 'Punta Cana ', 27, 'PUJ'),
(65, 'Reykjavik ', 40, 'KEF'),
(66, 'Rome ', 4, 'ROM'),
(67, 'Runaway Bay', 45, ''),
(68, 'Salzburg ', 11, 'SZG'),
(69, 'San Miguel', 72, ''),
(70, 'Santorini', 34, ''),
(71, 'Sorrento', 4, ''),
(73, 'St. Barts', 84, ''),
(74, 'St. John ', 85, 'STT'),
(75, 'St. Croix ', 85, 'STX'),
(76, 'St. Thomas ', 85, 'STT'),
(77, 'St. Kitts', 86, 'SKB'),
(78, 'St. Maarten/St. Martin ', 88, 'SXM'),
(79, 'St. Pete''s Beach, Florida', 31, ''),
(80, 'St. Vincent ', 66, 'SVD'),
(81, 'Taormina, Sicily', 61, ''),
(84, 'Turks & Caicos', 68, ''),
(85, 'Riviera Maya - Puerto Moreles ', 72, 'CUN'),
(86, 'Isla Mujeres', 72, ''),
(87, 'Auvergne-Salers', 2, 'CFE'),
(88, 'Allentown ', 120, 'ABE'),
(89, 'Albuquerque', 113, 'ABQ'),
(90, 'Waco ', 123, 'ACT'),
(91, 'Atlantic City ', 131, 'ACY'),
(92, 'Augusta ', 95, 'AGS'),
(93, 'Walla Walla ', 127, 'ALW'),
(94, 'Amarillo ', 123, 'AMA'),
(95, 'Anchorage ', 7, 'ANC'),
(96, 'Naples ', 31, 'APF'),
(97, 'Appleton ', 129, 'ATW'),
(98, 'Augusta (AUG)', 103, 'AUG'),
(99, 'Austin ', 123, 'AUS'),
(100, 'Wausau ', 129, 'AUW'),
(101, 'Wilkes-Barre/Scraton ', 120, 'AVP'),
(102, 'Scranton ', 120, 'AVP'),
(103, 'Kalamazoo ', 106, 'AZO'),
(104, 'Hartford ', 92, 'BDL'),
(105, 'Benton Harbor ', 106, 'BEH'),
(106, 'Bangor ', 103, 'BGR'),
(107, 'Birmingham ', 75, 'BHM'),
(108, 'Billings ', 110, 'BIL'),
(109, 'Bismarck ', 116, 'BIS'),
(110, 'Nashville ', 87, 'BNA'),
(111, 'Boise ', 96, 'BOI'),
(112, 'Boston ', 105, 'BOS'),
(113, 'Brownsville ', 123, 'BRO'),
(114, 'Battle Creek ', 106, 'BTL'),
(115, 'Baton Rouge ', 102, 'BTR'),
(116, 'Burlington ', 125, 'BTV'),
(117, 'Baltimore ', 104, 'BWI'),
(118, 'Canton/Akron ', 117, 'CAK'),
(119, 'Cedar Rapids ', 99, 'CID'),
(120, 'Columbus ', 117, 'CMH'),
(121, 'Champaign ', 97, 'CMI'),
(122, 'Colorado Springs ', 91, 'COS'),
(123, 'Charlestown ', 128, 'CRW'),
(124, 'Cincinnati ', 117, 'CVG'),
(125, 'Duluth ', 107, 'DLH'),
(126, 'Des Moines ', 99, 'DSM'),
(127, 'El Paso ', 123, 'ELP'),
(128, 'Key West ', 31, 'EYW'),
(129, 'Evansville ', 98, 'EVV'),
(130, 'Flint ', 106, 'FNT'),
(131, 'Sioux Falls ', 122, 'FSD'),
(132, 'Fort Wayne ', 98, 'FWA'),
(133, 'Spokane ', 127, 'GEG'),
(134, 'Galveston ', 123, 'GLS'),
(135, 'Green Bay ', 129, 'GRB'),
(136, 'Greensboro ', 115, 'GSO'),
(137, 'Greensville/Spartansburg ', 83, 'GSP'),
(138, 'Hot Springs ', 90, 'HOT'),
(139, 'Huntington ', 128, 'HTS'),
(140, 'Harrisburg ', 120, 'MDT'),
(141, 'Washington DC/Dulles ', 94, 'IAD'),
(142, 'Wichita', 100, 'ICT'),
(143, 'Wilmington ', 93, 'ILG'),
(144, 'Joplin ', 109, 'JLN'),
(145, 'Juneau (JNU)', 75, 'JNU'),
(146, 'Jacksonville ', 115, 'OAJ'),
(147, 'Knoxville ', 87, 'TYS'),
(148, 'Kansas City ', 109, 'MCI'),
(149, 'Lafayette ', 98, 'LAF'),
(150, 'Lansing ', 106, 'LAN'),
(151, 'Lubbock ', 123, 'LBB'),
(152, 'Lexington ', 101, 'LEX'),
(153, 'Lincoln ', 111, 'LNK'),
(154, 'LaCrosse ', 129, 'LSE'),
(155, 'Saginaw ', 106, 'MBS'),
(156, 'Memphis ', 87, 'MEM'),
(157, 'McAllen ', 123, 'MFE'),
(158, 'Montgomery ', 75, 'MGM'),
(159, 'Mobile ', 75, 'MDB'),
(160, 'Madison ', 129, 'MSN'),
(161, 'Norfolk ', 126, 'ORF'),
(162, 'Omaha ', 111, 'OMA'),
(163, 'Worcester ', 105, 'ORH'),
(164, 'Oshkosh ', 129, 'OSH'),
(165, 'Portland ', 119, 'PDX'),
(166, 'Peoria ', 97, 'PIA'),
(167, 'Palm Springs ', 18, 'PSP'),
(168, 'Portand ', 103, 'PWM'),
(169, 'Raleigh/Durham ', 115, 'RDU'),
(170, 'Roanoke ', 126, 'ROA'),
(171, 'San Antonio ', 123, 'SAT'),
(172, 'South Bend ', 98, 'SBN'),
(173, 'Louisville ', 101, 'SDF'),
(174, 'Seattle/Tacoma ', 127, 'SEA'),
(175, 'Salt Lake City ', 124, 'SLC'),
(176, 'Sacramento ', 18, 'SMF'),
(177, 'Springfield ', 108, 'SGF'),
(178, 'Sioux City ', 99, 'SUX'),
(179, 'Tallahassee ', 31, 'TLH'),
(180, 'Tokepka ', 100, 'TOP'),
(181, 'Anguilla ', 8, 'AXA'),
(182, 'Monterrey ', 72, 'MTY'),
(183, 'Palermo ', 61, 'PMO'),
(184, 'St. Lucia ', 64, 'UVF'),
(185, 'Sanibel Island', 31, ''),
(186, 'Bermuda', 15, 'BDA'),
(187, 'Vienna', 11, ''),
(188, 'Chandigarh ', 41, 'CHD'),
(189, 'South Africa', 62, ''),
(190, 'Holbox', 72, ''),
(191, 'Ostia ', 4, 'ROM'),
(192, 'Progreso', 72, ''),
(193, 'Rio de Janeiro', 133, ''),
(194, 'Veracruz', 72, ''),
(195, 'British Virgin Islands', 17, ''),
(196, 'Dominica', 26, ''),
(197, 'Grenada', 35, ''),
(198, 'Guadeloupe', 134, ''),
(199, 'Martinique', 135, ''),
(200, 'Trinidad & Tobago', 136, ''),
(201, 'Amalfi Coast', 4, ''),
(202, 'Los Cabos', 72, 'SJD'),
(203, 'Riviera Maya - Akumal', 72, 'CUN'),
(204, 'Riviera Maya - Tulum', 72, 'CUN'),
(205, 'Riviera Maya - Puerto Aventuras', 72, 'CUN'),
(206, 'Bavaro', 27, 'PUJ'),
(207, 'Adelaide', 10, 'ADL'),
(208, 'Alice Springs', 10, 'ASP'),
(209, 'Aix-en-provence', 2, 'LYS'),
(210, 'Angouleme', 2, 'ANG'),
(211, 'Antwerp', 13, 'ANR'),
(212, 'Aran Islands', 43, 'GWY'),
(213, 'Athens', 34, 'ATH'),
(214, 'Augsburg', 3, 'AGB'),
(216, 'Ayers Rock', 10, 'AYQ'),
(217, 'Great Barrier Reef', 10, 'NMP'),
(218, 'Bath', 1, 'BRS'),
(219, 'Bavaria', 3, 'MUC'),
(220, 'Bayonne', 2, 'BIQ'),
(221, 'Berlin', 3, 'SXF'),
(222, 'Bordeaux', 2, 'BOD'),
(223, 'Bonnieux', 2, 'NCE');

-- --------------------------------------------------------

--
-- Структура таблицы `region`
--

CREATE TABLE IF NOT EXISTS `region` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `currency_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `region`
--

INSERT INTO `region` (`id`, `name`, `currency_id`) VALUES
(2, 'Asia', 1),
(3, 'Africa', 1),
(6, 'Europe and Mediterranean', 1),
(7, 'South America', 1),
(8, 'Canada', 1),
(9, 'Caribbean', 1),
(10, 'Central America', 1),
(11, 'Mexico', 1),
(12, 'South Pacific', 1),
(13, 'USA', 1),
(16, 'Antartica', 1),
(17, 'Middle East', 1),
(18, 'USA - West', 1),
(19, 'USA - Southeast', 1),
(20, 'USA - Midwest', 1),
(21, 'USA - Southwest', 1),
(22, 'USA - Northeast', 1),
(23, 'USA - Mountain', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `venue_service`
--

CREATE TABLE IF NOT EXISTS `venue_service` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `venue_service`
--

INSERT INTO `venue_service` (`id`, `name`) VALUES
(1, 'Wedding Package'),
(2, 'Wedding Location and Setup'),
(3, 'On-site Coordinator for Day of Wedding'),
(4, 'Wedding Items'),
(5, 'Reception Items'),
(6, 'Outside Vendors Allowed'),
(7, 'Guest Allowed'),
(8, 'Guest Allowed – with Day Pass');

-- --------------------------------------------------------

--
-- Структура таблицы `venue_type`
--

CREATE TABLE IF NOT EXISTS `venue_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `venue_type`
--

INSERT INTO `venue_type` (`id`, `name`) VALUES
(1, 'All-inclusive Resort'),
(2, 'Resort'),
(3, 'Boutique'),
(4, 'Castle'),
(5, 'Cathedral'),
(6, 'Chateau'),
(7, 'Church'),
(8, 'Estate'),
(9, 'Hotel'),
(10, 'Outdoor Venue'),
(11, 'Park'),
(12, 'Restaurant'),
(13, 'Temple'),
(14, 'Villa'),
(15, 'Beach'),
(16, 'Formal Garden'),
(17, 'Golf Club'),
(18, 'Hall'),
(19, 'Vineyard'),
(20, 'Other');

-- --------------------------------------------------------

--
-- Структура таблицы `vibe`
--

CREATE TABLE IF NOT EXISTS `vibe` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `vibe`
--

INSERT INTO `vibe` (`id`, `name`) VALUES
(1, 'One Event Per Day'),
(2, 'Multiple Weddings Per Day'),
(3, 'Chapel'),
(4, 'Gazebo'),
(5, 'Beach Wedding Location – Private'),
(6, 'Beach Wedding Location – Public'),
(7, 'Cliff Wedding Location'),
(8, 'Garden Wedding Location'),
(9, 'Oceanview Wedding Location'),
(10, 'Outdoor Reception Location'),
(11, 'Ruin Wedding Location'),
(12, 'Terrace Wedding Location'),
(13, 'Ballroom'),
(14, 'Adults Only'),
(15, 'Gay Friendly'),
(16, 'Family Friendly'),
(17, 'Non-guests may attend with Daypass'),
(18, 'Non-guests may not attend'),
(19, 'Venue will host non-guest events');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `destination`
--
ALTER TABLE `destination`
  ADD PRIMARY KEY (`id`), ADD KEY `currency_id` (`currency_id`), ADD KEY `region_id` (`region_id`);

--
-- Индексы таблицы `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`), ADD KEY `region_id` (`destination_id`);

--
-- Индексы таблицы `region`
--
ALTER TABLE `region`
  ADD UNIQUE KEY `id` (`id`), ADD KEY `currency_id` (`currency_id`);

--
-- Индексы таблицы `venue_service`
--
ALTER TABLE `venue_service`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `venue_type`
--
ALTER TABLE `venue_type`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `vibe`
--
ALTER TABLE `vibe`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=138;
--
-- AUTO_INCREMENT для таблицы `currency`
--
ALTER TABLE `currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT для таблицы `destination`
--
ALTER TABLE `destination`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=140;
--
-- AUTO_INCREMENT для таблицы `language`
--
ALTER TABLE `language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `location`
--
ALTER TABLE `location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=224;
--
-- AUTO_INCREMENT для таблицы `region`
--
ALTER TABLE `region`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT для таблицы `venue_service`
--
ALTER TABLE `venue_service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT для таблицы `venue_type`
--
ALTER TABLE `venue_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT для таблицы `vibe`
--
ALTER TABLE `vibe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `destination`
--
ALTER TABLE `destination`
ADD CONSTRAINT `destination_ibfk_1` FOREIGN KEY (`region_id`) REFERENCES `region` (`id`),
ADD CONSTRAINT `destination_ibfk_2` FOREIGN KEY (`currency_id`) REFERENCES `currency` (`id`);

--
-- Ограничения внешнего ключа таблицы `location`
--
ALTER TABLE `location`
ADD CONSTRAINT `location_ibfk_2` FOREIGN KEY (`destination_id`) REFERENCES `destination` (`id`);

--
-- Ограничения внешнего ключа таблицы `region`
--
ALTER TABLE `region`
ADD CONSTRAINT `region_ibfk_1` FOREIGN KEY (`currency_id`) REFERENCES `currency` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
