-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2023 at 08:35 PM
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
(1, 2),
(2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `cart_product`
--

CREATE TABLE `cart_product` (
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
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
(1, 'camera'),
(2, 'phone');

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
  `order_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `buyer_id`, `order_status`) VALUES
(1, 2, ''),
(2, 2, ''),
(3, 2, ''),
(4, 2, ''),
(5, 2, ''),
(6, 2, ''),
(7, 2, ''),
(8, 2, '');

-- --------------------------------------------------------

--
-- Table structure for table `order_billing`
--

CREATE TABLE `order_billing` (
  `id` int(11) NOT NULL,
  `flatNo` int(11) NOT NULL,
  `buildingNo` int(11) NOT NULL,
  `city` varchar(20) NOT NULL,
  `country` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `credit_card_holdername` varchar(20) NOT NULL,
  `credit_card_type` varchar(20) NOT NULL,
  `credit_card_num` int(11) NOT NULL,
  `expMonth` int(11) NOT NULL,
  `expYear` int(11) NOT NULL,
  `cvv` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_billing`
--

INSERT INTO `order_billing` (`id`, `flatNo`, `buildingNo`, `city`, `country`, `phone`, `email`, `credit_card_holdername`, `credit_card_type`, `credit_card_num`, `expMonth`, `expYear`, `cvv`, `order_id`, `buyer_id`) VALUES
(44, 1, 1, '1', '11', '2', '1', '1', '1', 1, 1, 1, 1, 7, 2);

-- --------------------------------------------------------

--
-- Table structure for table `order_product`
--

CREATE TABLE `order_product` (
  `product_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_product`
--

INSERT INTO `order_product` (`product_id`, `order_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `credit_card_type` varchar(20) NOT NULL,
  `credit_card_num` int(11) NOT NULL,
  `credit_card_holdername` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(1, 'Xiaomi', 'tttt', 25, 'Available', 'red', 1, 124.99, 2, 2, 'images/02-15-53xiaomi.jpeg');

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
(1, 'S');

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `buyer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(2, 'seller'),
(3, 'buyer');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `fullname` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(20) DEFAULT NULL,
  `blocked` tinyint(1) NOT NULL DEFAULT 0,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `fullname`, `username`, `email`, `password`, `phone`, `address`, `blocked`, `role_id`) VALUES
(1, 'admin', 'admin', 'admin', 'admin', 'admin', 'admin', 0, 1),
(2, 'buyer', 'buyer', 'buyer', 'buyer', 'buyer', 'buyer', 0, 3),
(3, 'seller', 'seller', 'seller', 'seller', 'seller', 'seller', 0, 2);

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
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_user` (`buyer_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_size` (`size_id`),
  ADD KEY `product_category` (`category_id`),
  ADD KEY `product_seller` (`seller_id`);

--
-- Indexes for table `product_size`
--
ALTER TABLE `product_size`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`buyer_id`,`product_id`),
  ADD KEY `watch_list_product` (`product_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `order_billing`
--
ALTER TABLE `order_billing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_size`
--
ALTER TABLE `product_size`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_user` FOREIGN KEY (`buyer_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `product_seller` FOREIGN KEY (`seller_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `product_size` FOREIGN KEY (`size_id`) REFERENCES `product_size` (`id`);

--
-- Constraints for table `purchase`
--
ALTER TABLE `purchase`
  ADD CONSTRAINT `purchase_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `purchase_user` FOREIGN KEY (`buyer_id`) REFERENCES `user` (`id`);

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
