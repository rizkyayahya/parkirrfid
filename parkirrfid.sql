-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2021 at 03:45 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `parkirrfid`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_anggota`
--

CREATE TABLE `tb_anggota` (
  `id_card` varchar(20) NOT NULL,
  `id_chat` int(20) NOT NULL,
  `Nama` varchar(20) NOT NULL,
  `Gender` enum('L','P') NOT NULL,
  `Saldo` int(20) NOT NULL,
  `Sw_user` int(20) NOT NULL,
  `Tanggal` date NOT NULL,
  `Status` int(11) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Level` enum('Anggota','Admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_anggota`
--

INSERT INTO `tb_anggota` (`id_card`, `id_chat`, `Nama`, `Gender`, `Saldo`, `Sw_user`, `Tanggal`, `Status`, `Password`, `Level`) VALUES
('admin', 441884684, 'admin', 'L', 0, 1, '0000-00-00', 1, '$2y$10$S/Ashr1oOQ2K8Kdnys0Y4u920Bpuc2vJHPRC49fk9NfzFm1T/oi1.', 'Admin');

-- --------------------------------------------------------
CREATE TABLE `tabel_reset_password` (
  `no` int(20) NOT NULL,
  `ID` varchar(20) NOT NULL,
  `uniqid` varchar(20) NOT NULL,
  `expdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tabel_reset_password`
--

INSERT INTO `tabel_reset_password` (`no`, `ID`, `uniqid`, `expdate`) VALUES
(1, 'admin', '602f2e630df5b', '0000-00-00'),
(2, 'admin', '602f2ec0f3d8f', '0000-00-00'),
(3, 'admin', '602f54310817e', '2021-02-19'),
(4, 'admin', '602f584462ed0', '2021-02-19'),
(5, 'admin', '602f611a797c1', '2021-02-19'),
(6, 'admin', '6030657d9deaf', '2021-02-20'),
(7, 'admin', '6030b0a1c6490', '2021-02-20'),
(8, 'admin', '6030b0da41559', '2021-02-20'),
(9, '2eabf34', '6030b11b01284', '2021-02-20');

--
-- Table structure for table `tb_pengaturan`
--

CREATE TABLE `tb_pengaturan` (
  `idbaru` varchar(20) NOT NULL,
  `Token_bot` varchar(100) NOT NULL,
  `Token_web` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_pengaturan`
--

INSERT INTO `tb_pengaturan` (`idbaru`, `Token_bot`, `Token_web`) VALUES
('', '1393285308:AAFlmT3u393eudj39i', 'abc123');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pengunjung`
--

CREATE TABLE `tb_pengunjung` (
  `no` int(20) NOT NULL,
  `id_card` varchar(20) NOT NULL,
  `Tanggal` date NOT NULL,
  `Masuk` int(20) NOT NULL,
  `Keluar` int(20) NOT NULL,
  `id_kendaraan` int(20) NOT NULL,
  `Tarif` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



--
-- Table structure for table `tb_slot`
--

CREATE TABLE `tb_slot` (
  `id_slot` varchar(20) NOT NULL,
  `Waktu` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Status` varchar(20) NOT NULL,
  `id_kendaraan` int(20) NOT NULL,
  `id_card` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_slot`
--

INSERT INTO `tb_slot` (`id_slot`, `Waktu`, `Status`, `id_kendaraan`, `id_card`) VALUES
('R2-A1', '2021-01-02 12:18:50', 'kosong', 1, ''),
('R2-A2', '2021-01-02 11:57:28', 'kosong', 1, ''),
('R2-A3', '2021-01-02 10:07:21', 'kosong', 1, ''),
('R2-A4', '2021-01-02 10:16:14', 'kosong', 1, ''),
('R2-A5', '2021-01-02 10:10:57', 'kosong', 1, ''),
('R2-A6', '2021-01-02 11:13:48', 'kosong', 1, ''),
('R4-A1', '2021-01-02 12:23:56', 'kosong', 2, ''),
('R4-A2', '2020-12-04 10:35:15', 'kosong', 2, ''),
('R4-A3', '2020-12-04 10:35:15', 'kosong', 2, ''),
('R4-A4', '2021-01-02 12:18:24', 'kosong', 2, ''),
('R4-A5', '2021-01-02 11:22:59', 'kosong', 2, ''),
('R4-A6', '2021-01-02 11:23:12', 'kosong', 2, ''),
('R6-A1', '2020-12-04 10:35:15', 'kosong', 3, ''),
('R6-A2', '2021-01-02 12:19:24', 'kosong', 3, ''),
('R6-A3', '2021-01-02 11:55:05', 'kosong', 3, ''),
('R6-A4', '2021-01-02 11:27:02', 'kosong', 3, ''),
('R6-A5', '2021-01-02 11:27:16', 'kosong', 3, ''),
('R6-A6', '2021-01-02 11:27:35', 'kosong', 3, '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_tarif`
--

CREATE TABLE `tb_tarif` (
  `id_kendaraan` int(20) NOT NULL,
  `Kendaraan` varchar(20) NOT NULL,
  `tarif_1` int(11) NOT NULL,
  `tarif_2` int(11) NOT NULL,
  `tarif_3` int(11) NOT NULL,
  `tarif_4` int(11) NOT NULL,
  `tarif_5` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_tarif`
--

INSERT INTO `tb_tarif` (`id_kendaraan`, `Kendaraan`, `tarif_1`, `tarif_2`, `tarif_3`, `tarif_4`, `tarif_5`) VALUES
(1, 'Roda 2', 1500, 2500, 3500, 8500, 21000),
(2, 'Roda 4', 2000, 4000, 6000, 7500, 30000),
(3, 'Roda 6', 3000, 6000, 9000, 10500, 35000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_transaksi`
--

CREATE TABLE `tb_transaksi` (
  `no` int(20) NOT NULL,
  `Waktu` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_card` varchar(20) NOT NULL,
  `Kredit` int(20) NOT NULL,
  `Debet` int(20) NOT NULL,
  `Saldo` int(20) NOT NULL,
  `Ket` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_anggota`
--
ALTER TABLE `tb_anggota`
  ADD PRIMARY KEY (`id_card`),
  ADD KEY `Nama` (`Nama`);

--
-- Indexes for table `tabel_reset_password`
--
ALTER TABLE `tabel_reset_password`
  ADD PRIMARY KEY (`no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- Indexes for table `tb_pengaturan`
--
ALTER TABLE `tb_pengaturan`
  ADD PRIMARY KEY (`idbaru`);

--
-- Indexes for table `tb_pengunjung`
--
ALTER TABLE `tb_pengunjung`
  ADD PRIMARY KEY (`no`),
  ADD KEY `id_card` (`id_card`);

--
-- Indexes for table `tb_slot`
--
ALTER TABLE `tb_slot`
  ADD PRIMARY KEY (`id_slot`);

--
-- Indexes for table `tb_tarif`
--
ALTER TABLE `tb_tarif`
  ADD PRIMARY KEY (`id_kendaraan`);

--
-- Indexes for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  ADD PRIMARY KEY (`no`),
  ADD KEY `id_card` (`id_card`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_pengunjung`
--
ALTER TABLE `tb_pengunjung`
  MODIFY `no` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=354;

--
-- AUTO_INCREMENT for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  MODIFY `no` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=475;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_pengunjung`
--
ALTER TABLE `tb_pengunjung`
  ADD CONSTRAINT `tb_pengunjung_ibfk_1` FOREIGN KEY (`id_card`) REFERENCES `tb_anggota` (`id_card`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  ADD CONSTRAINT `tb_transaksi_ibfk_1` FOREIGN KEY (`id_card`) REFERENCES `tb_anggota` (`id_card`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- AUTO_INCREMENT for table `tabel_reset_password`
--
ALTER TABLE `tabel_reset_password`
  MODIFY `no` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
