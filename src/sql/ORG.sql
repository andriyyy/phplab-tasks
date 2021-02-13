-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Фев 12 2021 г., 23:33
-- Версия сервера: 8.0.23-0ubuntu0.20.04.1
-- Версия PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `ORG`
--

-- --------------------------------------------------------

--
-- Структура таблицы `Bonus`
--

CREATE TABLE `Bonus` (
  `WORKER_REF_ID` int DEFAULT NULL,
  `BONUS_AMOUNT` int DEFAULT NULL,
  `BONUS_DATE` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Bonus`
--

INSERT INTO `Bonus` (`WORKER_REF_ID`, `BONUS_AMOUNT`, `BONUS_DATE`) VALUES
(1, 5000, '2016-02-20 00:00:00'),
(2, 3000, '2016-06-11 00:00:00'),
(3, 4000, '2016-02-20 00:00:00'),
(1, 4500, '2016-02-20 00:00:00'),
(2, 3500, '2016-06-11 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `Title`
--

CREATE TABLE `Title` (
  `WORKER_REF_ID` int DEFAULT NULL,
  `WORKER_TITLE` char(25) DEFAULT NULL,
  `AFFECTED_FROM` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Title`
--

INSERT INTO `Title` (`WORKER_REF_ID`, `WORKER_TITLE`, `AFFECTED_FROM`) VALUES
(1, 'Manager', '2016-02-20 00:00:00'),
(2, 'Executive', '2016-06-11 00:00:00'),
(8, 'Executive', '2016-06-11 00:00:00'),
(5, 'Manager', '2016-06-11 00:00:00'),
(4, 'Asst. Manager', '2016-06-11 00:00:00'),
(7, 'Executive', '2016-06-11 00:00:00'),
(6, 'Lead', '2016-06-11 00:00:00'),
(3, 'Lead', '2016-06-11 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `Worker`
--

CREATE TABLE `Worker` (
  `WORKER_ID` int NOT NULL,
  `FIRST_NAME` char(25) DEFAULT NULL,
  `LAST_NAME` char(25) DEFAULT NULL,
  `SALARY` int DEFAULT NULL,
  `JOINING_DATE` datetime DEFAULT NULL,
  `DEPARTMENT` char(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Worker`
--

INSERT INTO `Worker` (`WORKER_ID`, `FIRST_NAME`, `LAST_NAME`, `SALARY`, `JOINING_DATE`, `DEPARTMENT`) VALUES
(1, 'Monika', 'Arora', 100000, '2014-02-20 09:00:00', 'HR'),
(2, 'Niharika', 'Verma', 80000, '2014-06-11 09:00:00', 'Admin'),
(3, 'Vishal', 'Singhal', 300000, '2014-02-20 09:00:00', 'HR'),
(4, 'Amitabh', 'Singh', 500000, '2014-02-20 09:00:00', 'Admin'),
(5, 'Vivek', 'Bhati', 500000, '2014-06-11 09:00:00', 'Admin'),
(6, 'Vipul', 'Diwan', 200000, '2014-06-11 09:00:00', 'Account'),
(7, 'Satish', 'Kumar', 75000, '2014-01-20 09:00:00', 'Account'),
(8, 'Geetika', 'Chauhan', 90000, '2014-04-11 09:00:00', 'Admin');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `Bonus`
--
ALTER TABLE `Bonus`
  ADD KEY `WORKER_REF_ID` (`WORKER_REF_ID`);

--
-- Индексы таблицы `Title`
--
ALTER TABLE `Title`
  ADD KEY `WORKER_REF_ID` (`WORKER_REF_ID`);

--
-- Индексы таблицы `Worker`
--
ALTER TABLE `Worker`
  ADD PRIMARY KEY (`WORKER_ID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `Worker`
--
ALTER TABLE `Worker`
  MODIFY `WORKER_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `Bonus`
--
ALTER TABLE `Bonus`
  ADD CONSTRAINT `Bonus_ibfk_1` FOREIGN KEY (`WORKER_REF_ID`) REFERENCES `Worker` (`WORKER_ID`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `Title`
--
ALTER TABLE `Title`
  ADD CONSTRAINT `Title_ibfk_1` FOREIGN KEY (`WORKER_REF_ID`) REFERENCES `Worker` (`WORKER_ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
