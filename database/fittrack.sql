-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 12, 2024 at 05:53 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fittrack`
--

-- --------------------------------------------------------

--
-- Table structure for table `clanarina`
--

CREATE TABLE `clanarina` (
  `id` int(11) NOT NULL,
  `idClana` int(11) NOT NULL,
  `iznos` decimal(10,2) NOT NULL,
  `datumUplate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clanarina`
--

INSERT INTO `clanarina` (`id`, `idClana`, `iznos`, `datumUplate`) VALUES
(27, 3, 2500.00, '2024-03-03 10:53:02'),
(28, 3, 2200.00, '2024-03-03 10:53:18'),
(29, 2, 2700.00, '2024-03-03 17:23:29');

-- --------------------------------------------------------

--
-- Table structure for table `grupa`
--

CREATE TABLE `grupa` (
  `id` int(10) NOT NULL,
  `naziv` varchar(50) NOT NULL,
  `trener` int(10) NOT NULL,
  `opis` text DEFAULT NULL,
  `slika` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grupa`
--

INSERT INTO `grupa` (`id`, `naziv`, `trener`, `opis`, `slika`) VALUES
(1, 'Fitness 18h', 2, 'Naša grupa je osmišljena kako bismo pružili nezaboravan fitness doživljaj svim članovima koji žele postići svoje fitness ciljeve uz podršku i motivaciju zajednice. Bez obzira da li ste početnik ili iskusni vežbač, ovde ćete pronaći treninge prilagođene svim nivoima kondicije.', './images/groupPhoto2.jpg'),
(2, 'FitnessCardio 4x1', 2, 'Raznovrsni treninzi: Od intenzivnih kardio treninga do snage i fleksibilnosti, naši treninzi su pažljivo osmišljeni kako bi vam pružili sveobuhvatno iskustvo. Neka fitness postane vaša strast, a zajedništvo u grupi vaša motivacija. Vidimo se na treninzima! ', './images/groupPhoto3.jpg'),
(3, 'Trening x 60', 3, 'Iskusni treneri: Naši sertifikovani treneri su tu da vas vode kroz svaki trening, pruže vam prilagođene savete i motivišu vas da premašite svoje granice. Timski duh: Grupno vežbanje nije samo o fizičkom napretku, već i o izgradnji zajedništva. Delite svoje uspehe, podržavajte jedni druge i zajedno gradite zdrav način života.', './images/groupPhoto4.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

CREATE TABLE `korisnik` (
  `id` int(10) NOT NULL,
  `email` varchar(60) NOT NULL,
  `username` varchar(60) NOT NULL,
  `fullName` varchar(60) NOT NULL,
  `regDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `password` varchar(255) NOT NULL,
  `idGrupe` int(11) DEFAULT NULL,
  `admin` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`id`, `email`, `username`, `fullName`, `regDate`, `password`, `idGrupe`, `admin`) VALUES
(2, 'pop@gmail.com', 'pop', 'Relja Popovic', '2024-02-29 13:44:26', '$2y$10$gCl/kW2wDrRQYQP233rGnOduTKCFy/GmdFJKOE9mRJfDieTlbK6P6', 3, 1),
(3, 'nikola@gmail.com', 'nikola', 'Nikola Milanovic', '2024-02-29 13:45:05', '$2y$10$LVM9ID6QEwVJNRtCC9wo1.ZSOmyxayIqZCHXjXO4XLtgmaw2oIDz6', 1, 0),
(4, 'letecaptica@gmail.com', 'letecaptica', 'Marko Milanovic', '2024-03-01 18:00:28', '$2y$10$SFbxEX0BP0flb2ib2ADHl.D28zv2261xExhxrX0lKqMhI4CXaDp6K', NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clanarina`
--
ALTER TABLE `clanarina`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idClana` (`idClana`);

--
-- Indexes for table `grupa`
--
ALTER TABLE `grupa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trener` (`trener`);

--
-- Indexes for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `idGrupe` (`idGrupe`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clanarina`
--
ALTER TABLE `clanarina`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `grupa`
--
ALTER TABLE `grupa`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `korisnik`
--
ALTER TABLE `korisnik`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `clanarina`
--
ALTER TABLE `clanarina`
  ADD CONSTRAINT `clanarina_ibfk_1` FOREIGN KEY (`idClana`) REFERENCES `korisnik` (`id`);

--
-- Constraints for table `grupa`
--
ALTER TABLE `grupa`
  ADD CONSTRAINT `grupa_ibfk_1` FOREIGN KEY (`trener`) REFERENCES `korisnik` (`id`);

--
-- Constraints for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD CONSTRAINT `korisnik_ibfk_1` FOREIGN KEY (`idGrupe`) REFERENCES `grupa` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
