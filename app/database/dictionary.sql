

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `translator`
--

-- --------------------------------------------------------

--
-- Структура таблиці `app`
--

CREATE TABLE `app` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `app_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `app_version` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `plural`
--

CREATE TABLE `plural` (
  `id` int(10) UNSIGNED NOT NULL,
  `plural_group` int(10) UNSIGNED NOT NULL,
  `quantity` enum('zero','one','two','few','many','other') COLLATE utf8_unicode_ci NOT NULL,
  `lang` enum('en','uk','') COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `plural_group`
--

CREATE TABLE `plural_group` (
  `id` int(11) NOT NULL,
  `app_id` int(10) UNSIGNED NOT NULL,
  `item` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `word_en`
--

CREATE TABLE `word_en` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(767) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Структура таблиці `word_en_uk`
--

CREATE TABLE `word_en_uk` (
  `id` int(10) UNSIGNED NOT NULL,
  `word_en` int(10) UNSIGNED NOT NULL,
  `word_uk` int(10) UNSIGNED NOT NULL,
  `app` int(10) UNSIGNED NOT NULL,
  `item` varchar(700) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `plural_group` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `word_en_uk_big`
--

CREATE TABLE `word_en_uk_big` (
  `id` int(10) UNSIGNED NOT NULL,
  `word_en` text COLLATE utf8_unicode_ci,
  `word_uk` text COLLATE utf8_unicode_ci,
  `app` int(10) UNSIGNED NOT NULL,
  `item` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `plural_group` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `word_uk`
--

CREATE TABLE `word_uk` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(10000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `app`
--
ALTER TABLE `app`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `app_id` (`app_id`);

--
-- Індекси таблиці `plural`
--
ALTER TABLE `plural`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `plural_group` (`plural_group`,`quantity`,`lang`);

--
-- Індекси таблиці `plural_group`
--
ALTER TABLE `plural_group`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `app_id` (`app_id`,`item`);

--
-- Індекси таблиці `word_en`
--
ALTER TABLE `word_en`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `english` (`name`);

--
-- Індекси таблиці `word_en_uk`
--
ALTER TABLE `word_en_uk`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `word_en_uk_big`
--
ALTER TABLE `word_en_uk_big`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `word_uk`
--
ALTER TABLE `word_uk`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `app`
--
ALTER TABLE `app`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `plural`
--
ALTER TABLE `plural`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `plural_group`
--
ALTER TABLE `plural_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `word_en`
--
ALTER TABLE `word_en`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `word_en_uk`
--
ALTER TABLE `word_en_uk`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `word_en_uk_big`
--
ALTER TABLE `word_en_uk_big`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `word_uk`
--
ALTER TABLE `word_uk`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
