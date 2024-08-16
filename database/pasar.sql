-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 16 Agu 2024 pada 22.36
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
-- Database: `pasar`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `pasar`
--

CREATE TABLE `pasar` (
  `idl` int(11) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `deskripsi` text NOT NULL,
  `nsentral` varchar(255) NOT NULL,
  `latitude` float(10,6) NOT NULL,
  `longitude` float(10,6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `pasar`
--

INSERT INTO `pasar` (`idl`, `nama`, `deskripsi`, `nsentral`, `latitude`, `longitude`) VALUES
(17, 'Kios Baju', 'Baju Distro Rp. 1000 <br> Baju 3Seconds Rp. 4000', 'Pasar Senggol', -3.994317, 119.663246),
(23, 'Kios Ikan', '1 2 34 56 789 0', 'Pasar Sentral Lakessi', -3.993033, 119.582138),
(24, 'Kios Bakso', 'Tuk tak', 'Pasar Ikan Senggol', -3.978648, 119.547119),
(25, 'Kios Kios', 'Sat set', 'Pasar Jompie', -4.004973, 119.628052),
(26, 'Kios Sate', 'cek', 'Pasar Sumpaminangae', -4.005197, 119.627396),
(27, 'Kiosku', 'base', 'Pasar Senggol', -3.967174, 119.590546),
(28, 'KiosMu', 'dot id', 'Pasar Sentral Lakessi', -3.971455, 119.622307),
(29, 'Kios COK', 'CEK', 'Pasar Ikan Senggol', -3.971798, 119.689941),
(30, 'Kios Kosmetik', 'MEK', 'Pasar Jompie', -3.967003, 119.655434),
(31, 'Kios SA', 'SA', 'Pasar Sumpaminangae', -3.996286, 119.551582);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sentral`
--

CREATE TABLE `sentral` (
  `idl` int(11) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `deskripsi` text NOT NULL,
  `images` varchar(255) DEFAULT NULL,
  `latitude` float(10,6) NOT NULL,
  `longitude` float(10,6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `sentral`
--

INSERT INTO `sentral` (`idl`, `nama`, `deskripsi`, `images`, `latitude`, `longitude`) VALUES
(1, 'Pasar Sentral Lakessi', 'Bla Cek 1234', 'Pasar-Sentral-Lakessi-1.png', -4.005049, 119.627678),
(2, 'Pasar Senggol', 'Bla Bla', 'ikan.jpg', -4.007703, 119.621521),
(3, 'Pasar Ikan Senggol', 'Cek 123 321', 'CIL02819-1.JPG', -4.005820, 119.621727),
(4, 'Pasar Sumpaminangae', 'Cakar Terus', 'CIL02827-1.JPG', -4.045368, 119.626160),
(5, 'Pasar Jompie', 'Des Tos Kes', 'CIL02801 (1).jpg', -3.998976, 119.640465);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `pass` text DEFAULT NULL,
  `level` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `pass`, `level`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Admin'),
(2, 'ulla', '4f9103524228b78d81c703cc9a886415', 'User');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `pasar`
--
ALTER TABLE `pasar`
  ADD PRIMARY KEY (`idl`);

--
-- Indeks untuk tabel `sentral`
--
ALTER TABLE `sentral`
  ADD PRIMARY KEY (`idl`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `pasar`
--
ALTER TABLE `pasar`
  MODIFY `idl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT untuk tabel `sentral`
--
ALTER TABLE `sentral`
  MODIFY `idl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
