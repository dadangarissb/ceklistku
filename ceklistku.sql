-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2026 at 02:29 AM
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
-- Database: `ceklistku`
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
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_user`, `password`, `nama_user`, `jabatan`, `id_unit`, `status`) VALUES
('admin_mks', 'P@ssw0rd', 'Admin Makassar', 'TL K3L & KAM', 1, 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `apar`
--

CREATE TABLE `apar` (
  `id_apar` int(11) NOT NULL,
  `lokasi_apar` varchar(150) NOT NULL,
  `foto_apar` varchar(200) DEFAULT NULL,
  `foto_lokasi` varchar(200) DEFAULT NULL,
  `jenis_apar` varchar(50) DEFAULT NULL,
  `merk_apar` varchar(50) DEFAULT NULL,
  `no_apar` varchar(30) DEFAULT NULL,
  `berat_apar` decimal(5,2) DEFAULT NULL,
  `tgl_kadaluarsa` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `apar`
--

INSERT INTO `apar` (`id_apar`, `lokasi_apar`, `foto_apar`, `foto_lokasi`, `jenis_apar`, `merk_apar`, `no_apar`, `berat_apar`, `tgl_kadaluarsa`) VALUES
(4, 'Lobby', 'UNIT_1775056009_84.jpg', 'LOC_1775056009_29.jpg', 'Powder', 'Gunnebo', '1', 6.00, '2026-04-24'),
(5, 'Lobby', 'UNIT_1775056427_98.jpg', 'LOC_1775056427_85.jpg', 'Powder', 'Gunnebo', '2', 6.00, '2026-04-23'),
(6, 'Lobby', 'UNIT_1775056728_86.jpg', 'LOC_1775056728_42.jpg', 'Powder', 'Gunnebo', '3', 6.00, '2026-04-23'),
(7, 'Lobby', 'UNIT_1775056776.jpeg', 'LOC_1775056777.jpeg', 'Powder', 'Gunnebo', '4', 6.00, '2026-04-23');

-- --------------------------------------------------------

--
-- Table structure for table `ceklist_apar`
--

CREATE TABLE `ceklist_apar` (
  `id_ceklist` int(11) NOT NULL,
  `id_apar` int(11) NOT NULL,
  `foto_apar` varchar(200) DEFAULT NULL,
  `kategori` enum('cek rutin','isi ulang') NOT NULL,
  `tekanan` varchar(20) DEFAULT NULL,
  `safety_pin` varchar(20) DEFAULT NULL,
  `handle` varchar(20) DEFAULT NULL,
  `selang_nozzle` varchar(20) DEFAULT NULL,
  `kondisi_fisik` varchar(20) DEFAULT NULL,
  `catatan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ceklist_apar`
--

INSERT INTO `ceklist_apar` (`id_ceklist`, `id_apar`, `foto_apar`, `kategori`, `tekanan`, `safety_pin`, `handle`, `selang_nozzle`, `kondisi_fisik`, `catatan`, `created_at`) VALUES
(1, 4, 'CHECK_1775057646_53.jpg', 'cek rutin', 'Normal', 'Lengkap', NULL, NULL, 'Baik', NULL, '2026-04-01 09:34:06'),
(2, 4, 'default.jpg', 'cek rutin', 'Normal', 'Lengkap', 'Lengkap', 'Lengkap', NULL, 'Baik', '2026-04-01 09:39:07');

-- --------------------------------------------------------

--
-- Table structure for table `ceklist_harian`
--

CREATE TABLE `ceklist_harian` (
  `id_ceklist` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `nama_user` varchar(100) NOT NULL,
  `id_lokasi` int(11) NOT NULL,
  `tgl_ceklist` date NOT NULL,
  `id_detail_pekerjaan` int(11) NOT NULL,
  `id_freq_ceklist` int(11) NOT NULL,
  `nama_detail_pekerjaan` varchar(150) NOT NULL,
  `status` varchar(5) NOT NULL DEFAULT 'belum',
  `tugas_lainnya` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ceklist_harian`
--

INSERT INTO `ceklist_harian` (`id_ceklist`, `username`, `nama_user`, `id_lokasi`, `tgl_ceklist`, `id_detail_pekerjaan`, `id_freq_ceklist`, `nama_detail_pekerjaan`, `status`, `tugas_lainnya`, `created_at`, `updated_at`) VALUES
(27, 'anas', '', 1, '2026-03-26', 0, 6, '', 'sudah', NULL, '2026-03-26 13:21:39', '2026-03-26 13:21:39');

-- --------------------------------------------------------

--
-- Table structure for table `detail_pekerjaan`
--

CREATE TABLE `detail_pekerjaan` (
  `id_detail_pekerjaan` int(11) NOT NULL,
  `id_kategori_pekerjaan` int(11) NOT NULL,
  `nama_detail_pekerjaan` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_pekerjaan`
--

INSERT INTO `detail_pekerjaan` (`id_detail_pekerjaan`, `id_kategori_pekerjaan`, `nama_detail_pekerjaan`) VALUES
(1, 1, 'Memeriksa kamar'),
(2, 1, 'Membuang sampah'),
(3, 2, 'Membersihkan kamar'),
(4, 1, 'Membersihkan kamar mandi'),
(5, 5, 'Memeriksa tisu tersedia'),
(6, 5, 'Memastikan wastafel bersih');

-- --------------------------------------------------------

--
-- Table structure for table `freq_ceklist`
--

CREATE TABLE `freq_ceklist` (
  `id_freq_ceklist` int(11) NOT NULL,
  `id_kategori_pekerjaan` int(11) NOT NULL,
  `waktu_awal_cek` time NOT NULL,
  `waktu_akhir_cek` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `freq_ceklist`
--

INSERT INTO `freq_ceklist` (`id_freq_ceklist`, `id_kategori_pekerjaan`, `waktu_awal_cek`, `waktu_akhir_cek`) VALUES
(5, 1, '11:00:00', '12:00:00'),
(6, 1, '13:00:00', '15:00:00'),
(7, 1, '15:00:00', '17:00:00'),
(8, 5, '08:00:00', '10:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_pekerjaan`
--

CREATE TABLE `kategori_pekerjaan` (
  `id_kategori_pekerjaan` int(11) NOT NULL,
  `id_unit` int(11) NOT NULL,
  `nama_kategori_pekerjaan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori_pekerjaan`
--

INSERT INTO `kategori_pekerjaan` (`id_kategori_pekerjaan`, `id_unit`, `nama_kategori_pekerjaan`) VALUES
(1, 1, 'CS Wisma'),
(2, 1, 'CS Kelas'),
(5, 1, 'CS Toilet'),
(6, 1, 'CS Halaman & Taman');

-- --------------------------------------------------------

--
-- Table structure for table `kelompok_lokasi`
--

CREATE TABLE `kelompok_lokasi` (
  `id_kelompok_lokasi` int(11) NOT NULL,
  `nama_kelompok_lokasi` varchar(50) NOT NULL,
  `id_unit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kelompok_lokasi`
--

INSERT INTO `kelompok_lokasi` (`id_kelompok_lokasi`, `nama_kelompok_lokasi`, `id_unit`) VALUES
(1, 'Wisma Anggrek', 1),
(2, 'Wisma Bougenvile', 1),
(3, 'Wisma Cempaka', 1),
(4, 'Wisma Dahlia', 1),
(5, 'Wisma Edelweiss', 1),
(6, 'Wisma Flamboyan', 1),
(7, 'Wisma Gladiol', 1),
(8, 'Wisma Hortensia', 1),
(9, 'Aula', 0),
(10, 'Aula', 0),
(11, 'Aula', 1),
(12, 'Masjid', 1),
(13, 'Kantor', 1),
(14, 'Kelas', 1),
(15, 'Laboratorium', 1),
(16, 'Pantry', 1),
(17, 'Kafe Kece', 1);

-- --------------------------------------------------------

--
-- Table structure for table `keluhan`
--

CREATE TABLE `keluhan` (
  `id_keluhan` int(11) NOT NULL,
  `nama_keluhan` varchar(100) NOT NULL,
  `lokasi_keluhan` varchar(50) NOT NULL,
  `foto_keluhan` varchar(255) DEFAULT NULL,
  `pelapor` varchar(30) NOT NULL,
  `tgl_laporan` datetime DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `pic` varchar(30) DEFAULT NULL,
  `foto_selesai` varchar(255) DEFAULT NULL,
  `tgl_selesai` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `keluhan`
--

INSERT INTO `keluhan` (`id_keluhan`, `nama_keluhan`, `lokasi_keluhan`, `foto_keluhan`, `pelapor`, `tgl_laporan`, `status`, `pic`, `foto_selesai`, `tgl_selesai`) VALUES
(1, 'Pintu rusak', 'Wisma Gladiol', 'default.png', 'anas', '2026-03-29 20:20:15', 'Pending', NULL, NULL, NULL),
(2, 'Matihss', 'fsdf', 'lapor_1774808747.jpg', 'anas', '2026-03-29 20:25:47', 'Pending', NULL, NULL, NULL),
(3, 'sfdsf', 'fd', 'lapor_1774808799.png', 'anas', '2026-03-29 20:26:40', 'Pending', NULL, NULL, NULL),
(4, 'fdsf', 'fdsf', 'lapor_1774808883.jpg', 'anas', '2026-03-29 20:28:04', 'Pending', NULL, NULL, NULL),
(5, 'dsds', 'fdf', 'lapor_1774809188.jpg', 'anas', '2026-03-29 20:33:08', 'Pending', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lokasi`
--

CREATE TABLE `lokasi` (
  `id_lokasi` int(11) NOT NULL,
  `id_unit` int(11) NOT NULL,
  `nama_lokasi` varchar(30) NOT NULL,
  `kondisi` varchar(10) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `pic` varchar(30) NOT NULL,
  `id_kelompok_lokasi` int(11) NOT NULL,
  `keterangan` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lokasi`
--

INSERT INTO `lokasi` (`id_lokasi`, `id_unit`, `nama_lokasi`, `kondisi`, `id_kategori`, `pic`, `id_kelompok_lokasi`, `keterangan`) VALUES
(5, 1, 'Flamboyan 1', 'baik', 2, 'agus', 6, ''),
(6, 1, 'Flamboyan 2', 'baik', 2, 'anas', 6, ''),
(7, 1, 'Flamboyan 3', '', 1, 'asbudi', 6, ''),
(8, 1, 'Flamboyan 4', '', 1, 'anas', 6, ''),
(10, 1, 'Flamboyan 6', '', 1, 'asdar', 6, ''),
(12, 1, 'Anggrek 1', '', 1, 'anas', 1, '');

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
(1, 'UPDL Makassar', 'Jl. Malino No.377, Mawang, Kec. Somba Opu, Kabupaten Gowa, Sulawesi Selatan 92119'),
(2, 'UPDL Jakarta', 'fsfsdf'),
(4, 'UPDL Bogor', ''),
(5, 'UPDL Semarang', '');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `nama_user` varchar(30) NOT NULL,
  `id_unit` int(11) NOT NULL,
  `id_kategori_pekerjaan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `nama_user`, `id_unit`, `id_kategori_pekerjaan`) VALUES
('anas', 'P@ssw0rd', 'Ahmad Anas', 1, 1),
('asbudi', 'P@ssw0rd', 'Asbudi', 1, 2),
('asdar', 'P@ssw0rd', 'Asdar', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `apar`
--
ALTER TABLE `apar`
  ADD PRIMARY KEY (`id_apar`);

--
-- Indexes for table `ceklist_apar`
--
ALTER TABLE `ceklist_apar`
  ADD PRIMARY KEY (`id_ceklist`),
  ADD KEY `id_apar` (`id_apar`);

--
-- Indexes for table `ceklist_harian`
--
ALTER TABLE `ceklist_harian`
  ADD PRIMARY KEY (`id_ceklist`);

--
-- Indexes for table `detail_pekerjaan`
--
ALTER TABLE `detail_pekerjaan`
  ADD PRIMARY KEY (`id_detail_pekerjaan`);

--
-- Indexes for table `freq_ceklist`
--
ALTER TABLE `freq_ceklist`
  ADD PRIMARY KEY (`id_freq_ceklist`);

--
-- Indexes for table `kategori_pekerjaan`
--
ALTER TABLE `kategori_pekerjaan`
  ADD PRIMARY KEY (`id_kategori_pekerjaan`);

--
-- Indexes for table `kelompok_lokasi`
--
ALTER TABLE `kelompok_lokasi`
  ADD PRIMARY KEY (`id_kelompok_lokasi`);

--
-- Indexes for table `keluhan`
--
ALTER TABLE `keluhan`
  ADD PRIMARY KEY (`id_keluhan`);

--
-- Indexes for table `lokasi`
--
ALTER TABLE `lokasi`
  ADD PRIMARY KEY (`id_lokasi`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`id_unit`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `apar`
--
ALTER TABLE `apar`
  MODIFY `id_apar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ceklist_apar`
--
ALTER TABLE `ceklist_apar`
  MODIFY `id_ceklist` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ceklist_harian`
--
ALTER TABLE `ceklist_harian`
  MODIFY `id_ceklist` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `detail_pekerjaan`
--
ALTER TABLE `detail_pekerjaan`
  MODIFY `id_detail_pekerjaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `freq_ceklist`
--
ALTER TABLE `freq_ceklist`
  MODIFY `id_freq_ceklist` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `kategori_pekerjaan`
--
ALTER TABLE `kategori_pekerjaan`
  MODIFY `id_kategori_pekerjaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kelompok_lokasi`
--
ALTER TABLE `kelompok_lokasi`
  MODIFY `id_kelompok_lokasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `keluhan`
--
ALTER TABLE `keluhan`
  MODIFY `id_keluhan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `lokasi`
--
ALTER TABLE `lokasi`
  MODIFY `id_lokasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `id_unit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ceklist_apar`
--
ALTER TABLE `ceklist_apar`
  ADD CONSTRAINT `ceklist_apar_ibfk_1` FOREIGN KEY (`id_apar`) REFERENCES `apar` (`id_apar`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
