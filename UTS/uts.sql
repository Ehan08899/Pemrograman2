-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 30 Okt 2026 pada 13.57
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uts`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendaftar`
--

CREATE TABLE `pendaftar` (
  `id` int(11) NOT NULL,
  `tgl_input` date NOT NULL,
  `kode` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jk` enum('Laki-Laki','Perempuan') NOT NULL,
  `asal_sekolah` varchar(100) NOT NULL,
  `pekerjaan_ortu` varchar(100) NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `mat` tinyint(3) UNSIGNED NOT NULL,
  `bing` tinyint(3) UNSIGNED NOT NULL,
  `umum` tinyint(3) UNSIGNED NOT NULL,
  `rata_rata` decimal(5,2) NOT NULL,
  `tempat_tes` varchar(20) NOT NULL,
  `keterangan` enum('Lulus','Cadangan','Tidak Lulus') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pendaftar`
--

INSERT INTO `pendaftar` (`id`, `tgl_input`, `kode`, `nama`, `jk`, `asal_sekolah`, `pekerjaan_ortu`, `tempat_lahir`, `tgl_lahir`, `mat`, `bing`, `umum`, `rata_rata`, `tempat_tes`, `keterangan`, `created_at`) VALUES
(1, '2026-10-30', 'A2', 'ehank', 'Laki-Laki', 'Oxford', 'Presiden', 'Menteng atas', '2005-10-25', 100, 100, 100, 100.00, 'Gedung A', 'Lulus', '2026-10-30 12:42:23'),
(2, '2026-10-31', 'A3', 'ehank', 'Laki-Laki', 'Oxford', 'Presiden', 'Menteng atas', '2000-10-30', 80, 78, 89, 82.33, 'Gedung A', 'Lulus', '2026-10-30 12:49:19'),
(4, '2026-10-28', 'A4', 'ipul', 'Laki-Laki', 'Sasmita', 'Guru', 'Tangerang', '2026-10-30', 88, 89, 70, 82.33, 'Gedung A', 'Lulus', '2026-10-30 12:56:33');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `pendaftar`
--
ALTER TABLE `pendaftar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode` (`kode`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `pendaftar`
--
ALTER TABLE `pendaftar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
