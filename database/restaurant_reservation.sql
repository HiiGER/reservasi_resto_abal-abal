-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Des 2024 pada 14.41
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
-- Database: `restaurant_reservation`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`) VALUES
(1, 'Appetizers', '2024-12-24 13:01:54'),
(2, 'Main Course', '2024-12-24 13:01:54'),
(3, 'Desserts', '2024-12-24 13:01:54'),
(4, 'Drinks', '2024-12-24 13:01:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `reservation_code` varchar(20) DEFAULT NULL,
  `table_number` int(11) DEFAULT NULL,
  `reservation_date` date DEFAULT NULL,
  `reservation_time` time DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `reservation_code`, `table_number`, `reservation_date`, `reservation_time`, `created_at`) VALUES
(3, 'yanto', 'yanto@gmail.com', '0878479586357', '988180', 9, '2024-12-03', '08:29:00', '2024-12-23 15:29:44'),
(4, 'adoni', 'jomok@gmail.com', '0895478275', '740901', 4, '2024-12-26', '10:30:00', '2024-12-23 15:30:25'),
(6, 'Angger Tirta', '2200018135@webmail.uad.ac.id', '089670364314', '120000', 10, '2024-12-12', '08:37:00', '2024-12-23 15:37:49'),
(7, 'Hidayat', 'ReyHidayat@gmail.com', '089364239155', '594571', 90, '2024-12-19', '17:06:00', '2024-12-24 12:40:56'),
(8, 'Beckham', 'DavidBac@gmail.com', '0893504325323', '559965', 5, '2024-12-14', '14:10:00', '2024-12-24 12:46:24'),
(9, 'asdsgfhsgddf', 'asdsgfhsgddf@gmail.com', '0971455452434', '210603', 7, '2022-10-07', '17:17:00', '2024-12-24 13:08:20'),
(10, 'asdsgfhsgddf', 'asdsgfhsgddf@gmail.com', '0971455452434', '563179', 7, '2022-10-07', '17:17:00', '2024-12-24 13:08:23'),
(12, 'Angger Tirta', '2200018135@webmail.uad.ac.id', '089670364314', '390956', 1, '2024-12-26', '23:44:00', '2024-12-24 14:44:13'),
(13, 'potter', '2200018135@webmail.uad.ac.id', '08356893513', '578300', 6, '2024-12-21', '10:46:00', '2024-12-24 14:46:40'),
(14, 'murtas', 'murtasian@gmail.com', '089670364314', '363662', 23, '2024-12-26', '13:25:00', '2024-12-25 05:16:27'),
(15, 'bakdnfad', 'dghf@gmail.com', '&#039;0', '881607', 2, '2024-12-30', '23:01:00', '2024-12-26 15:04:43'),
(16, 'bakdnfad', 'dghf@gmail.com', '&#039;', '922124', 2, '2024-12-30', '23:01:00', '2024-12-26 15:05:01'),
(17, 'bakdnfad', 'dghf@gmail.com', 'q234575', '819932', 2, '2024-12-30', '23:01:00', '2024-12-26 15:05:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `employees`
--

INSERT INTO `employees` (`id`, `username`, `password`) VALUES
(2, 'admin', '482c811da5d5b4bc6d497ffa98491e38'),
(3, 'staff1', '7896643378c5649dece75df7b842b8b5'),
(4, 'staff2', 'b9fc99b7c5ac3016b8a0f435d989d282');

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`id`, `name`, `price`, `description`, `created_at`, `category_id`) VALUES
(1, 'Spring Rolls', 30000.00, 'Crispy spring rolls with sweet chili sauce', '2024-12-24 13:01:54', 1),
(2, 'Beef Steak', 120000.00, 'Juicy grilled steak served with mashed potatoes', '2024-12-24 13:01:54', 2),
(3, 'Cheesecake', 45000.00, 'Classic New York-style cheesecake', '2024-12-24 13:01:54', 3),
(4, 'Lemonade', 20000.00, 'Freshly squeezed lemonade', '2024-12-24 13:01:54', 4),
(5, 'Garlic Bread', 25000.00, 'Crispy garlic bread with a hint of parsley', '2024-12-24 13:06:00', 1),
(6, 'Bruschetta', 30000.00, 'Grilled bread topped with fresh tomatoes and basil', '2024-12-24 13:06:00', 1),
(7, 'Stuffed Mushrooms', 35000.00, 'Mushrooms stuffed with cheese and herbs', '2024-12-24 13:06:00', 1),
(8, 'Chicken Alfredo Pasta', 75000.00, 'Creamy Alfredo sauce with tender chicken', '2024-12-24 13:06:01', 2),
(9, 'Grilled Salmon', 150000.00, 'Fresh salmon fillet grilled to perfection', '2024-12-24 13:06:01', 2),
(10, 'Beef Rendang', 90000.00, 'Traditional Indonesian beef stew with spices', '2024-12-24 13:06:01', 2),
(11, 'Nasi Goreng Special', 45000.00, 'Fried rice with shrimp, chicken, and fried egg', '2024-12-24 13:06:01', 2),
(12, 'Chocolate Lava Cake', 50000.00, 'Warm chocolate cake with a gooey center', '2024-12-24 13:06:01', 3),
(13, 'Ice Cream Sundae', 30000.00, 'Vanilla ice cream topped with chocolate syrup and nuts', '2024-12-24 13:06:01', 3),
(14, 'Fruit Salad', 25000.00, 'Freshly cut seasonal fruits with honey dressing', '2024-12-24 13:06:01', 3),
(15, 'Iced Coffee', 20000.00, 'Cold brew coffee served over ice', '2024-12-24 13:06:01', 4),
(16, 'Green Tea Latte', 25000.00, 'Creamy matcha latte with a hint of sweetness', '2024-12-24 13:06:01', 4),
(17, 'Fresh Orange Juice', 30000.00, 'Freshly squeezed orange juice', '2024-12-24 13:06:01', 4),
(18, 'Mineral Water', 10000.00, 'Bottled mineral water', '2024-12-24 13:06:01', 4),
(19, 'Milkshake', 35000.00, 'Creamy milkshake in chocolate, vanilla, or strawberry', '2024-12-24 13:06:01', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `review` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `reviews`
--

INSERT INTO `reviews` (`id`, `name`, `image_path`, `city`, `review`, `created_at`) VALUES
(1, 'Angger', '../uploads/supporting.jpeg', 'Yogyakarta', 'Mantab Keren gila anjer, MAHAL ASUUUUUUUUUUUUUUUUUUUUUUUUUUUUUU', '2024-12-25 04:38:25'),
(2, 'Yantosss', '../uploads/dataset-cover.jpg', 'Yogyakarta', 'Produktivitas berbeda dengan Produksi. Jika produksi hanya fokus untuk merubah input menjadi output, maka produktivitas meliputi seluruh proses yang dilaksanakan untuk mencari peluang perbaikan yang efektif dan efisien dalam rangka menghasilkan keluaran secara tangible atau intangible yang berkualitas.', '2024-12-25 04:44:09'),
(3, 'EDWARD', '../uploads/my thubnnail.jpg', 'Yogyakarta', 'Kemarin malam saya berkesempatan makan malam di Maillard, dan sungguh, pengalaman yang luar biasa! Suasana restorannya begitu hangat dan nyaman, dengan sentuhan rustic yang elegan. Pelayanannya pun sangat ramah dan profesional. Saya memesan Steak Maillard dengan saus béarnaise, dan dagingnya dimasak dengan sempurna—luarnya garing dan dalamnya juicy, persis seperti yang saya suka. Proses Maillard benar-benar terasa dalam setiap gigitan, memberikan rasa yang kaya dan kompleks. Pasangan saya memesan Pasta Maillard dengan udang, dan dia pun sangat terkesan dengan rasa sausnya yang creamy dan segar. Sebagai penutup, kami memesan Es Krim Maillard buatan sendiri yang rasanya begitu lembut dan lezat. Secara keseluruhan, Maillard memberikan pengalaman bersantap yang tak terlupakan. Sangat direkomendasikan!', '2024-12-25 08:08:59');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indeks untuk tabel `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
