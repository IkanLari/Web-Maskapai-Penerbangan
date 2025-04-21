-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 21 Apr 2025 pada 13.30
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `maskapai_penerbangan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `penerbangan`
--

CREATE TABLE `penerbangan` (
  `id_maskapai` int(11) NOT NULL,
  `maskapai` varchar(255) NOT NULL,
  `asal` varchar(255) NOT NULL,
  `tujuan` varchar(255) NOT NULL,
  `tanggal` varchar(255) NOT NULL,
  `waktu` varchar(255) NOT NULL,
  `harga` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `penerbangan`
--

INSERT INTO `penerbangan` (`id_maskapai`, `maskapai`, `asal`, `tujuan`, `tanggal`, `waktu`, `harga`) VALUES
(9, 'Lion Air', 'Jakarta, Indonesia', 'Beijing, China', '2025-04-30', '21:00', '4616300'),
(10, 'AirAsia', 'Surabaya, Indonesia', 'Manado, Indonesia', '2025-04-28', '18:00', '2150000'),
(11, 'Lion Air', 'Moskow, Rusia', 'Kuala Lumpur, Malaysia', '2025-05-22', '08:15', '7099880'),
(12, 'Citilink', 'Manado, Indonesia', 'Tokyo, Jepang', '2025-04-16', '10:00', '10177992'),
(13, 'Lion Air', 'Beijing, China', 'Jakarta, Indonesia', '2025-05-01', '00:00', '4800000'),
(14, 'Lion Air', 'Kuala Lumpur, Malaysia', 'Moskow, Rusia', '2025-04-22', '12:40', '6906900'),
(15, 'Sriwijaya Air', 'Jakarta, Indonesia', 'Papua, Indonesia', '2025-04-27', '13:30', '3705000'),
(16, 'AirAsia', 'Manado, Indonesia', 'Surabaya, Indonesia', '2025-04-28', '20:30', '2000000'),
(17, 'Sriwijaya Air', 'Papua, Indonesia', 'Jakarta, Indonesia', '2025-04-27', '18:45', '3690960'),
(18, 'Sriwijaya Air', 'Mingaladon, Myanmar', 'Jakarta, Indonesia', '2025-05-06', '22:45', '4103500');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tiket_penerbangan`
--

CREATE TABLE `tiket_penerbangan` (
  `id_tiket` int(11) NOT NULL,
  `id_maskapai` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `no_rekening` varchar(50) NOT NULL,
  `waktu_pemesanan` datetime NOT NULL DEFAULT current_timestamp(),
  `jumlah_tiket` int(11) NOT NULL,
  `total_harga` varchar(255) NOT NULL,
  `status` enum('accepted','rejected','progress','pending') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tiket_penerbangan`
--

INSERT INTO `tiket_penerbangan` (`id_tiket`, `id_maskapai`, `id_user`, `no_rekening`, `waktu_pemesanan`, `jumlah_tiket`, `total_harga`, `status`) VALUES
(21, 10, 20, '12345678901234', '2025-04-16 19:05:04', 2, '4300000', 'rejected'),
(27, 16, 20, '12345678901234', '2025-04-16 19:35:37', 2, '4000000', 'accepted'),
(29, 17, 47, '09876543210987', '2025-04-16 20:12:18', 4, '14763840', 'pending'),
(31, 15, 47, '09876543210987', '2025-04-16 20:14:25', 4, '14820000', 'progress'),
(32, 12, 36, '73429452462049', '2025-04-16 20:21:41', 1, '10177992', 'pending');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `username`, `role`, `password`, `email`, `created_at`) VALUES
(19, 'atmint', 'admin', 'db176be86995bcb8ef4dc354456568234a76f954dc658502b5f34f18f4e56262', 'admin@email.com', '2025-03-12 00:12:01'),
(20, 'Nicky Arvin', 'user', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'nickyarvin@gmail.com', '2025-03-12 00:13:10'),
(26, 'AirAsia', 'maskapai', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 'airasia@email.com', '2025-03-12 18:00:42'),
(35, 'Lion Air', 'maskapai', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 'lionair@email.com', '2025-04-03 15:46:18'),
(36, 'charles', 'user', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'charles@email.com', '2025-04-03 15:47:27'),
(40, 'Garuda Indonesia', 'maskapai', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 'garudaindonesia@email.com', '2025-04-03 15:57:55'),
(44, 'poland', 'user', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'poland@email.com', '2025-04-04 22:08:43'),
(45, 'Citilink', 'maskapai', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 'citilink@email.com', '2025-04-09 08:35:16'),
(47, 'bubus', 'user', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'ambatubasss@email.com', '2025-04-09 11:09:01'),
(48, 'asep knalpot', 'user', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'klontong@email.com', '2025-04-09 11:50:25'),
(49, 'Sriwijaya Air', 'maskapai', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 'sriwijayaair@email.com', '2025-04-09 11:56:25');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `penerbangan`
--
ALTER TABLE `penerbangan`
  ADD PRIMARY KEY (`id_maskapai`);

--
-- Indeks untuk tabel `tiket_penerbangan`
--
ALTER TABLE `tiket_penerbangan`
  ADD PRIMARY KEY (`id_tiket`),
  ADD KEY `id_maskapai` (`id_maskapai`) USING BTREE,
  ADD KEY `id` (`id_user`) USING BTREE;

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `penerbangan`
--
ALTER TABLE `penerbangan`
  MODIFY `id_maskapai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `tiket_penerbangan`
--
ALTER TABLE `tiket_penerbangan`
  MODIFY `id_tiket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
