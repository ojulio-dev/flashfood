-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.4.27-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.3.0.6589
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para db_flashfood
CREATE DATABASE IF NOT EXISTS `db_flashfood` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `db_flashfood`;

-- Copiando estrutura para tabela db_flashfood.additional
CREATE TABLE IF NOT EXISTS `additional` (
  `additional_id` int(11) NOT NULL AUTO_INCREMENT,
  `ingredient_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `status` bit(1) NOT NULL DEFAULT b'1',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`additional_id`),
  KEY `FK_additional_ingredient` (`ingredient_id`),
  KEY `FK_additional_product` (`product_id`),
  CONSTRAINT `FK_additional_ingredient` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredient` (`ingredient_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_additional_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela db_flashfood.additional: ~5 rows (aproximadamente)
INSERT INTO `additional` (`additional_id`, `ingredient_id`, `product_id`, `status`, `created_at`) VALUES
	(50, 15, 13, b'1', '2023-01-10 06:18:47'),
	(55, 28, 125, b'1', '2023-01-10 06:42:28'),
	(56, 14, 125, b'1', '2023-01-10 06:42:28'),
	(58, 14, 138, b'1', '2023-01-14 16:07:08'),
	(71, 28, 151, b'1', '2023-01-15 13:07:45');

-- Copiando estrutura para tabela db_flashfood.cart
CREATE TABLE IF NOT EXISTS `cart` (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `status` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`cart_id`),
  KEY `FK_cart_product` (`product_id`),
  KEY `FK_cart_user` (`user_id`),
  CONSTRAINT `FK_cart_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `FK_cart_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=341 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela db_flashfood.cart: ~27 rows (aproximadamente)
INSERT INTO `cart` (`cart_id`, `user_id`, `product_id`, `quantity`, `status`) VALUES
	(312, 32, 46, 1, b'0'),
	(313, 32, 127, 1, b'0'),
	(314, 32, 125, 1, b'0'),
	(315, 32, 138, 1, b'0'),
	(316, 32, 54, 1, b'0'),
	(317, 32, 125, 1, b'0'),
	(319, 32, 13, 1, b'0'),
	(320, 32, 125, 1, b'0'),
	(321, 32, 13, 1, b'0'),
	(322, 32, 125, 1, b'0'),
	(323, 32, 125, 5, b'0'),
	(324, 32, 44, 1, b'0'),
	(325, 32, 138, 1, b'0'),
	(326, 32, 13, 2, b'0'),
	(327, 32, 52, 1, b'0'),
	(328, 32, 12, 2, b'0'),
	(329, 32, 125, 1, b'0'),
	(331, 32, 44, 1, b'0'),
	(332, 32, 151, 5, b'0'),
	(333, 32, 151, 1, b'0'),
	(334, 32, 44, 1, b'0'),
	(335, 32, 44, 1, b'0'),
	(336, 32, 138, 1, b'0'),
	(337, 32, 44, 1, b'0'),
	(338, 32, 125, 1, b'0'),
	(339, 32, 125, 1, b'0'),
	(340, 32, 125, 1, b'0');

-- Copiando estrutura para tabela db_flashfood.cart_additional
CREATE TABLE IF NOT EXISTS `cart_additional` (
  `cart_additional_id` int(11) NOT NULL AUTO_INCREMENT,
  `cart_id` int(11) NOT NULL,
  `additional_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `status` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`cart_additional_id`),
  KEY `FK_cart_additional_additional` (`additional_id`),
  KEY `FK_cart_additional_cart` (`cart_id`),
  CONSTRAINT `FK_cart_additional_additional` FOREIGN KEY (`additional_id`) REFERENCES `additional` (`additional_id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `FK_cart_additional_cart` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`cart_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela db_flashfood.cart_additional: ~17 rows (aproximadamente)
INSERT INTO `cart_additional` (`cart_additional_id`, `cart_id`, `additional_id`, `quantity`, `status`) VALUES
	(62, 319, 50, 9, b'0'),
	(63, 320, 55, 9, b'0'),
	(64, 320, 56, 9, b'0'),
	(65, 321, 50, 9, b'0'),
	(66, 322, 55, 3, b'0'),
	(67, 322, 56, 3, b'0'),
	(68, 323, 55, 2, b'0'),
	(69, 323, 56, 1, b'0'),
	(71, 329, 55, 1, b'0'),
	(72, 329, 56, 2, b'0'),
	(74, 336, 58, 9, b'0'),
	(75, 338, 55, 1, b'0'),
	(76, 338, 56, 1, b'0'),
	(77, 339, 55, 1, b'0'),
	(78, 339, 56, 1, b'0'),
	(79, 340, 55, 1, b'0'),
	(80, 340, 56, 1, b'0');

-- Copiando estrutura para tabela db_flashfood.ingredient
CREATE TABLE IF NOT EXISTS `ingredient` (
  `ingredient_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `price` float(7,2) NOT NULL DEFAULT 0.00,
  `slug` varchar(255) NOT NULL,
  `status` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`ingredient_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela db_flashfood.ingredient: ~4 rows (aproximadamente)
INSERT INTO `ingredient` (`ingredient_id`, `name`, `price`, `slug`, `status`) VALUES
	(14, 'Cebola', 2.50, 'cebola', b'1'),
	(15, 'Hamburguer', 5.00, 'hamburguer', b'1'),
	(28, 'Batata-Palha', 15.00, 'batata-palha', b'1'),
	(29, 'Filé de Frango', 12.00, 'filé-de-frango', b'1');

-- Copiando estrutura para tabela db_flashfood.order
CREATE TABLE IF NOT EXISTS `order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `status_id` int(11) NOT NULL DEFAULT 1,
  `order_number` varchar(6) NOT NULL,
  `table_number` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`order_id`) USING BTREE,
  KEY `FK_order_user` (`user_id`),
  KEY `FK_order_order_status` (`status_id`),
  CONSTRAINT `FK_order_order_status` FOREIGN KEY (`status_id`) REFERENCES `order_status` (`status_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_order_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=134 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela db_flashfood.order: ~1 rows (aproximadamente)
INSERT INTO `order` (`order_id`, `user_id`, `status_id`, `order_number`, `table_number`, `created_at`) VALUES
	(133, 32, 1, '000003', 20, '2023-01-16 14:22:07');

-- Copiando estrutura para tabela db_flashfood.order_item
CREATE TABLE IF NOT EXISTS `order_item` (
  `order_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `category_name` varchar(100) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_banner` varchar(20) NOT NULL,
  `product_description` varchar(255) NOT NULL,
  `product_price` float(8,2) NOT NULL,
  `product_special_price` float(8,2) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`order_item_id`) USING BTREE,
  KEY `FK_order_item_order` (`order_id`),
  KEY `FK_order_item_product` (`product_id`),
  CONSTRAINT `FK_order_item_order` FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_order_item_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=187 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela db_flashfood.order_item: ~1 rows (aproximadamente)
INSERT INTO `order_item` (`order_item_id`, `order_id`, `product_id`, `category_name`, `product_name`, `product_banner`, `product_description`, `product_price`, `product_special_price`, `quantity`, `created_at`) VALUES
	(186, 133, 125, 'Principais', 'Prato do Dia', '125.jpg', 'Melhor Prato da Cidade', 18.50, 15.99, 1, '2023-01-16 14:22:07');

-- Copiando estrutura para tabela db_flashfood.order_item_additional
CREATE TABLE IF NOT EXISTS `order_item_additional` (
  `order_item_additional_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `order_item_id` int(11) NOT NULL,
  `additional_id` int(11) NOT NULL,
  `additional_name` varchar(255) NOT NULL,
  `additional_price` float(8,2) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`order_item_additional_id`),
  KEY `FK_order_item_additional_additional` (`additional_id`),
  KEY `FK_order_item_additional_order` (`order_id`),
  KEY `FK_order_item_additional_order_item` (`order_item_id`),
  CONSTRAINT `FK_order_item_additional_additional` FOREIGN KEY (`additional_id`) REFERENCES `additional` (`additional_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_order_item_additional_order` FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_order_item_additional_order_item` FOREIGN KEY (`order_item_id`) REFERENCES `order_item` (`order_item_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela db_flashfood.order_item_additional: ~2 rows (aproximadamente)
INSERT INTO `order_item_additional` (`order_item_additional_id`, `order_id`, `order_item_id`, `additional_id`, `additional_name`, `additional_price`, `quantity`) VALUES
	(49, 133, 186, 55, 'Batata-Palha', 15.00, 1),
	(50, 133, 186, 56, 'Cebola', 2.50, 1);

-- Copiando estrutura para tabela db_flashfood.order_status
CREATE TABLE IF NOT EXISTS `order_status` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT,
  `position` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `color` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`status_id`),
  UNIQUE KEY `position` (`position`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela db_flashfood.order_status: ~4 rows (aproximadamente)
INSERT INTO `order_status` (`status_id`, `position`, `name`, `color`, `created_at`) VALUES
	(1, 1, 'pendente', '#FFAB00', '2023-01-11 11:42:45'),
	(2, 2, 'processando', '#3892f3', '2023-01-11 11:43:01'),
	(3, 3, 'finalizado', '#36B37E', '2023-01-11 11:47:37'),
	(4, 4, 'cancelado', '#ea3829', '2023-01-11 11:47:48');

-- Copiando estrutura para tabela db_flashfood.product
CREATE TABLE IF NOT EXISTS `product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `banner` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `price` float(8,2) NOT NULL,
  `special_price` float(8,2) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `status` bit(1) NOT NULL DEFAULT b'1',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`product_id`) USING BTREE,
  UNIQUE KEY `slug` (`slug`),
  KEY `FK_product_product_category` (`category_id`),
  CONSTRAINT `FK_product_product_category` FOREIGN KEY (`category_id`) REFERENCES `product_category` (`category_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=154 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela db_flashfood.product: ~13 rows (aproximadamente)
INSERT INTO `product` (`product_id`, `category_id`, `name`, `banner`, `description`, `price`, `special_price`, `slug`, `status`, `updated_at`, `created_at`) VALUES
	(6, 3, 'Batata Frita', '6.jpg', 'Melhor Batata Frita do Mundo', 23.00, 32.32, 'batata-frita', b'1', '2022-09-17 21:56:29', '2022-09-17 21:56:29'),
	(12, 4, 'Coca-Cola', '12.jpg', 'Melhor Coca-Cola da Cidade', 5.99, 4.99, 'coca-cola', b'1', '2022-09-17 23:22:23', '2022-09-17 23:22:23'),
	(13, 2, 'Hamburguer Maneiro', '13.jpg', 'Melhor Hamburguer da Cidade', 23.99, 18.99, 'hamburguer-maneiro', b'1', '2022-09-17 23:30:10', '2022-09-17 23:30:10'),
	(44, 1, 'Milk Shake', '44.jpg', 'Melhor Milk Shake da Cidade! ', 18.99, 12.99, 'milk-shake', b'1', '2022-09-22 19:17:22', '2022-09-22 19:17:22'),
	(45, 3, 'Coxinha', '45.jpg', 'Melhor Coxinha da Cidade', 5.00, 4.50, 'coxinha', b'1', '2022-09-22 22:40:49', '2022-09-22 22:40:49'),
	(46, 1, 'Açaí Maneiro', '46.jpg', 'Melhor Açaí do Mundo!', 14.99, 13.99, 'acai-maneiro', b'1', '2022-09-28 23:58:22', '2022-09-28 23:58:22'),
	(52, 3, 'Pizza 4 Quejos', '52.jpg', 'Melhor Pizza da Cidade', 32.50, 25.00, 'pizza-4-quejos', b'1', '2022-09-29 00:06:41', '2022-09-29 00:06:41'),
	(54, 15, 'Churrasco self-service', '54.jpg', 'Melhor Churrasco da Cidade', 2.95, 19.99, 'churrasco-self-service', b'1', '2022-09-30 04:09:20', '2022-09-30 04:09:20'),
	(113, 3, 'Salgado de Presunto e Queijo', '113.jpg', 'Melhor salgado de Presunto e Queijo do Mundo!', 5.00, 4.50, 'salgado-de-presunto-e-queijo', b'1', '2022-10-31 21:33:55', '2022-10-31 21:33:55'),
	(125, 15, 'Prato do Dia', '125.jpg', 'Melhor Prato da Cidade', 18.50, 15.99, 'prato-do-dia', b'1', '2022-11-14 20:39:03', '2022-11-14 20:39:03'),
	(127, 1, 'Sorvete Maneiro', '127.jpg', 'Melhor sorvete do Mundo', 15.00, 13.00, 'sorvete-maneiro', b'1', '2022-11-17 16:25:44', '2022-11-17 16:25:44'),
	(138, 16, 'Sushi Yoda', '138.jpg', 'Melhor Sushi do mundo', 5.00, 3.25, 'sushi-yoda', b'1', '2022-12-21 07:37:03', '2022-12-21 07:37:03'),
	(151, 4, 'Teste', '151.jpg', 'Fazendo alguns testeeeeeeeeeeeees', 9999.99, NULL, 'teste', b'1', '2023-01-15 12:19:29', '2023-01-15 12:19:29');

-- Copiando estrutura para tabela db_flashfood.product_category
CREATE TABLE IF NOT EXISTS `product_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `banner` varchar(255) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela db_flashfood.product_category: ~7 rows (aproximadamente)
INSERT INTO `product_category` (`category_id`, `name`, `banner`, `slug`, `status`, `updated_at`, `created_at`) VALUES
	(1, 'Sorvetes', '1.jpg', 'sorvetes', 1, '2022-09-17 17:02:47', '2022-09-17 17:02:47'),
	(2, 'Lanches', '2.jpg', 'lanches', 1, '2022-09-17 17:07:24', '2022-09-17 17:07:24'),
	(3, 'Salgados', '3.jpg', 'salgados', 1, '2022-09-17 21:42:04', '2022-09-17 21:42:04'),
	(4, 'Bebidas', '4.jpg', 'bebidas', 1, '2022-09-17 23:17:37', '2022-09-17 23:17:37'),
	(13, 'Sobremesas', '13.jpg', 'sobremesas', 1, '2022-09-24 20:43:23', '2022-09-24 20:43:23'),
	(15, 'Principais', '15.jpg', 'principais', 1, '2022-09-30 04:06:47', '2022-09-30 04:06:47'),
	(16, 'Pratos Japoneses', '16.jpg', 'pratos-japoneses', 1, '2022-12-21 07:35:42', '2022-12-21 07:35:42');

-- Copiando estrutura para tabela db_flashfood.role
CREATE TABLE IF NOT EXISTS `role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela db_flashfood.role: ~1 rows (aproximadamente)
INSERT INTO `role` (`role_id`, `name`, `created_at`) VALUES
	(1, 'admin', '2022-11-10 16:51:50');

-- Copiando estrutura para tabela db_flashfood.table
CREATE TABLE IF NOT EXISTS `table` (
  `table_id` int(11) NOT NULL AUTO_INCREMENT,
  `table_number` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`table_id`),
  UNIQUE KEY `table_number` (`table_number`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela db_flashfood.table: ~7 rows (aproximadamente)
INSERT INTO `table` (`table_id`, `table_number`, `status`, `created_at`) VALUES
	(14, 1, 1, '2023-01-14 05:36:49'),
	(15, 2, 1, '2023-01-14 05:36:52'),
	(16, 3, 1, '2023-01-14 05:36:54'),
	(17, 4, 1, '2023-01-14 05:36:55'),
	(18, 5, 1, '2023-01-14 05:36:57'),
	(19, 6, 1, '2023-01-14 05:36:59'),
	(20, 7, 1, '2023-01-14 05:37:03');

-- Copiando estrutura para tabela db_flashfood.user
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
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela db_flashfood.user: ~2 rows (aproximadamente)
INSERT INTO `user` (`user_id`, `role_id`, `name`, `email`, `password`, `image`, `birthdate`, `status`, `created_at`, `updated_at`) VALUES
	(32, 1, 'Julio Cesar', 'ojuliocesar@gmail.com', '7c96b41274561b0e627ca1eac9f31d3bdf13445f', '32.jpg', '2005-11-21', 1, '2022-11-18 17:15:17', '2022-11-18 17:15:17'),
	(34, 1, 'Emanuel', '123@gmail.com', '9a2428f0baadc1ac8b2a4aead80df44d9106636d', NULL, '2023-01-04', 1, '2023-01-14 05:52:00', '2023-01-14 05:52:00');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
