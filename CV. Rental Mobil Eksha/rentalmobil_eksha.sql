-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2024 at 06:33 PM
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
  `foto_mobil_eksha` varchar(255) DEFAULT NULL,
  `harga_sewa_eksha` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_mobil_eksha`
--

INSERT INTO `tbl_mobil_eksha` (`no_plat_eksha`, `nama_mobil_eksha`, `brand_mobil_eksha`, `tipe_transmisi_eksha`, `foto_mobil_eksha`, `harga_sewa_eksha`) VALUES
('Z 1010 RAR', 'Xenia', 'Daihatsu ', 'Matic', 'all new xenia.png', 1000000),
('AG 2010 RA', 'Avanza', 'Toyota ', 'Matic', 'toyota-avanza-transparent-image-download-18272.png', 1100000),
('B 3010 RAR', 'SF90 Stradale', 'Ferrari ', 'Manual', 'Ferrari SF90 Stradale.jpeg', 55000000),
('A 4010 RAR', 'McLaren 600LT', 'McLaren ', 'Manual', 'McLaren 600LT.png', 65000000),
('T 5010 RAR', 'Porsche Macam Turbo', 'Porsche ', 'Manual', 'porsche macam turbo.png', 45000000),
('K 6010 RAR', 'Porsche Panamera Turbo', 'Porsche ', 'Manual', 'Porsche_Panamera Turbo.png', 54000000),
('D 7010 RAR', 'Ayla', 'Daihatsu ', 'Matic', 'daihatsu-ayla-2020-2022-1622090641.3209283.png', 650000);

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
('202020', 'Vestia Zeta', '081221188742', 'PERUM KOTABARU JL.BOGOR BLOK 6 NO 88, RT 04, '),
('303030', 'Azizi Shafa Asadel', '081221188742', 'PERUM KOTABARU JL.CIANJUR BLOK 6 NO 88, RT 04'),
('404040', 'Futaro Uesugi', '081221188744', 'Akibahara - Jepang');

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
  `status_eksha` enum('Aktif','Selesai') NOT NULL DEFAULT 'Aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_rental_eksha`
--

INSERT INTO `tbl_rental_eksha` (`no_trx_eksha`, `nik_ktp_eksha`, `no_plat_eksha`, `tgl_rental_eksha`, `jam_rental_eksha`, `harga_eksha`, `lama_eksha`, `total_bayar_eksha`, `tgl_selesai_eksha`, `status_eksha`) VALUES
('TRX-20241230175009', '303030', 'K 6010 RAR', '2024-12-30', '23:50:00', 54000000, 7, 378000000, '2025-01-02', 'Aktif'),
('TRX-20241230182807', '202020', 'D 7010 RAR', '2024-12-31', '00:27:00', 750000, 2, 1500000, '2025-01-02', 'Selesai'),
('TRX-20241230182851', '202020', 'B 3010 RAR', '2024-12-31', '00:28:00', 55000000, 2, 110000000, '2025-01-02', 'Aktif');

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
(8, 'Miku Nakano', '202cb962ac59075b964b07152d234b70', 'Miku Nakano', 'user'),
(9, 'Eksha Kawaii', '202cb962ac59075b964b07152d234b70', 'Eksha Kawaii', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_pelanggan_eksha`
--
ALTER TABLE `tbl_pelanggan_eksha`
  ADD PRIMARY KEY (`nik_ktp_eksha`);

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
  MODIFY `id_user_eksha` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
