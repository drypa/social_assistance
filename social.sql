-- phpMyAdmin SQL Dump
-- version 4.0.8
-- http://www.phpmyadmin.net
--
-- Хост: localhost:3306
-- Время создания: Дек 04 2013 г., 07:27
-- Версия сервера: 5.5.32
-- Версия PHP: 5.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `social`
--
CREATE DATABASE IF NOT EXISTS `social` DEFAULT CHARACTER SET cp1251 COLLATE cp1251_general_ci;
USE `social`;

-- --------------------------------------------------------

--
-- Структура таблицы `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `passport` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `middlename` varchar(255) NOT NULL,
  `birth_date` date NOT NULL,
  PRIMARY KEY (`passport`)
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

--
-- Очистить таблицу перед добавлением данных `client`
--

TRUNCATE TABLE `client`;
--
-- Дамп данных таблицы `client`
--

INSERT INTO `client` (`passport`, `surname`, `name`, `middlename`, `birth_date`) VALUES
('1111 0501', 'Петров', 'Петр', 'Петрович', '1975-01-01'),
('4000 1235', 'Иванов', 'Иван', 'Иванович', '1980-01-10');

-- --------------------------------------------------------

--
-- Структура таблицы `contract`
--

DROP TABLE IF EXISTS `contract`;
CREATE TABLE IF NOT EXISTS `contract` (
  `contract_num` int(11) NOT NULL AUTO_INCREMENT,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `client_passport` varchar(255) NOT NULL,
  PRIMARY KEY (`contract_num`),
  KEY `client_passport` (`client_passport`)
) ENGINE=InnoDB  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=3 ;

--
-- Очистить таблицу перед добавлением данных `contract`
--

TRUNCATE TABLE `contract`;
--
-- Дамп данных таблицы `contract`
--

INSERT INTO `contract` (`contract_num`, `start`, `end`, `client_passport`) VALUES
(1, '2010-01-11', '2011-02-11', '1111 0501'),
(2, '2010-01-02', '2010-01-03', '4000 1235');

-- --------------------------------------------------------

--
-- Структура таблицы `departments`
--

DROP TABLE IF EXISTS `departments`;
CREATE TABLE IF NOT EXISTS `departments` (
  `department_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`department_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=5 ;

--
-- Очистить таблицу перед добавлением данных `departments`
--

TRUNCATE TABLE `departments`;
--
-- Дамп данных таблицы `departments`
--

INSERT INTO `departments` (`department_id`, `name`) VALUES
(1, 'Отдел приема граждан'),
(2, 'Отдел психологии'),
(4, 'Юридический отдел');

-- --------------------------------------------------------

--
-- Структура таблицы `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `service_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `department_id` int(11) NOT NULL,
  PRIMARY KEY (`service_id`),
  KEY `department_id` (`department_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=4 ;

--
-- Очистить таблицу перед добавлением данных `services`
--

TRUNCATE TABLE `services`;
--
-- Дамп данных таблицы `services`
--

INSERT INTO `services` (`service_id`, `name`, `department_id`) VALUES
(2, 'психологическая помощь', 2),
(3, 'Юридическая консультация', 4);

-- --------------------------------------------------------

--
-- Структура таблицы `service_log`
--

DROP TABLE IF EXISTS `service_log`;
CREATE TABLE IF NOT EXISTS `service_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contract_num` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `contract_num` (`contract_num`,`service_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=5 ;

--
-- Очистить таблицу перед добавлением данных `service_log`
--

TRUNCATE TABLE `service_log`;
--
-- Дамп данных таблицы `service_log`
--

INSERT INTO `service_log` (`id`, `contract_num`, `service_id`, `date`) VALUES
(1, 1, 2, '2001-11-20'),
(2, 2, 3, '2002-11-20'),
(3, 1, 2, '2010-11-01'),
(4, 2, 3, '2010-11-02');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
