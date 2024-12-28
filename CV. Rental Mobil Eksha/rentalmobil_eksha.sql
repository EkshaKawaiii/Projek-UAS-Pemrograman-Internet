-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 28, 2024 at 08:41 AM
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
-- Database: `rentalmobil_eksha`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mobil_eksha`
--

CREATE TABLE `tbl_mobil_eksha` (
  `no_plat_eksha` varchar(10) NOT NULL,
  `nama_mobil_eksha` varchar(25) DEFAULT NULL,
  `brand_mobil_eksha` varchar(25) DEFAULT NULL,
  `tipe_transmisi_eksha` varchar(10) DEFAULT NULL,
  `foto_mobil_eksha` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_mobil_eksha`
--

INSERT INTO `tbl_mobil_eksha` (`no_plat_eksha`, `nama_mobil_eksha`, `brand_mobil_eksha`, `tipe_transmisi_eksha`, `foto_mobil_eksha`) VALUES
('B 1010 ASN', 'Porsche Macam Turbo', 'Porsche ', 'Manual', 'porsche macam turbo.png'),
('F 2020 RAR', 'Ferrari SF90 Stradale', 'Ferrari', 'Manual', 'Ferrari SF90 Stradale.jpeg'),
('Z 1010 OOY', 'Daihatsu Xenia', 'Daihatsu', 'Matic', 'all new xenia.png'),
('Z 1010 RAR', 'McLaren 600LT', 'McLaren', 'Manual', 'McLaren 600LT.png'),
('Z 1010 RIR', 'Porsche Panamera Turbo', 'Porsche ', 'Manual', 'Porsche_Panamera Turbo.png'),
('Z 4010 RAR', 'Toyota Avanza ', 'Toyota', 'Matic', 'toyota-avanza-transparent-image-download-18272.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pelanggan_eksha`
--

CREATE TABLE `tbl_pelanggan_eksha` (
  `nik_ktp_eksha` varchar(16) NOT NULL,
  `nama_eksha` varchar(35) DEFAULT NULL,
  `no_hp_eksha` varchar(15) DEFAULT NULL,
  `alamat_eksha` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_pelanggan_eksha`
--

INSERT INTO `tbl_pelanggan_eksha` (`nik_ktp_eksha`, `nama_eksha`, `no_hp_eksha`, `alamat_eksha`) VALUES
('101010', 'Miku Nakano', '081221188741', 'PERUM KOTABARU JL.BANDUNG BLOK 6 NO 88, RT 04'),
('1010100', 'Miku Nakano', '081221188741', 'PERUM KOTABARU JL.BANDUNG BLOK 6 NO 88, RT 04'),
('202020', 'Vestia Zeta', '081221188742', 'Tanggerang'),
('303030', 'Kobo Kanaeru', '081221188743', 'Jakarta');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rental_eksha`
--

CREATE TABLE `tbl_rental_eksha` (
  `no_trx_eksha` varchar(20) NOT NULL,
  `nik_ktp_eksha` varchar(16) DEFAULT NULL,
  `no_plat_eksha` varchar(10) DEFAULT NULL,
  `tgl_rental_eksha` date DEFAULT NULL,
  `jam_rental_eksha` time DEFAULT NULL,
  `harga_eksha` int(11) DEFAULT NULL,
  `lama_eksha` int(11) DEFAULT NULL,
  `total_bayar_eksha` int(11) DEFAULT NULL,
  `tgl_selesai_eksha` date DEFAULT NULL,
  `status_eksha` enum('Active','Completed') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_eksha`
--

CREATE TABLE `tbl_user_eksha` (
  `id_user_eksha` int(11) NOT NULL,
  `username_eksha` varchar(35) DEFAULT NULL,
  `password_eksha` varchar(100) DEFAULT NULL,
  `nama_lengkap_eksha` varchar(35) DEFAULT NULL,
  `level_eksha` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user_eksha`
--

INSERT INTO `tbl_user_eksha` (`id_user_eksha`, `username_eksha`, `password_eksha`, `nama_lengkap_eksha`, `level_eksha`) VALUES
(1, 'Eksha', '202cb962ac59075b964b07152d234b70', 'Eksha Oktavian Perdana', 'user'),
(4, 'Miku Nakano', '202cb962ac59075b964b07152d234b70', 'Miku Nakano', 'user'),
(5, 'Kobo Kanaeru', '202cb962ac59075b964b07152d234b70', 'Kobo Kanaeru', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_mobil_eksha`
--
ALTER TABLE `tbl_mobil_eksha`
  ADD PRIMARY KEY (`no_plat_eksha`);

--
-- Indexes for table `tbl_pelanggan_eksha`
--
ALTER TABLE `tbl_pelanggan_eksha`
  ADD PRIMARY KEY (`nik_ktp_eksha`);

--
-- Indexes for table `tbl_rental_eksha`
--
ALTER TABLE `tbl_rental_eksha`
  ADD PRIMARY KEY (`no_trx_eksha`),
  ADD KEY `nik_ktp_eksha` (`nik_ktp_eksha`),
  ADD KEY `no_plat_eksha` (`no_plat_eksha`);

--
-- Indexes for table `tbl_user_eksha`
--
ALTER TABLE `tbl_user_eksha`
  ADD PRIMARY KEY (`id_user_eksha`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_user_eksha`
--
ALTER TABLE `tbl_user_eksha`
  MODIFY `id_user_eksha` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_rental_eksha`
--
ALTER TABLE `tbl_rental_eksha`
  ADD CONSTRAINT `tbl_rental_eksha_ibfk_1` FOREIGN KEY (`nik_ktp_eksha`) REFERENCES `tbl_pelanggan_eksha` (`nik_ktp_eksha`),
  ADD CONSTRAINT `tbl_rental_eksha_ibfk_2` FOREIGN KEY (`no_plat_eksha`) REFERENCES `tbl_mobil_eksha` (`no_plat_eksha`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
