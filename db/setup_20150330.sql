-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 30 Mar 2015, 15:01:07
-- Sunucu sürümü: 5.6.21
-- PHP Sürümü: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Veritabanı: `inspireme`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
`CommentID` bigint(20) NOT NULL,
  `CommentText` text COLLATE utf8_turkish_ci NOT NULL,
  `UserID` bigint(20) NOT NULL,
  `PostID` bigint(20) NOT NULL,
  `CreatedOn` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `comments`
--

INSERT INTO `comments` (`CommentID`, `CommentText`, `UserID`, `PostID`, `CreatedOn`) VALUES
(1, 'First Comment Text', 1, 1, '2015-03-30 00:00:00'),
(2, 'Second Comment Text', 1, 1, '2015-03-30 00:00:00'),
(3, 'Third Comment Text', 1, 1, '2015-03-30 00:00:00');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `comms`
--

CREATE TABLE IF NOT EXISTS `comms` (
`CommID` bigint(20) NOT NULL,
  `CommName` varchar(32) COLLATE utf8_turkish_ci NOT NULL,
  `ShortDesc` varchar(256) COLLATE utf8_turkish_ci DEFAULT NULL,
  `Privacy` enum('public','private') COLLATE utf8_turkish_ci NOT NULL,
  `CreatedOn` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `comms`
--

INSERT INTO `comms` (`CommID`, `CommName`, `ShortDesc`, `Privacy`, `CreatedOn`) VALUES
(1, 'FA48J 2012-2013 Scriptwriting', 'This community has been created with the purpose of sample display.', 'public', '2015-03-30 00:00:00');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
`PostID` bigint(20) NOT NULL,
  `PostText` text COLLATE utf8_turkish_ci NOT NULL,
  `PostTitle` text COLLATE utf8_turkish_ci NOT NULL,
  `UserID` bigint(20) NOT NULL,
  `CommID` bigint(20) NOT NULL,
  `CreatedOn` datetime NOT NULL,
  `IsDeleted` tinyint(1) NOT NULL DEFAULT '0',
  `PrevPostID` bigint(20) DEFAULT NULL,
  `NextPostID` bigint(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `posts`
--

INSERT INTO `posts` (`PostID`, `PostText`, `PostTitle`, `UserID`, `CommID`, `CreatedOn`, `IsDeleted`, `PrevPostID`, `NextPostID`) VALUES
(1, 'Lorem ipsum dolor sit amet, eu splendide forensibus mei, mel in movet impetus forensibus. Vel ea vidit tacimates. Ut qui facer nostrud elaboraret, harum tritani facilisis mel ut, mel cu lorem nulla. His illud altera no, ea modus verear vim. Ignota electram scripserit id sit. Ne bonorum nominavi quaestio eum, an eos feugait scriptorem.\r\n\r\nAn apeirian qualisque vix, an viris ridens discere mei. Ocurreret quaerendum id nec, enim graece nostro et quo, ad cum denique fabellas. Falli zril laoreet nam et. Et omittam fastidii his, case audiam habemus mel ei.\r\n\r\nIuvaret offendit comprehensam mea ei. Mel ad vero veniam nostrum, mei erat eruditi platonem ut, definiebas scripserit cu has. Ne maiorum vituperatoribus cum, vidit propriae fabellas duo ne, ne mea explicari imperdiet. Malorum insolens neglegentur ex pri. Ullum mollis ut eos, an pri fugit efficiantur.\r\n\r\nAt nullam feugait vis, vim ne tale everti prodesset, menandri dissentias per eu. No aeque quidam ponderum qui. Et aeque noster sit. Eu vel everti melius habemus, eum vulputate definitionem ut, usu exerci urbanitas ne. Idque tacimates adversarium per ad. Vix viris dolorum feugait ei, vero summo tation sit ex.\r\n\r\nTibique dolores gubergren eu eam, unum bonorum in usu. Eius mazim audiam est ad. In usu agam primis contentiones. Aliquid volutpat mel ei, quo dico laoreet pericula ne.', 'Post Title 1', 1, 1, '2015-03-30 00:00:00', 0, NULL, 2),
(2, 'Lorem ipsum dolor sit amet, eu splendide forensibus mei, mel in movet impetus forensibus. Vel ea vidit tacimates. Ut qui facer nostrud elaboraret, harum tritani facilisis mel ut, mel cu lorem nulla. His illud altera no, ea modus verear vim. Ignota electram scripserit id sit. Ne bonorum nominavi quaestio eum, an eos feugait scriptorem.\r\n\r\nAn apeirian qualisque vix, an viris ridens discere mei. Ocurreret quaerendum id nec, enim graece nostro et quo, ad cum denique fabellas. Falli zril laoreet nam et. Et omittam fastidii his, case audiam habemus mel ei.\r\n\r\nIuvaret offendit comprehensam mea ei. Mel ad vero veniam nostrum, mei erat eruditi platonem ut, definiebas scripserit cu has. Ne maiorum vituperatoribus cum, vidit propriae fabellas duo ne, ne mea explicari imperdiet. Malorum insolens neglegentur ex pri. Ullum mollis ut eos, an pri fugit efficiantur.\r\n\r\nAt nullam feugait vis, vim ne tale everti prodesset, menandri dissentias per eu. No aeque quidam ponderum qui. Et aeque noster sit. Eu vel everti melius habemus, eum vulputate definitionem ut, usu exerci urbanitas ne. Idque tacimates adversarium per ad. Vix viris dolorum feugait ei, vero summo tation sit ex.\r\n\r\nTibique dolores gubergren eu eam, unum bonorum in usu. Eius mazim audiam est ad. In usu agam primis contentiones. Aliquid volutpat mel ei, quo dico laoreet pericula ne.', 'Post Title 2', 1, 1, '2015-03-30 00:00:00', 0, 1, 3),
(3, 'Lorem ipsum dolor sit amet, eu splendide forensibus mei, mel in movet impetus forensibus. Vel ea vidit tacimates. Ut qui facer nostrud elaboraret, harum tritani facilisis mel ut, mel cu lorem nulla. His illud altera no, ea modus verear vim. Ignota electram scripserit id sit. Ne bonorum nominavi quaestio eum, an eos feugait scriptorem.\r\n\r\nAn apeirian qualisque vix, an viris ridens discere mei. Ocurreret quaerendum id nec, enim graece nostro et quo, ad cum denique fabellas. Falli zril laoreet nam et. Et omittam fastidii his, case audiam habemus mel ei.\r\n\r\nIuvaret offendit comprehensam mea ei. Mel ad vero veniam nostrum, mei erat eruditi platonem ut, definiebas scripserit cu has. Ne maiorum vituperatoribus cum, vidit propriae fabellas duo ne, ne mea explicari imperdiet. Malorum insolens neglegentur ex pri. Ullum mollis ut eos, an pri fugit efficiantur.\r\n\r\nAt nullam feugait vis, vim ne tale everti prodesset, menandri dissentias per eu. No aeque quidam ponderum qui. Et aeque noster sit. Eu vel everti melius habemus, eum vulputate definitionem ut, usu exerci urbanitas ne. Idque tacimates adversarium per ad. Vix viris dolorum feugait ei, vero summo tation sit ex.\r\n\r\nTibique dolores gubergren eu eam, unum bonorum in usu. Eius mazim audiam est ad. In usu agam primis contentiones. Aliquid volutpat mel ei, quo dico laoreet pericula ne.', 'Post Title 3', 1, 1, '2015-03-30 00:00:00', 0, 2, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `readsforposts`
--

CREATE TABLE IF NOT EXISTS `readsforposts` (
  `UserID` bigint(20) NOT NULL,
  `PostID` bigint(20) NOT NULL,
  `ReadOn` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `requests`
--

CREATE TABLE IF NOT EXISTS `requests` (
  `UserID` bigint(20) NOT NULL,
  `CommID` bigint(20) NOT NULL,
  `SentOn` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `upvotesforcomments`
--

CREATE TABLE IF NOT EXISTS `upvotesforcomments` (
  `UserID` bigint(20) NOT NULL,
  `CommentID` bigint(20) NOT NULL,
  `CreatedOn` datetime NOT NULL,
  `IsDeleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `upvotesforposts`
--

CREATE TABLE IF NOT EXISTS `upvotesforposts` (
  `UserID` bigint(20) NOT NULL,
  `PostID` bigint(20) NOT NULL,
  `CreatedOn` datetime NOT NULL,
  `IsDeleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`UserID` bigint(20) NOT NULL,
  `Email` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `UserName` varchar(32) COLLATE utf8_turkish_ci DEFAULT NULL,
  `RegDate` datetime DEFAULT NULL,
  `Password` varchar(32) COLLATE utf8_turkish_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`UserID`, `Email`, `UserName`, `RegDate`, `Password`) VALUES
(1, 'ibrahim.cimentepe@gmail.com', 'asliCikmazi23', '2015-03-30 00:00:00', '23');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `usersincomms`
--

CREATE TABLE IF NOT EXISTS `usersincomms` (
  `UserID` bigint(20) NOT NULL,
  `CommID` bigint(20) NOT NULL,
  `JoinedOn` datetime NOT NULL,
  `ValidUntil` datetime NOT NULL,
  `Role` enum('admin','user') COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `usersincomms`
--

INSERT INTO `usersincomms` (`UserID`, `CommID`, `JoinedOn`, `ValidUntil`, `Role`) VALUES
(1, 1, '2015-03-30 00:00:00', '2015-06-23 00:00:00', 'user');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `comments`
--
ALTER TABLE `comments`
 ADD PRIMARY KEY (`CommentID`), ADD KEY `UserID` (`UserID`), ADD KEY `PostID` (`PostID`);

--
-- Tablo için indeksler `comms`
--
ALTER TABLE `comms`
 ADD PRIMARY KEY (`CommID`);

--
-- Tablo için indeksler `posts`
--
ALTER TABLE `posts`
 ADD PRIMARY KEY (`PostID`), ADD KEY `UserID` (`UserID`), ADD KEY `CommID` (`CommID`), ADD KEY `PrevPostID` (`PrevPostID`), ADD KEY `NextPostID` (`NextPostID`);

--
-- Tablo için indeksler `readsforposts`
--
ALTER TABLE `readsforposts`
 ADD PRIMARY KEY (`UserID`,`PostID`), ADD KEY `PostID` (`PostID`);

--
-- Tablo için indeksler `requests`
--
ALTER TABLE `requests`
 ADD PRIMARY KEY (`UserID`,`CommID`), ADD KEY `CommID` (`CommID`);

--
-- Tablo için indeksler `upvotesforcomments`
--
ALTER TABLE `upvotesforcomments`
 ADD PRIMARY KEY (`UserID`,`CommentID`), ADD KEY `CommentID` (`CommentID`);

--
-- Tablo için indeksler `upvotesforposts`
--
ALTER TABLE `upvotesforposts`
 ADD PRIMARY KEY (`UserID`,`PostID`), ADD KEY `PostID` (`PostID`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`UserID`), ADD UNIQUE KEY `Email` (`Email`);

--
-- Tablo için indeksler `usersincomms`
--
ALTER TABLE `usersincomms`
 ADD PRIMARY KEY (`UserID`,`CommID`), ADD KEY `CommID` (`CommID`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `comments`
--
ALTER TABLE `comments`
MODIFY `CommentID` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Tablo için AUTO_INCREMENT değeri `comms`
--
ALTER TABLE `comms`
MODIFY `CommID` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Tablo için AUTO_INCREMENT değeri `posts`
--
ALTER TABLE `posts`
MODIFY `PostID` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
MODIFY `UserID` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `comments`
--
ALTER TABLE `comments`
ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`PostID`) REFERENCES `posts` (`PostID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `posts`
--
ALTER TABLE `posts`
ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`CommID`) REFERENCES `comms` (`CommID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `posts_ibfk_3` FOREIGN KEY (`PrevPostID`) REFERENCES `posts` (`PostID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `posts_ibfk_4` FOREIGN KEY (`NextPostID`) REFERENCES `posts` (`PostID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `readsforposts`
--
ALTER TABLE `readsforposts`
ADD CONSTRAINT `readsforposts_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `readsforposts_ibfk_2` FOREIGN KEY (`PostID`) REFERENCES `posts` (`PostID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `requests`
--
ALTER TABLE `requests`
ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `requests_ibfk_2` FOREIGN KEY (`CommID`) REFERENCES `comms` (`CommID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `upvotesforcomments`
--
ALTER TABLE `upvotesforcomments`
ADD CONSTRAINT `upvotesforcomments_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `upvotesforcomments_ibfk_2` FOREIGN KEY (`CommentID`) REFERENCES `comments` (`CommentID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `upvotesforposts`
--
ALTER TABLE `upvotesforposts`
ADD CONSTRAINT `upvotesforposts_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `upvotesforposts_ibfk_2` FOREIGN KEY (`PostID`) REFERENCES `posts` (`PostID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `usersincomms`
--
ALTER TABLE `usersincomms`
ADD CONSTRAINT `usersincomms_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `usersincomms_ibfk_2` FOREIGN KEY (`CommID`) REFERENCES `comms` (`CommID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
