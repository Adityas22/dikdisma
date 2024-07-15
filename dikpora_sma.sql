-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 15, 2024 at 05:50 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dikpora_sma`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(13, 'user', '1jeYoXHRRzbBemDSBJNybnxLZdnAVUMKWRa98YAU7SY=');

-- --------------------------------------------------------

--
-- Table structure for table `surat`
--

CREATE TABLE `surat` (
  `id` int(11) NOT NULL,
  `tanggal` varchar(50) NOT NULL,
  `nomor` varchar(100) NOT NULL,
  `asal` varchar(100) NOT NULL,
  `isi` text NOT NULL,
  `tujuan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `surat`
--

INSERT INTO `surat` (`id`, `tanggal`, `nomor`, `asal`, `isi`, `tujuan`) VALUES
(8, '03-07-2024', '123ad123', 'asdasd', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet voluptatibus minus ea eum officiis\r\n                    dolores. Consequatur, et ab animi itaque, quo enim recusandae corrupti aliquam tenetur architecto\r\n                    doloribus, rem reprehenderit!\r\n2132132132312\r\n213213', 'Haryoko S.Pd'),
(11, '30-08-2023', '123 asd 123', 'asd asd', 'Nabi Muhammad adalah nabi dan rasul terakhir serta penutup umat Islam yang diberikan banyak mukjizat oleh Allah Swt. Salah satu mukjizat yang terbesar adalah diturunkannya kitab Al Quran sebagai bukti kenabiannya.\r\n\r\nNabi Muhammad SAW mengalami sebuah peristiwa besar yakni Isra Miraj. Isra merupakan perjalanan malam dari Masjidil Haram di Mekah ke Masjidil Aqsa di Yerusalem.\r\n\r\nSementara Miraj adalah kenaikan Nabi Muhammad ke langit tertinggi yakni Sidratul Muntaha melewati berbagai tingkatan untuk menerima wahyu dari Allah SWT, salah satunya perintah sholat lima waktu.\r\n\r\nDemikian kisah singkat 25 nabi dan rasul beserta mukjizatnya. Mukjizat yang diberikan kepada para nabi dan rasul menjadi bukti kekuasaan Allah Swt. Semoga bermanfaat.\r\n\r\nBaca artikel CNN Indonesia \"Kisah 25 Nabi dan Rasul Singkat beserta Mukjizatnya\" selengkapnya di sini: https://www.cnnindonesia.com/edukasi/20240313112940-569-1073671/kisah-25-nabi-dan-rasul-singkat-beserta-mukjizatnya.\r\n\r\nDownload Apps CNN Indonesia sekarang https://app.cnnindonesia.com/', 'Angga Arisdian P'),
(12, '01-07-2024', '1', '1', '1', 'Widayatun S.Pd');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surat`
--
ALTER TABLE `surat`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `surat`
--
ALTER TABLE `surat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
