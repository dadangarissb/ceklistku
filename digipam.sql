-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 02, 2025 at 05:19 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `digipam`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_user` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `nama_user` varchar(30) NOT NULL,
  `jabatan` varchar(30) NOT NULL,
  `id_unit` int(11) NOT NULL,
  `role` varchar(40) NOT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_user`, `password`, `nama_user`, `jabatan`, `id_unit`, `role`, `status`) VALUES
('dadangarissb', 'P@ssw0rd', 'Dadang Aris SB', 'TL K3L & KAM', 1, 'approver 1', 'aktif'),
('faqih', 'P@ssw0rd', 'Achmad Faqih', 'TL Yan', 1, 'approver 2', 'Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `approval_mutasi`
--

CREATE TABLE `approval_mutasi` (
  `id_approval_mutasi` int(11) NOT NULL,
  `id_mutasi_jaga` int(11) NOT NULL,
  `id_petugas_terima` int(11) NOT NULL,
  `catatan_penerima` varchar(100) NOT NULL,
  `id_approver_1` int(11) NOT NULL,
  `nama_approver_1` varchar(30) NOT NULL,
  `approver_1_at` datetime DEFAULT NULL,
  `catatan_approver_1` varchar(100) NOT NULL,
  `id_approver_2` int(11) NOT NULL,
  `nama_approver_2` varchar(30) NOT NULL,
  `approver_2_at` datetime DEFAULT NULL,
  `catatan_approver_2` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `approval_mutasi`
--

INSERT INTO `approval_mutasi` (`id_approval_mutasi`, `id_mutasi_jaga`, `id_petugas_terima`, `catatan_penerima`, `id_approver_1`, `nama_approver_1`, `approver_1_at`, `catatan_approver_1`, `id_approver_2`, `nama_approver_2`, `approver_2_at`, `catatan_approver_2`, `status`) VALUES
(1, 17, 1, '', 0, '', NULL, '', 0, '', NULL, '', ''),
(2, 19, 1, '', 0, '', NULL, '', 0, '', NULL, '', ''),
(3, 20, 1, '', 1, 'Dadang', NULL, '', 0, 'Faqih', NULL, '', ''),
(4, 21, 1, '', 1, 'Dadang', NULL, '', 0, 'Faqih', NULL, '', ''),
(5, 22, 1, '', 1, 'Dadang', NULL, '', 2, 'Faqih', NULL, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_patroli`
--

CREATE TABLE `jadwal_patroli` (
  `id_jadwal` int(11) NOT NULL,
  `id_unit` int(11) NOT NULL,
  `nama_jadwal` varchar(100) NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal_patroli`
--

INSERT INTO `jadwal_patroli` (`id_jadwal`, `id_unit`, `nama_jadwal`, `jam_mulai`, `jam_selesai`, `keterangan`, `created_at`) VALUES
(1, 1, 'Shift 1 (1)', '06:00:00', '07:59:00', '', '2025-11-01 03:54:28'),
(2, 1, 'Shift 1 (2)', '08:00:00', '09:59:00', '', '2025-11-01 03:54:54'),
(3, 1, 'Shift 1 (3)', '10:00:00', '11:59:00', '', '2025-11-01 03:55:10'),
(4, 1, 'Shift 1 (4)', '12:00:00', '13:59:00', '', '2025-11-01 07:41:33'),
(5, 1, 'Shift 2 (1)', '14:00:00', '15:59:00', '', '2025-11-01 07:41:59'),
(6, 1, 'Shift 2 (2)', '16:00:00', '17:59:00', '', '2025-11-01 08:04:31'),
(7, 1, 'Shift 2 (3)', '18:00:00', '19:59:00', '', '2025-11-01 08:05:23'),
(8, 1, 'Shift 2 (4)', '20:00:00', '21:59:00', '', '2025-11-01 08:06:11'),
(9, 1, 'Shift 3 (1)', '22:00:00', '23:59:00', '', '2025-11-01 08:06:49'),
(10, 1, 'Shift 3 (2)', '00:00:00', '01:59:00', '', '2025-11-01 08:07:15'),
(11, 1, 'Shift 3 (3)', '02:00:00', '03:59:00', '', '2025-11-01 08:07:37'),
(12, 1, 'Shift 3 (4)', '04:00:00', '05:59:00', '', '2025-11-01 08:07:57');

-- --------------------------------------------------------

--
-- Table structure for table `mutasi_jaga`
--

CREATE TABLE `mutasi_jaga` (
  `id_mutasi_jaga` int(11) NOT NULL,
  `id_unit` int(11) NOT NULL,
  `tanggal_jaga` date DEFAULT NULL,
  `shift` varchar(30) NOT NULL,
  `petugas_serah` varchar(30) NOT NULL,
  `petugas_terima` varchar(30) NOT NULL,
  `catatan_mutasi` text NOT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT current_timestamp(),
  `catatan_penerima` varchar(100) NOT NULL,
  `id_approver_1` int(11) NOT NULL,
  `nama_approver_1` varchar(30) NOT NULL,
  `approver_1_at` datetime DEFAULT NULL,
  `catatan_approver_1` varchar(100) NOT NULL,
  `id_approver_2` int(11) NOT NULL,
  `nama_approver_2` varchar(30) NOT NULL,
  `approver_2_at` datetime DEFAULT NULL,
  `catatan_approver_2` int(11) NOT NULL,
  `status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mutasi_peralatan`
--

CREATE TABLE `mutasi_peralatan` (
  `id_mutasi_peralatan` int(11) NOT NULL,
  `id_mutasi_jaga` int(11) NOT NULL,
  `nama_peralatan` varchar(30) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `kondisi` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patroli`
--

CREATE TABLE `patroli` (
  `id_patroli` int(11) NOT NULL,
  `id_satpam` int(11) NOT NULL,
  `id_unit` int(11) NOT NULL,
  `id_titik` int(11) NOT NULL,
  `id_jadwal` int(11) NOT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `waktu` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patroli`
--

INSERT INTO `patroli` (`id_patroli`, `id_satpam`, `id_unit`, `id_titik`, `id_jadwal`, `latitude`, `longitude`, `foto`, `keterangan`, `waktu`) VALUES
(11, 2, 1, 8, 9, -5.22143140, 119.49915790, '', 'aman', '2025-11-01 17:54:18');

-- --------------------------------------------------------

--
-- Table structure for table `peralatan`
--

CREATE TABLE `peralatan` (
  `id_peralatan` int(11) NOT NULL,
  `nama_peralatan` varchar(30) NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peralatan`
--

INSERT INTO `peralatan` (`id_peralatan`, `nama_peralatan`, `jumlah`) VALUES
(1, 'Senter', 5),
(2, 'HT', 5),
(3, 'Tongkat ', 4),
(4, 'Portal', 1);

-- --------------------------------------------------------

--
-- Table structure for table `satpam`
--

CREATE TABLE `satpam` (
  `id_satpam` int(11) NOT NULL,
  `password` varchar(30) NOT NULL,
  `id_unit` int(11) NOT NULL,
  `nama_satpam` varchar(40) NOT NULL,
  `jabatan` varchar(15) NOT NULL,
  `kompetensi` varchar(15) NOT NULL,
  `no_kta` varchar(20) NOT NULL,
  `berlaku_sampai` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `satpam`
--

INSERT INTO `satpam` (`id_satpam`, `password`, `id_unit`, `nama_satpam`, `jabatan`, `kompetensi`, `no_kta`, `berlaku_sampai`) VALUES
(1, 'P@ssw0rd', 1, 'Syahlan Samad', 'Danru', 'Gada Madya', '19.01.001397', '2027-05-03'),
(2, 'P@ssw0rd', 1, 'Ade Yuliani', 'Anggota', 'Gada Pratama', '19.20.385331', '2026-12-14'),
(3, 'P@ssw0rd', 1, 'Muhammad Hijrah', 'Anggota', 'Gada Pratama', '19.15.373127', '2026-12-14'),
(4, 'P@ssw0rd', 1, 'Mustapa', 'Anggota', 'Gada Pratama', '19.10.005555', '2027-04-04'),
(5, 'P@ssw0rd', 1, 'Abdul Latif', 'Anggota', 'Gada Pratama', '19.01.000113', '2027-03-06'),
(6, 'P@ssw0rd', 1, 'Satpam Unit Lain', 'Anggota', 'Gada Pratama', 'dsdsd', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `titik_patroli`
--

CREATE TABLE `titik_patroli` (
  `id_titik` int(11) NOT NULL,
  `id_unit` int(11) NOT NULL,
  `nama_titik` varchar(100) NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `radius` int(11) DEFAULT 10,
  `deskripsi` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `titik_patroli`
--

INSERT INTO `titik_patroli` (`id_titik`, `id_unit`, `nama_titik`, `latitude`, `longitude`, `radius`, `deskripsi`, `foto`, `created_at`) VALUES
(4, 1, 'Parkiran Driver', -5.14566010, 119.44695080, 10, '', 'titik_1761930418_915a87.jpg', '2025-10-31 17:06:58'),
(5, 1, 'Aula', -5.14566010, 119.44695080, 10, '', 'titik_1761930430_874c6e.jpg', '2025-10-31 17:07:10'),
(6, 1, 'Kafe Kecce', -5.14566010, 119.44695080, 10, '', 'titik_1761930443_4ec50c.jpg', '2025-10-31 17:07:23'),
(7, 1, 'Lobby', -5.22254880, 119.49313910, 10, '', 'titik_1761931023_32505a.jpg', '2025-10-31 17:17:03'),
(8, 1, 'Bugenvile 5', -5.22143140, 119.49915790, 10, '', 'titik_1761984846_fac22a.jpg', '2025-11-01 08:14:06');

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `id_unit` int(11) NOT NULL,
  `nama_unit` varchar(50) NOT NULL,
  `alamat_unit` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`id_unit`, `nama_unit`, `alamat_unit`) VALUES
(1, 'UPDL Makassar (Mawang)', 'Jl. Malino No.377, Mawang, Kec. Somba Opu, Kabupaten Gowa, Sulawesi Selatan 92119'),
(2, 'Unit Lain', 'fsfsdf');

-- --------------------------------------------------------

--
-- Table structure for table `unit_satpam`
--

CREATE TABLE `unit_satpam` (
  `id_unit_satpam` int(11) NOT NULL,
  `id_unit` int(11) NOT NULL,
  `id_satpam` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `unit_satpam`
--

INSERT INTO `unit_satpam` (`id_unit_satpam`, `id_unit`, `id_satpam`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 1, 2),
(4, 2, 2),
(5, 1, 3),
(6, 2, 3),
(7, 1, 4),
(8, 2, 4),
(9, 1, 5),
(10, 2, 5),
(11, 3, 6);

-- --------------------------------------------------------

--
-- Table structure for table `visitor`
--

CREATE TABLE `visitor` (
  `id_visitor` int(11) NOT NULL,
  `id_unit` int(11) NOT NULL,
  `nama_visitor` varchar(30) NOT NULL,
  `instansi` varchar(50) NOT NULL,
  `keperluan` varchar(50) NOT NULL,
  `bertemu_dengan` varchar(30) NOT NULL,
  `tgl_masuk` datetime NOT NULL DEFAULT current_timestamp(),
  `tgl_keluar` datetime DEFAULT NULL,
  `status` varchar(10) NOT NULL,
  `id_satpam_masuk` int(11) NOT NULL,
  `id_satpam_keluar` int(11) NOT NULL,
  `no_kartu_akses` varchar(3) NOT NULL,
  `foto` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `visitor`
--

INSERT INTO `visitor` (`id_visitor`, `id_unit`, `nama_visitor`, `instansi`, `keperluan`, `bertemu_dengan`, `tgl_masuk`, `tgl_keluar`, `status`, `id_satpam_masuk`, `id_satpam_keluar`, `no_kartu_akses`, `foto`) VALUES
(1, 1, 'Budi Setiawan', 'PLN UID', 'Bertemu manager', 'Manager', '2025-10-30 05:42:19', '2025-10-30 15:38:38', 'keluar', 0, 4, '2', ''),
(2, 1, 'New Visitor', 'PT Bagus', 'fsdfsdf', 'dsafd', '2025-10-30 06:23:00', '2025-10-30 15:38:02', 'keluar', 3, 4, '42', ''),
(3, 1, 'Dadang', 'updl makassr', 'fsafa', 'fsdf', '2025-10-30 23:00:00', '2025-10-31 22:03:54', 'keluar', 4, 4, '7', 'visitor_1761836463.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `approval_mutasi`
--
ALTER TABLE `approval_mutasi`
  ADD PRIMARY KEY (`id_approval_mutasi`);

--
-- Indexes for table `jadwal_patroli`
--
ALTER TABLE `jadwal_patroli`
  ADD PRIMARY KEY (`id_jadwal`);

--
-- Indexes for table `mutasi_jaga`
--
ALTER TABLE `mutasi_jaga`
  ADD PRIMARY KEY (`id_mutasi_jaga`);

--
-- Indexes for table `mutasi_peralatan`
--
ALTER TABLE `mutasi_peralatan`
  ADD PRIMARY KEY (`id_mutasi_peralatan`);

--
-- Indexes for table `patroli`
--
ALTER TABLE `patroli`
  ADD PRIMARY KEY (`id_patroli`);

--
-- Indexes for table `peralatan`
--
ALTER TABLE `peralatan`
  ADD PRIMARY KEY (`id_peralatan`);

--
-- Indexes for table `satpam`
--
ALTER TABLE `satpam`
  ADD PRIMARY KEY (`id_satpam`);

--
-- Indexes for table `titik_patroli`
--
ALTER TABLE `titik_patroli`
  ADD PRIMARY KEY (`id_titik`),
  ADD KEY `id_unit` (`id_unit`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`id_unit`);

--
-- Indexes for table `unit_satpam`
--
ALTER TABLE `unit_satpam`
  ADD PRIMARY KEY (`id_unit_satpam`);

--
-- Indexes for table `visitor`
--
ALTER TABLE `visitor`
  ADD PRIMARY KEY (`id_visitor`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `approval_mutasi`
--
ALTER TABLE `approval_mutasi`
  MODIFY `id_approval_mutasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jadwal_patroli`
--
ALTER TABLE `jadwal_patroli`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `mutasi_jaga`
--
ALTER TABLE `mutasi_jaga`
  MODIFY `id_mutasi_jaga` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `mutasi_peralatan`
--
ALTER TABLE `mutasi_peralatan`
  MODIFY `id_mutasi_peralatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `patroli`
--
ALTER TABLE `patroli`
  MODIFY `id_patroli` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `peralatan`
--
ALTER TABLE `peralatan`
  MODIFY `id_peralatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `satpam`
--
ALTER TABLE `satpam`
  MODIFY `id_satpam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `titik_patroli`
--
ALTER TABLE `titik_patroli`
  MODIFY `id_titik` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `id_unit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `unit_satpam`
--
ALTER TABLE `unit_satpam`
  MODIFY `id_unit_satpam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `visitor`
--
ALTER TABLE `visitor`
  MODIFY `id_visitor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `titik_patroli`
--
ALTER TABLE `titik_patroli`
  ADD CONSTRAINT `titik_patroli_ibfk_1` FOREIGN KEY (`id_unit`) REFERENCES `unit` (`id_unit`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
