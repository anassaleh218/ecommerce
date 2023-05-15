-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2023 at 11:24 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `buyer_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `cart_product`
--

CREATE TABLE `cart_product` (
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'phones'),
(2, 'laptops'),
(3, 'electronics'),
(5, 'iphone');

-- --------------------------------------------------------

--
-- Table structure for table `fav_products`
--

CREATE TABLE `fav_products` (
  `buyer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `order_status` varchar(50) NOT NULL DEFAULT 'Shipped'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `buyer_id`, `order_status`) VALUES
(1, 2, 'Shipped');

-- --------------------------------------------------------

--
-- Table structure for table `order_billing`
--

CREATE TABLE `order_billing` (
  `id` int(11) NOT NULL,
  `flatNo` int(11) NOT NULL,
  `buildingNo` int(11) NOT NULL,
  `street` varchar(50) NOT NULL,
  `city` varchar(20) NOT NULL,
  `country` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `credit_card_holdername` varchar(20) NOT NULL,
  `credit_card_type` varchar(20) NOT NULL,
  `credit_card_num` int(11) NOT NULL,
  `expMonth` int(11) NOT NULL,
  `expYear` int(11) NOT NULL,
  `cvv` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_billing`
--

INSERT INTO `order_billing` (`id`, `flatNo`, `buildingNo`, `street`, `city`, `country`, `phone`, `email`, `credit_card_holdername`, `credit_card_type`, `credit_card_num`, `expMonth`, `expYear`, `cvv`, `order_id`, `buyer_id`, `createdAt`) VALUES
(1, 1, 15, 'street', 'Bulaq Ad Daqrur', 'Egypt', '01001759098', 'anassaleh2108@gmail.com', 'Anas Saleh Mousa', 'MasterCard', 1255488, 5, 27, 147, 1, 2, '2023-05-10 06:26:08');

-- --------------------------------------------------------

--
-- Table structure for table `order_product`
--

CREATE TABLE `order_product` (
  `product_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_product`
--

INSERT INTO `order_product` (`product_id`, `order_id`, `quantity`) VALUES
(6, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `color` varchar(20) NOT NULL,
  `size_id` int(11) DEFAULT NULL,
  `start_price` float NOT NULL,
  `category_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `image` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `quantity`, `status`, `color`, `size_id`, `start_price`, `category_id`, `seller_id`, `image`) VALUES
(1, 'iPhone 14 Pro', 'Premium finish\r\nBrand: Apple\r\nIt will be an excellent pick for you\r\nComes with proper packaging', 213, 'Available', 'gold', NULL, 399.99, 1, 1, 'images/10-34-5661HHS0HrjpL._AC_SL1500_.jpg'),
(2, 'Xiaomi Redmi 10A ', 'Released 2022, March 31\r\nAndroid 11, MIUI 12.5\r\nResolution 720 x 1600 pixels,\r\nFingerprint (rear-mou', 22, 'Available', 'red', NULL, 100, 1, 1, 'images/10-36-1161NCeh9qd3L._AC_SL1215_.jpg'),
(3, 'IdeaPad 3', 'Technical Specifications\r\nProcessor : Intel Core i3-1115G4 (2C / 4T, 3.0 / 4.1GHz, 6MB) /Memory : 4G', 123, 'Available', 'red', NULL, 2311, 2, 1, 'images/10-37-2751DzvZ3Eq2L._AC_.jpg'),
(4, 'Lenovo IdeaPad 1 Lap', 'Lenovo IdeaPad 3 Laptop - Intel Core i3-10110U, 8 GB RAM, 1 TB HDD, Intel UHD Graphics,  15.6\" FHD (', 34, 'Available', 'gold', NULL, 3088, 2, 1, 'images/10-38-4141zezCpPE8L._AC_.jpg'),
(5, 'Smart LED TV', 'TV with Built-in Receiver and Remote Control\r\nModel : UA50CU7000UXEG\r\nSamsung 50 Inch 4K UHD Smart L', 11, 'Available', 'red', 1, 3121, 3, 1, 'images/10-40-3761ckfbfWrfL._AC_SL1000_.jpg'),
(6, 'iphone15', 'iphone', 15, 'Available', 'red', NULL, 150, 5, 1, 'images/08-24-14canon.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `product_feedback`
--

CREATE TABLE `product_feedback` (
  `id` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `feedback` text NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_feedback`
--

INSERT INTO `product_feedback` (`id`, `rate`, `feedback`, `buyer_id`, `product_id`) VALUES
(1, 4, 'very good iPhone', 2, 1),
(2, 4, 'good', 2, 6);

-- --------------------------------------------------------

--
-- Table structure for table `product_size`
--

CREATE TABLE `product_size` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_size`
--

INSERT INTO `product_size` (`id`, `name`) VALUES
(1, '50 Inch'),
(2, '20 Inch');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `role_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `role_name`) VALUES
(1, 'admin'),
(2, 'buyer'),
(3, 'seller');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `fullname` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `password` longtext NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(20) DEFAULT NULL,
  `blocked` tinyint(1) NOT NULL DEFAULT 0,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `fullname`, `username`, `email`, `password`, `phone`, `address`, `blocked`, `role_id`) VALUES
(1, 'seller', 'seller', 'seller@gmail.com', '$2y$10$nLNhHH.3yWhOvcSpmYV32u5pEeRLCS3HrpBE1ZZCqKXdGRriCk4Qu', '01001759098', '17 Kamal Al Sharif S', 0, 3),
(2, 'buyer', 'buyer', 'buyer@gmail.com', '$2y$10$XyiOTLC9ctoDvQ55ANnuW.VEy/U8Ej4Q4vdi9UFHz9ead/WloVLYq', '01288600785', '17 Kamal Al Sharif S', 0, 2),
(3, 'admin', 'admin', 'admin@gmail.com', '$2y$10$ov4wwBu1lTXOrvxmcBCywOvJVy3cZByRtGKdciR7hMjW5niNEy44a', '01288600785', '17 Kamal Al Sharif S', 0, 1),
(4, 'asd', 'asd', 'asd', '$2y$10$8GC6bzsOSBmRrS7EcUEwkOOluYzqswT8DvkpNaT5KUMJwXQ2WG3Bi', '0100', 'asd', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `watch_list`
--

CREATE TABLE `watch_list` (
  `buyer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_user` (`buyer_id`);

--
-- Indexes for table `cart_product`
--
ALTER TABLE `cart_product`
  ADD PRIMARY KEY (`cart_id`,`product_id`),
  ADD KEY `cart_product_productid` (`product_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fav_products`
--
ALTER TABLE `fav_products`
  ADD PRIMARY KEY (`buyer_id`,`product_id`),
  ADD KEY `fav_product_buyer` (`buyer_id`),
  ADD KEY `fav_product_product` (`product_id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_buyer` (`buyer_id`);

--
-- Indexes for table `order_billing`
--
ALTER TABLE `order_billing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_billing_order` (`order_id`),
  ADD KEY `order_billing_buyer` (`buyer_id`);

--
-- Indexes for table `order_product`
--
ALTER TABLE `order_product`
  ADD PRIMARY KEY (`product_id`,`order_id`),
  ADD KEY `order_product_orderid` (`order_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_size` (`size_id`),
  ADD KEY `product_category` (`category_id`),
  ADD KEY `product_seller` (`seller_id`);

--
-- Indexes for table `product_feedback`
--
ALTER TABLE `product_feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_feedback_product` (`product_id`),
  ADD KEY `product_feedback_buyer` (`buyer_id`);

--
-- Indexes for table `product_size`
--
ALTER TABLE `product_size`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `user_role` (`role_id`);

--
-- Indexes for table `watch_list`
--
ALTER TABLE `watch_list`
  ADD PRIMARY KEY (`buyer_id`,`product_id`),
  ADD KEY `watch_list_product` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_billing`
--
ALTER TABLE `order_billing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product_feedback`
--
ALTER TABLE `product_feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_size`
--
ALTER TABLE `product_size`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_user` FOREIGN KEY (`buyer_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `cart_product`
--
ALTER TABLE `cart_product`
  ADD CONSTRAINT `cart_product_cartid` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`),
  ADD CONSTRAINT `cart_product_productid` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `fav_products`
--
ALTER TABLE `fav_products`
  ADD CONSTRAINT `fav_product_buyer` FOREIGN KEY (`buyer_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `fav_product_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_buyer` FOREIGN KEY (`buyer_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `order_billing`
--
ALTER TABLE `order_billing`
  ADD CONSTRAINT `order_billing_buyer` FOREIGN KEY (`buyer_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `order_billing_order` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`);

--
-- Constraints for table `order_product`
--
ALTER TABLE `order_product`
  ADD CONSTRAINT `order_product_orderid` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`),
  ADD CONSTRAINT `order_product_prouctid` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `product_seller` FOREIGN KEY (`seller_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `product_size` FOREIGN KEY (`size_id`) REFERENCES `product_size` (`id`);

--
-- Constraints for table `product_feedback`
--
ALTER TABLE `product_feedback`
  ADD CONSTRAINT `product_feedback_buyer` FOREIGN KEY (`buyer_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `product_feedback_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_role` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);

--
-- Constraints for table `watch_list`
--
ALTER TABLE `watch_list`
  ADD CONSTRAINT `watch_list_buyer` FOREIGN KEY (`buyer_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `watch_list_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
