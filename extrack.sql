-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 04 Des 2025 pada 15.40
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
-- Database: `extrack`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `assets`
--

CREATE TABLE `assets` (
  `asset_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `asset_name` varchar(100) NOT NULL,
  `balance` decimal(15,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `assets`
--

INSERT INTO `assets` (`asset_id`, `user_id`, `asset_name`, `balance`, `created_at`, `updated_at`) VALUES
(9, 7, 'Tunai', 211000.00, '2025-12-02 06:27:35', '2025-12-04 14:30:52'),
(10, 7, 'Bank', 280000.00, '2025-12-02 07:17:11', '2025-12-04 14:28:57'),
(13, 7, 'E-wallet', 790000.00, '2025-12-04 14:27:56', '2025-12-04 14:30:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `category_type` enum('income','expense') NOT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`category_id`, `user_id`, `category_name`, `category_type`, `icon`, `is_default`, `created_at`, `updated_at`) VALUES
(15, 7, 'Lainnya', 'expense', '📦', 1, '2025-12-02 06:27:35', '2025-12-02 06:27:35'),
(16, 7, 'Lainnya', 'income', '💰', 1, '2025-12-02 06:27:35', '2025-12-02 06:27:35'),
(17, 7, 'Makanan', 'expense', '🍚', 0, '2025-12-02 07:18:37', '2025-12-02 07:18:37'),
(18, 7, 'Transportasi', 'expense', '🚗', 0, '2025-12-02 07:18:59', '2025-12-02 07:18:59'),
(19, 7, 'Jajan', 'expense', '🍿', 0, '2025-12-02 07:19:38', '2025-12-02 07:19:46'),
(24, 7, 'Bonus', 'income', '🪙', 0, '2025-12-04 14:28:14', '2025-12-04 14:28:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `token` varchar(100) NOT NULL,
  `is_used` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `password_resets`
--

INSERT INTO `password_resets` (`id`, `email`, `token`, `is_used`, `created_at`, `expires_at`) VALUES
(5, 'irfannazrilac@gmail.com', '0ba7826b421276fdf421582fc29d838706173ffa2639f9c9a0b2da23effe69ef', 0, '2025-12-04 14:18:19', '2025-12-04 16:18:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `test`
--

CREATE TABLE `test` (
  `icon` varchar(1) NOT NULL,
  `category` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `test`
--

INSERT INTO `test` (`icon`, `category`) VALUES
('🍕', 'Food');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `transaction_type` enum('income','expense','transfer') NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `asset_id` int(11) NOT NULL,
  `transaction_date` date NOT NULL,
  `to_asset_id` int(11) DEFAULT NULL,
  `from_asset_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `user_id`, `transaction_type`, `amount`, `description`, `category_id`, `asset_id`, `transaction_date`, `to_asset_id`, `from_asset_id`, `created_at`, `updated_at`) VALUES
(1, 7, 'income', 20000.00, 'Uang saku', 16, 9, '2025-12-02', NULL, NULL, '2025-12-02 08:19:03', '2025-12-02 08:20:50'),
(2, 7, 'transfer', 20000.00, 'Transfer', NULL, 10, '2025-12-02', 9, 10, '2025-12-02 08:19:39', '2025-12-02 08:19:39'),
(3, 7, 'expense', 12000.00, 'Ayam Malay', 17, 9, '2025-12-02', NULL, NULL, '2025-12-02 08:21:08', '2025-12-02 08:21:08'),
(4, 7, 'expense', 52000.00, 'Ganti Oli', 18, 9, '2025-12-02', NULL, NULL, '2025-12-02 08:23:44', '2025-12-02 08:23:44'),
(5, 7, 'expense', 5000.00, 'Telur Gulung', 19, 9, '2025-12-02', NULL, NULL, '2025-12-02 08:29:16', '2025-12-02 08:29:16'),
(6, 7, 'expense', 20000.00, 'Nasi Padang', 17, 10, '2025-12-02', NULL, NULL, '2025-12-02 08:31:45', '2025-12-02 08:31:45'),
(7, 7, 'expense', 100000.00, 'Telur Gulung', 19, 10, '2025-12-04', NULL, NULL, '2025-12-04 14:22:45', '2025-12-04 14:22:45'),
(8, 7, 'expense', 50000.00, 'Ganti Oli', 18, 10, '2025-12-04', NULL, NULL, '2025-12-04 14:24:49', '2025-12-04 14:24:49'),
(9, 7, 'transfer', 40000.00, 'Transfer', NULL, 13, '2025-12-04', 10, 13, '2025-12-04 14:28:42', '2025-12-04 14:28:42'),
(10, 7, 'transfer', 70000.00, 'Transfer', NULL, 10, '2025-12-04', 13, 10, '2025-12-04 14:28:57', '2025-12-04 14:28:57'),
(11, 7, 'transfer', 60000.00, 'Transfer', NULL, 9, '2025-12-04', 13, 9, '2025-12-04 14:30:52', '2025-12-04 14:30:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `verification_token` varchar(100) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `token_expires_at` datetime DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `is_verified`, `verification_token`, `remember_token`, `token_expires_at`, `password`, `profile_photo`, `created_at`, `updated_at`) VALUES
(7, 'irfannazril', 'irfannazrilac@gmail.com', 1, NULL, NULL, NULL, '$2y$10$ocJCUdjq4pNxZaVR7RqDfuj.dVVll48xCEUsla2F.otkwNQTvuPES', 'profile_7_1764659603.jpg', '2025-12-02 06:27:35', '2025-12-04 14:11:00');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`asset_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`),
  ADD KEY `token` (`token`),
  ADD KEY `expires_at` (`expires_at`),
  ADD KEY `idx_email_created` (`email`,`created_at`),
  ADD KEY `idx_token_used` (`token`,`is_used`);

--
-- Indeks untuk tabel `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `asset_id` (`asset_id`),
  ADD KEY `to_asset_id` (`to_asset_id`),
  ADD KEY `from_asset_id` (`from_asset_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_is_verified` (`is_verified`),
  ADD KEY `idx_verification_token` (`verification_token`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `assets`
--
ALTER TABLE `assets`
  MODIFY `asset_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `assets`
--
ALTER TABLE `assets`
  ADD CONSTRAINT `assets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `transactions_ibfk_3` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`asset_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_ibfk_4` FOREIGN KEY (`to_asset_id`) REFERENCES `assets` (`asset_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_ibfk_5` FOREIGN KEY (`from_asset_id`) REFERENCES `assets` (`asset_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
