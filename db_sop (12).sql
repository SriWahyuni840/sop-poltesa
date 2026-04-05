-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2026 at 04:49 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sop`
--

-- --------------------------------------------------------

--
-- Table structure for table `catatans`
--

CREATE TABLE `catatans` (
  `id` int(11) NOT NULL,
  `sop_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `jenis_catatan` enum('verifikasi_admin','review_kepala') NOT NULL DEFAULT 'verifikasi_admin',
  `isi_catatan` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `catatans`
--

INSERT INTO `catatans` (`id`, `sop_id`, `user_id`, `jenis_catatan`, `isi_catatan`, `created_at`, `updated_at`) VALUES
(1, 1, 15, 'verifikasi_admin', 'kurang teliti dibagian...', '2026-03-23 10:15:35', '2026-03-23 10:15:35'),
(2, 21, 15, 'verifikasi_admin', 'kurang dibagian tgl efektiiif', '2026-03-27 02:42:06', '2026-03-27 02:42:06'),
(3, 25, 15, 'verifikasi_admin', 'ssssssssss', '2026-04-02 08:18:37', '2026-04-02 08:18:37'),
(4, 25, 15, 'verifikasi_admin', 'ssssssssss', '2026-04-02 08:18:38', '2026-04-02 08:18:38'),
(5, 25, 15, 'verifikasi_admin', 'ssssssssss', '2026-04-02 08:18:39', '2026-04-02 08:18:39');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_sop`
--

CREATE TABLE `jenis_sop` (
  `id` int(11) NOT NULL,
  `kode_jenis` varchar(20) NOT NULL,
  `nama_jenis` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jenis_sop`
--

INSERT INTO `jenis_sop` (`id`, `kode_jenis`, `nama_jenis`, `created_at`, `updated_at`) VALUES
(1, 'PR', 'Perencanaan dan Program', '2026-03-23 16:59:04', '2026-03-23 16:59:04'),
(2, 'KU', 'Keuangan', '2026-03-23 16:59:04', '2026-03-23 16:59:04'),
(3, 'KS', 'Kerja Sama', '2026-03-23 16:59:04', '2026-03-23 16:59:04'),
(4, 'KP', 'Kepegawaian', '2026-03-23 16:59:04', '2026-03-23 16:59:04'),
(5, 'HK', 'Hukum', '2026-03-23 16:59:04', '2026-03-23 16:59:04'),
(6, 'OT', 'Organisasi dan Ketatalaksanaan', '2026-03-23 16:59:04', '2026-03-23 16:59:04'),
(7, 'HM', 'Hubungan Masyarakat', '2026-03-23 16:59:04', '2026-03-23 16:59:04'),
(8, 'LK', 'Perlengkapan', '2026-03-23 16:59:04', '2026-03-23 16:59:04'),
(9, 'TU', 'Kearsipan', '2026-03-23 16:59:04', '2026-03-23 16:59:04'),
(10, 'RT', 'Kerumahtanggaan', '2026-03-23 16:59:04', '2026-03-23 16:59:04'),
(11, 'TI', 'Teknologi Informasi dan Komunikasi', '2026-03-23 16:59:04', '2026-03-23 16:59:04'),
(12, 'PP', 'Pendidikan dan Pelatihan', '2026-03-23 16:59:04', '2026-03-23 16:59:04'),
(13, 'WS', 'Pengawasan', '2026-03-23 16:59:04', '2026-03-23 16:59:04'),
(14, 'GT', 'Guru dan Tenaga Kependidikan', '2026-03-23 16:59:04', '2026-03-23 16:59:04'),
(15, 'DM', 'Pendidikan Anak Usia Dini, Pendidikan Dasar dan Pendidikan Menengah', '2026-03-23 16:59:04', '2026-03-23 16:59:04'),
(16, 'DV', 'Pendidikan Vokasi', '2026-03-23 16:59:04', '2026-03-23 16:59:04'),
(17, 'DT', 'Pendidikan Tinggi', '2026-03-23 16:59:04', '2026-03-23 16:59:04'),
(18, 'KB', 'Kebudayaan', '2026-03-23 16:59:04', '2026-03-23 16:59:04'),
(19, 'DS', 'Data Statistik Pendidikan dan Kebudayaan', '2026-03-23 16:59:04', '2026-03-23 16:59:04'),
(20, 'SF', 'Sensor Film', '2026-03-23 16:59:04', '2026-03-23 16:59:04'),
(21, 'BS', 'Pengembangan, Pembinaan, dan Pelindungan Bahasa dan Sastra Indonesia', '2026-03-23 16:59:04', '2026-03-23 16:59:04'),
(22, 'SK', 'Standar, Kurikulum, dan Asesmen Pendidikan', '2026-03-23 16:59:04', '2026-03-23 16:59:04'),
(23, 'AK', 'Akreditasi', '2026-03-23 16:59:04', '2026-03-23 16:59:04'),
(24, 'SP', 'Standarisasi Pendidikan', '2026-03-23 16:59:04', '2026-03-23 16:59:04'),
(25, 'PN', 'Prestasi Nasional', '2026-03-23 16:59:04', '2026-03-23 16:59:04'),
(26, 'PK', 'Penguatan Karakter', '2026-03-23 16:59:04', '2026-03-23 16:59:04'),
(27, 'LP', 'Layanan Pembiayaan Pendidikan', '2026-03-23 16:59:04', '2026-03-23 16:59:04'),
(28, 'AL', 'Akademik LLDIKTI', '2026-03-23 16:59:04', '2026-03-23 16:59:04'),
(29, 'KL', 'Kelembagaan Lembaga Layanan Dikti', '2026-03-23 16:59:04', '2026-03-23 16:59:04'),
(30, 'KM', 'Kemahasiswaan Lembaga Layanan Dikti', '2026-03-23 16:59:04', '2026-03-23 16:59:04');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nomor_sops`
--

CREATE TABLE `nomor_sops` (
  `id` int(11) NOT NULL,
  `sop_id` int(11) NOT NULL,
  `nomor_sop` varchar(100) NOT NULL,
  `nomor_urut` int(11) NOT NULL,
  `status_nomor` enum('booking','final') NOT NULL DEFAULT 'booking',
  `tanggal_booking` datetime DEFAULT NULL,
  `tanggal_finalisasi` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nomor_sops`
--

INSERT INTO `nomor_sops` (`id`, `sop_id`, `nomor_sop`, `nomor_urut`, `status_nomor`, `tanggal_booking`, `tanggal_finalisasi`, `created_at`, `updated_at`) VALUES
(1, 1, 'SOP/BKU/AL/2026/001', 1, '', '2026-03-24 03:53:08', NULL, '2026-03-23 20:53:08', '2026-03-23 20:53:08'),
(2, 2, 'SOP/BKU/AL/2026/002', 2, 'final', '2026-03-24 04:31:23', '2026-03-24 04:31:32', '2026-03-23 21:31:23', '2026-03-23 21:31:32'),
(3, 3, 'SOP/BKU/AL/2026/003', 3, 'final', '2026-03-24 05:18:25', '2026-03-24 05:19:12', '2026-03-23 22:18:25', '2026-03-23 22:19:12'),
(4, 4, 'SOP/BKU/BS/2026/001', 1, 'final', '2026-03-24 05:39:11', '2026-03-24 05:54:49', '2026-03-23 22:39:11', '2026-03-23 22:54:49'),
(5, 5, 'SOP/BKU/DT/2026/001', 1, 'final', '2026-03-24 11:27:21', '2026-03-24 11:27:36', '2026-03-24 04:27:21', '2026-03-24 04:27:36'),
(6, 6, 'SOP/BKU/BS/2026/002', 2, 'final', '2026-03-24 11:52:43', '2026-03-24 11:52:51', '2026-03-24 04:52:43', '2026-03-24 04:52:51'),
(7, 7, 'SOP/BKU/BS/2026/003', 3, 'final', '2026-03-24 11:55:53', '2026-03-24 11:56:03', '2026-03-24 04:55:53', '2026-03-24 04:56:03'),
(8, 8, 'SOP/BKU/AK/2026/001', 1, 'final', '2026-03-24 12:04:55', '2026-03-24 12:20:11', '2026-03-24 05:04:55', '2026-03-24 05:20:11'),
(9, 9, 'SOP/BKU/HK/2026/001', 1, 'final', '2026-03-24 12:21:56', '2026-03-24 12:22:12', '2026-03-24 05:21:56', '2026-03-24 05:22:12'),
(10, 10, 'SOP/BKU/HM/2026/001', 1, 'final', '2026-03-24 12:58:19', '2026-03-24 12:58:59', '2026-03-24 05:58:19', '2026-03-24 05:58:59'),
(11, 11, 'SOP/BKU/AK/2026/002', 2, 'final', '2026-03-24 13:11:17', '2026-03-24 13:11:30', '2026-03-24 06:11:17', '2026-03-24 06:11:30'),
(12, 12, 'SOP/BKU/HK/2026/002', 2, 'final', '2026-03-25 03:21:38', '2026-03-25 03:21:44', '2026-03-24 20:21:38', '2026-03-24 20:21:44'),
(13, 13, 'SOP/BKU/AL/2026/004', 4, 'final', '2026-03-25 10:28:23', '2026-03-25 11:26:49', '2026-03-25 03:28:23', '2026-03-25 04:26:49'),
(14, 14, 'SOP/BKU/AK/2026/003', 3, 'final', '2026-03-25 13:13:57', '2026-03-25 13:15:11', '2026-03-25 06:13:57', '2026-03-25 06:15:11'),
(15, 15, 'SOP/BKU/HK/2026/003', 3, 'final', '2026-03-25 13:39:21', '2026-03-25 13:40:31', '2026-03-25 06:39:21', '2026-03-25 06:40:31'),
(16, 16, 'SOP/BKU/HM/2026/002', 2, 'final', '2026-03-25 13:58:06', '2026-03-25 13:59:06', '2026-03-25 06:58:06', '2026-03-25 06:59:06'),
(17, 17, 'SOP/BKU/KP/2026/001', 1, 'final', '2026-03-25 14:56:24', '2026-03-25 14:57:06', '2026-03-25 07:56:24', '2026-03-25 07:57:06'),
(18, 18, 'SOP/BKU/KL/2026/001', 1, 'final', '2026-03-25 15:28:18', '2026-03-25 15:29:24', '2026-03-25 08:28:18', '2026-03-25 08:29:24'),
(19, 19, 'SOP/BKU/KS/2026/001', 1, 'final', '2026-03-25 15:48:52', '2026-03-25 15:50:13', '2026-03-25 08:48:52', '2026-03-25 08:50:13'),
(20, 20, 'SOP/BKU/KB/2026/001', 1, 'final', '2026-03-26 10:54:15', '2026-03-26 10:57:02', '2026-03-26 03:54:15', '2026-03-26 03:57:02'),
(21, 22, 'SOP/BKU/HM/2026/003', 3, 'final', '2026-03-28 08:01:37', '2026-03-28 08:02:31', '2026-03-28 01:01:37', '2026-03-28 01:02:31'),
(22, 23, 'SOP/MI/KB/2026/001', 1, 'final', '2026-04-01 10:11:09', '2026-04-01 10:12:29', '2026-04-01 03:11:09', '2026-04-01 03:12:29'),
(23, 24, 'SOP/MI/AK/2026/001', 1, 'final', '2026-04-02 15:06:28', '2026-04-03 09:04:28', '2026-04-02 08:06:28', '2026-04-03 02:04:28'),
(24, 26, 'SOP/MI/HK/2026/001', 1, 'final', '2026-04-04 13:20:13', '2026-04-04 13:21:08', '2026-04-04 06:20:13', '2026-04-04 06:21:08'),
(25, 28, 'SOP/MI/GT/2026/001', 1, 'final', '2026-04-04 20:54:00', '2026-04-04 20:54:56', '2026-04-04 13:54:00', '2026-04-04 13:54:56'),
(26, 29, 'SOP/MI/KL/2026/001', 1, 'final', '2026-04-04 21:13:31', '2026-04-04 21:14:10', '2026-04-04 14:13:31', '2026-04-04 14:14:10'),
(27, 25, 'SOP/MI/KB/2026/002', 2, 'final', '2026-04-04 21:27:48', '2026-04-04 21:28:29', '2026-04-04 14:27:48', '2026-04-04 14:28:29'),
(28, 30, 'SOP/MI/AK/2026/002', 2, 'final', '2026-04-04 21:38:08', '2026-04-04 21:38:45', '2026-04-04 14:38:08', '2026-04-04 14:38:45');

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sop_id` int(11) NOT NULL,
  `jenis_notifikasi` enum('revisi_admin','revisi_kepala') NOT NULL,
  `judul` varchar(255) NOT NULL,
  `pesan` text NOT NULL,
  `status_baca` enum('belum_dibaca','sudah_dibaca') DEFAULT 'belum_dibaca',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sops`
--

CREATE TABLE `sops` (
  `id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `jenis_sop_id` int(11) NOT NULL,
  `nama_sop` varchar(255) NOT NULL,
  `tahun_berlaku` year(4) NOT NULL,
  `tanggal_pembuatan` date NOT NULL,
  `tanggal_revisi` date DEFAULT NULL,
  `tanggal_efektif` date DEFAULT NULL,
  `file_draft` varchar(255) NOT NULL,
  `file_bernomor` varchar(255) DEFAULT NULL,
  `file_surat_permohonan` varchar(255) NOT NULL,
  `file_final` varchar(255) DEFAULT NULL,
  `status` enum('draft','diajukan','dikembalikan_admin','diverifikasi_admin','nomor_booking','dikembalikan_kepala','disetujui_kepala','nomor_final','dikirim_ke_umum','dikirim_ke_direktur','ditandatangani','diarsipkan') NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `archived_by` int(11) DEFAULT NULL,
  `archived_at` datetime DEFAULT NULL,
  `qr_code` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sops`
--

INSERT INTO `sops` (`id`, `unit_id`, `jenis_sop_id`, `nama_sop`, `tahun_berlaku`, `tanggal_pembuatan`, `tanggal_revisi`, `tanggal_efektif`, `file_draft`, `file_bernomor`, `file_surat_permohonan`, `file_final`, `status`, `created_at`, `updated_at`, `archived_by`, `archived_at`, `qr_code`) VALUES
(1, 1, 28, 'pelaksanaan perkuliahan', '2026', '2026-03-23', NULL, '2026-03-23', 'drafts/iBUCtdWMm38Rt2qx9Zz6zS8gClnjCV765ECZNYWk.docx', NULL, 'surat/qhwvWLepQmZX97DAVb4sWbb8YKqOAIIhb1mx3O7o.docx', NULL, '', '2026-03-23 10:02:20', '2026-03-23 20:53:08', NULL, NULL, NULL),
(2, 1, 28, 'adademik 2026', '2026', '2026-03-24', NULL, '2026-03-27', 'drafts/j8HW4dq6l6zZYbvSF2E6aThJxMCVaxffadIDLIe6.docx', NULL, 'surat/9wKLYGEQQtgoxFM5eTtaRq9gpwlaw3qPgmIRL1Xh.docx', NULL, 'nomor_final', '2026-03-23 21:29:59', '2026-03-23 21:31:32', NULL, NULL, NULL),
(3, 1, 28, 'perkuliahan', '2026', '2026-03-24', NULL, '2026-04-09', 'drafts/6xEyHsrllD6Bk9utZPfHwbh4FvtTZbdQpHmGTOrw.docx', NULL, 'surat/SMWKHihPMSeUyffU0h98QWJ5p0st09TYj6zK51oZ.docx', NULL, 'nomor_final', '2026-03-23 22:17:21', '2026-03-23 22:19:13', NULL, NULL, NULL),
(4, 1, 21, 'biaya pendidikan', '2026', '2026-03-24', NULL, '2026-04-11', 'drafts/2U8RWyOR2kS91LXjQMy3mVlRiDW5lXRmCk0mqsQk.docx', NULL, 'surat/igFn9tK41hgZKDRbYu2Q5hTa0ZTsQkCc14Yr66Ic.docx', 'final/sop-final-4-1774331686.docx', 'nomor_final', '2026-03-23 22:38:41', '2026-03-23 22:54:49', NULL, NULL, NULL),
(5, 1, 17, 'pendidikan', '2026', '2026-03-24', NULL, '2026-04-08', 'drafts/R5HhU8FrqOu6FDlUWZoZkjFHEEyVmXdHQbxjXSzN.docx', NULL, 'surat/A1BhpquBF9MOiJCZTuuIl0ugrRyRgwMbNHHfWuvl.docx', 'final/sop-final-5-1774351651.docx', 'nomor_final', '2026-03-24 04:25:52', '2026-03-24 04:27:36', NULL, NULL, NULL),
(6, 1, 21, 'pengembangan bahasa', '2026', '2026-03-27', NULL, '2026-04-08', 'drafts/GvN2XcyPx7jLjDFHayDrNXzT5P1WITDh33R5cgC9.docx', NULL, 'surat/RHiyveLC81vkW5i0W6BIgT5BIeJ7EvGnsXZsvNAR.docx', 'final/sop-final-6-1774353358.docx', 'nomor_final', '2026-03-24 04:52:03', '2026-03-24 04:55:58', NULL, NULL, NULL),
(7, 1, 21, 'sastra indo', '2026', '2026-03-24', NULL, '2026-04-07', 'drafts/IAeaACTgRCbV5rlDyCVG5FlXCnqeWsFfWiZkcsoh.docx', NULL, 'surat/D1C6BXtrPGawlFNEsfrVwTUtGRdo5rC5d85sAsfV.docx', 'final/sop-final-7-1774353368.docx', 'nomor_final', '2026-03-24 04:55:29', '2026-03-24 04:56:08', NULL, NULL, NULL),
(8, 1, 23, 'akreditasi', '2026', '2026-03-24', NULL, '2026-04-05', 'drafts/5FetXze4fOJ5b0CyS42oVIyJKYi3Z6MhudPl6UtJ.docx', NULL, 'surat/NARGYeaQEXJPz0lnIG4zAoqR6idHnTVE9lcUOE3B.docx', NULL, 'nomor_final', '2026-03-24 05:04:24', '2026-03-24 05:20:11', NULL, NULL, NULL),
(9, 1, 5, 'hukum', '2026', '2026-03-24', NULL, '2026-04-01', 'drafts/V6FGToCmOwjuUfc1et2ab8D4MOFQr2Mr32yhPpyz.docx', NULL, 'surat/09jcvZzVQvgak9i910pzc72aj81psvqwGudLpTls.docx', 'final/sop-final-9-1774447337.docx', 'diarsipkan', '2026-03-24 05:21:00', '2026-04-04 13:41:51', 15, '2026-03-25 21:03:35', 'qr/qr-sop-9.png'),
(10, 1, 7, 'hb masyarakat', '2026', '2026-03-24', NULL, '2026-03-26', 'drafts/aPNlzPECPiWQLqnB3duxToI25q1er4OQwa02J7j0.docx', NULL, 'surat/K6DPIf1HWEJbaMJwvIJXRdYwoSi59Et9RdFjihis.docx', 'final/sop-final-10-1774357102.docx', 'nomor_final', '2026-03-24 05:57:26', '2026-03-24 05:58:59', NULL, NULL, NULL),
(11, 1, 23, 'akredutasi', '2026', '2026-03-26', '2026-03-25', '2026-03-25', 'drafts/VsO3q7C7M2X6dO5Oo3d1QLVxPJs0v9gNqqdFYk5R.docx', NULL, 'surat/r5FJ5C6f0dFCPgkXOCTP00DWjD4B0Mz8w47ZA7yK.docx', 'final/sop-final-11-1774361618.docx', 'nomor_final', '2026-03-24 06:10:40', '2026-03-24 07:13:38', NULL, NULL, NULL),
(12, 1, 5, 'hukum kampus', '2026', '2026-03-25', NULL, '2026-04-07', 'drafts/uQADdfoOwPWp4K1jCarQsL1sjuYpUQpcGhwDoHHL.docx', NULL, 'surat/wtDRvKED8SLQ7F4iAzJIQZq5bOnaYqAbZsBCrV3n.docx', 'final/sop-final-12-1774408901.docx', 'diarsipkan', '2026-03-24 20:20:45', '2026-04-04 13:41:51', 15, '2026-03-28 15:32:51', 'VERIFIKASI SOP: SOP/BKU/HK/2026/002 | DISAHKAN DIREKTUR'),
(13, 1, 28, 'akademikkk', '2026', '2026-03-25', NULL, '2026-03-30', 'drafts/Z7SGOW3VFRIPm8ghkjgo9T4rksvu2MUVzmdl3riu.docx', NULL, 'surat/spfRZozB1P5lzVxJ8iiTJfuknT3h7r5gTyRzfmOj.docx', 'bernomor/sop-bernomor-13-1774438055.docx', 'dikirim_ke_direktur', '2026-03-25 03:18:26', '2026-03-25 04:34:29', NULL, NULL, NULL),
(14, 1, 23, 'akreditasi kmps', '2026', '2026-03-25', NULL, '2026-03-27', 'drafts/7OQPMePiEavG0eBeaaImXA5s3Gw6o9ll44C60Cgp.docx', NULL, 'surat/WXyMvcZkjvYYY0lOMBs5QFQaLn1UDPqBmeMhwf3k.docx', NULL, 'dikirim_ke_direktur', '2026-03-25 06:13:23', '2026-03-25 06:15:36', NULL, NULL, NULL),
(15, 1, 5, 'hkm', '2026', '2026-03-25', NULL, '2026-03-25', 'drafts/0zqK2Z1SRkq2dmdwU7v8s8f5ZVdzgKiorxh6nSdc.docx', NULL, 'surat/XcFM0u569vYW5ygqiTlyetAUA6ah9U93HYugx0J1.docx', 'final/sop-final-15-1774446144.docx', 'diarsipkan', '2026-03-25 06:38:20', '2026-04-04 13:41:51', 15, '2026-03-25 21:53:57', 'qr/qr-sop-15.png'),
(16, 1, 7, 'hb mayarakat umum', '2026', '2026-03-25', NULL, '2026-03-31', 'drafts/3jqfjacCcqcKXMlC4Hh3e1CuGYpk4W2ofWLfl1im.docx', NULL, 'surat/sh0S7Ro9WsoPKt6qM0X0m4ofAX7JsDKwOsGOVVpf.docx', 'bernomor/sop-bernomor-16-1774447181.docx', 'dikirim_ke_direktur', '2026-03-25 06:57:22', '2026-03-25 07:01:28', NULL, NULL, NULL),
(17, 1, 4, 'pegawai', '2026', '2026-03-25', NULL, '2026-03-26', 'drafts/2hzcrsmorM1n277tecS17lBlm90ar3yznc4yRHtv.docx', 'bernomor/sop-bernomor-17-1774450628.docx', 'surat/ggqojZ0qIIIQJwqV5SBP4Wv9jydmUHjgckLLF846.docx', 'final/sop-final-17-1774452684.docx', 'diarsipkan', '2026-03-25 07:55:44', '2026-04-04 13:41:51', 15, '2026-03-28 15:32:57', 'qr/qr-sop-17.png'),
(18, 1, 29, 'kelembagaan', '2026', '2026-03-25', NULL, '2026-03-26', 'drafts/E6WjI9U2vpOgEyBkqeFUZl4EaodAF2QiOk0P0Vyd.docx', 'bernomor/sop-bernomor-18-1774452568.docx', 'surat/BvgGA1QRoRRpB8e7jHNN119l7HZOMMJok1vAL9N8.docx', NULL, 'dikirim_ke_direktur', '2026-03-25 08:27:20', '2026-03-25 08:30:17', NULL, NULL, NULL),
(19, 1, 3, 'ks', '2026', '2026-03-25', NULL, '2026-03-26', 'drafts/K74OR3GNVOQO5UwB5zCbrbG5LZclMAjm4S2DEO4d.docx', 'bernomor/sop-bernomor-19-1774453817.docx', 'surat/aquJisfFFzuNpFY3GjsfkOcbSHv38Wnl4pyvJUwD.docx', NULL, 'dikirim_ke_direktur', '2026-03-25 08:47:52', '2026-03-25 08:53:27', NULL, NULL, NULL),
(20, 1, 18, 'kebudayaann', '2026', '2026-03-26', NULL, '2026-03-26', 'drafts/S00BaaE4dqYshVo1c96KJxMMXaQGD5oKYtEcSQYl.docx', 'bernomor/sop-bernomor-20-1774522624.docx', 'surat/DQksx1rEc2a2UhbGANDizlENYUcPQfyOHrAoInQm.docx', 'final/sop-final-20-1774524688.docx', 'diarsipkan', '2026-03-26 03:53:23', '2026-04-04 13:41:51', 15, '2026-04-04 12:54:29', 'qr/qr-sop-20.png'),
(21, 1, 28, 'LLDIKTI', '2026', '2026-03-27', '2026-03-26', '2026-03-27', 'drafts/4aB916NsaWCcCtqL5eELFbuek13bM3bjvIOHVqgD.docx', NULL, 'surat/qi1qtRBPmYfrUPml2858tzCemFryOC6ejtTX9ZBe.docx', NULL, 'dikembalikan_admin', '2026-03-27 02:40:43', '2026-03-27 02:42:06', NULL, NULL, NULL),
(22, 1, 7, 'hubungan masyarakat', '2026', '2026-03-28', '2026-03-28', '2026-03-31', 'drafts/05meYa1tNblcML8CwVP6ylIJk4dHjDzERUDACYzb.docx', 'bernomor/sop-bernomor-22-1774684970.docx', 'surat/SsTRxCUcSoT0yfhqMCihEASgKBSncQ1l6z8nk45O.docx', 'final/sop-final-22-1774686902.docx', 'diarsipkan', '2026-03-28 01:00:33', '2026-04-04 13:41:51', 15, '2026-04-02 22:00:38', 'qr/qr-sop-22.png'),
(23, 12, 18, 'kebudayaan masyarakat', '2026', '2026-04-01', NULL, '2026-04-24', 'drafts/iWD9EYepZnXOoPlitlF2hvE8Ei4aoO4LkPw8MuZh.docx', 'bernomor/sop-bernomor-23-1775038354.docx', 'surat/mEdLAhAutwxBL6HkQCEcA1Cpjfc3cSbZEfjA9A5I.docx', 'final/sop-final-23-1775038461.docx', 'ditandatangani', '2026-04-01 03:10:25', '2026-04-01 03:14:21', NULL, NULL, 'qr/qr-sop-23.png'),
(24, 12, 23, 'Akreditasi kampuss', '2026', '2026-04-02', NULL, '2026-04-09', 'drafts/HnicKEFGPxUmsyeps5J5TEuAeqr0kOJKjF6W6giE.docx', 'bernomor/SOP-BERNOMOR-AKREDITASI-KAMPUSS-SOP-MI-AK-2026-001.docx', 'surat/jAXcSOQYQIfw81USv1LKMyUE0eeP1Fnu97MlaoWI.docx', 'final/SOP-FINAL-AKREDITASI-KAMPUSS-SOP-MI-AK-2026-001-1775207362.docx', 'diarsipkan', '2026-04-02 08:05:02', '2026-04-04 13:41:51', 15, '2026-04-04 12:25:46', 'qr/qr-sop-24.png'),
(25, 12, 18, 'kebudayaan masyarakat', '2026', '2026-04-02', '2026-04-02', '2026-04-04', 'drafts/mLN1NxfEChQdXQPgal1oKWXQnnZwo9PoujaH3p4Y.docx', 'bernomor/SOP-BERNOMOR-KEBUDAYAAN-MASYARAKAT-SOP-MI-KB-2026-002.docx', 'surat/vJvuQnSFbKYhC35igjNShpCzr3OwRfZr8JSwUBwD.docx', 'final/SOP-FINAL-KEBUDAYAAN-MASYARAKAT-SOP-MI-KB-2026-002-1775312948.docx', 'ditandatangani', '2026-04-02 08:17:34', '2026-04-04 14:29:08', NULL, NULL, 'qr/qr-sop-25.png'),
(26, 12, 5, 'hukum kedinasan', '2026', '2026-04-04', NULL, '2026-04-04', 'drafts/vfbCpOBMDpxGi5sCGcWaHKKHjVxLoxVexgBrBPVo.docx', 'bernomor/SOP-BERNOMOR-HUKUM-KEDINASAN-SOP-MI-HK-2026-001.docx', 'surat/ukySO992BIYNMbJ006EA94wgf7dD6BfkWiVvR5kE.docx', 'final/SOP-FINAL-HUKUM-KEDINASAN-SOP-MI-HK-2026-001-1775309200.docx', 'diarsipkan', '2026-04-03 19:34:45', '2026-04-04 13:41:51', 15, '2026-04-04 20:33:07', 'qr/qr-sop-26.png'),
(27, 12, 23, 'akreditas', '2026', '2026-04-04', '2026-04-04', NULL, 'drafts/iGOX9qFCMqSqVfTM4DsaBh10GGJsNNPxnKQ8bZPJ.docx', NULL, 'surat/Pa05eRrf7lFGn351irx6qz4N9nIUGfAjaPQq2D94.docx', NULL, 'draft', '2026-04-04 03:37:51', '2026-04-04 04:52:50', NULL, NULL, NULL),
(28, 12, 14, 'guru', '2026', '2026-04-04', NULL, '2026-04-04', 'drafts/8VM6F4ClCSgx1AEavzwq9nRbIsWHAgG1kEbc2WOk.docx', 'bernomor/SOP-BERNOMOR-GURU-SOP-MI-GT-2026-001.docx', 'surat/I8yqjQTg9vqqGYsrS5O74AtWePzFJBIcF4tzvnwn.docx', 'final/SOP-FINAL-GURU-SOP-MI-GT-2026-001-1775310951.docx', 'diarsipkan', '2026-04-04 13:53:30', '2026-04-04 14:11:52', 15, '2026-04-04 21:11:52', 'qr/qr-sop-28.png'),
(29, 12, 29, 'lembaga', '2026', '2026-04-04', NULL, '2026-04-04', 'drafts/sAhsQk6lyKGhNgJrbBgW5MvpUm85gfRRnNZRm1cU.docx', 'bernomor/SOP-BERNOMOR-LEMBAGA-SOP-MI-KL-2026-001.docx', 'surat/1DTkmcz1RQ8WKdpyCiHR2PL0vjKNa2xDc8xVgCyU.docx', 'final/SOP-FINAL-LEMBAGA-SOP-MI-KL-2026-001-1775312110.docx', 'ditandatangani', '2026-04-04 14:13:04', '2026-04-04 14:15:10', NULL, NULL, 'qr/qr-sop-29.png'),
(30, 12, 23, 'a', '2026', '2026-04-04', NULL, '2026-04-04', 'drafts/QJ0a0Q6RDQ11Kh2TOcKJBuBHnQwIXtRl6UT9o4Kr.docx', 'bernomor/SOP-BERNOMOR-A-SOP-MI-AK-2026-002.docx', 'surat/1s2CJNEx0VN7HGjfxPeccSYRVlivQcnThZ4RozXY.docx', 'final/SOP-FINAL-A-SOP-MI-AK-2026-002-1775314101.docx', 'ditandatangani', '2026-04-04 14:37:43', '2026-04-04 14:48:21', NULL, NULL, 'qr/qr-sop-30.png');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` int(11) NOT NULL,
  `kode_unit` varchar(20) NOT NULL,
  `nama_unit` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `kode_unit`, `nama_unit`, `created_at`, `updated_at`) VALUES
(1, 'BKU', 'Bagian Keuangan dan Umum', '2026-03-23 16:58:34', '2026-03-23 16:58:34'),
(2, 'BAKPK', 'Bagian Akademik, Kemahasiswaan, Perencanaan, dan Kerjasama', '2026-03-23 16:58:34', '2026-03-23 16:58:34'),
(3, 'PPMPP', 'Pusat Penjaminan Mutu dan Pengembangan Pembelajaran', '2026-03-23 16:58:34', '2026-03-23 16:58:34'),
(4, 'P3M', 'Pusat Penelitian dan PKM', '2026-03-23 16:58:34', '2026-03-23 16:58:34'),
(5, 'UPA-Perpustakaan', 'UPA Perpustakaan', '2026-03-23 16:58:34', '2026-03-23 16:58:34'),
(6, 'UPA-Bahasa', 'UPA Bahasa', '2026-03-23 16:58:34', '2026-03-23 16:58:34'),
(7, 'UPA-PKK', 'UPA Pengembangan Karir dan Kewirausahaan', '2026-03-23 16:58:34', '2026-03-23 16:58:34'),
(8, 'UPA-PP', 'UPA Perawatan dan Perbaikan', '2026-03-23 16:58:34', '2026-03-23 16:58:34'),
(9, 'UPA-TIK', 'UPA TIK', '2026-03-23 16:58:34', '2026-03-23 16:58:34'),
(10, 'LSP', 'Lembaga Pengembangan Sertifikasi', '2026-03-23 16:58:34', '2026-03-23 16:58:34'),
(11, 'AGB', 'Jurusan Agribisnis', '2026-03-23 16:58:34', '2026-03-23 16:58:34'),
(12, 'MI', 'Jurusan Manajemen Informatika', '2026-03-23 16:58:34', '2026-03-23 16:58:34'),
(13, 'TME', 'Jurusan Teknik Mesin', '2026-03-23 16:58:34', '2026-03-23 16:58:34'),
(14, 'SPI', 'Satuan Pengawas Internal', '2026-03-23 16:58:34', '2026-03-23 16:58:34');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('unit','admin_p2mpp','kepala_pusat','bagian_umum','direktur') NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `unit_id`, `name`, `username`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 1, 'Unit BKU', 'unit_bku', '12345678', 'unit', '2026-03-23 17:00:10', '2026-03-23 17:00:10'),
(2, 2, 'Unit BAKPK', 'unit_bakpk', '12345678', 'unit', '2026-03-23 17:00:10', '2026-03-23 17:00:10'),
(3, 3, 'Unit PPMPP', 'unit_ppmpp', '12345678', 'unit', '2026-03-23 17:00:10', '2026-03-23 17:00:10'),
(4, 4, 'Unit P3M', 'unit_p3m', '12345678', 'unit', '2026-03-23 17:00:10', '2026-03-23 17:00:10'),
(5, 5, 'Unit UPA Perpustakaan', 'unit_upa_perpustakaan', '12345678', 'unit', '2026-03-23 17:00:10', '2026-03-23 17:00:10'),
(6, 6, 'Unit UPA Bahasa', 'unit_upa_bahasa', '12345678', 'unit', '2026-03-23 17:00:10', '2026-03-23 17:00:10'),
(7, 7, 'Unit UPA PKK', 'unit_upa_pkk', '12345678', 'unit', '2026-03-23 17:00:10', '2026-03-23 17:00:10'),
(8, 8, 'Unit UPA PP', 'unit_upa_pp', '12345678', 'unit', '2026-03-23 17:00:10', '2026-03-23 17:00:10'),
(9, 9, 'Unit UPA TIK', 'unit_upa_tik', '12345678', 'unit', '2026-03-23 17:00:10', '2026-03-23 17:00:10'),
(10, 10, 'Unit LSP', 'unit_lsp', '12345678', 'unit', '2026-03-23 17:00:10', '2026-03-23 17:00:10'),
(11, 11, 'Unit AGB', 'unit_agb', '12345678', 'unit', '2026-03-23 17:00:10', '2026-03-23 17:00:10'),
(12, 12, 'Unit MI', 'unit_mi', '12345678', 'unit', '2026-03-23 17:00:10', '2026-03-23 17:00:10'),
(13, 13, 'Unit TME', 'unit_tme', '12345678', 'unit', '2026-03-23 17:00:10', '2026-03-23 17:00:10'),
(14, 14, 'Unit SPI', 'unit_spi', '12345678', 'unit', '2026-03-23 17:00:10', '2026-03-23 17:00:10'),
(15, NULL, 'Admin P2MPP', 'admin_p2mpp', '12345678', 'admin_p2mpp', '2026-03-23 17:00:10', '2026-03-23 17:00:10'),
(16, NULL, 'Kepala Pusat Penjamin Mutu', 'kepala_pusat', '12345678', 'kepala_pusat', '2026-03-25 10:33:35', '2026-03-25 10:33:35'),
(17, NULL, 'Bagian Umum', 'umum', '12345678', 'bagian_umum', '2026-03-25 11:56:57', '2026-03-25 11:56:57'),
(18, NULL, 'Direktur', 'direktur', '12345678', 'direktur', '2026-03-25 12:27:58', '2026-03-25 12:36:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `catatans`
--
ALTER TABLE `catatans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_catatans_sop` (`sop_id`),
  ADD KEY `fk_catatans_user` (`user_id`);

--
-- Indexes for table `jenis_sop`
--
ALTER TABLE `jenis_sop`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_jenis` (`kode_jenis`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nomor_sops`
--
ALTER TABLE `nomor_sops`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sop_id` (`sop_id`),
  ADD UNIQUE KEY `nomor_sop` (`nomor_sop`);

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `sop_id` (`sop_id`);

--
-- Indexes for table `sops`
--
ALTER TABLE `sops`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sops_unit` (`unit_id`),
  ADD KEY `fk_sops_jenis` (`jenis_sop_id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_unit` (`kode_unit`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `fk_users_unit` (`unit_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `catatans`
--
ALTER TABLE `catatans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jenis_sop`
--
ALTER TABLE `jenis_sop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nomor_sops`
--
ALTER TABLE `nomor_sops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sops`
--
ALTER TABLE `sops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `catatans`
--
ALTER TABLE `catatans`
  ADD CONSTRAINT `fk_catatans_sop` FOREIGN KEY (`sop_id`) REFERENCES `sops` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_catatans_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `nomor_sops`
--
ALTER TABLE `nomor_sops`
  ADD CONSTRAINT `fk_nomor_sops_sop` FOREIGN KEY (`sop_id`) REFERENCES `sops` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `notifikasi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifikasi_ibfk_2` FOREIGN KEY (`sop_id`) REFERENCES `sops` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sops`
--
ALTER TABLE `sops`
  ADD CONSTRAINT `fk_sops_jenis` FOREIGN KEY (`jenis_sop_id`) REFERENCES `jenis_sop` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sops_unit` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_unit` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
