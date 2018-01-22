-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 22 Sty 2018, 17:33
-- Wersja serwera: 10.1.21-MariaDB
-- Wersja PHP: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `projekt`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `signups`
--

CREATE TABLE `signups` (
  `signups_id` int(10) NOT NULL,
  `signup_email_address` varchar(250) DEFAULT NULL,
  `signup_date` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `signups`
--

INSERT INTO `signups` (`signups_id`, `signup_email_address`, `signup_date`) VALUES
(1, 'gblazusiak@gmail.com', '2017-09-08 17:43:29'),
(2, 'janek@gmail.com', '2018-01-18 14:44:20'),
(13, 'janusz@tulczyn.pl', '2018-01-22 17:28:15'),
(12, 'Andrzej@o2.pl', '2018-01-21 23:18:24'),
(11, 'Janek@jan.com', '2018-01-21 23:02:22');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id` int(11) NOT NULL,
  `user` text COLLATE utf8_polish_ci NOT NULL,
  `pass` text COLLATE utf8_polish_ci NOT NULL,
  `email` text COLLATE utf8_polish_ci NOT NULL,
  `dnipremium` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id`, `user`, `pass`, `email`, `dnipremium`) VALUES
(27, 'Samuraj', '$2y$10$b0lDpZ/N6nJ2/FXJdl5nq.i9MHhttNFl6bKZ3xbe7wVj.lYB7orxW', 'gblazusiak@gmail.com', '2018-06-19 00:00:00'),
(31, 'Tracz', '$2y$10$FD7ZUwZPt3USqbz.od5sZOZ5/0f7dtoW/JeyAsxH3hyt6swLPEGf6', 'janusz@tulczyn.pl', '2018-01-29 17:27:58');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `signups`
--
ALTER TABLE `signups`
  ADD PRIMARY KEY (`signups_id`);

--
-- Indexes for table `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `signups`
--
ALTER TABLE `signups`
  MODIFY `signups_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
