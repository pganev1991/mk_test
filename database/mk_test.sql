-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Време на генериране: 29 ное 2023 в 09:16
-- Версия на сървъра: 10.4.28-MariaDB
-- Версия на PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данни: `mk_test`
--

-- --------------------------------------------------------

--
-- Структура на таблица `analisys`
--

CREATE TABLE `analisys` (
  `id` int(11) NOT NULL,
  `theme` varchar(255) DEFAULT NULL,
  `difficulty` int(11) DEFAULT NULL,
  `question` text DEFAULT NULL,
  `question_img` varchar(255) DEFAULT NULL,
  `correct_answer` int(11) DEFAULT NULL,
  `answer1` text DEFAULT NULL,
  `answer1_img` varchar(255) DEFAULT NULL,
  `answer2` text DEFAULT NULL,
  `answer2_img` varchar(255) DEFAULT NULL,
  `answer3` text DEFAULT NULL,
  `answer3_img` varchar(255) DEFAULT NULL,
  `answer4` text DEFAULT NULL,
  `answer4_img` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура на таблица `ear`
--

CREATE TABLE `ear` (
  `id` int(11) NOT NULL,
  `theme` varchar(255) DEFAULT NULL,
  `difficulty` int(11) DEFAULT NULL,
  `question` text DEFAULT NULL,
  `question_img` varchar(255) DEFAULT NULL,
  `correct_answer` int(11) DEFAULT NULL,
  `answer1` text DEFAULT NULL,
  `answer1_img` varchar(255) DEFAULT NULL,
  `answer2` text DEFAULT NULL,
  `answer2_img` varchar(255) DEFAULT NULL,
  `answer3` text DEFAULT NULL,
  `answer3_img` varchar(255) DEFAULT NULL,
  `answer4` text DEFAULT NULL,
  `answer4_img` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Схема на данните от таблица `ear`
--

INSERT INTO `ear` (`id`, `theme`, `difficulty`, `question`, `question_img`, `correct_answer`, `answer1`, `answer1_img`, `answer2`, `answer2_img`, `answer3`, `answer3_img`, `answer4`, `answer4_img`) VALUES
(123, 'Интервали', 5, 'Какъв прост мелодически интервал прозвучава?', '', 0, 'г. 3', '', 'м. 2', '', 'ч. 4', '', 'ув. 4', ''),
(124, 'Ладове', 4, 'Каква разновидност на мажора прозвучава?', NULL, 3, 'Натурален', '', 'Мелодичен', '', 'Хармоничен', '', 'Бихармоничен', ''),
(125, 'Интервали', 3, 'Какъв хармоничен прост интервал прозвучава?', '', 1, 'ч. 4', '', 'ч. 5', '', 'м. 3', '', 'г. 6', ''),
(126, 'Ладове', 4, 'Какъв вид пентатоничен лад прозвучава?', '', 1, 'Мажорна пентатоника', '', 'Минорна пентатоника', '', 'Реверсивна пентатоника', '', 'Хипореверсивна пентатоника', ''),
(127, 'Акорди', 6, 'Каква разновидност на мажора прозвучава?', '', 2, 'Натурален', '', 'Мелодичен', '', 'Хармоничен', '', 'Бихармоничен', ''),
(128, 'Акорди', 7, 'Какъв старинен лед прозвучава?', '', 1, 'Дорийски', '', 'Фригийски', '', 'Лидийски', '', 'Миксолидийски', ''),
(129, 'Размери', 4, 'Какъв размер прозвучава?', '', 3, '3/4', '', '4/4', '', '5/4', '', '7/8', ''),
(130, 'Размери', 2, 'Какъв метрум прозвучава?', '', 0, 'Двувременен', '', 'Тривременен', '', 'Четиривременен', '', 'Петвременен', ''),
(131, 'Акорди', 3, 'Какво обръщение на мажорно-малкото четиризвучие прозвучава?', '', 2, '7', '', '65', '', '43', '', '2', ''),
(132, 'Ладове', 4, 'Каква разновидност на минора прозвучава?', '', 0, 'Натурален', '', 'Мелодичен', '', 'Хармоничен', '', 'Бихармоничен', ''),
(133, 'Интервали', 2, 'Какъв мелодичен сложен интервал прозвучава?', '', 2, 'ч. 12', '', 'ч. 11', '', 'м. 10', '', 'г. 9', ''),
(134, 'Акорди', 7, 'Какъв вид четиризвучие в тясно разположение прозвучава?', '', 2, 'мажорно-малко 7', '', 'минорно-голямо 7', '', 'полуумалено 7', '', 'полуувеличено 7', '');

-- --------------------------------------------------------

--
-- Структура на таблица `harmony`
--

CREATE TABLE `harmony` (
  `id` int(11) NOT NULL,
  `theme` varchar(255) DEFAULT NULL,
  `difficulty` int(11) DEFAULT NULL,
  `question` text DEFAULT NULL,
  `question_img` varchar(255) DEFAULT NULL,
  `correct_answer` int(11) DEFAULT NULL,
  `answer1` text DEFAULT NULL,
  `answer1_img` varchar(255) DEFAULT NULL,
  `answer2` text DEFAULT NULL,
  `answer2_img` varchar(255) DEFAULT NULL,
  `answer3` text DEFAULT NULL,
  `answer3_img` varchar(255) DEFAULT NULL,
  `answer4` text DEFAULT NULL,
  `answer4_img` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Схема на данните от таблица `harmony`
--

INSERT INTO `harmony` (`id`, `theme`, `difficulty`, `question`, `question_img`, `correct_answer`, `answer1`, `answer1_img`, `answer2`, `answer2_img`, `answer3`, `answer3_img`, `answer4`, `answer4_img`) VALUES
(3, 'Чужди тонове', 7, 'Кои видове чужди тонове отговарят на тези от такт №2 в примера:', 'question_img_1700778793_f36d1b0295a838ce165998bf18eb0b06.png', 1, 'Задържан, предявен', '', 'Задържан, задържан', '', 'Неподготвен, проходящ', '', 'Проходящ, съседен', '');

-- --------------------------------------------------------

--
-- Структура на таблица `history`
--

CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `theme` varchar(255) DEFAULT NULL,
  `difficulty` int(11) DEFAULT NULL,
  `question` text DEFAULT NULL,
  `question_img` varchar(255) DEFAULT NULL,
  `correct_answer` int(11) DEFAULT NULL,
  `answer1` text DEFAULT NULL,
  `answer1_img` varchar(255) DEFAULT NULL,
  `answer2` text DEFAULT NULL,
  `answer2_img` varchar(255) DEFAULT NULL,
  `answer3` text DEFAULT NULL,
  `answer3_img` varchar(255) DEFAULT NULL,
  `answer4` text DEFAULT NULL,
  `answer4_img` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура на таблица `theory`
--

CREATE TABLE `theory` (
  `id` int(11) NOT NULL,
  `theme` varchar(255) DEFAULT NULL,
  `difficulty` int(11) DEFAULT NULL,
  `question` text DEFAULT NULL,
  `question_img` varchar(255) DEFAULT NULL,
  `correct_answer` int(11) DEFAULT NULL,
  `answer1` text DEFAULT NULL,
  `answer1_img` varchar(255) DEFAULT NULL,
  `answer2` text DEFAULT NULL,
  `answer2_img` varchar(255) DEFAULT NULL,
  `answer3` text DEFAULT NULL,
  `answer3_img` varchar(255) DEFAULT NULL,
  `answer4` text DEFAULT NULL,
  `answer4_img` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Схема на данните от таблица `theory`
--

INSERT INTO `theory` (`id`, `theme`, `difficulty`, `question`, `question_img`, `correct_answer`, `answer1`, `answer1_img`, `answer2`, `answer2_img`, `answer3`, `answer3_img`, `answer4`, `answer4_img`) VALUES
(21, 'Сложни интервали', 6, 'Определете сложните мелодически интеврали в такт 1 от нотния пример:', 'question_img_1700808894_37ff64f4bc678685b0573b081f326ef4.png', 2, 'г. 10 и м. 9', NULL, 'ч. 12 и м. 10', NULL, 'ч. 11 и г. 9', NULL, 'г. 13 и м. 9', NULL),
(22, 'Тризвучия', 4, 'Кой вид тризвучие има следния интервалов състав: м. 3 -> ум. 5?', '', 2, 'Мажорно', '', 'Минорно', '', 'Умалено', '', 'Увеличено', ''),
(23, 'Четиризвучия', 5, 'Кой вид четиризвучие има следния интервалов състав: г. 3 -> ч. 5 -> м. 7?', '', 0, 'Мажорно-малко', '', 'Мажорно-голямо', '', 'Минорно-малко', '', 'Полуувеличено', ''),
(24, 'Алтерации', 2, 'В кой такт откривате алтеровани ладови степени?', 'question_img_1700645355_ed11d0c3961f057f1036f03c45f4bd5c.png', 3, '1', '', '2', '', '3', '', '4', ''),
(25, 'Особено деление', 3, 'Триола от осмини ноти се равнява на:', '', 1, 'Цяла нота', '', 'Четвъртина нота', '', 'Половина нота', '', 'Бревис', ''),
(26, 'Сложни интервали', 5, 'Кой сложен интервал е производен от ч. 4 + ч. 8?', '', 2, 'м. 9', '', 'г. 10', '', 'ч. 11', '', 'ч. 12', '');

-- --------------------------------------------------------

--
-- Структура на таблица `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `school` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `role` enum('expert_mk','director_nms') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Схема на данните от таблица `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `first_name`, `last_name`, `email`, `school`, `city`, `phone`, `role`) VALUES
(1, 'pganev91', '$2y$10$.WyGEx3/Ro/.MVT/KxVjhexkyApcNHqzKR3ZF5Lxdn73Hh0E628JS', 'Петко', 'Ганев', 'petkoganev@gmail.com', 'NUMSI Burgas', 'Burgas', '08999942774', 'expert_mk');

--
-- Indexes for dumped tables
--

--
-- Индекси за таблица `analisys`
--
ALTER TABLE `analisys`
  ADD PRIMARY KEY (`id`);

--
-- Индекси за таблица `ear`
--
ALTER TABLE `ear`
  ADD PRIMARY KEY (`id`);

--
-- Индекси за таблица `harmony`
--
ALTER TABLE `harmony`
  ADD PRIMARY KEY (`id`);

--
-- Индекси за таблица `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`);

--
-- Индекси за таблица `theory`
--
ALTER TABLE `theory`
  ADD PRIMARY KEY (`id`);

--
-- Индекси за таблица `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `analisys`
--
ALTER TABLE `analisys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ear`
--
ALTER TABLE `ear`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `harmony`
--
ALTER TABLE `harmony`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `theory`
--
ALTER TABLE `theory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
