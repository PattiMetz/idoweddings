-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Июн 21 2016 г., 14:45
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
-- Структура таблицы `venue`
--

CREATE TABLE IF NOT EXISTS `venue` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `featured_name` varchar(100) NOT NULL,
  `location_id` int(11) NOT NULL,
  `active` enum('0','1') NOT NULL,
  `featured` enum('0','1') NOT NULL,
  `type_id` int(11) NOT NULL,
  `vibe_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `guest_capacity` varchar(50) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=236 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `venue`
--

INSERT INTO `venue` (`id`, `name`, `featured_name`, `location_id`, `active`, `featured`, `type_id`, `vibe_id`, `service_id`, `comment`, `guest_capacity`, `updated_by`, `updated_at`) VALUES
(96, 'Sunscape the Beach', 'Sunscape the Beach', 64, '1', '0', 1, 1, 1, '', 'Sunscape the Beach', 1, '2009/08/20 14:43:54'),
(97, 'Crown Paradise Club', 'Crown Paradise Club', 8, '1', '0', 1, 1, 1, '', 'Crown Paradise Club', 1, '2009/08/20 07:40:41'),
(98, 'Moon Palace', 'Moon Palace', 8, '1', '0', 1, 1, 1, '', 'Moon Palace', 1, '2009/08/20 14:21:34'),
(99, 'Parroquia de Nuestra Senora de Guadalupe', 'Puerto Vallarta Cathedral', 63, '1', '0', 1, 1, 1, '', 'Parroquia de Nuestra Senora de Guadalupe', 1, '2009/08/20 14:31:24'),
(108, 'Chateau de la Bastide', 'Chateau de la Bastide', 87, '1', '0', 1, 1, 1, '', 'Chateau de la Bastide', 1, '2009/08/20 07:36:37'),
(114, 'dfgdfgdfg', 'dfgdfgdfg', 2, '1', '0', 1, 1, 1, '', 'dfgdfgdfg', 1, '2009/11/25 01:48:54'),
(117, 'Casa Ybel Resort', 'Casa Ybel Resort', 185, '1', '1', 1, 1, 1, '', 'Casa Ybel Resort', 1, '2009/08/20 07:31:44'),
(123, 'Villa Premiere', 'Villa Premiere', 63, '1', '1', 1, 1, 1, '', 'Villa Premiere', 1, '2009/08/20 15:09:02'),
(124, 'Buenaventura Grand Hotel & Spa', 'Buenaventura Grand Hotel & Spa', 63, '1', '1', 1, 1, 1, '', 'Buenaventura Grand Hotel & Spa', 1, '2009/10/11 13:52:06'),
(125, 'Hacienda Hotel & Spa', 'Hacienda Hotel & Spa', 63, '1', '1', 1, 1, 1, '', 'Hacienda Hotel & Spa', 1, '2009/08/20 12:50:19'),
(126, 'Grand Coco Bay', 'Grand Coco Bay', 57, '1', '0', 1, 1, 1, '', 'Grand Coco Bay', 1, '2009/10/01 12:02:47'),
(127, 'Dreams Tulum Resort & Spa', 'Dreams Tulum Resort & Spa', 204, '1', '0', 1, 1, 1, '', 'Dreams Tulum Resort & Spa', 1, '2013/08/18 07:37:47'),
(129, 'La Casa del Agua', 'La Casa del Agua', 57, '1', '1', 1, 1, 1, '', 'La Casa del Agua', 1, '2009/12/09 00:10:49'),
(130, 'Hotel Sacher', 'Hotel Sacher', 187, '1', '0', 1, 1, 1, '', 'Hotel Sacher', 1, '2009/08/20 12:58:32'),
(131, 'Parroquia de Nuestra Senora de Carmen', 'Playa del Carmen Parish', 57, '1', '0', 1, 1, 1, '', 'Parroquia de Nuestra Senora de Carmen', 1, '2009/08/20 14:29:45'),
(132, 'Capilla Nuestra Senora del Carmen', 'Chapel Playa del Carmen', 57, '1', '0', 1, 1, 1, '', 'Capilla Nuestra Senora del Carmen', 1, '2009/10/01 11:58:33'),
(133, 'Petit Lafitte', 'Petit Lafitte', 57, '1', '1', 1, 1, 1, '', 'Petit Lafitte', 1, '2009/08/20 14:32:49'),
(134, 'Marina Maroma', 'Marina Maroma', 57, '1', '0', 1, 1, 1, '', 'Marina Maroma', 1, '2009/10/19 00:32:15'),
(135, 'Blue Parrot', 'Blue Parrot', 57, '1', '1', 1, 1, 1, '', 'Blue Parrot', 1, '2009/08/20 07:18:37'),
(136, 'Las Palapas', 'Beachfront Location', 57, '1', '1', 1, 1, 1, '', 'Las Palapas', 1, '2009/02/09 11:46:37'),
(137, 'Azulik', 'Azulik', 204, '1', '0', 1, 1, 1, '', 'Azulik', 1, '2013/08/18 07:29:18'),
(138, 'Al Cielo', 'Al Cielo', 57, '1', '0', 1, 1, 1, '', 'Al Cielo', 1, '2008/03/18 10:54:47'),
(139, 'Shangri-La', 'Shangri-La', 57, '1', '0', 1, 1, 1, '', 'Shangri-La', 1, '2013/09/03 10:05:57'),
(140, 'Playa Maya', 'Playa Maya', 57, '1', '1', 1, 1, 1, '', 'Playa Maya', 1, '2009/10/01 18:18:21'),
(141, 'Faro Mazatlan', 'Faro Mazatlan', 44, '1', '0', 1, 1, 1, '', 'Faro Mazatlan', 1, '2009/08/20 12:08:24'),
(143, 'Ambiance Villas at Kin Ha', 'Ambiance Villas at Kin Ha', 8, '1', '1', 1, 1, 1, '', 'Ambiance Villas at Kin Ha', 1, '2009/12/03 10:58:18'),
(144, 'XCaret', 'Xcaret', 57, '1', '0', 1, 1, 1, '', 'XCaret', 1, '2013/09/16 08:32:49'),
(145, 'El Cid Mazatlan', 'El Cid Mazatlan', 44, '1', '0', 1, 1, 1, '', 'El Cid Mazatlan', 1, '2009/08/20 12:04:56'),
(146, 'Marriott Casa Magna', 'Marriott Casa Magna', 8, '1', '0', 1, 1, 1, '', 'Marriott Casa Magna', 1, '2009/08/20 13:54:59'),
(147, 'Bahia Principe Riviera Maya', 'Bahia Principe Riviera Maya', 204, '1', '0', 1, 1, 1, '', 'Bahia Principe Riviera Maya', 1, '2013/08/18 07:37:02'),
(149, 'Holiday Inn Sunspree', 'Holiday Inn Sunspree', 44, '1', '0', 1, 1, 1, '', 'Holiday Inn Sunspree', 1, '2009/08/20 12:53:13'),
(150, 'Grand Oasis Cancun', 'Grand Oasis Cancun', 8, '1', '1', 1, 1, 1, '', 'Grand Oasis Cancun', 1, '2010/02/11 13:28:46'),
(151, 'The Royal Playa del Carmen', 'The Royal Playa del Carmen', 57, '1', '0', 1, 1, 1, '', 'The Royal Playa del Carmen', 1, '2009/10/01 18:20:08'),
(152, 'NH Krystal Cancun', 'NH Krystal Cancun', 8, '1', '1', 1, 1, 1, '', 'NH Krystal Cancun', 1, '2014/10/01 15:58:28'),
(153, 'Ritz Carlton Golf & Spa Resort, Rose Hall', 'Ritz Carlton Golf & Spa Resort, Rose Hall', 47, '1', '0', 1, 1, 1, '', 'Ritz Carlton Golf & Spa Resort, Rose Hall', 1, '2009/08/20 14:28:23'),
(154, 'Grand Riviera Princess & Grand Sunset Princess', 'Grand Riviera Princess & Grand Sunset Princess', 57, '1', '0', 1, 1, 1, '', 'Grand Riviera Princess & Grand Sunset Princess', 1, '2009/10/01 18:23:18'),
(155, 'Pueblo Bonito Mazatlan', 'Pueblo Bonito Mazatlan', 44, '1', '0', 1, 1, 1, '', 'Pueblo Bonito Mazatlan', 1, '2009/08/20 14:38:17'),
(159, 'Le Meridien Cancun Resort & Spa', 'Le Meridien Cancun Resort & Spa', 8, '1', '0', 1, 1, 1, '', 'Le Meridien Cancun Resort & Spa', 1, '2009/08/20 13:22:57'),
(160, 'The Westin Resort & Spa, Cancun', 'The Westin Resort & Spa, Cancun', 8, '1', '0', 1, 1, 1, '', 'The Westin Resort & Spa, Cancun', 1, '2009/08/20 15:07:22'),
(161, 'Maroma Resort & Spa', 'Maroma Resort & Spa', 85, '1', '0', 1, 1, 1, '', 'Maroma Resort & Spa', 1, '2009/08/20 13:51:48'),
(163, 'Sunset Lagoon', 'Sunset Lagoon', 8, '1', '0', 1, 1, 1, '', 'Sunset Lagoon', 1, '2009/08/20 14:45:07'),
(164, 'Dreams Cancun Resort & Spa', 'Dreams Cancun Resort & Spa', 8, '1', '0', 1, 1, 1, '', 'Dreams Cancun Resort & Spa', 1, '2013/08/13 07:46:36'),
(165, 'Las Rosas Hotel & Spa', 'Las Rosas Hotel & Spa', 29, '1', '0', 1, 1, 1, '', 'Las Rosas Hotel & Spa', 1, '2009/08/20 13:20:58'),
(166, 'Test Nanda', 'Test Nanda', 182, '1', '0', 1, 1, 1, '', 'Test Nanda', 1, '2009/12/03 11:25:56'),
(167, 'Flamingo Cancun', 'Flamingo Cancun', 8, '1', '1', 1, 1, 1, '', 'Flamingo Cancun', 1, '2009/10/08 12:31:38'),
(168, 'Parroquia de Cristo Resucitado', 'Cancun Church', 8, '1', '0', 1, 1, 1, '', 'Parroquia de Cristo Resucitado', 1, '2009/08/20 14:20:30'),
(169, 'Gran Melia Cancun', 'Gran Melia Cancun', 8, '1', '1', 1, 1, 1, '', 'Gran Melia Cancun', 1, '2009/10/08 12:34:13'),
(170, 'H10 Ocean Coral & Ocean Turquesa', 'H10 Ocean Coral & Ocean Turquesa', 85, '1', '1', 1, 1, 1, '', 'H10 Ocean Coral & Ocean Turquesa', 1, '2009/08/20 12:51:58'),
(171, 'The Royal Cancun', 'The Royal Cancun', 8, '1', '0', 1, 1, 1, '', 'The Royal Cancun', 1, '2009/08/20 15:04:14'),
(172, 'Estero Beach Hotel', 'Estero Beach Hotel', 29, '1', '1', 1, 1, 1, '', 'Estero Beach Hotel', 1, '2009/08/20 12:06:41'),
(173, 'Villa Sol y Luna', 'Villa Sol y Luna', 85, '1', '1', 1, 1, 1, '', 'Villa Sol y Luna', 1, '2009/08/20 15:10:53'),
(176, 'testShortLink', 'testShortLink', 46, '1', '0', 1, 1, 1, '', 'testShortLink', 1, '2010/04/15 08:23:07'),
(177, 'egrdgfdsg', 'rewt', 45, '0', '0', 1, 1, 1, '', 'egrdgfdsg', 1, '2008/07/02 05:02:54'),
(178, 'Paradisus', 'Paradisus', 85, '1', '0', 1, 1, 1, '', 'Paradisus', 1, '2009/09/11 08:35:27'),
(179, 'Temptation Resort & Spa', 'Temptation Resort & Spa', 8, '1', '0', 1, 1, 1, '', 'Temptation Resort & Spa', 1, '2009/08/20 14:47:22'),
(180, 'Dreams Punta Cana Resort & Spa', 'Dreams Punta Cana Resort & Spa', 64, '1', '0', 1, 1, 1, '', 'Dreams Punta Cana Resort & Spa', 1, '2009/08/20 11:55:39'),
(181, 'Bavaro Princess All Suites Resort, Spa & Casino', 'Bavaro Princess All Suites Resort, Spa & Casino', 64, '1', '0', 1, 1, 1, '', 'Bavaro Princess All Suites Resort, Spa & Casino', 1, '2009/08/20 07:16:12'),
(182, 'MAUI-Royal Lahaina', 'MAUI-Royal Lahaina', 43, '1', '0', 1, 1, 1, '', 'MAUI-Royal Lahaina', 1, '2009/08/20 13:47:16'),
(183, 'Private Casa del Cielo', 'Private Casa del Cielo', 85, '1', '1', 1, 1, 1, '', 'Private Casa del Cielo', 1, '2009/08/20 14:36:41'),
(184, 'Grand Mayan Riviera Maya', 'Grand Mayan Riviera Maya', 57, '1', '0', 1, 1, 1, '', 'Grand Mayan Riviera Maya', 1, '2009/10/01 18:21:46'),
(185, 'Castelbuono Ventimiglia''s Castle ', 'Civil Ceremony Castle outside of Cefalu', 22, '1', '0', 1, 1, 1, '', 'Castelbuono Ventimiglia''s Castle ', 1, '2009/08/20 07:33:13'),
(186, 'Makena Surf Beach', 'Makena Surf Beach', 43, '1', '0', 1, 1, 1, '', 'Makena Surf Beach', 1, '2009/08/20 13:42:03'),
(187, 'Hotel Reef Yucatan', 'Hotel Reef Yucatan', 192, '1', '0', 1, 1, 1, '', 'Hotel Reef Yucatan', 1, '2009/08/20 12:54:20'),
(188, 'Catalonia Riviera Maya', 'Catalonia Riviera Maya', 205, '1', '0', 1, 1, 1, '', 'Catalonia Riviera Maya', 1, '2013/08/18 07:42:25'),
(189, 'Beach ', 'Beach ', 21, '1', '0', 1, 1, 1, '', 'Beach ', 1, '2009/08/20 07:17:16'),
(190, 'Luna Palace', 'Luna Palace', 44, '1', '1', 1, 1, 1, '', 'Luna Palace', 1, '2009/08/20 13:40:34'),
(191, 'Sun Palace', 'Sun Palace', 8, '1', '0', 1, 1, 1, '', 'Sun Palace', 1, '2009/08/20 14:41:20'),
(192, 'Cancun Carib Park Royal', 'Cancun Beach Location', 8, '1', '0', 1, 1, 1, '', 'Cancun Carib Park Royal', 1, '2011/08/24 22:43:04'),
(193, 'Oasis Resorts', 'Oasis Resorts', 8, '1', '0', 1, 1, 1, '', 'Oasis Resorts', 1, '2009/08/20 14:24:31'),
(194, 'Kauai Beach Location', 'Kauai Beach Location', 35, '1', '0', 1, 1, 1, '', 'Kauai Beach Location', 1, '2009/08/20 13:05:34'),
(195, 'Royal Decameron Club Caribbean ', 'Royal Decameron Club Caribbean ', 67, '1', '0', 1, 1, 1, '', 'Royal Decameron Club Caribbean ', 1, '2009/08/20 14:39:56'),
(196, 'Christ Church', 'Christian Church', 193, '1', '0', 1, 1, 1, '', 'Christ Church', 1, '2009/08/20 07:39:19'),
(197, 'test_venue', 'test_venue', 8, '1', '0', 1, 1, 1, '', 'test_venue', 1, '2009/08/18 09:26:28'),
(198, 'Hotel Riu Palace Aruba', 'Hotel Riu Palace Aruba', 12, '1', '0', 1, 1, 1, '', 'Hotel Riu Palace Aruba', 1, '2009/08/20 12:56:43'),
(199, 'Pacifica Resort', 'Pacifica Resort', 33, '1', '0', 1, 1, 1, '', 'Pacifica Resort', 1, '2009/09/11 20:52:31'),
(200, 'Waimanalo Beach Cottages', 'Waimanalo ', 53, '1', '0', 1, 1, 1, '', 'Waimanalo Beach Cottages', 1, '2014/10/31 11:55:27'),
(201, 'Sunset Mona Lisa Restaurant', 'Sunset Mona Lisa Restaurant', 19, '1', '0', 1, 1, 1, '', 'Sunset Mona Lisa Restaurant', 1, '2009/10/10 14:57:11'),
(202, 'Sugar Ridge', 'Sugar Ridge', 11, '1', '1', 1, 1, 1, '', 'Sugar Ridge', 1, '2014/05/18 06:00:34'),
(203, 'Key West Beach', 'Key West Beach ', 128, '1', '1', 1, 1, 1, '', 'Key West Beach', 1, '2010/01/14 13:56:47'),
(204, 'GR Solaris', 'GR Solaris', 8, '1', '0', 1, 1, 1, '', 'GR Solaris', 1, '2013/01/22 10:58:50'),
(205, 'Test', 'Test', 181, '0', '0', 1, 1, 1, '', 'Test', 1, '2013/03/19 13:51:49'),
(206, 'ATEST', 'ATEST', 11, '0', '0', 1, 1, 1, '', 'ATEST', 1, '2013/03/19 16:23:24'),
(207, 'KUKUA RESTAURANT BEACH CLUB', 'Beach Club', 64, '1', '0', 1, 1, 1, '', 'KUKUA RESTAURANT BEACH CLUB', 1, '2013/08/06 13:59:42'),
(208, 'Villa del Palmar', 'Villa del Palmar', 8, '1', '1', 1, 1, 1, '', 'Villa del Palmar', 1, '2013/08/13 08:08:08'),
(209, 'Jobson Cove', 'Jobson Cove', 186, '0', '0', 1, 1, 1, '', 'Jobson Cove', 1, '2015/06/29 07:30:30');

-- --------------------------------------------------------

--
-- Структура таблицы `venue_address`
--

CREATE TABLE IF NOT EXISTS `venue_address` (
  `venue_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `state` varchar(100) NOT NULL,
  `zip` varchar(10) NOT NULL,
  `city` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `timezone` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `site` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `venue_address`
--

INSERT INTO `venue_address` (`venue_id`, `country_id`, `state`, `zip`, `city`, `address`, `timezone`, `email`, `site`) VALUES
(96, 27, '', '', 'Punta Cana ', '', 0, '', 'www.weddingsonthemove.com/sunscape-punta-cana'),
(97, 72, '', '', 'Cancun ', '', 0, '', 'www.weddingsonthemove.com/crown-paradise-club'),
(98, 72, '', '', 'Cancun ', '', 0, '', 'www.weddingsonthemove.com/moon-palace'),
(99, 72, '', '48300', 'Puerto Vallarta ', 'Hidalgo 370 Centro Ciudad: 48300 Puerto Vallarta ', 0, '', 'www.weddingsonthemove.com/puerto-vallarta-cathedral'),
(108, 2, '', '', 'Auvergne-Salers', '', 0, '', 'www.weddingsonthemove.com/chateaude-la-bastide'),
(114, 2, '', '', 'Paris ', 'ewbvcvbcvbdfgdfcvn', 0, '', 'www.weddingsonthemove.com/'),
(117, 31, '', '', 'Sanibel Island', '', 0, '', 'www.weddingsonthemove.com/casa-ybel-resort'),
(123, 72, '', '48350', 'Puerto Vallarta ', 'San Salvador No. 117 Col. 5 de Diciembre', 0, '', 'www.weddingsonthemove.com/villa-premiere'),
(124, 72, '', '48350', 'Puerto Vallarta ', 'Av. México 1301 Col. 5 de Diciembre Puerto Vallarta, Jalisco ', 0, '', 'www.weddingsonthemove.com/buenaventura-grand-hotel'),
(125, 72, '', '48310', 'Puerto Vallarta ', 'Blvd. Francisco Medina Ascencio 2699 Puerto Vallarta, Jalisco ', 0, '', 'www.weddingsonthemove.com/hacienda-hotel'),
(126, 72, '', '77710', 'Riviera Maya - Playa', 'Calle Costera Norte S.N. Lte. 1 Mza. 7 Región 6, Playa del Carmen, Quintana Roo', 0, '', 'www.weddingsonthemove.com/grandcocobay'),
(127, 72, '', '77780', 'Riviera Maya - Tulum', 'Carretera Chetumal – Puerto Juárez KM 234 Solidaridad, Tulum Quintana Roo C.P.77780', 0, '', 'www.weddingsonthemove.com/dreams-tulum'),
(129, 72, '', '77710', 'Riviera Maya - Playa', '5ª Avenida con Calle 2, Segundo Piso Centro, Playa del Carmen Quintana Roo, Mexico', 0, '', 'www.weddingsonthemove.com/lacasadelagua'),
(130, 11, '', '', 'Vienna', '', 0, '', 'www.weddingsonthemove.com/'),
(131, 72, '', '77710', 'Riviera Maya - Playa', 'Calle 12 Norte entre Av.15 y 20 Norte Col, Centro, 77710 Playa del Carmen Q. Roo ', 0, '', 'www.weddingsonthemove.com/catholic-church-playa-del-carmen'),
(132, 72, '', '77710', 'Riviera Maya - Playa', 'Calle 12 Norte entre Av.15 y 20 Norte Col, Centro, 77710 Playa del Carmen Q. Roo ', 0, '', 'www.weddingsonthemove.com/chapel-playdelcarmen'),
(133, 72, '', '', 'Riviera Maya - Playa', 'Carretera Cancún - Chetumal km 296 + 2.1 Xcalacoco, Playa del Carmen, Q. Roo, México', 0, '', 'www.weddingsonthemove.com/petit-lafitte'),
(134, 72, '', '', 'Riviera Maya - Playa', 'Punta Bete', 0, '', 'www.weddingsonthemove.com/marina-maroma'),
(135, 72, '', '', 'Riviera Maya - Playa', '', 0, '', 'www.weddingsonthemove.com/blue-parrot'),
(136, 72, '', '77710', 'Riviera Maya - Playa', 'Calle 34 Nte entre 5a Av y Z.F.M. 77710 Playa del Carmen, Q. Roo, Mexico', 0, '', 'www.weddingsonthemove.com/laspalapas'),
(137, 72, '', '', 'Riviera Maya - Tulum', '', 0, '', 'www.weddingsonthemove.com/azulik'),
(138, 72, '', '', 'Riviera Maya - Playa', 'Carretera Federal Cancun-Tulum KM 118 Xpu-Ha Beach 1.5 CP 77710 (Riviera Maya) Solidaridad, Q. Ro', 0, '', ''),
(139, 72, '', '', 'Riviera Maya - Playa', 'Calle 38 Norte con Zona Federal Maritima Playa del Carmen - Quintana Roo - Mexico', 0, '', 'www.weddingsonthemove.com/'),
(140, 72, '', '77710', 'Riviera Maya - Playa', 'Zona FMT entre calle 6 y 8 Norte (on the beach near 8th street) Playa del Carmen, Q Roo 77710', 0, '', 'www.weddingsonthemove.com/playa-maya'),
(141, 72, '', '82100', 'Mazatlan ', 'Punta del Sábalo S/N, Zona Dorada C.P 82100, Mazatlán Sinaloa', 0, '', 'www.weddingsonthemove.com/faro-mazatlan'),
(143, 72, '', '77500', 'Cancun ', 'Blvd. Kukulcan km 8,5 Zona Hotelera, Cancun, Q. Roo, Mexico', 0, '', 'www.weddingsonthemove.com/ambiancevillas'),
(144, 72, '', '', 'Riviera Maya - Playa', '', 0, '', 'www.weddingsonthemove.com/xcaret'),
(145, 72, '', '82210', 'Mazatlan ', 'Av. Camarón Sábalo S/N Apartado Postal 813 Mazatlán, Sinaloa, México 82110', 0, '', 'www.weddingsonthemove.com/elcid-mazatlan'),
(146, 72, '', '77500', 'Cancun ', 'Boulevard Kukulcan, Retorno Chac L-41, Zona Hotelera Cancun, Quintana Roo 77500 Mexico ', 0, '', 'www.weddingsonthemove.com/mariott-casa-magna'),
(147, 72, '', '', 'Riviera Maya - Tulum', 'Playa Aventuras Akumal. Crtra. Xetumal - Cancún, Km. 251.', 0, '', 'www.weddingsonthemove.com/bahia-principe-riviera-maya'),
(149, 72, '', '', 'Mazatlan ', '', 0, '', 'www.weddingsonthemove.com/holidayinn-sunspree-mazatlan'),
(150, 72, '', '77500', 'Cancun ', 'Blvd. Kukulkan Km 16,5 Lote 45, 46 y 47 Zona Hotelera', 0, '', 'www.weddingsonthemove.com/grand-oasis-cancun'),
(151, 72, '', '', 'Riviera Maya - Playa', 'Av. Constituyentes y Mar Playa del Carmen, Q. Roo, Mexico', 0, '', 'www.weddingsonthemove.com/royal-playa-del-carmen'),
(152, 72, '', '', 'Cancun ', 'Blvd. Kukulkán Km. 9 Lotes 9 y 9a Cancún, Q. Roo México', 0, '', 'www.weddingsonthemove.com/nh-krystal-cancun'),
(153, 45, '', '', 'Montego Bay ', 'Karen Shields Catering Sales Manager ', 0, '', 'www.weddingsonthemove.com/ritz-carlton-rose-hall'),
(154, 72, '', '77710', 'Riviera Maya - Playa', '\r\nPunta Bete Km. 296, carretera Chetumal - Prto Juarez.\r\n\r\n77710 SOlidarida Q Roo Mexico ', 0, '', 'www.weddingsonthemove.com/grand-princess'),
(155, 72, '', '82110', 'Mazatlan ', '\r\nAv. Camaron Sabalo 2121 Norte\r\n\r\nApartado Postal no. 6\r\n\r\nMAzatlan, Sinaloa\r\n\r\n', 0, '', 'www.weddingsonthemove.com/pueblo-bonito-mazatlan'),
(159, 72, '', '77500', 'Cancun ', 'WEDDING COORDINATOR & SOCIAL EVENTS\r\nRETORNO DEL REY Mz. 53 - Lote 37-1 Km. 14, Z.H. Sec. A&', 0, '', 'www.weddingsonthemove.com/lemeridien-cancun'),
(160, 72, '', '77500', 'Cancun ', '\r\nweddings and events sales manager \r\n\r\nboulevard kukulcan km 20 cancun\r\n\r\n', 0, '', 'www.weddingsonthemove.com/westin-resort'),
(161, 72, '', '77710', 'Riviera Maya - Puert', 'Carretera Cancún Tulum Km 51, Playa Maroma, Riv. Maya, Solidaridad Q Roo', 0, '', 'www.weddingsonthemove.com/maroma'),
(163, 72, '', '', 'Cancun ', '\r\nBoulevard Kukulkan Km. 5.8, Zona Hotelera. Cancun, Quintana Roo, Mexico.\r\n', 0, '', 'www.weddingsonthemove.com/sunset-lagoon'),
(164, 72, '', '77500', 'Cancun ', '\r\nPunta Cancun s/n, Zona Hotelera Cancun,\r\n\r\nQuintana Roo, Mexico 77500 \r\n\r\n', 0, '', 'www.weddingsonthemove.com/dreams'),
(165, 72, '', '', 'Ensenada ', '\r\nKm. 105.5 Tijuana - Ensenada Road\r\nEnsenada, Baja California, Mexico.\r\n\r\n', 0, '', 'www.weddingsonthemove.com/lasrosas'),
(166, 72, '', '', 'Monterrey ', '', 0, '', 'www.weddingsonthemove.com/'),
(167, 72, '', '', 'Cancun ', '', 0, '', 'www.weddingsonthemove.com/flamingo-cancun'),
(168, 72, '', '77500', 'Cancun ', 'Blvd. Kukulcan km. 3,5', 0, '', 'www.weddingsonthemove.com/cancun-catholic-church'),
(169, 72, '', '', 'Cancun ', 'Asistente Grupos y Convenciones | Assitant to Director of Conference Services\r\n\r\nBoulevard Kukulcán Km. 16.5 Hotel Zone\r\nCancún Quintana Roo México C.P. 77500\r\n \r\n\r\n', 0, '', 'www.weddingsonthemove.com/gran-melia-cancun'),
(170, 72, '', '', 'Riviera Maya - Puert', 'SM 12, Mza. 15, Lote 1-02, 103\r\nPredio María Irene, Puerto Morelos. \r\nMunicipio Benito Juárez\r\nQ. Roo, México C.P. 77511 ', 0, '', 'www.weddingsonthemove.com/h10-ocean-coral'),
(171, 72, '', '', 'Cancun ', ' Blvd. Kukulcan KM 11.5, HZ\r\nCancun, 77500\r\nQ. Roo, México', 0, '', 'www.weddingsonthemove.com/royal-cancun'),
(172, 72, '', '', 'Ensenada ', '\r\nEstero Beach Hotel/Resort\r\nPlayas del estero S/N\r\nEx - Ejido Chapultepec, Ensenada\r\nBaja California, Mexico\r\n\r\n', 0, '', 'www.weddingsonthemove.com/estero-beach-hotel'),
(173, 72, '', '', 'Riviera Maya - Puert', '', 0, '', 'www.weddingsonthemove.com/villa-sol-y-luna'),
(176, 72, '', '', 'Mexico City ', '', 0, '', 'www.weddingsonthemove.com/testShortLinks'),
(177, 72, '', '', 'Merida ', '', 0, '', 'www.weddingsonthemove.com/'),
(178, 72, '', '', 'Riviera Maya - Puert', '\r\n \r\n\r\n', 0, '', 'www.weddingsonthemove.com/paradisus-cancun-resorp'),
(179, 72, '', '', 'Cancun ', '\r\nHOTEL TEMPTATION RESORT AND SPA (Antes Blue Bay Cancun Adults Only)\r\nHOTEL BLUE BAY CLUB CANCUN\r\nHOTEL DESIRE RESORT AND SPA\r\n\r\n', 0, '', 'www.weddingsonthemove.com/temptation-resort'),
(180, 27, '', '', 'Punta Cana ', 'PROVINCIA LA ALTAGRACIA\r\nUVERO ALTO-HIGUEY', 0, '', 'www.weddingsonthemove.com/dreams-punta-cana'),
(181, 27, '', '', 'Punta Cana ', 'PLAYA BAVARO, HIGUEY', 0, '', 'www.weddingsonthemove.com/bavaro-princess'),
(182, 38, '', '', 'Maui ', '', 0, '', 'www.weddingsonthemove.com/royal-lahaina'),
(183, 72, '', '', 'Riviera Maya - Puert', '', 0, '', 'www.weddingsonthemove.com/casa-del-cielo'),
(184, 72, '', '', 'Riviera Maya - Playa', '', 0, '', 'www.weddingsonthemove.com/grand-mayan-riviera'),
(185, 61, '', '', 'Cefalu, Sicily ', '', 0, '', 'www.weddingsonthemove.com/cefalu-castle'),
(186, 38, '', '', 'Maui ', '', 0, '', 'www.weddingsonthemove.com/makena-surf-beach'),
(187, 72, '', '', 'Progreso', '', 0, '', 'www.weddingsonthemove.com/hotel-reef-yucatan'),
(188, 72, '', '', 'Riviera Maya - Puert', '', 0, '', 'www.weddingsonthemove.com/catalonia-riviera-maya'),
(189, 19, '', 'KY1-1106', 'Cayman Islands ', 'P.O. Box 443GT test', 0, '', 'www.weddingsonthemove.com/cayman-beach'),
(190, 72, '', '', 'Mazatlan ', '\r\n Laura Raygoza Scott\r\n\r\nEjecutiva de Ventas\r\n\r\nHotel Oceano Palace &\r\n\r\nSuites Luna Palace.\r\n\r\nTel: 01 (669) 916-1160 / 914-1231.\r\n\r\nFax: 01 (669) 913-9666.\r\n\r\nMéxico: 01 800 696-7800.\r\n\r\nU.S.A. 1 800 352-7690.\r\n\r\nCANADA: 1 866 891-4214.\r\n\r\n', 0, '', 'www.weddingsonthemove.com/luna-palace-mazatlan'),
(191, 72, '', '', 'Cancun ', '', 0, '', 'www.weddingsonthemove.com/sun-palace'),
(192, 72, '', '', 'Cancun ', 'CANCUN CARIBE ROYAL PARK GRAND', 0, '', 'www.weddingsonthemove.com/cancun-caribe-park-royal'),
(193, 72, '', '', 'Cancun ', '', 0, '', 'www.weddingsonthemove.com/oasis-resorts-cancun'),
(194, 38, '', '', 'Kauai ', '', 0, '', 'www.weddingsonthemove.com/kauai-beach'),
(195, 45, '', '', 'Runaway Bay', '\r\nPO Box 65\r\nRunaway Bay, St. Ann, Jamaica, West Indies\r\n\r\n \r\n\r\n', 0, '', 'www.weddingsonthemove.com/royal-decameron-club-caribbean'),
(196, 133, '', '', 'Rio de Janeiro', 'Christ Church\r\nRua Real Grandeza 99\r\nBotafogo 22281 - 030\r\nRio de Janeiro\r\n\r\n\r\n\r\n \r\n\r\n', 0, '', 'www.weddingsonthemove.com/brazil-christian-church'),
(197, 72, '', '', 'Cancun ', 'test', 0, '', 'www.weddingsonthemove.com/testt'),
(198, 9, '', '', 'Aruba ', ' ', 0, '', 'www.weddingsonthemove.com/riu-palace-aruba'),
(199, 72, '', '', 'Ixtapa/Zihuatanejo ', '', 0, '', 'www.weddingsonthemove.com/'),
(200, 38, '', '96795', 'Oahu ', '\r\nTommy DeHarne\r\n41-1003 Laumilo Street\r\nWaimanola, WI  96795\r\n\r\n \r\n\r\n \r\n\n\n', 0, '', 'www.weddingsonthemove.com/Waimanalo_Beach_Cottages'),
(201, 72, '', '', 'Cabo San Lucas ', '', 0, '', 'www.weddingsonthemove.com/'),
(202, 77, '', '', 'Antigua', '\r\n', 0, '', 'www.weddingsonthemove.com/sugarridge'),
(203, 31, '', '', 'Key West ', '901 Fleming Street • Key West • Corner of Margaret & Fleming', 0, '', 'www.weddingsonthemove.com/'),
(204, 72, '', '', 'Cancun ', '\r\n\r\n\r\n', 0, '', 'www.weddingsonthemove.com/'),
(205, 8, '', '', 'Anguilla ', '', 0, '', 'www.weddingsonthemove.com/'),
(206, 77, '', '', 'Antigua', '', 0, '', 'www.weddingsonthemove.com/'),
(207, 27, '', '', 'Punta Cana ', '\r\nCtra. Arena Gorda a Macao S/N\r\n\r\nEntrada por Club de Golf Punta Blanca, junto a Bahía Príncipe.\r\n\r\nBávaro, República Dominicana\r\n\r\n', 0, '', 'www.weddingsonthemove.com/'),
(208, 72, '', '', 'Cancun ', 'Carretera a Punta Sam Km. 5.2 Mza 9 Lote 3 SM-2, Zona Continental de Isla Mujeres, Cancun, Q. Roo, Mexico 77400', 0, '', 'www.weddingsonthemove.com/'),
(209, 15, '', '', 'Bermuda', '', 0, '', 'www.weddingsonthemove.com/');

-- --------------------------------------------------------

--
-- Структура таблицы `venue_contact`
--

CREATE TABLE IF NOT EXISTS `venue_contact` (
  `id` int(11) NOT NULL,
  `venue_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `skype` varchar(255) NOT NULL,
  `phone` text NOT NULL,
  `contact_type` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=247 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `venue_contact`
--

INSERT INTO `venue_contact` (`id`, `venue_id`, `name`, `email`, `skype`, `phone`, `contact_type`) VALUES
(152, 96, 'Grisel Cordones', '', '', '809-682-0404', 3),
(153, 97, 'Evelyn', '', '', '01152998 848 9000 ext. 7200', 1),
(154, 98, '', '', '', '800-635-1836, ext. 6010', 1),
(155, 98, 'Carolina Lopez, Sr. Wedding Planner', '', '', '800-635-1836', 2),
(156, 99, 'Srta. Lily or Gena', '', '', '01152 322 222 1326', 1),
(157, 123, 'Edith Moran', '', '', '+52 322 226 7040', 1),
(158, 123, 'Ivonne Torres', 'ivonne.torres@premiereonline.com.mx', '', '+52 322 226 7040', 2),
(159, 123, 'Ana Diaz y Carlos Aleluya', 'reservations@premiereonline.com.mx, reservations2@premiereonline.com.mx', '', '+52 322 226 7040', 3),
(160, 124, '', '', '', '+52 322 226 70 00', 1),
(161, 125, 'Dalia Aguirre', '', '', '+52 322 226 66 67', 1),
(162, 125, 'Denys Montes de Oca (Grte de Vnts Intern)', 'sales@haciendaonline.com', '', '', 2),
(163, 125, 'Guadalupe Sбnchez', 'reservaciones@haciendaonline.com.mx', '', '', 3),
(164, 126, '', '', '', '+529848772880', 1),
(165, 126, 'Roberto Cintro', 'salesdir@grandcocobay.com', '', '+529848772880', 2),
(166, 127, 'Landy Cahum (ass coord bodas)', '', '', '+52 984 871 3333', 1),
(167, 129, 'Laura Aguilar', '', '', '+52 984 80 30 232 /+52 984 87 312 16', 1),
(168, 131, 'Cecilia Morales & Rosy Aldeni', '', '', '52 984 87 301 88', 1),
(169, 132, 'Cecilia Morales & Rosy Aldeni', '', '', '+52 984 87 301 88', 1),
(170, 133, 'Jose-Luis Rivera', '', '', '+52 984 877 40 00', 1),
(171, 133, 'Jose-Luis Rivera (General Manager)', 'gerencia@petitlafitte.com', '', '', 2),
(172, 133, 'Ernesto Hernandez', 'reservaciones@petitlafitte.com', '', '', 3),
(173, 134, 'Valeria Martinez (Weddings executive Lomas Travel)', '', '', '+52 998 881 9400 ext 2409', 1),
(174, 134, 'Rafaela la Antigua (Chief Weddings executive Lomas Travel)', 'weddingscoord@lomas-travel.com', '', '+52 998 881 9400', 2),
(175, 135, 'Paula Riquelme', '', '', '+52 984 206 3350', 1),
(176, 136, 'Pierre-Andre Rueg', '', '', '+529848734260 / +529848730616', 1),
(177, 136, 'Pierre-Andre Rueg', '', '', '', 2),
(178, 136, 'Maripaz', '', '', '', 3),
(179, 138, '', '', '', '+52 984 84 09 012', 1),
(180, 139, '', '', '', '+52 984 87 30591', 1),
(181, 140, 'Pilar Reyero', '', '', '+52 984 803 2022/3', 1),
(182, 141, 'Olga Marin', '', '', '+52 669 913 11 11', 1),
(183, 143, 'Lupita Palacios', '', '', '+52 998 891 54 32 direct / +52 998 883 11 00', 1),
(184, 143, 'Lupita Palacios', 'lupita.palacios@ambiancevillas.com / lupita.palacios@kinhabeach.com', '', '+52 998 891 54 32 direct / +52 998 883 11 00', 2),
(185, 144, 'Liliana Alatorre - Special Events Coordinator', '', '', '+52 984 871 5323', 1),
(186, 145, 'Jesus R. Gaxiola Sanchez ', '', '', ' +52 (669) 913-33-33 Ext. 3222', 1),
(187, 146, 'Josefina Luna', '', '', '+52 998 20 14 directo / 881 2000 hotel', 1),
(188, 147, 'Paloma Flores', '', '', '+52984 8755000 ext 28117', 1),
(189, 149, 'Eva Consuelo Brambila Ortega', '', '', '+52 (669) 913 22 22', 1),
(190, 150, 'Magaly Yanez & Aileen Fonseca ', '', '', '+52 998 287 38 00 Ext 6507', 1),
(191, 150, 'Corporate Office Ventas', '', '', '+52 998 848 9900', 2),
(192, 150, 'Corporate Office reservations', '', '', '+52 998 848 91 44', 3),
(193, 151, 'Zulma Dominguez', '', '', ': (52) (984) 877-29-00 Ext.4014 ', 1),
(194, 152, 'Jessica Pedroza', '', '', '+52 998 848 9835', 1),
(195, 153, 'Karen Shields', '', '', '876-953-2800 ext 5061', 1),
(196, 153, 'Karen Shields', '', '', '', 2),
(197, 154, 'Damarys Diaz', '', '', '+52 984 87 73 500 ext 4362', 1),
(198, 155, 'Sarah Emerson', '', '', '+52 669 989 8900 ext 8760', 1),
(199, 159, 'Clara Zamora', '', '', '', 1),
(200, 160, 'gabriela rivera ', '', '', '+52.998.848.7400 ext 4153', 1),
(201, 161, 'Carena Trampe', '', '', '+529988728200', 1),
(202, 163, 'Adriana Velez', '', '', '52 (998) 881-4615/4500', 1),
(203, 164, 'Alejandra Galindo (Group Sales Manager)', '', '', '+52 998 848 7000 ext 7606', 1),
(204, 164, 'Alejandra Galindo (Group Sales Manager)', 'groups.drecu@dreamsresorts.com', '', '+52 998 848 7000 ext 7606', 3),
(205, 165, 'Yvonne Tapia', '', '', '52 (646) 174 4595/4310/4320/4360/5674', 1),
(206, 166, 'Patti', '', '', '', 1),
(207, 167, 'Sandra Rojas', '', '', '998 8 48 88 70 Ext. 2676', 1),
(208, 168, 'Lupita Ramos', '', '', '+52 998 849 5035', 1),
(209, 169, 'Irma Del Бngel', '', '', '(52.998) 881.1708', 1),
(210, 170, 'Madelline Ramirez / Ana', '', '', '(998) 287 21 00 ext. 3021.', 1),
(211, 171, 'Vicky Iniesta', '', '', '+52 (998) 8 81 73 10', 1),
(212, 172, 'Alma Cruz Patino', '', '', '011(52646) 176 - 6225/30/35', 1),
(213, 177, 'etryretyre', '', '', '', 1),
(214, 178, 'Perla Cervantes Moreno', '', '', '52 (998) 872 83 83 ext 8223', 1),
(215, 179, 'Luz Elena Cortizo', '', '', '(998) 8.89.95.17, 8.48.79.03', 1),
(216, 180, 'Grisel Cordones', '', '', '(809) 682-0404 phone Ext 6131', 1),
(217, 181, '', '', '', '809-221-2311 ', 1),
(218, 182, 'Theresa', '', '', '', 1),
(219, 183, 'n.a.', '', '', '', 1),
(220, 183, 'Solmar rental', '', '', '866 726 1808 / 858 204 90 35', 3),
(221, 184, 'Yazmin Delamora', '', '', '011-52-984-109-5039', 1),
(222, 185, 'Alessandra', '', '', '', 1),
(223, 187, 'Lili E. Monsivais Glz.', '', '', '1 999 941 94 94', 1),
(224, 189, 'Desiree Evans', '', '', '345 949 9333 ', 1),
(225, 190, 'Jose Roman Nunez', '', '', '52 669 9130 777', 1),
(226, 190, 'Laura Raygoza Scott', '', '', '(669) 916-1160 / 914-1231.', 2),
(227, 191, 'Claudia Martinez', '', '', '', 1),
(228, 192, 'Brenda Camacho', '', '', '8-48-78-26/ 8-48-78-00 Ext 7808', 1),
(229, 195, 'Diane Fairchild', '', '', '876-973-4802', 1),
(230, 195, 'German De Pombo', '', '', '(876) 973-4803 ', 2),
(231, 196, 'Rev David Weller', '', '', '(55 21) 2226-7332 ', 1),
(232, 196, 'Karen Natalie Pegler', 'chchurch@terra.com.br', '', '', 2),
(233, 197, '123456', '', '', '', 1),
(234, 198, 'Carolina Hernбndez ', '', '', '(297) 586 3900 ', 1),
(235, 199, 'Albina', '', '', ' +52 (55) 5487-5228 ', 1),
(236, 199, 'Mr. Eloin - Food & Beverage Manager', '', '', '', 2),
(237, 200, 'Tommy DeHarne', '', '', '808-478-0274', 1),
(238, 202, '', '', '', '268-562-7700', 1),
(239, 202, 'Keith Martel', ' ', '', '268-464-7000', 2),
(240, 203, 'Ron Scott', '', '', '305-292-5177 ', 1),
(241, 204, 'Lic. Katia Vargas Libreros - (Edgar)', '', '', '52 (998) 8488400 Ext:4040', 1),
(242, 207, 'Bego', '', '', '+1 829.943.81.18', 1),
(243, 208, 'Karina Peсa ', '', '', '+52 (998) 193 2600 Ext. 509', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `venue_doc`
--

CREATE TABLE IF NOT EXISTS `venue_doc` (
  `id` int(11) NOT NULL,
  `venue_id` int(11) NOT NULL,
  `doc` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `venue_has_service`
--

CREATE TABLE IF NOT EXISTS `venue_has_service` (
  `venue_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `venue_has_type`
--

CREATE TABLE IF NOT EXISTS `venue_has_type` (
  `venue_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `venue_has_vibe`
--

CREATE TABLE IF NOT EXISTS `venue_has_vibe` (
  `venue_id` int(11) NOT NULL,
  `vibe_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `venue`
--
ALTER TABLE `venue`
  ADD PRIMARY KEY (`id`), ADD KEY `type_id` (`type_id`);

--
-- Индексы таблицы `venue_address`
--
ALTER TABLE `venue_address`
  ADD UNIQUE KEY `venue_id_2` (`venue_id`), ADD KEY `venue_id` (`venue_id`);

--
-- Индексы таблицы `venue_contact`
--
ALTER TABLE `venue_contact`
  ADD PRIMARY KEY (`id`), ADD KEY `venue_id` (`venue_id`), ADD KEY `venue_id_2` (`venue_id`);

--
-- Индексы таблицы `venue_doc`
--
ALTER TABLE `venue_doc`
  ADD PRIMARY KEY (`id`), ADD KEY `venue_id` (`venue_id`), ADD KEY `venue_id_2` (`venue_id`);

--
-- Индексы таблицы `venue_has_service`
--
ALTER TABLE `venue_has_service`
  ADD PRIMARY KEY (`venue_id`,`service_id`), ADD KEY `venue_id` (`venue_id`), ADD KEY `service_id` (`service_id`), ADD KEY `venue_id_2` (`venue_id`), ADD KEY `service_id_2` (`service_id`);

--
-- Индексы таблицы `venue_has_type`
--
ALTER TABLE `venue_has_type`
  ADD PRIMARY KEY (`venue_id`,`type_id`), ADD KEY `venue_id` (`venue_id`), ADD KEY `type_id` (`type_id`);

--
-- Индексы таблицы `venue_has_vibe`
--
ALTER TABLE `venue_has_vibe`
  ADD PRIMARY KEY (`venue_id`,`vibe_id`), ADD KEY `venue_id` (`venue_id`), ADD KEY `vibe_id` (`vibe_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `venue`
--
ALTER TABLE `venue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=236;
--
-- AUTO_INCREMENT для таблицы `venue_contact`
--
ALTER TABLE `venue_contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=247;
--
-- AUTO_INCREMENT для таблицы `venue_doc`
--
ALTER TABLE `venue_doc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `venue_address`
--
ALTER TABLE `venue_address`
ADD CONSTRAINT `venue_address_ibfk_1` FOREIGN KEY (`venue_id`) REFERENCES `venue` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `venue_contact`
--
ALTER TABLE `venue_contact`
ADD CONSTRAINT `venue_contact_ibfk_1` FOREIGN KEY (`venue_id`) REFERENCES `venue` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `venue_doc`
--
ALTER TABLE `venue_doc`
ADD CONSTRAINT `venue_doc_ibfk_1` FOREIGN KEY (`venue_id`) REFERENCES `venue` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `venue_has_service`
--
ALTER TABLE `venue_has_service`
ADD CONSTRAINT `venue_has_service_ibfk_1` FOREIGN KEY (`venue_id`) REFERENCES `venue` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `venue_has_service_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `venue_service` (`id`);

--
-- Ограничения внешнего ключа таблицы `venue_has_type`
--
ALTER TABLE `venue_has_type`
ADD CONSTRAINT `venue_has_type_ibfk_1` FOREIGN KEY (`venue_id`) REFERENCES `venue` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `venue_has_type_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `venue_type` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `venue_has_vibe`
--
ALTER TABLE `venue_has_vibe`
ADD CONSTRAINT `venue_has_vibe_ibfk_1` FOREIGN KEY (`venue_id`) REFERENCES `venue` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `venue_has_vibe_ibfk_2` FOREIGN KEY (`vibe_id`) REFERENCES `vibe` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
