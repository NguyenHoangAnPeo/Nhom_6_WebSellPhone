-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.32-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for websellphone
CREATE DATABASE IF NOT EXISTS `websellphone` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `websellphone`;

-- Dumping structure for table websellphone.cart
CREATE TABLE IF NOT EXISTS `cart` (
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL COMMENT 'số lượng',
  KEY `FK_cart_users` (`user_id`),
  KEY `FK_cart_product` (`product_id`),
  CONSTRAINT `FK_cart_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_cart_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table websellphone.cart: ~0 rows (approximately)
DELETE FROM `cart`;

-- Dumping structure for table websellphone.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(256) NOT NULL COMMENT 'tên loại',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table websellphone.categories: ~2 rows (approximately)
DELETE FROM `categories`;
INSERT INTO `categories` (`id`, `category_name`) VALUES
	(1, 'Nike'),
	(2, 'i er');

-- Dumping structure for table websellphone.oderdetail
CREATE TABLE IF NOT EXISTS `oderdetail` (
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL COMMENT 'số lượng',
  `price` float DEFAULT NULL COMMENT 'giá',
  KEY `FK_orderdetail_order` (`order_id`),
  KEY `FK_orderdetail_product` (`product_id`),
  CONSTRAINT `FK_orderdetail_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_orderdetail_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table websellphone.oderdetail: ~0 rows (approximately)
DELETE FROM `oderdetail`;

-- Dumping structure for table websellphone.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `order_date` date DEFAULT NULL COMMENT 'ngày order',
  `total_price` float DEFAULT NULL COMMENT 'tổng giá',
  `status` varchar(256) DEFAULT NULL COMMENT 'trạng thái',
  PRIMARY KEY (`id`),
  KEY `FK_order_users` (`user_id`),
  CONSTRAINT `FK_order_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table websellphone.orders: ~0 rows (approximately)
DELETE FROM `orders`;

-- Dumping structure for table websellphone.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) DEFAULT NULL,
  `description` varchar(256) DEFAULT NULL COMMENT 'mô tả',
  `price` double DEFAULT NULL COMMENT 'giá',
  `stock` int(11) DEFAULT NULL COMMENT 'số lượng tồn kho',
  `category_id` int(11) DEFAULT NULL,
  `image` varchar(256) DEFAULT NULL COMMENT 'đường dẫn link ảnh',
  PRIMARY KEY (`id`),
  KEY `FK_product_category` (`category_id`),
  CONSTRAINT `FK_product_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table websellphone.products: ~0 rows (approximately)
DELETE FROM `products`;

-- Dumping structure for table websellphone.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL DEFAULT '0',
  `username` char(50) DEFAULT NULL,
  `password` varchar(256) DEFAULT NULL,
  `phone` varchar(32) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `role` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table websellphone.users: ~0 rows (approximately)
DELETE FROM `users`;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
