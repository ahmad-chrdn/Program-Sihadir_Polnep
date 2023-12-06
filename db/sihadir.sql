-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 28, 2023 at 02:47 PM
-- Server version: 8.0.35
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tes`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id_admin` bigint UNSIGNED NOT NULL,
  `nm_admin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id_admin`, `nm_admin`, `username`, `password`, `foto`) VALUES
(1, 'Superadmin', 'admin@gmail.com', '$2y$10$jhy6Iajag2Z4/WFuYdXsGer/YKJOHcz.cFEHCZIwP3x3gf84j7Ux.', '_2c6ae715-4533-4b3e-81df-ff14229f3816.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `dosens`
--

CREATE TABLE `dosens` (
  `id_dosen` bigint UNSIGNED NOT NULL,
  `nip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nm_dosen` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jadwals`
--

CREATE TABLE `jadwals` (
  `id_jadwal` bigint UNSIGNED NOT NULL,
  `hari` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jam_ke` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `durasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `makul_id` bigint UNSIGNED NOT NULL,
  `dosen_id` bigint UNSIGNED NOT NULL,
  `ruangan_id` bigint UNSIGNED NOT NULL,
  `kelas_id` bigint UNSIGNED NOT NULL,
  `semester_id` bigint UNSIGNED NOT NULL,
  `prodi_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jurusans`
--

CREATE TABLE `jurusans` (
  `id_jurusan` bigint UNSIGNED NOT NULL,
  `kd_jurusan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_jurusan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kelass`
--

CREATE TABLE `kelass` (
  `id_kelas` bigint UNSIGNED NOT NULL,
  `kd_kelas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nm_kelas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kompensasis`
--

CREATE TABLE `kompensasis` (
  `id_kompensasi` bigint UNSIGNED NOT NULL,
  `mahasiswa_id` bigint UNSIGNED NOT NULL,
  `jumlah_jam` int NOT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswas`
--

CREATE TABLE `mahasiswas` (
  `id_mahasiswa` bigint UNSIGNED NOT NULL,
  `nim` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nm_mahasiswa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kelas_id` bigint UNSIGNED NOT NULL,
  `prodi_id` bigint UNSIGNED NOT NULL,
  `jurusan_id` bigint UNSIGNED NOT NULL,
  `status` enum('Aktif','SP1','SP2','SP3','DO') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mata_kuliahs`
--

CREATE TABLE `mata_kuliahs` (
  `id_makul` bigint UNSIGNED NOT NULL,
  `kd_makul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nm_makul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sks` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `presensi_dosens`
--

CREATE TABLE `presensi_dosens` (
  `id_presensi_dosen` bigint UNSIGNED NOT NULL,
  `dosen_id` bigint UNSIGNED NOT NULL,
  `jadwal_id` bigint UNSIGNED NOT NULL,
  `status_dosen` enum('Hadir','Tidak Hadir') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `waktu_presensi` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `presensi_mahasiswas`
--

CREATE TABLE `presensi_mahasiswas` (
  `id_presensi_mahasiswa` bigint UNSIGNED NOT NULL,
  `mahasiswa_id` bigint UNSIGNED NOT NULL,
  `jadwal_id` bigint UNSIGNED NOT NULL,
  `status_mahasiswa` enum('Hadir','Terlambat','Izin','Sakit','Alpa') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dokumen` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  `waktu_presensi` datetime NOT NULL,
  `dosen_id` bigint UNSIGNED NOT NULL,
  `status_presensi` enum('Menunggu Konfirmasi','Dikonfirmasi','Ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Menunggu Konfirmasi',
  `waktu_konfirmasi` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prodis`
--

CREATE TABLE `prodis` (
  `id_prodi` bigint UNSIGNED NOT NULL,
  `kd_prodi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_prodi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenjang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jurusan_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ruangans`
--

CREATE TABLE `ruangans` (
  `id_ruangan` bigint UNSIGNED NOT NULL,
  `kd_ruangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nm_ruangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `semesters`
--

CREATE TABLE `semesters` (
  `id_semester` bigint UNSIGNED NOT NULL,
  `semester` enum('Ganjil','Genap') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `thn_ajaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `admins_email_unique` (`username`);

--
-- Indexes for table `dosens`
--
ALTER TABLE `dosens`
  ADD PRIMARY KEY (`id_dosen`),
  ADD UNIQUE KEY `dosens_nip_unique` (`nip`);

--
-- Indexes for table `jadwals`
--
ALTER TABLE `jadwals`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `jadwals_makul_id_foreign` (`makul_id`),
  ADD KEY `jadwals_dosen_id_foreign` (`dosen_id`),
  ADD KEY `jadwals_ruangan_id_foreign` (`ruangan_id`),
  ADD KEY `jadwals_kelas_id_foreign` (`kelas_id`),
  ADD KEY `jadwals_semester_id_foreign` (`semester_id`),
  ADD KEY `jadwals_prodi_id_foreign` (`prodi_id`);

--
-- Indexes for table `jurusans`
--
ALTER TABLE `jurusans`
  ADD PRIMARY KEY (`id_jurusan`),
  ADD UNIQUE KEY `jurusans_kd_jurusan_unique` (`kd_jurusan`);

--
-- Indexes for table `kelass`
--
ALTER TABLE `kelass`
  ADD PRIMARY KEY (`id_kelas`),
  ADD UNIQUE KEY `kelass_kd_kelas_unique` (`kd_kelas`);

--
-- Indexes for table `kompensasis`
--
ALTER TABLE `kompensasis`
  ADD PRIMARY KEY (`id_kompensasi`),
  ADD KEY `kompensasis_mahasiswa_id_foreign` (`mahasiswa_id`);

--
-- Indexes for table `mahasiswas`
--
ALTER TABLE `mahasiswas`
  ADD PRIMARY KEY (`id_mahasiswa`),
  ADD UNIQUE KEY `mahasiswas_nim_unique` (`nim`),
  ADD KEY `mahasiswas_kelas_id_foreign` (`kelas_id`),
  ADD KEY `mahasiswas_prodi_id_foreign` (`prodi_id`),
  ADD KEY `mahasiswas_jurusan_id_foreign` (`jurusan_id`);

--
-- Indexes for table `mata_kuliahs`
--
ALTER TABLE `mata_kuliahs`
  ADD PRIMARY KEY (`id_makul`),
  ADD UNIQUE KEY `mata_kuliahs_kd_makul_unique` (`kd_makul`);

--
-- Indexes for table `presensi_dosens`
--
ALTER TABLE `presensi_dosens`
  ADD PRIMARY KEY (`id_presensi_dosen`),
  ADD KEY `presensi_dosens_dosen_id_foreign` (`dosen_id`),
  ADD KEY `presensi_dosens_jadwal_id_foreign` (`jadwal_id`);

--
-- Indexes for table `presensi_mahasiswas`
--
ALTER TABLE `presensi_mahasiswas`
  ADD PRIMARY KEY (`id_presensi_mahasiswa`),
  ADD KEY `presensi_mahasiswas_mahasiswa_id_foreign` (`mahasiswa_id`),
  ADD KEY `presensi_mahasiswas_jadwal_id_foreign` (`jadwal_id`),
  ADD KEY `presensi_mahasiswas_dosen_id_foreign` (`dosen_id`);

--
-- Indexes for table `prodis`
--
ALTER TABLE `prodis`
  ADD PRIMARY KEY (`id_prodi`),
  ADD UNIQUE KEY `prodis_kd_prodi_unique` (`kd_prodi`),
  ADD KEY `prodis_jurusan_id_foreign` (`jurusan_id`);

--
-- Indexes for table `ruangans`
--
ALTER TABLE `ruangans`
  ADD PRIMARY KEY (`id_ruangan`),
  ADD UNIQUE KEY `ruangans_kd_ruangan_unique` (`kd_ruangan`);

--
-- Indexes for table `semesters`
--
ALTER TABLE `semesters`
  ADD PRIMARY KEY (`id_semester`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id_admin` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dosens`
--
ALTER TABLE `dosens`
  MODIFY `id_dosen` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jadwals`
--
ALTER TABLE `jadwals`
  MODIFY `id_jadwal` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jurusans`
--
ALTER TABLE `jurusans`
  MODIFY `id_jurusan` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kelass`
--
ALTER TABLE `kelass`
  MODIFY `id_kelas` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kompensasis`
--
ALTER TABLE `kompensasis`
  MODIFY `id_kompensasi` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mahasiswas`
--
ALTER TABLE `mahasiswas`
  MODIFY `id_mahasiswa` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mata_kuliahs`
--
ALTER TABLE `mata_kuliahs`
  MODIFY `id_makul` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `presensi_dosens`
--
ALTER TABLE `presensi_dosens`
  MODIFY `id_presensi_dosen` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `presensi_mahasiswas`
--
ALTER TABLE `presensi_mahasiswas`
  MODIFY `id_presensi_mahasiswa` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prodis`
--
ALTER TABLE `prodis`
  MODIFY `id_prodi` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ruangans`
--
ALTER TABLE `ruangans`
  MODIFY `id_ruangan` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `semesters`
--
ALTER TABLE `semesters`
  MODIFY `id_semester` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jadwals`
--
ALTER TABLE `jadwals`
  ADD CONSTRAINT `jadwals_dosen_id_foreign` FOREIGN KEY (`dosen_id`) REFERENCES `dosens` (`id_dosen`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jadwals_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelass` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jadwals_makul_id_foreign` FOREIGN KEY (`makul_id`) REFERENCES `mata_kuliahs` (`id_makul`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jadwals_prodi_id_foreign` FOREIGN KEY (`prodi_id`) REFERENCES `prodis` (`id_prodi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jadwals_ruangan_id_foreign` FOREIGN KEY (`ruangan_id`) REFERENCES `ruangans` (`id_ruangan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jadwals_semester_id_foreign` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`id_semester`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kompensasis`
--
ALTER TABLE `kompensasis`
  ADD CONSTRAINT `kompensasis_mahasiswa_id_foreign` FOREIGN KEY (`mahasiswa_id`) REFERENCES `mahasiswas` (`id_mahasiswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mahasiswas`
--
ALTER TABLE `mahasiswas`
  ADD CONSTRAINT `mahasiswas_jurusan_id_foreign` FOREIGN KEY (`jurusan_id`) REFERENCES `jurusans` (`id_jurusan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mahasiswas_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelass` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mahasiswas_prodi_id_foreign` FOREIGN KEY (`prodi_id`) REFERENCES `prodis` (`id_prodi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `presensi_dosens`
--
ALTER TABLE `presensi_dosens`
  ADD CONSTRAINT `presensi_dosens_dosen_id_foreign` FOREIGN KEY (`dosen_id`) REFERENCES `dosens` (`id_dosen`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `presensi_dosens_jadwal_id_foreign` FOREIGN KEY (`jadwal_id`) REFERENCES `jadwals` (`id_jadwal`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `presensi_mahasiswas`
--
ALTER TABLE `presensi_mahasiswas`
  ADD CONSTRAINT `presensi_mahasiswas_dosen_id_foreign` FOREIGN KEY (`dosen_id`) REFERENCES `dosens` (`id_dosen`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `presensi_mahasiswas_jadwal_id_foreign` FOREIGN KEY (`jadwal_id`) REFERENCES `jadwals` (`id_jadwal`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `presensi_mahasiswas_mahasiswa_id_foreign` FOREIGN KEY (`mahasiswa_id`) REFERENCES `mahasiswas` (`id_mahasiswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `prodis`
--
ALTER TABLE `prodis`
  ADD CONSTRAINT `prodis_jurusan_id_foreign` FOREIGN KEY (`jurusan_id`) REFERENCES `jurusans` (`id_jurusan`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
