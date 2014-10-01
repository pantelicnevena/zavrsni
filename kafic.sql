-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 01, 2014 at 06:56 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `kafic`
--

-- --------------------------------------------------------

--
-- Table structure for table `artikal`
--

CREATE TABLE IF NOT EXISTS `artikal` (
  `artikalID` int(11) NOT NULL AUTO_INCREMENT,
  `nazivArtikla` varchar(40) COLLATE utf8_bin NOT NULL,
  `ambalaza` varchar(30) COLLATE utf8_bin NOT NULL,
  `rokTrajanja` date NOT NULL,
  `stanjeNaZalihama` double NOT NULL,
  `cena` double NOT NULL,
  `distributerID` int(11) NOT NULL,
  `kategorijaID` int(11) NOT NULL,
  PRIMARY KEY (`artikalID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=33 ;

--
-- Dumping data for table `artikal`
--

INSERT INTO `artikal` (`artikalID`, `nazivArtikla`, `ambalaza`, `rokTrajanja`, `stanjeNaZalihama`, `cena`, `distributerID`, `kategorijaID`) VALUES
(1, 'Domaća kafa', '0.2l', '2016-04-01', 13.8, 100, 151, 1),
(2, 'Espresso', '0.15l', '2017-09-01', 22, 120, 161, 1),
(3, 'Espresso sa mlekom', '0.15l', '2017-09-01', 22, 135, 161, 1),
(4, 'Espresso sa šlagom', '0.15l', '2017-09-01', 22, 150, 161, 1),
(5, 'Cappuccino', '0.15l', '2017-05-01', 18, 140, 161, 1),
(6, 'Nescafe', '0.25l', '2017-08-01', 32, 160, 181, 1),
(7, 'Nescafe sa šlagom', '0.2l', '2017-08-01', 32, 170, 181, 1),
(8, 'Grčki nesfrape', '0.3l', '2017-08-01', 32, 180, 181, 1),
(9, 'Coca Cola', '0.33l', '2015-10-01', 87, 170, 211, 2),
(10, 'Schweppes', '0.33l', '2015-10-01', 75, 170, 211, 2),
(11, 'Sprite', '0.33l', '2015-10-01', 65, 170, 211, 2),
(12, 'Fanta', '0.33l', '2015-10-01', 60, 170, 211, 2),
(13, 'Limona', '0.2l', '2016-07-01', 43, 170, 215, 2),
(14, 'NEXT voćni', '0.25l', '2015-08-01', 55, 150, 211, 3),
(15, 'Booster', '0.33l', '2016-05-01', 67, 165, 335, 2),
(16, 'Ice Tea - Nectar', '0.25l', '2015-07-01', 68, 160, 335, 3),
(17, 'Ice Tea - Hello', '0.25l', '2016-02-01', 32, 140, 315, 3),
(18, 'Pago voćni', '0.33l', '2016-09-01', 47, 170, 325, 3),
(19, 'Limunada', '0.3l', '2020-09-01', 15, 190, 350, 3),
(20, 'Ceđena pomorandža', '0.3l', '2020-01-01', 20, 190, 350, 3),
(21, 'Ceđeno voće MIX', '0.3l', '2020-01-01', 15, 210, 350, 3),
(22, 'Jelen pivo', '0.33l', '2015-05-01', 89, 110, 351, 8),
(23, 'Nikšićko pivo', '0.33l', '2015-07-01', 92, 110, 352, 8),
(24, 'Jelen pivo', '0.5l', '2015-06-01', 94, 150, 351, 8),
(26, 'Heineken', '0.33l', '2015-02-01', 35, 130, 352, 8),
(27, 'Staropramen', '0.33l', '2014-12-01', 42, 140, 352, 8),
(32, 'Lasko pivo', '0.33l', '2015-01-01', 45, 190, 351, 6);

-- --------------------------------------------------------

--
-- Table structure for table `distributer`
--

CREATE TABLE IF NOT EXISTS `distributer` (
  `distributerID` int(10) NOT NULL AUTO_INCREMENT,
  `nazivDistributera` varchar(35) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`distributerID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=355 ;

--
-- Dumping data for table `distributer`
--

INSERT INTO `distributer` (`distributerID`, `nazivDistributera`) VALUES
(151, 'Grand - Atlantic Brands d.o.o.'),
(161, 'KIMBO espresso - Ilikop d.o.o.'),
(181, 'Nescafe - Vending d.o.o.'),
(211, 'Coca Cola Helenic Bottling Company'),
(215, 'Limona'),
(315, 'Fruvita d.o.o.'),
(325, 'Pago d.o.o.'),
(335, 'Nectar d.o.o.'),
(350, 'Bama Gruppen'),
(351, 'Apatinska Pivara d.o.o.'),
(352, 'Arcadia Team d.o.o'),
(353, 'Bambi d.o.o.'),
(354, 'jessica alba');

-- --------------------------------------------------------

--
-- Table structure for table `kategorija`
--

CREATE TABLE IF NOT EXISTS `kategorija` (
  `kategorijaID` int(11) NOT NULL AUTO_INCREMENT,
  `nazivKategorije` varchar(25) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`kategorijaID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=8 ;

--
-- Dumping data for table `kategorija`
--

INSERT INTO `kategorija` (`kategorijaID`, `nazivKategorije`) VALUES
(1, 'Kafa'),
(2, 'Gazirani sok'),
(3, 'Negazirani sok'),
(4, 'Žestina'),
(5, 'Pivo'),
(6, 'Vino'),
(7, 'Hladni napici');

-- --------------------------------------------------------

--
-- Table structure for table `konobar`
--

CREATE TABLE IF NOT EXISTS `konobar` (
  `konobarID` int(4) NOT NULL AUTO_INCREMENT,
  `ime` varchar(30) COLLATE utf8_bin NOT NULL,
  `prezime` varchar(40) COLLATE utf8_bin NOT NULL,
  `godinaRodjenja` year(4) NOT NULL,
  `mestoRodjenja` varchar(25) COLLATE utf8_bin NOT NULL,
  `korisnickoIme` varchar(20) COLLATE utf8_bin NOT NULL,
  `korisnickaSifra` varchar(15) COLLATE utf8_bin NOT NULL,
  `role` smallint(6) NOT NULL,
  `slika` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`konobarID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1022 ;

--
-- Dumping data for table `konobar`
--

INSERT INTO `konobar` (`konobarID`, `ime`, `prezime`, `godinaRodjenja`, `mestoRodjenja`, `korisnickoIme`, `korisnickaSifra`, `role`, `slika`) VALUES
(1000, 'Nevena', 'Pantelić', 1991, 'Brčko', 'nepa', 'nepa', 4, '0'),
(1001, 'Anja', 'Popović', 1986, 'Skoplje', 'anjpo', 'anjpo', 2, '0'),
(1002, 'Milica', 'Popović', 1991, 'Knin', 'mipo', 'mipo', 2, '0'),
(1003, 'Nikola', 'Perić', 1989, 'Šabac', 'nipe', 'nipe', 2, '0'),
(1005, 'Aleksa', 'Janković', 1986, 'Beograd', 'alja', 'alja', 2, '0'),
(1006, 'Milena', 'Pantelić', 1988, 'Valjevo', 'mipa', 'mipa', 2, '0'),
(1007, 'Marko', 'Katana', 1984, 'Beograd', 'maka', 'maka', 2, '0'),
(1008, 'Marija', 'Uglješić', 1988, 'Šamac', 'maug', 'maug', 2, '0'),
(1009, 'Dragana', 'Sretenović', 1990, 'Novi Sad', 'drsr', 'drsr', 2, '0'),
(1010, 'Marija', 'Popović', 1985, 'Knin', 'mapo', 'mapo', 2, '0'),
(1011, 'Zorica', 'Živanović', 1988, 'Beograd', 'zozi', 'zozi', 2, '0'),
(1012, 'Jovana', 'Pantelic', 1988, 'Loznica', 'jopa', 'jopa', 2, '0'),
(1013, 'Vesna', 'Đurđević', 1990, 'Bijeljina', 'vedju', 'vedju', 2, '0'),
(1015, 'Uroš', 'Milenković', 1992, 'Bor', 'enco', 'urmi', 2, '0'),
(1016, 'Kristina', 'Petrić', 1992, 'Beograd', 'krpe', 'krpe', 2, '0'),
(1017, 'Marija', 'Popović', 1986, 'Knin', 'mapo', 'mapo', 2, '0'),
(1018, 'Ivana', 'Mandrapa', 1989, 'Sarajevo', 'ivma', 'ivma', 2, '0'),
(1019, 'Jovanka', 'Perković', 1987, 'Kragujevac', 'jope', 'jope', 2, '0'),
(1020, 'Marko', 'Prokin', 1991, 'Beograd', 'mapr', 'mapr', 2, 'default'),
(1021, 'Jelisaveta', 'Pavlović', 1991, 'Beograd', 'jepa', 'jepa', 2, 'default');

-- --------------------------------------------------------

--
-- Table structure for table `porudzbina`
--

CREATE TABLE IF NOT EXISTS `porudzbina` (
  `porudzbinaID` int(15) NOT NULL AUTO_INCREMENT,
  `datumPorudzbine` date NOT NULL,
  `razduzeno` tinyint(1) NOT NULL,
  `napravljena` int(11) NOT NULL,
  `konobarID` int(11) NOT NULL,
  `stoID` int(3) NOT NULL,
  `razduzenjeID` int(11) NOT NULL,
  PRIMARY KEY (`porudzbinaID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5540 ;

--
-- Dumping data for table `porudzbina`
--

INSERT INTO `porudzbina` (`porudzbinaID`, `datumPorudzbine`, `razduzeno`, `napravljena`, `konobarID`, `stoID`, `razduzenjeID`) VALUES
(1, '2014-06-29', 1, 1, 1004, 5, 101),
(2, '2014-09-07', 1, 0, 1005, 3, 201),
(3, '2014-09-08', 1, 1, 1006, 7, 301),
(4, '2014-09-09', 1, 1, 1007, 10, 401),
(5, '2014-07-02', 1, 1, 1008, 8, 501),
(6, '2014-07-10', 0, 1, 1009, 4, 601),
(7, '2014-07-09', 1, 1, 1000, 5, 701),
(8, '2014-07-15', 0, 0, 1002, 9, 801),
(9, '2014-07-03', 1, 1, 1003, 2, 901),
(10, '2014-07-20', 0, 0, 1006, 3, 1001),
(11, '2014-07-05', 1, 1, 1005, 6, 1101),
(12, '2014-07-04', 1, 1, 1006, 10, 1201),
(13, '2014-09-26', 1, 1, 1007, 8, 1301),
(14, '2014-09-27', 1, 1, 1008, 5, 1401),
(15, '2014-09-06', 1, 1, 1009, 4, 1501),
(5515, '2014-09-27', 1, 1, 1000, 1, 551501),
(5518, '2014-07-07', 1, 1, 1002, 5, 551801),
(5531, '2014-07-11', 0, 1, 1003, 9, 553101),
(5532, '2014-07-11', 1, 1, 1000, 8, 553201),
(5533, '2014-07-17', 0, 0, 1000, 4, 5101),
(5535, '2014-09-28', 1, 1, 1000, 1, 5919),
(5536, '2014-09-28', 1, 1, 1002, 5, 5911),
(5537, '2014-09-07', 1, 0, 1005, 3, 201),
(5538, '2014-09-29', 0, 0, 1001, 1, 16),
(5539, '2014-09-29', 0, 1, 1001, 4, 5547);

-- --------------------------------------------------------

--
-- Table structure for table `razduzenje`
--

CREATE TABLE IF NOT EXISTS `razduzenje` (
  `razduzenjeID` int(5) NOT NULL,
  `ukupnaVrednost` double NOT NULL,
  `konobarID` int(11) NOT NULL,
  `porudzbinaID` int(11) NOT NULL,
  PRIMARY KEY (`razduzenjeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `razduzenje`
--

INSERT INTO `razduzenje` (`razduzenjeID`, `ukupnaVrednost`, `konobarID`, `porudzbinaID`) VALUES
(101, 420, 1004, 1),
(201, 305, 1005, 2),
(301, 465, 1006, 3),
(401, 310, 1007, 4),
(501, 430, 1008, 5),
(601, 480, 1009, 6),
(701, 305, 1000, 7),
(801, 510, 1002, 8),
(901, 500, 1003, 9),
(1001, 260, 1006, 10),
(1101, 350, 1005, 11),
(1201, 520, 1006, 12),
(1301, 200, 1007, 13),
(1401, 320, 1008, 14),
(1501, 580, 1009, 15),
(551501, 480, 1000, 5515),
(551801, 260, 1002, 5518),
(553101, 510, 1003, 5531);

-- --------------------------------------------------------

--
-- Table structure for table `stavka`
--

CREATE TABLE IF NOT EXISTS `stavka` (
  `redniBrojStavke` int(3) NOT NULL AUTO_INCREMENT,
  `kolicina` int(11) NOT NULL,
  `porudzbinaID` int(5) NOT NULL,
  `artikalID` int(5) NOT NULL,
  PRIMARY KEY (`redniBrojStavke`),
  KEY `redniBrojStavke` (`redniBrojStavke`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=37 ;

--
-- Dumping data for table `stavka`
--

INSERT INTO `stavka` (`redniBrojStavke`, `kolicina`, `porudzbinaID`, `artikalID`) VALUES
(1, 1, 5515, 1),
(2, 1, 5515, 6),
(3, 2, 5531, 9),
(4, 1, 5531, 10),
(5, 3, 5518, 6),
(6, 1, 1, 1),
(7, 1, 1, 6),
(8, 1, 1, 16),
(9, 1, 2, 3),
(10, 1, 2, 7),
(11, 1, 3, 3),
(12, 1, 3, 6),
(13, 1, 3, 13),
(14, 1, 4, 19),
(15, 1, 4, 2),
(16, 1, 5, 8),
(17, 1, 5, 1),
(18, 1, 5, 14),
(19, 3, 6, 6),
(20, 1, 7, 15),
(21, 1, 7, 5),
(22, 3, 8, 9),
(23, 1, 9, 9),
(24, 1, 9, 10),
(25, 1, 9, 6),
(26, 1, 10, 1),
(27, 1, 10, 6),
(28, 1, 11, 8),
(29, 1, 11, 9),
(30, 1, 12, 7),
(31, 1, 12, 16),
(32, 1, 12, 19),
(33, 2, 13, 1),
(34, 2, 14, 6),
(35, 2, 15, 10),
(36, 2, 15, 2);

-- --------------------------------------------------------

--
-- Table structure for table `sto`
--

CREATE TABLE IF NOT EXISTS `sto` (
  `stoID` int(3) NOT NULL AUTO_INCREMENT,
  `brojStola` int(11) NOT NULL,
  PRIMARY KEY (`stoID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=14 ;

--
-- Dumping data for table `sto`
--

INSERT INTO `sto` (`stoID`, `brojStola`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10),
(11, 11),
(12, 12),
(13, 13);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
