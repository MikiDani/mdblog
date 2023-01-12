-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Gép: mysql.omega:3306
-- Létrehozás ideje: 2023. Jan 13. 00:25
-- Kiszolgáló verziója: 5.7.39-log
-- PHP verzió: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `mdblog`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `blogbody`
--

CREATE TABLE `blogbody` (
  `blogid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `blogname` varchar(32) NOT NULL,
  `blogtitle` text NOT NULL,
  `categoryid` int(11) NOT NULL,
  `startepoch` int(11) NOT NULL,
  `bgimg` varchar(32) NOT NULL,
  `userurl` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `blogbody`
--

INSERT INTO `blogbody` (`blogid`, `userid`, `blogname`, `blogtitle`, `categoryid`, `startepoch`, `bgimg`, `userurl`) VALUES
(3818950, 94, 'Gábor\'s ideas for the world.', 'The thinking man.', 8, 1660258923, 'bg_3818950.jpg', 'gaborka94'),
(3826798, 104, 'Az internet.', 'Az online tér lehetőségei.', 5, 1660517038, 'bg_3826798.jpg', 'gaboraron104'),
(5980372, 92, 'Unknown', 'Unknown', 8, 1659522454, '', 'Daniel92'),
(6251107, 1, 'Dani Blog', 'Gondolataim...', 8, 1660422897, 'bg_6251107.jpg', 'dani1'),
(8536721, 95, 'A testépítés rejtelei.', 'Mindent amit érdemes tudni!', 1, 1660070483, 'bg_8536721.jpg', 'tesztelek95'),
(9842354, 91, 'Egyél a városban!', 'Gasztó utazás kis vendéglőkben.', 4, 1659462772, 'bg_9842354.jpg', 'admin91');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `blogcategory`
--

CREATE TABLE `blogcategory` (
  `categoryid` int(11) NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `blogcategory`
--

INSERT INTO `blogcategory` (`categoryid`, `name`) VALUES
(1, 'lifestyle'),
(2, 'culture'),
(3, 'technology'),
(4, 'gastronomy'),
(5, 'sports'),
(6, 'personal'),
(7, 'contemplative'),
(8, 'general');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `blogcomments`
--

CREATE TABLE `blogcomments` (
  `commentid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `entrieid` int(11) NOT NULL,
  `commenttext` text NOT NULL,
  `commentepoch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `blogcomments`
--

INSERT INTO `blogcomments` (`commentid`, `userid`, `entrieid`, `commenttext`, `commentepoch`) VALUES
(3, 91, 50, 'Aliquet necarcu. In enim justo, rhoncus ut, imperdiet venenatis vita. Fringilla aliquet necarcu. In enim justrhon, imperdiet a, venenatis vita.', 2147483647),
(4, 95, 48, 'Fringilla aliquet necarcu. In enim justo, rhoncus ut, imperdiet venenatis vita. Fringilla aliquet necarcu. In enim justo, rhoncus imperdiet a, venenatis vita.', 2147483647),
(18, 94, 53, 'Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo.', 1660492876),
(42, 1, 47, 'Fringilla aliquet necarcu. In enim justo, rhoncus ut, imperdiet a, venenatis vita.', 1660497810),
(43, 1, 46, 'Donec pede justonec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo.', 1660497936),
(56, 1, 57, 'Fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae.', 1660506047),
(68, 104, 48, 'Fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae.', 1660510256),
(70, 1, 49, 'Fringilla vel, aliquet nec, vulputate eget, arcu. Rhoncus ut, imperdiet a, venenatis vitae.', 1660512499),
(71, 1, 57, 'Fringilla aliquet necarcu. In enim justo, rhoncus ut, imperdiet a, venenatis vita.', 1660513689),
(80, 1, 53, 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pelle.', 1660551440),
(81, 1, 53, 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibu.', 1660551480),
(82, 91, 61, 'Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet.', 1660555632),
(83, 91, 62, 'Donec pede justo, fringilla vel, aliquet nec.', 1660555652),
(84, 91, 56, 'Good ideas!', 1660555676),
(85, 91, 48, ' Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet.', 1660555716),
(86, 91, 50, 'In enim justo, rhoncus ut, imperdiet.', 1660555738),
(89, 91, 46, 'Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet.', 1660563222),
(90, 104, 62, 'In enim justo, rhoncus ut, imperdiet a, venenatis vita.', 1660564504),
(91, 104, 57, 'Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus.', 1660564528),
(92, 104, 56, 'Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus.', 1660564544),
(93, 104, 49, 'Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus.', 1660564568),
(94, 104, 50, 'Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus.', 1660564582);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `blogentries`
--

CREATE TABLE `blogentries` (
  `entrieid` int(11) NOT NULL,
  `blogid` int(11) NOT NULL,
  `entrietitle` text NOT NULL,
  `entriebody` text NOT NULL,
  `entrieepoch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `blogentries`
--

INSERT INTO `blogentries` (`entrieid`, `blogid`, `entrietitle`, `entriebody`, `entrieepoch`) VALUES
(46, 9842354, 'Praesent sapien massa, convallis a pellentesque nec, egestas non nore.', 'Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Sed porttitor lectus nibh. Pellentesque in ipsum id orci porta dapibus. Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Vivamus suscipit tortor eget felis porttitor volutpat. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Proin eget tortor risus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Donec sollicitudin molestie malesuada. Quisque velit nisi, pretium ut lacinia in, elementum id enim. Nulla porttitor accumsan tincidunt. Donec rutrum congue leo eget malesuada. Curabitur non nulla sit amet nisl tempus convallis quis ac lectus.<br />\r\n<br />\r\nNulla quis lorem ut libero malesuada feugiat. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Proin eget tortor risus. Donec sollicitudin molestie malesuada. Vivamus magna justo, lacinia eget consectetur sed, convallis at tellus. Vivamus suscipit tortor eget felis porttitor volutpat. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Proin eget tortor risus. Nulla quis lorem ut libero malesuada feugiat. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Donec sollicitudin molestie malesuada. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Quisque velit nisi, pretium ut lacinia in, elementum id enim. Proin eget tortor risus.<br />\r\n', 1659958948),
(47, 9842354, 'A pellentesque nec, egestas.', 'Proin eget tortor risus. Donec rutrum congue leo eget malesuada. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Proin eget tortor risus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Nulla porttitor accumsan tincidunt. Vivamus magna justo, lacinia eget consectetur sed, convallis at tellus. Sed porttitor lectus nibh. Cras ultricies ligula sed magna dictum porta. Pellentesque in ipsum id orci porta dapibus.', 1659958980),
(48, 8536721, ' Etiam semper nunc a dui placerat volutpat. Donec auctor diam diam, eget consequat.', 'Sed et libero congue, congue augue quis, pellentesque erat. Curabitur ut sem elit. Aliquam dictum metus nisi, ac ultrices enim pulvinar quis. Donec id odio nec libero accumsan blandit nec in mi. Ut consequat ultricies tempus. Pellentesque risus ante, commodo a purus ut, elementum rhoncus urna. Praesent non leo a tortor gravida mollis a at nulla.<br />\r\n<br />\r\nQuisque erat turpis, euismod sed aliquet eu, facilisis in nulla. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam vitae sapien malesuada, faucibus purus et, pretium purus. Maecenas eget arcu cursus neque ultricies ullamcorper et vitae quam. Etiam semper nunc a dui placerat volutpat. Donec auctor diam diam, eget consequat elit ultrices a. Morbi id quam sodales, tristique metus in, accumsan mi. Cras auctor ante non metus auctor cursus id non ex. Vestibulum sit amet nunc felis.', 1660070576),
(49, 8536721, 'Donec auctor diam diam, eget consequat  Etiam semper nunc a dui placerat volutpat.  Etiam semper nunc a dui placerat volutpat.', 'Morbi vestibulum pretium libero et condimentum. Maecenas quis magna elit. Aenean id lacus aliquam, iaculis eros vel, maximus dui. Nullam malesuada fringilla lorem, ut gravida purus imperdiet id. Donec ut purus nec risus imperdiet ultricies. Donec non sem sit amet leo tincidunt aliquet vitae at est. Phasellus rutrum libero quis leo efficitur, in molestie nisi elementum. Ut orci libero, finibus et turpis at, elementum dignissim diam. Quisque elit ligula, luctus at ipsum aliquam, luctus convallis urna. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Cras a luctus quam. Donec hendrerit sed tortor sit amet semper. Sed eget tortor fermentum, mollis lacus et, porttitor quam. Sed vel condimentum tellus, nec luctus dui. Phasellus hendrerit posuere mollis.', 1660070606),
(50, 8536721, 'Maecenas eget arcu cursus neque ultricies.', 'Morbi vestibulum pretium libero et condimentum. Maecenas quis magna elit. Aenean id lacus aliquam, iaculis eros vel, maximus dui. Nullam malesuada fringilla lorem, ut gravida purus imperdiet id. Donec ut purus nec risus imperdiet ultricies. Donec non sem sit amet leo tincidunt aliquet vitae at est. Phasellus rutrum libero quis leo efficitur, in molestie nisi elementum. Ut orci libero, finibus et turpis at, elementum dignissim diam. Quisque elit ligula, luctus at ipsum aliquam, luctus convallis urna. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Cras a luctus quam. Donec hendrerit sed tortor sit amet semper. Sed eget tortor fermentum, mollis lacus et, porttitor quam. Sed vel condimentum tellus, nec luctus dui. Phasellus hendrerit posuere mollis.', 1565372643),
(53, 3818950, 'Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula.', 'Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Pellentesque in ipsum id orci porta dapibus. Quisque velit nisi, pretium ut lacinia in, elementum id enim. Sed porttitor lectus nibh. Nulla porttitor accumsan tincidunt. Nulla quis lorem ut libero malesuada feugiat. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Lorem ipsum dolor sit amet, consectetur adipiscing elit.<br />\r\n<br />\r\nPellentesque in ipsum id orci porta dapibus. Nulla quis lorem ut libero malesuada feugiat. Pellentesque in ipsum id orci porta dapibus. Curabitur aliquet quam id dui posuere blandit. Vivamus magna justo, lacinia eget consectetur sed, convallis at tellus. Vivamus magna justo, lacinia eget consectetur sed, convallis at tellus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Curabitur aliquet quam id dui posuere blandit. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Curabitur aliquet quam id dui posuere blandit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula.<br />\r\n<br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur aliquet quam id dui posuere blandit. Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Pellentesque in ipsum id orci porta dapibus. Donec sollicitudin molestie malesuada. Vivamus suscipit tortor eget felis porttitor volutpat. Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Pellentesque in ipsum id orci porta dapibus. Curabitur aliquet quam id dui posuere blandit. Proin eget tortor risus. Cras ultricies ligula sed magna dictum porta. Vivamus suscipit tortor eget felis porttitor volutpat. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a.', 1660259230),
(56, 6251107, 'Első gondolat', 'Első gondolataim! Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Pellentesque in ipsum id orci porta dapibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Nulla quis lorem ut libero malesuada feugiat. Sed porttitor lectus nibh. Pellentesque in ipsum id orci porta dapibus. Nulla porttitor accumsan tincidunt. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Sed porttitor lectus nibh. Nulla quis lorem ut libero malesuada feugiat.', 1565714142),
(57, 6251107, 'Következő gondolataim.', 'Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Pellentesque in ipsum id orci porta dapibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Nulla quis lorem ut libero malesuada feugiat. Sed porttitor lectus nibh. Pellentesque in ipsum id orci porta dapibus. Nulla porttitor accumsan tincidunt. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Sed porttitor lectus nibh. Nulla quis lorem ut libero malesuada feugiat.<br />\r\n<br />\r\nPellentesque in ipsum id orci porta dapibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin eget tortor risus. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Nulla quis lorem ut libero malesuada feugiat. Proin eget tortor risus. Vivamus suscipit tortor eget felis porttitor volutpat. Pellentesque in ipsum id orci porta dapibus. Curabitur aliquet quam id dui posuere blandit. Donec sollicitudin molestie malesuada. Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Pellentesque in ipsum id orci porta dapibus. Vivamus magna justo, lacinia eget consectetur sed, convallis at tellus. Quisque velit nisi, pretium ut lacinia in, elementum id enim.', 1660470982),
(61, 3826798, 'Gábor Áron 1', 'Gábor Áron 1', 1660517076),
(62, 6251107, 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. eqwe', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibu\r\n\r\nLorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibu\r\n\r\nLorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibu\r\n\r\nqweqweqweqwe\r\n\r\nertertert', 1660542175);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `rank`
--

CREATE TABLE `rank` (
  `id` int(11) NOT NULL,
  `rankname` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `rank`
--

INSERT INTO `rank` (`id`, `rankname`) VALUES
(2, 'commenter'),
(3, 'blogger'),
(4, 'admin');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `tokens`
--

CREATE TABLE `tokens` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `token` varchar(32) NOT NULL,
  `epochstart` int(11) NOT NULL,
  `epochend` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `tokens`
--

INSERT INTO `tokens` (`id`, `userid`, `token`, `epochstart`, `epochend`) VALUES
(108, 104, '3238cdb051c1e970e1bb05281515e755', 1660557292, 1660578892),
(109, 1, 'eacbf21e985bdf8f96eb395fbb5ef649', 1660550734, 1660572334),
(110, 91, 'afe28a77bb5e1fa3afd8d2a4b115d737', 1660555525, 1660577125);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `useremail` varchar(30) NOT NULL,
  `userpassword` varchar(32) NOT NULL,
  `userrank` int(10) NOT NULL,
  `userinfo` text NOT NULL,
  `imglink` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `username`, `useremail`, `userpassword`, `userrank`, `userinfo`, `imglink`) VALUES
(1, 'dani', 'dani@dani.hu', '1', 4, '', 'avatar2.svg'),
(91, 'admin', 'admin@admin.hu', '1', 4, 'Im a verry best men in the world!', 'avatar2.svg'),
(92, 'Daniel', 'daniel@daniel.hu', '123456', 3, '', 'avatar3.svg'),
(94, 'Gaborka', 'gaborka@gaborka.hu', '123456', 4, '', 'avatar3.svg'),
(95, 'TesztElek', '1tesztelek@teszt.hu', '123456', 4, '', 'avatar7.svg'),
(104, 'GáborÁron', 'gaboraron@mail.hu', '123456', 3, '', 'none.svg');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `blogbody`
--
ALTER TABLE `blogbody`
  ADD PRIMARY KEY (`blogid`),
  ADD KEY `categoryid` (`categoryid`),
  ADD KEY `blogbody_ibfk_2` (`userid`);

--
-- A tábla indexei `blogcategory`
--
ALTER TABLE `blogcategory`
  ADD PRIMARY KEY (`categoryid`);

--
-- A tábla indexei `blogcomments`
--
ALTER TABLE `blogcomments`
  ADD PRIMARY KEY (`commentid`),
  ADD KEY `entrieid` (`entrieid`);

--
-- A tábla indexei `blogentries`
--
ALTER TABLE `blogentries`
  ADD PRIMARY KEY (`entrieid`),
  ADD KEY `blogid` (`blogid`);

--
-- A tábla indexei `rank`
--
ALTER TABLE `rank`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user token` (`userid`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rank` (`userrank`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `blogbody`
--
ALTER TABLE `blogbody`
  MODIFY `blogid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9842355;

--
-- AUTO_INCREMENT a táblához `blogcategory`
--
ALTER TABLE `blogcategory`
  MODIFY `categoryid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT a táblához `blogcomments`
--
ALTER TABLE `blogcomments`
  MODIFY `commentid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT a táblához `blogentries`
--
ALTER TABLE `blogentries`
  MODIFY `entrieid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT a táblához `rank`
--
ALTER TABLE `rank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT a táblához `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `blogbody`
--
ALTER TABLE `blogbody`
  ADD CONSTRAINT `blogbody_ibfk_1` FOREIGN KEY (`categoryid`) REFERENCES `blogcategory` (`categoryid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `blogbody_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `blogcomments`
--
ALTER TABLE `blogcomments`
  ADD CONSTRAINT `blogcomments_ibfk_1` FOREIGN KEY (`entrieid`) REFERENCES `blogentries` (`entrieid`);

--
-- Megkötések a táblához `blogentries`
--
ALTER TABLE `blogentries`
  ADD CONSTRAINT `blogentries_ibfk_1` FOREIGN KEY (`blogid`) REFERENCES `blogbody` (`blogid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `tokens`
--
ALTER TABLE `tokens`
  ADD CONSTRAINT `user token` FOREIGN KEY (`userid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `rank` FOREIGN KEY (`userrank`) REFERENCES `rank` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
