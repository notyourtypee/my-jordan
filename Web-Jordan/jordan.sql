-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Apr 2023 pada 05.03
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jordan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cart`
--

CREATE TABLE `cart` (
  `id_cart` varchar(50) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `produk_id` varchar(50) NOT NULL,
  `ukuran` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` varchar(50) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
('116228', 'Low'),
('166718', 'Slip On'),
('972503', 'High');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` varchar(50) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `produks_id` varchar(50) NOT NULL,
  `ukurans` varchar(50) NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `pembayaran` int(11) NOT NULL,
  `total` double NOT NULL,
  `tanggal_pembelian` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `user_id`, `produks_id`, `ukurans`, `nama_lengkap`, `email`, `phone`, `alamat`, `pembayaran`, `total`, `tanggal_pembelian`) VALUES
('246887', '692680', '533791,424836', '40,38', 'Steve', 'steve@gmail.com', '2131232412', 'Indo', 3, 1030000, '2023-04-24'),
('378791', '692680', '424836,533791', '36,40', 'Mark', 'mark@gmail.com', '0912831231', 'Rumah', 3, 1030000, '2023-04-20'),
('444019', '692680', '424836', '38', 'Elon Musk', 'elon@gmail.com', '0981231231', 'Mars', 3, 430000, '2023-04-15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id_produk` varchar(50) NOT NULL,
  `kode` varchar(50) NOT NULL,
  `nama_produk` varchar(50) NOT NULL,
  `warna` varchar(50) NOT NULL,
  `harga` double NOT NULL,
  `stok` int(11) NOT NULL,
  `p_ukuran` varchar(50) NOT NULL,
  `deskripsi` varchar(50) NOT NULL,
  `gambar1` varchar(50) NOT NULL,
  `gambar2` varchar(50) NOT NULL,
  `gambar3` varchar(50) NOT NULL,
  `kategori_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id_produk`, `kode`, `nama_produk`, `warna`, `harga`, `stok`, `p_ukuran`, `deskripsi`, `gambar1`, `gambar2`, `gambar3`, `kategori_id`) VALUES
('424836', 'pwxyz', 'Mid Citrus', 'Orange', 430000, 50, '34,36,38,40', 'Upper : 12 oz canvas\r\nToe Cap : Suede\r\nThread : Ny', '6445e9d1104cf.png', '6445e9d110cab.jpg', '6445e9d110ea5.jpg', '116228'),
('425065', 'abcdefg', 'Mid Grey Camo', 'Grey', 900000, 90, '30,35,38', 'Toe Cap : Suede\r\nThread : Nylon\r\nEyelets : Alumuni', '6445edec56812.png', '', '', '972503'),
('533791', 'klmnop', 'Mid Carbon Fiber', 'Hitam', 600000, 90, '32,40', 'Insole : Ultralite Foam\r\nFoxing : Rubber\r\nOutsole ', '6445ecc7a338e.png', '', '', '166718');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `level`) VALUES
('01', 'admin', 'password', 1),
('692680', 'user1', 'password', 0);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id_cart`),
  ADD KEY `produk_id` (`produk_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `kategori_id` (`kategori_id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
