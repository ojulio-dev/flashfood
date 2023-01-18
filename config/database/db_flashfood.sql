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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela db_flashfood.additional: ~7 rows (aproximadamente)
INSERT INTO `additional` (`additional_id`, `ingredient_id`, `product_id`, `status`, `created_at`) VALUES
	(1, 1, 2, b'1', '2023-01-18 09:14:54'),
	(2, 2, 2, b'1', '2023-01-18 09:14:54'),
	(3, 3, 2, b'1', '2023-01-18 09:14:54'),
	(4, 4, 2, b'1', '2023-01-18 09:14:54'),
	(5, 5, 8, b'1', '2023-01-18 09:15:20'),
	(6, 6, 3, b'1', '2023-01-18 09:15:31'),
	(7, 7, 3, b'1', '2023-01-18 09:15:31');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela db_flashfood.cart: ~4 rows (aproximadamente)
INSERT INTO `cart` (`cart_id`, `user_id`, `product_id`, `quantity`, `status`) VALUES
	(1, 1, 1, 2, b'0'),
	(2, 1, 8, 2, b'0'),
	(3, 1, 4, 2, b'0'),
	(4, 1, 2, 2, b'0');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela db_flashfood.cart_additional: ~3 rows (aproximadamente)
INSERT INTO `cart_additional` (`cart_additional_id`, `cart_id`, `additional_id`, `quantity`, `status`) VALUES
	(1, 2, 5, 1, b'0'),
	(2, 4, 1, 1, b'0'),
	(3, 4, 4, 1, b'0');

-- Copiando estrutura para tabela db_flashfood.ingredient
CREATE TABLE IF NOT EXISTS `ingredient` (
  `ingredient_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `price` float(7,2) NOT NULL DEFAULT 0.00,
  `slug` varchar(255) NOT NULL,
  `status` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`ingredient_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela db_flashfood.ingredient: ~7 rows (aproximadamente)
INSERT INTO `ingredient` (`ingredient_id`, `name`, `price`, `slug`, `status`) VALUES
	(1, 'Nutella', 3.00, 'nutella', b'1'),
	(2, 'Morango', 1.00, 'morango', b'1'),
	(3, 'Banana', 1.50, 'banana', b'1'),
	(4, 'Leite em Pó', 1.00, 'leite-em-pó', b'1'),
	(5, 'Hamburguer', 5.00, 'hamburguer', b'1'),
	(6, 'Cereija', 1.00, 'cereija', b'1'),
	(7, 'Calda de Chocolate', 0.50, 'calda-de-chocolate', b'1');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela db_flashfood.order: ~1 rows (aproximadamente)
INSERT INTO `order` (`order_id`, `user_id`, `status_id`, `order_number`, `table_number`, `created_at`) VALUES
	(1, 1, 1, '000003', 5, '2023-01-18 11:06:40');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela db_flashfood.order_item: ~4 rows (aproximadamente)
INSERT INTO `order_item` (`order_item_id`, `order_id`, `product_id`, `category_name`, `product_name`, `product_banner`, `product_description`, `product_price`, `product_special_price`, `quantity`, `created_at`) VALUES
	(1, 1, 1, 'Bebidas', 'Coca-Cola LATA 350ML', '1.jpg', 'Com sabor inconfundível e único, a Coca-Cola Original é o refrigerante mais tradicional e consumido no mundo inteiro! Toda Coca-Cola Original é produzida especialmente para manter sempre a qualidade do melhor sabor de refrigerante! É perfeita para compart', 4.00, 3.69, 2, '2023-01-18 11:06:40'),
	(2, 1, 8, 'Lanches', 'Hamburguer da Casa', '8.jpg', 'Hamburguer criado por nós. 1 Hamburguer, 6 fatias de Queijo Prato, 6 fatias de Queijo Cheddar, 2 tomate, 3 folhas de alface, maionese da casa e ketchup. Tudo isso envolto de um Pão de Hamburguer.', 20.00, 18.00, 2, '2023-01-18 11:06:40'),
	(3, 1, 4, 'Sorvetes', 'Milk Shake com Oreo', '4.jpg', 'Milk Shake com Bolacha?', 17.00, 15.00, 2, '2023-01-18 11:06:40'),
	(4, 1, 2, 'Sorvetes', 'Açaí 500ml', '2.jpg', 'Açaí Maneiro', 17.00, 15.50, 2, '2023-01-18 11:06:40');

-- Copiando estrutura para tabela db_flashfood.order_item_additional
CREATE TABLE IF NOT EXISTS `order_item_additional` (
  `order_item_additional_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `order_item_id` int(11) NOT NULL,
  `additional_id` int(11) DEFAULT NULL,
  `additional_name` varchar(255) NOT NULL,
  `additional_price` float(8,2) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`order_item_additional_id`),
  KEY `FK_order_item_additional_additional` (`additional_id`),
  KEY `FK_order_item_additional_order` (`order_id`),
  KEY `FK_order_item_additional_order_item` (`order_item_id`),
  CONSTRAINT `FK_order_item_additional_additional` FOREIGN KEY (`additional_id`) REFERENCES `additional` (`additional_id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `FK_order_item_additional_order` FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_order_item_additional_order_item` FOREIGN KEY (`order_item_id`) REFERENCES `order_item` (`order_item_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela db_flashfood.order_item_additional: ~3 rows (aproximadamente)
INSERT INTO `order_item_additional` (`order_item_additional_id`, `order_id`, `order_item_id`, `additional_id`, `additional_name`, `additional_price`, `quantity`) VALUES
	(1, 1, 2, 5, 'Hamburguer', 5.00, 1),
	(2, 1, 4, 1, 'Nutella', 3.00, 1),
	(3, 1, 4, 4, 'Leite em Pó', 1.00, 1);

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
	(1, 1, 'pendente', '#FFAB00', '2023-01-17 19:27:53'),
	(2, 2, 'processando', '#3892F3', '2023-01-17 19:28:20'),
	(3, 3, 'finalizado', '#36B37E', '2023-01-17 19:29:00'),
	(4, 4, 'cancelado', '#EA3829', '2023-01-17 19:29:29');

-- Copiando estrutura para tabela db_flashfood.product
CREATE TABLE IF NOT EXISTS `product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `banner` varchar(255) NOT NULL,
  `description` text NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela db_flashfood.product: ~10 rows (aproximadamente)
INSERT INTO `product` (`product_id`, `category_id`, `name`, `banner`, `description`, `price`, `special_price`, `slug`, `status`, `updated_at`, `created_at`) VALUES
	(1, 3, 'Coca-Cola LATA 350ML', '1.jpg', 'Com sabor inconfundível e único, a Coca-Cola Original é o refrigerante mais tradicional e consumido no mundo inteiro! Toda Coca-Cola Original é produzida especialmente para manter sempre a qualidade do melhor sabor de refrigerante! É perfeita para compart', 4.00, 3.69, 'coca-cola-lata-350ml', b'1', '2023-01-18 08:24:36', '2023-01-18 08:24:36'),
	(2, 2, 'Açaí 500ml', '2.jpg', 'Açaí Maneiro', 17.00, 15.50, 'açaí-500ml', b'1', '2023-01-18 08:31:55', '2023-01-18 08:31:55'),
	(3, 2, 'Sorvete de Baunilha', '3.jpg', 'Sorvete de Baunilha é muito bom :D', 15.00, 14.50, 'sorvete-de-baunilha', b'1', '2023-01-18 08:35:02', '2023-01-18 08:35:02'),
	(4, 2, 'Milk Shake com Oreo', '4.jpg', 'Milk Shake com Bolacha?', 17.00, 15.00, 'milk-shake-com-oreo', b'1', '2023-01-18 08:36:48', '2023-01-18 08:36:48'),
	(5, 1, 'Coxinha para Encomenda', '5.jpg', 'Coxinha é bom demais mano.', 25.00, 22.50, 'coxinha-para-encomenda', b'1', '2023-01-18 08:39:47', '2023-01-18 08:39:47'),
	(6, 1, 'Pizza 4 Queijos', '6.jpg', 'A melhor pizza de todas.', 30.00, 28.50, 'pizza-4-queijos', b'1', '2023-01-18 08:41:32', '2023-01-18 08:41:32'),
	(7, 1, 'Salgado de Presunto e Queijo', '7.jpg', 'Melhor salgado de todos.', 5.00, 4.00, 'salgado-de-presunto-e-queijo', b'1', '2023-01-18 08:42:11', '2023-01-18 08:42:11'),
	(8, 4, 'Hamburguer da Casa', '8.jpg', 'Hamburguer criado por nós. 1 Hamburguer, 6 fatias de Queijo Prato, 6 fatias de Queijo Cheddar, 2 tomate, 3 folhas de alface, maionese da casa e ketchup. Tudo isso envolto de um Pão de Hamburguer.', 20.00, 18.00, 'hamburguer-da-casa', b'1', '2023-01-18 08:47:16', '2023-01-18 08:47:16'),
	(9, 5, 'Prato Principal', '9.jpg', 'Prato da Casa. Arroz, Feijão, 1 Ovo, 1 Filé de Frango, Bacon, Mandioca Frita e Tutu de Feijão.', 15.00, 14.00, 'prato-principal', b'1', '2023-01-18 08:50:44', '2023-01-18 08:50:44'),
	(10, 6, 'Churrasco Principal', '10.jpg', 'Churrasco da Casa.', 30.00, 25.00, 'churrasco-principal', b'1', '2023-01-18 08:51:46', '2023-01-18 08:51:46');

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela db_flashfood.product_category: ~6 rows (aproximadamente)
INSERT INTO `product_category` (`category_id`, `name`, `banner`, `slug`, `status`, `updated_at`, `created_at`) VALUES
	(1, 'Massas', '1.jpg', 'massas', 1, '2023-01-18 08:09:06', '2023-01-18 08:09:06'),
	(2, 'Sorvetes', '2.jpg', 'sorvetes', 1, '2023-01-18 08:13:53', '2023-01-18 08:13:53'),
	(3, 'Bebidas', '3.jpg', 'bebidas', 1, '2023-01-18 08:14:44', '2023-01-18 08:14:44'),
	(4, 'Lanches', '4.jpg', 'lanches', 1, '2023-01-18 08:17:32', '2023-01-18 08:17:32'),
	(5, 'Pratos Feitos', '5.jpg', 'pratos-feitos', 1, '2023-01-18 08:20:26', '2023-01-18 08:20:26'),
	(6, 'Carnes', '6.jpg', 'carnes', 1, '2023-01-18 08:22:48', '2023-01-18 08:22:48');

-- Copiando estrutura para tabela db_flashfood.role
CREATE TABLE IF NOT EXISTS `role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela db_flashfood.role: ~1 rows (aproximadamente)
INSERT INTO `role` (`role_id`, `name`, `created_at`) VALUES
	(1, 'admin', '2023-01-17 19:29:44');

-- Copiando estrutura para tabela db_flashfood.table
CREATE TABLE IF NOT EXISTS `table` (
  `table_id` int(11) NOT NULL AUTO_INCREMENT,
  `table_number` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`table_id`),
  UNIQUE KEY `table_number` (`table_number`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela db_flashfood.table: ~5 rows (aproximadamente)
INSERT INTO `table` (`table_id`, `table_number`, `status`, `created_at`) VALUES
	(1, 1, 1, '2023-01-18 09:16:46'),
	(2, 2, 1, '2023-01-18 09:16:48'),
	(3, 3, 1, '2023-01-18 09:16:49'),
	(4, 4, 1, '2023-01-18 09:16:51'),
	(5, 5, 1, '2023-01-18 09:16:53');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela db_flashfood.user: ~1 rows (aproximadamente)
INSERT INTO `user` (`user_id`, `role_id`, `name`, `email`, `password`, `image`, `birthdate`, `status`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Julio Cesar', 'ojuliocesar@gmail.com', '7c96b41274561b0e627ca1eac9f31d3bdf13445f', NULL, '2005-11-21', 1, '2023-01-18 09:16:07', '2023-01-18 09:16:07');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
