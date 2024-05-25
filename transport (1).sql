-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Апр 29 2024 г., 12:22
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `transport`
--

-- --------------------------------------------------------

--
-- Структура таблицы `autobusy`
--

CREATE TABLE `autobusy` (
  `id` int(11) NOT NULL,
  `numer` int(11) NOT NULL,
  `id_kierunka` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `autobusy`
--

INSERT INTO `autobusy` (`id`, `numer`, `id_kierunka`) VALUES
(1, 76571, 5),
(2, 98765, 9),
(3, 12345, 4),
(4, 65432, 7),
(5, 10062, 1),
(6, 20089, 3),
(7, 54499, 2),
(8, 43128, 6),
(9, 76859, 10),
(10, 67581, 8);

-- --------------------------------------------------------

--
-- Структура таблицы `cv`
--

CREATE TABLE `cv` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `umiejetnosci` varchar(255) NOT NULL,
  `doswiadczenie` varchar(255) NOT NULL,
  `wiek` int(100) NOT NULL,
  `poziom_angielskiego` varchar(255) NOT NULL,
  `edukacja` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `cv`
--

INSERT INTO `cv` (`id`, `email`, `umiejetnosci`, `doswiadczenie`, `wiek`, `poziom_angielskiego`, `edukacja`) VALUES
(1, 'darya@gmail.com', 'napisanie maili', 'nie mam', 23, 'C2', 'TEB Technikum'),
(2, 'mateusz@gmail.com', 'naprawienie błędów związanych z autobusami', '5 lat pracowałem w STO', 55, 'B2', 'Politechnika Warszawska'),
(3, 'pawel@gmail.com', 'kierowca', '20 lat ', 50, 'C2', 'Politechnika Warszawska');

-- --------------------------------------------------------

--
-- Структура таблицы `kierunki`
--

CREATE TABLE `kierunki` (
  `id` int(11) NOT NULL,
  `punkt_od` varchar(255) NOT NULL,
  `punkt_do` varchar(255) NOT NULL,
  `cena` int(11) NOT NULL,
  `id_autobusa` int(11) NOT NULL,
  `czas` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `kierunki`
--

INSERT INTO `kierunki` (`id`, `punkt_od`, `punkt_do`, `cena`, `id_autobusa`, `czas`) VALUES
(1, 'Warsawa', 'Gdansk', 50, 5, 'Wtorek 18:00\r\nPiątek 16:00'),
(2, 'Gdansk', 'Londyn', 120, 7, 'Wtorek 10:50\r\nŚroda 15:00'),
(3, 'Lodz', 'Budapeszt', 100, 6, 'Sobota 20:00\r\nCzwartek 20:00'),
(4, 'Wroclaw', 'Praga', 150, 3, 'Wtorek 12:00\r\nPiątek 14:30'),
(5, 'Gdansk', 'Berlin', 200, 1, 'Niedziela 17:40\r\nŚroda 12:00'),
(6, 'Szczecin', 'Lwow', 200, 8, 'Wtorek 12:00\r\nPiątek 17:00'),
(7, 'Białystok', 'Wilno', 150, 4, 'Środa 11:40\r\nCzwartek 16:00'),
(8, 'Katowice', 'Warszawa', 30, 10, 'Sobota 13:00\r\nCzwartek 18:30'),
(9, 'Bygdosz', 'Amsterdam', 350, 2, 'Piątek 12:00\r\nSobota 9:00'),
(10, 'Olsztyn', 'Sztokholm', 450, 9, 'Środa 18:20\r\nPiątek 13:30');

-- --------------------------------------------------------

--
-- Структура таблицы `pytania`
--

CREATE TABLE `pytania` (
  `id` int(11) NOT NULL,
  `tresc_pytania` varchar(255) NOT NULL,
  `email_odprawiciela` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `pytania`
--

INSERT INTO `pytania` (`id`, `tresc_pytania`, `email_odprawiciela`) VALUES
(1, 'Czy jest w autobusach Wi-Fi?', 'darya@gmail.com'),
(2, 'Czy mogę śliedzic gdzie teraz jest mój autobus?', 'adam@gmail.com'),
(3, 'Czy planuję Państwo dodać kierunek Warszawa-Mińsk', 'mateusz@gmail.com'),
(4, 'Jakie są najpopularniejsze trasy, którymi podróżują pasażerowie tego autobusu, i czy istnieją alternatywne trasy, które warto rozważyć?', 'marta@gmail.com'),
(5, 'Jakie są zasadnicze procedury dotyczące bagażu, w tym limit wagowy, opcje przechowywania bagażu oraz zasady dotyczące przewożenia bagażu specjalnego, takiego jak rowery czy wózki dziecięce?', 'nikola@gmail.com');

-- --------------------------------------------------------

--
-- Структура таблицы `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `haslo` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `rola` varchar(255) NOT NULL,
  `id_akt_podrozy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id`, `login`, `haslo`, `email`, `rola`, `id_akt_podrozy`) VALUES
(1, 'darya', '$2y$10$Ox/FJ3ZEuMQTYfoigYG9Se4Ca.cXsPB9Od95hTdhm2KwX02n8bTLa', 'darya@gmail.com', 'user', 3),
(2, 'adam', '$2y$10$HkUHMEcQBbMofBoQCGENDOYFXzu6r7ghbuVoxKuWY/YKMUcCY1gWq', 'adam@gmail.com', 'user', 2),
(3, 'mateusz', '$2y$10$HM6B3rdXVR6x7DUjI5h4TuWjEhqVvomgYJiDUQ9EC.yS38pNoVOa.', 'mateusz@gmail.com', 'user', NULL),
(4, 'jan', '$2y$10$fkqoER4eZpUuPcOHfqV.8eojHknLE8/lvfdssspHsWabxTop71.q.', 'jan@gmail.com', 'user', NULL),
(5, 'marta', '$2y$10$fZHCddKaMJYuB1.h9Xx8Q.TI9FuogoWvsce5nyg6CTPn3m4AfP2se', 'marta@gmail.com', 'user', NULL),
(6, 'karolina', '$2y$10$klZ1jsRtCyo1BlvT3JWzLeBg3RLjsRfoW7hgvmVi63uX/f1LSJQre', 'karolina@gmail.com', 'admin', NULL),
(7, 'karol', '$2y$10$mV8zRqZv0OHdvo6ZtxoIKuA4Od9iA3J0eBvIsDAplE9mRRPHNN.Ri', 'karol@gmail.com', 'admin', NULL),
(8, 'aleksandra', '$2y$10$dLAqrgTnpCs7/rHSiwmtUuhE/E7uoK4oKnH2SCRGG4MTAS9bZxlxS', 'aleksandra@gmail.com', 'admin', NULL),
(9, 'anna', '$2y$10$DaUu7qR.z7r9NkS8Qy1CJubadP/Yudn5HXUmX.eposCZVAXJ9O4Dq', 'anna@gmail.com', 'admin', NULL),
(10, 'nikola', '$2y$10$T2bPv0Cjw3LME/O13zZqP.pGTU/5jXFEgG0J3BkRSJJQ1r2FKT4J2', 'nikola@gmail.com', 'user', NULL),
(11, 'matylda', '$2y$10$iKhjQXoL4M1Bowi3/IVLp.Oiqa7gC9ug/TwymemSIW3z/qGRgHGs2', 'matylda@gmail.com', 'user', NULL),
(12, 'sebastian', '$2y$10$uycV4qIddiYSsOy2KDZi7.ItXqkey7ZK11gL16jqRFVzFJb2I4hZS', 'sebastian@gmail.com', 'admin', NULL),
(13, 'pawel', '$2y$10$mGqbY1q4agBw/nRDuW6q3OjtG9KCDiDFGoGuEb0Ou8ASj6.yjQshq', 'pawel@gmail.com', 'user', NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `autobusy`
--
ALTER TABLE `autobusy`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `cv`
--
ALTER TABLE `cv`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `kierunki`
--
ALTER TABLE `kierunki`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `pytania`
--
ALTER TABLE `pytania`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `autobusy`
--
ALTER TABLE `autobusy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `cv`
--
ALTER TABLE `cv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `kierunki`
--
ALTER TABLE `kierunki`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `pytania`
--
ALTER TABLE `pytania`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
