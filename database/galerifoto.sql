-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 09 Apr 2024 pada 06.28
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
-- Database: `galerifoto`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `komentar_foto`
--

CREATE TABLE `komentar_foto` (
  `komentarID` int(11) NOT NULL,
  `galeri_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nama_user` varchar(50) NOT NULL,
  `isi_komentar` text NOT NULL,
  `tanggal_komentar` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_galeri`
--

CREATE TABLE `tb_galeri` (
  `galeri_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `admin_name` varchar(100) NOT NULL,
  `galeri_name` varchar(100) NOT NULL,
  `galeri_deskripsi` text NOT NULL,
  `gambar` varchar(100) NOT NULL,
  `galeri_status` tinyint(1) NOT NULL,
  `tanggal_buat` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `kategori_galeri` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_galeri`
--

INSERT INTO `tb_galeri` (`galeri_id`, `user_id`, `admin_name`, `galeri_name`, `galeri_deskripsi`, `gambar`, `galeri_status`, `tanggal_buat`, `kategori_galeri`) VALUES
(1, 1, 'faisal', 'hayam', 'Ayam (Gallus gallus domesticus) adalah binatang unggas dari ordo Galliformes[1] yang biasa dipelihara untuk dimanfaatkan daging, telur, dan bulunya. Ayam peliharaan merupakan keturunan langsung dari salah satu subspesies ayam hutan yang dikenal sebagai ayam hutan merah (Gallus gallus) atau ayam bangkiwa (bankiva fowl). Kawin silang antar ras ayam telah menghasilkan ratusan galur unggul atau galur murni dengan bermacam-macam fungsi; yang paling umum adalah ayam potong (untuk dipotong) dan ayam petelur (untuk diambil telurnya). Ayam biasa dapat pula dikawin silang dengan kerabat dekatnya, ayam hutan hijau, yang menghasilkan hibrida mandul yang jantannya dikenal sebagai ayam bekisar.  Ayam memasok dua sumber protein dalam pangan: daging ayam dan telur.  Sudut pandang tradisional peternakan ayam dalam domestikasi spesies ini termaktub dalam Encyclopædia Britannica (2007): \"Manusia pertama mendomestikasi ayam asal India untuk keperluan adu ayam di Asia, Afrika, dan Eropa. Tidak ada perhatian khusus diberikan ke produksi telur atau daging. ', 'foto1712566639.jpeg', 1, '2024-04-08 08:57:59', 'hewan'),
(2, 1, 'faisal', 'manuk', 'jhajhsjadjhajh', 'foto1712585523.jpg', 1, '2024-04-08 14:12:03', 'hewan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kategori`
--

CREATE TABLE `tb_kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_kategori`
--

INSERT INTO `tb_kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'hewan'),
(2, 'alam'),
(3, 'arsitek');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_komentar`
--

CREATE TABLE `tb_komentar` (
  `id_komentar` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_galeri` int(11) NOT NULL,
  `nama_user` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_komentar`
--

INSERT INTO `tb_komentar` (`id_komentar`, `id_user`, `id_galeri`, `nama_user`, `description`) VALUES
(1, 2, 1, 'Bagas', 'hayam ');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_like_unlike_unduh`
--

CREATE TABLE `tb_like_unlike_unduh` (
  `like_id` int(11) NOT NULL,
  `galeri_id` int(11) NOT NULL,
  `nama_user` varchar(50) NOT NULL,
  `id_user` int(11) NOT NULL,
  `suka` int(100) NOT NULL,
  `tidaksuka` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `unduh` int(11) NOT NULL,
  `unduh_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_like_unlike_unduh`
--

INSERT INTO `tb_like_unlike_unduh` (`like_id`, `galeri_id`, `nama_user`, `id_user`, `suka`, `tidaksuka`, `tanggal`, `unduh`, `unduh_id`) VALUES
(1, 1, 'Bagas', 2, 1, 0, '2024-04-08 04:10:50', 0, 0),
(2, 1, 'Bagas', 2, 0, 0, '2024-04-08 04:16:07', 1, 0),
(3, 1, 'Bagas', 2, 0, 0, '2024-04-08 04:17:15', 1, 0),
(4, 1, 'faisal', 1, 0, 0, '2024-04-08 08:20:35', 1, 0),
(5, 2, 'Cindi', 6, 1, 0, '2024-04-08 09:12:28', 0, 0),
(6, 1, 'Cindi', 6, 0, 1, '2024-04-08 09:13:37', 0, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int(11) NOT NULL,
  `nama_user` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_telp` varchar(20) NOT NULL,
  `user_email` varchar(225) NOT NULL,
  `user_alamat` text NOT NULL,
  `user_akses` varchar(255) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `nama_user`, `username`, `password`, `user_telp`, `user_email`, `user_alamat`, `user_akses`) VALUES
(1, 'faisal', 'faisal', 'kobee133', '085783949623', 'faisal@gmail.com', 'cimahi\r\n', 'admin'),
(2, 'Bagas', 'bagus', 'juned', '085788992919', 'bagas@gmail.com', 'Bandung', 'admin'),
(6, 'Cindi', 'asd', '123', '0940839849389', 'asd@gmail.com', 'cimahi', 'user');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `komentar_foto`
--
ALTER TABLE `komentar_foto`
  ADD PRIMARY KEY (`komentarID`),
  ADD KEY `image_id` (`galeri_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `tb_galeri`
--
ALTER TABLE `tb_galeri`
  ADD PRIMARY KEY (`galeri_id`);

--
-- Indeks untuk tabel `tb_kategori`
--
ALTER TABLE `tb_kategori`
  ADD PRIMARY KEY (`id_kategori`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indeks untuk tabel `tb_komentar`
--
ALTER TABLE `tb_komentar`
  ADD PRIMARY KEY (`id_komentar`);

--
-- Indeks untuk tabel `tb_like_unlike_unduh`
--
ALTER TABLE `tb_like_unlike_unduh`
  ADD PRIMARY KEY (`like_id`);

--
-- Indeks untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `komentar_foto`
--
ALTER TABLE `komentar_foto`
  MODIFY `komentarID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_galeri`
--
ALTER TABLE `tb_galeri`
  MODIFY `galeri_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_kategori`
--
ALTER TABLE `tb_kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tb_komentar`
--
ALTER TABLE `tb_komentar`
  MODIFY `id_komentar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_like_unlike_unduh`
--
ALTER TABLE `tb_like_unlike_unduh`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `komentar_foto`
--
ALTER TABLE `komentar_foto`
  ADD CONSTRAINT `komentar_foto_ibfk_1` FOREIGN KEY (`galeri_id`) REFERENCES `tb_image` (`image_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `komentar_foto_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
