-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 16, 2026 at 02:00 PM
-- Server version: 8.0.30
-- PHP Version: 8.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_toko`
--

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id_history` int NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `id_user` int DEFAULT NULL,
  `id_order` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id_history`, `date`, `time`, `id_user`, `id_order`) VALUES
(23, '2024-06-10', '09:30:00', 11, 20),
(24, '2024-06-15', '14:00:00', 11, 21);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id_order` int NOT NULL,
  `order_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `total_price` decimal(10,2) DEFAULT NULL,
  `id_user` int DEFAULT NULL,
  `id_agent` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id_order`, `order_date`, `total_price`, `id_user`, `id_agent`) VALUES
(20, '2024-06-10 09:30:00', 45000.00, 11, 14),
(21, '2024-06-15 14:00:00', 20000.00, 11, 14),
(22, '2026-11-16 06:19:16', 145000.00, 11, 14),
(24, '2026-11-16 06:46:32', 96000.00, 11, 14),
(26, '2026-11-16 09:17:42', 289000.00, 11, 14);

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `id_order_detail` int NOT NULL,
  `quantity_item` int NOT NULL,
  `status` enum('SELESAI','DIPROSES','PENGANTARAN','MENUNGGU KONFIRMASI AGENT') NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `id_order` int DEFAULT NULL,
  `id_product` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`id_order_detail`, `quantity_item`, `status`, `subtotal`, `id_order`, `id_product`) VALUES
(31, 1, 'SELESAI', 20000.00, 20, 24),
(32, 1, 'SELESAI', 25000.00, 20, 26),
(33, 1, 'PENGANTARAN', 20000.00, 21, 27),
(34, 1, 'PENGANTARAN', 22000.00, 21, 28),
(35, 1, 'PENGANTARAN', 215000.00, 21, 29),
(36, 1, 'SELESAI', 25000.00, 22, 25),
(37, 6, 'SELESAI', 120000.00, 22, 24),
(39, 4, 'SELESAI', 96000.00, 24, 30),
(41, 1, 'SELESAI', 25000.00, 26, 25),
(42, 11, 'SELESAI', 264000.00, 26, 30);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id_product` int NOT NULL,
  `id_agent` int NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `name_product` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id_product`, `id_agent`, `img`, `name_product`, `price`, `stock`) VALUES
(24, 14, 'dummy_image', 'Galon Air Mineral 19L', 20000.00, 0),
(25, 14, 'dummy_image', 'Galon Air RO 19L', 25000.00, 38),
(26, 14, 'dummy_image', 'Gas LPG 3kg', 22000.00, 100),
(27, 14, 'dummy_image', 'Gas LPG 12kg', 215000.00, 30),
(28, 14, 'dummy_image', 'Air Mineral Botol 600ml', 5000.00, 200),
(29, 14, 'dummy_image', 'Galon Le Mineral 19L', 22000.00, 15),
(30, 14, 'prod_14_1794811383.jpg', 'Gas LPG 3kg (Pink)', 24000.00, 10);

-- --------------------------------------------------------

--
-- Table structure for table `reminder`
--

CREATE TABLE `reminder` (
  `id_reminder` int NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `id_user` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reminder`
--

INSERT INTO `reminder` (`id_reminder`, `date`, `time`, `id_user`) VALUES
(5, '2024-07-01', '09:00:00', 14);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id_role` int NOT NULL,
  `name_role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id_role`, `name_role`) VALUES
(1, 'user'),
(2, 'agent'),
(3, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `foto` longblob,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `no_hp` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text,
  `depot` varchar(50) DEFAULT NULL,
  `id_role` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `foto`, `username`, `password`, `no_hp`, `email`, `address`, `depot`, `id_role`) VALUES
(11, 0x757365725f31315f313739343832303435382e6a7067, 'al', '$2y$12$MZMlD8YiPJNqInTpiz0Gq.yWJ9TXXXq5PjihOfFzjW3xulpO/U6pq', '089923813', 'al@gmail.com', 'dadad', '', 1),
(12, NULL, 'alberich', '$2y$10$e.wXq.f2M2f2K1sA2c1M1u.4rN1aQ0Q0Q0Q0Q0Q0Q0Q0Q0Q0Q0Q0', '12313', 'abl@gakfdaw', '123', '', 1),
(13, NULL, 'budi', '$2y$12$vyOKDFhKW9wa8OsxFDLjKOpol51S8HnIi79LR8bBIXo8tRkt9l8rq', '12313', 'budi@gmail.com', 'ayam', '', 1),
(14, NULL, 'agent', '$2y$12$CFx7aCKQXMWpogYVkbCCUOFamoolQwsFNnqdBYSSSxOLGKVijjq9C', '0895362042424', 'shoya@gmail.com', 'Batam Centre', 'Shoya depot', 2),
(16, NULL, 'Zendrei', '$2y$12$fVJ9tQXbmsRR8R8EhsTIkuYYnKuH3x/ut8HSXrzQqpXTF2StKIw6K', '08992088934', 'zendrei08@gmail.com', 'batam', '', 1),
(17, NULL, 'shoya', '$2y$12$erVmL6KPkTcaTdU13l.gDOKpvejpRfNarDc8pttPZdYRbC6S.5a0m', '08992088934', 'shoya@gmail.com', 'BATAM', '', 1),
(18, NULL, 'jaki', '$2y$12$L3/f2Z.zltF...UUOAwF2OYzzzmPIYa6wm0y4xbolqRlLSUrtT3OC', '08992088934', 'jaki@gmail.com', 'BATAM', '', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id_history`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_order` (`id_order`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id_order_detail`),
  ADD KEY `id_order` (`id_order`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id_product`),
  ADD KEY `id_agent` (`id_agent`);

--
-- Indexes for table `reminder`
--
ALTER TABLE `reminder`
  ADD PRIMARY KEY (`id_reminder`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_role` (`id_role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id_history` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id_order` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id_order_detail` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id_product` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `reminder`
--
ALTER TABLE `reminder`
  MODIFY `id_reminder` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `history_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `history_ibfk_2` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id_order`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `order_detail_ibfk_1` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id_order`);

--
-- Constraints for table `reminder`
--
ALTER TABLE `reminder`
  ADD CONSTRAINT `reminder_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
