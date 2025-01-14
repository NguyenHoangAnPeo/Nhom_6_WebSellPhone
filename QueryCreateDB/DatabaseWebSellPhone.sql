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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table websellphone.categories: ~3 rows (approximately)
DELETE FROM `categories`;
INSERT INTO `categories` (`id`, `category_name`) VALUES
	(1, 'Smartphone'),
	(2, 'Tablet'),
	(3, 'Phụ kiện');

-- Dumping structure for table websellphone.orderdetail
CREATE TABLE IF NOT EXISTS `orderdetail` (
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL COMMENT 'số lượng',
  `price` float DEFAULT NULL COMMENT 'giá',
  KEY `FK_orderdetail_order` (`order_id`) USING BTREE,
  KEY `FK_orderdetail_product` (`product_id`) USING BTREE,
  CONSTRAINT `orderdetail_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table websellphone.orderdetail: ~3 rows (approximately)
DELETE FROM `orderdetail`;
INSERT INTO `orderdetail` (`order_id`, `product_id`, `quantity`, `price`) VALUES
	(0, 2, 1, 27990000),
	(0, 2, 1, 27990000),
	(0, 2, 1, 27990000);

-- Dumping structure for table websellphone.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `name` varchar(256) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `email` varchar(256) DEFAULT NULL,
  `address` varchar(256) DEFAULT NULL,
  `phone` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table websellphone.orders: ~3 rows (approximately)
DELETE FROM `orders`;
INSERT INTO `orders` (`name`, `total`, `email`, `address`, `phone`) VALUES
	('nha', 27990000, 'hoangan23082004@gmail.com', 'Thanh Hoá', 867648352),
	('nha', 27990000, 'hoangan23082004@gmail.com', 'Thanh Hoá', 867648352),
	('nha', 27990000, 'hoangan23082004@gmail.com', 'Thanh Hoá', 867648352);

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table websellphone.products: ~5 rows (approximately)
DELETE FROM `products`;
INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `category_id`, `image`) VALUES
	(1, 'iPhone 14 Pro Max', 'Điện thoại cao cấp của Apple với màn hình 6.7 inch và chip A16 Bionic.', 29990000, NULL, 1, 'iphone14promax1.jpg.avif'),
	(2, 'Samsung Galaxy S23 Ultra', 'Flagship của Samsung với camera 200MP và màn hình Dynamic AMOLED.', 27990000, NULL, 1, 'galaxys23ultra1.jpg.png'),
	(3, 'iPad Pro 12.9', 'Máy tính bảng cao cấp với màn hình Liquid Retina và chip M2.', 31990000, NULL, 2, 'ipadpro12.91.jpg.webp'),
	(4, 'AirPods Pro 2', 'Tai nghe không dây chống ồn chủ động với chip H2.', 5490000, NULL, 3, 'airpodspro21.jpg.jpg'),
	(5, 'Apple Watch Series 9', 'Đồng hồ thông minh với màn hình Always-On Retina và nhiều tính năng sức khỏe.', 10990000, NULL, 3, 'applewatchseries91.jpg.webp');

-- Dumping structure for table websellphone.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('user','admin') DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table websellphone.users: ~2 rows (approximately)
DELETE FROM `users`;
INSERT INTO `users` (`id`, `username`, `password`, `email`, `created_at`, `role`) VALUES
	(1, 'usser', '$2y$10$ccFp2NuDbbecL70YG.LSUeD8A7ZGqDgEs2UqW8rcSuEegeyv900jK', NULL, '2025-01-09 12:36:16', 'user'),
	(2, 'an', '$2y$10$/59VDVozdRGoUZMlk7YSBONEV5Ot64dT5nYQGfdMjZ54VH6QTLbDa', NULL, '2025-01-09 12:42:21', 'user'),
	(3, 'hoangan', '$2y$10$2cGARTHSNI.kJHE.PUTlp.1iZBEoEItOPSqB5ZlmvOoOuNQBdIiRe', NULL, '2025-01-12 10:21:31', 'user');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
