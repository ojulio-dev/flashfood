/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE DATABASE IF NOT EXISTS `db_flashfood` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `db_flashfood`;

CREATE TABLE IF NOT EXISTS `additional` (
  `additional_id` int(11) NOT NULL AUTO_INCREMENT,
  `ingredient_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `status` bit(1) NOT NULL DEFAULT b'1',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`additional_id`),
  KEY `FK_additional_ingredient` (`ingredient_id`),
  KEY `FK_additional_product` (`product_id`),
  CONSTRAINT `FK_additional_ingredient` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredient` (`ingredient_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_additional_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `additional` (`additional_id`, `ingredient_id`, `product_id`, `status`, `created_at`) VALUES
	(29, 14, 125, b'1', '2022-11-17 16:28:14'),
	(30, 28, 125, b'1', '2022-11-17 16:28:14');

CREATE TABLE IF NOT EXISTS `cart` (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `status` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`cart_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `cart` (`cart_id`, `user_id`, `product_id`, `quantity`, `status`) VALUES
	(1, 32, 46, 1, b'1'),
	(2, 32, 127, 1, b'1'),
	(3, 32, 45, 1, b'1'),
	(4, 32, 12, 2, b'1'),
	(5, 32, 52, 1, b'1'),
	(6, 32, 113, 1, b'1');

CREATE TABLE IF NOT EXISTS `cart_additional` (
  `cart_additional_id` int(11) NOT NULL AUTO_INCREMENT,
  `cart_id` int(11) NOT NULL,
  `additional_id` int(11) NOT NULL,
  PRIMARY KEY (`cart_additional_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS `ingredient` (
  `ingredient_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `price` float(7,2) NOT NULL DEFAULT 0.00,
  `slug` varchar(255) NOT NULL,
  `status` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`ingredient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `ingredient` (`ingredient_id`, `name`, `price`, `slug`, `status`) VALUES
	(14, 'Cebola', 2.50, 'cebola', b'1'),
	(15, 'Hamburguer', 5.00, 'hamburguer', b'1'),
	(28, 'Batata-Palha', 15.00, 'batata-palha', b'1');

CREATE TABLE IF NOT EXISTS `order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_number` int(11) NOT NULL,
  `table` int(11) NOT NULL,
  `status` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`order_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS `order_item` (
  `order_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`order_item_id`) USING BTREE,
  KEY `FK_order_item_order` (`order_id`),
  KEY `FK_order_item_product` (`product_id`),
  CONSTRAINT `FK_order_item_order` FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_order_item_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS `product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `banner` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `special_price` float(8,2) NOT NULL,
  `price` float(8,2) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `status` bit(1) NOT NULL DEFAULT b'1',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`product_id`) USING BTREE,
  KEY `FK_product_product_category` (`category_id`),
  CONSTRAINT `FK_product_product_category` FOREIGN KEY (`category_id`) REFERENCES `product_category` (`category_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `product` (`product_id`, `category_id`, `name`, `banner`, `description`, `special_price`, `price`, `slug`, `status`, `updated_at`, `created_at`) VALUES
	(6, 3, 'Batata Frita', '6.jpg', 'Melhor Batata Frita do Mundo', 32.32, 23.00, 'batata-frita', b'1', '2022-09-17 21:56:29', '2022-09-17 21:56:29'),
	(12, 4, 'Coca-Cola', '12.jpg', 'Melhor Coca-Cola da Cidade', 4.99, 5.99, 'coca-cola', b'1', '2022-09-17 23:22:23', '2022-09-17 23:22:23'),
	(13, 2, 'Hamburguer Maneiro', '13.jpg', 'Melhor Hamburguer da Cidade', 18.99, 23.99, 'hamburguer-maneiro', b'1', '2022-09-17 23:30:10', '2022-09-17 23:30:10'),
	(44, 1, 'Milk Shake', '44.jpg', 'Melhor Milk Shake da Cidade!', 12.99, 18.99, 'milk-shake', b'1', '2022-09-22 19:17:22', '2022-09-22 19:17:22'),
	(45, 3, 'Coxinha', '45.jpg', 'Melhor Coxinha da Cidade', 4.50, 5.00, 'coxinha', b'1', '2022-09-22 22:40:49', '2022-09-22 22:40:49'),
	(46, 1, 'Açaí Maneiro', '46.jpg', 'Melhor Açaí do Mundo!', 13.99, 14.99, 'açaí-maneiro', b'1', '2022-09-28 23:58:22', '2022-09-28 23:58:22'),
	(52, 3, 'Pizza 4 Quejos', '52.jpg', 'Melhor Pizza da Cidade', 130.99, 32.50, 'pizza-4-quejos', b'1', '2022-09-29 00:06:41', '2022-09-29 00:06:41'),
	(54, 15, 'Churrasco self-service', '54.jpg', 'Melhor Churrasco da Cidade', 19.99, 29.50, 'churrasco-self-service', b'1', '2022-09-30 04:09:20', '2022-09-30 04:09:20'),
	(113, 3, 'Salgado de Presunto e Queijo', '113.jpg', 'Melhor salgado de Presunto e Queijo do Mundo!', 4.50, 5.00, 'salgado-de-presunto-e-queijo', b'1', '2022-10-31 21:33:55', '2022-10-31 21:33:55'),
	(125, 15, 'Prato do Dia', '125.jpg', 'Melhor Prato da Cidade', 15.99, 18.50, 'prato-do-dia', b'1', '2022-11-14 20:39:03', '2022-11-14 20:39:03'),
	(127, 1, 'Sorvete Maneiro', '127.jpg', 'Melhor sorvete do Mundo', 13.00, 15.00, 'sorvete-maneiro', b'1', '2022-11-17 16:25:44', '2022-11-17 16:25:44');

CREATE TABLE IF NOT EXISTS `product_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `banner` varchar(255) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `product_category` (`category_id`, `name`, `banner`, `slug`, `status`, `updated_at`, `created_at`) VALUES
	(1, 'Sorvetes', '1.jpg', 'sorvetes', 1, '2022-09-17 17:02:47', '2022-09-17 17:02:47'),
	(2, 'Lanches', '2.jpg', 'lanches', 1, '2022-09-17 17:07:24', '2022-09-17 17:07:24'),
	(3, 'Salgados', '3.jpg', 'salgados', 1, '2022-09-17 21:42:04', '2022-09-17 21:42:04'),
	(4, 'Bebidas', '4.jpg', 'bebidas', 1, '2022-09-17 23:17:37', '2022-09-17 23:17:37'),
	(13, 'Sobremesas', '13.jpg', 'sobremesas', 1, '2022-09-24 20:43:23', '2022-09-24 20:43:23'),
	(15, 'Principais', '15.jpg', 'principais', 1, '2022-09-30 04:06:47', '2022-09-30 04:06:47');

CREATE TABLE IF NOT EXISTS `role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `role` (`role_id`, `name`, `created_at`) VALUES
	(1, 'admin', '2022-11-10 16:51:50');

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `birthdate` date NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`user_id`) USING BTREE,
  UNIQUE KEY `email` (`email`),
  KEY `FK_user_role` (`role_id`),
  CONSTRAINT `FK_user_role` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `user` (`user_id`, `role_id`, `name`, `email`, `password`, `image`, `birthdate`, `status`, `created_at`, `updated_at`) VALUES
	(32, 1, 'Julio Cesar', 'ojuliocesar@gmail.com', '7c96b41274561b0e627ca1eac9f31d3bdf13445f', '32.jpg', '2005-11-21', 1, '2022-11-18 17:15:17', '2022-11-18 17:15:17'),
	(33, 1, 'Emanuel Correa', 'emanuel@gmail.com', '237debecc7336dd476b510269ab29a4d94379818', NULL, '2000-11-04', 1, '2022-11-18 17:17:57', '2022-11-18 17:17:57');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
