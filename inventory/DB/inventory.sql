-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.30 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para db_inventory
CREATE DATABASE IF NOT EXISTS `db_inventory` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `db_inventory`;

-- Volcando estructura para tabla db_inventory.branches
CREATE TABLE IF NOT EXISTS `branches` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `branch_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla db_inventory.branches: ~0 rows (aproximadamente)
DELETE FROM `branches`;

-- Volcando estructura para tabla db_inventory.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Volcando estructura para tabla db_inventory.companies
CREATE TABLE IF NOT EXISTS `companies` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando estructura para tabla db_inventory.customers
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
--   `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
--   `phone` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
--   `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
--   `rut` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `abreviacion` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando estructura para tabla db_inventory.menus
CREATE TABLE IF NOT EXISTS `menus` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int NOT NULL DEFAULT '0',
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `menu_url` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla db_inventory.menus: ~15 rows (aproximadamente)
DELETE FROM `menus`;
INSERT INTO `menus` (`id`, `parent_id`, `name`, `icon`, `menu_url`, `status`, `created_at`, `updated_at`) VALUES
	(1, 2, 'Unidades', 'straighten', 'unit.index', 0, '2024-07-23 13:17:51', '2024-07-23 13:17:56'),
	(2, 0, 'Gestión de Productos', 'shopping_cart', NULL, 0, '2024-07-23 13:17:53', '2020-07-29 13:17:54'),
	(3, 0, 'Gestión de Entradas', 'inventory', 'stock.index', 0, '2024-07-23 13:17:52', '2024-07-23 13:17:54'),
	(4, 0, 'Lista de Solicitudes', 'receipt', 'demand.index', 0, '2024-07-23 13:17:51', '2024-07-23 13:17:56'),
	(5, 0, 'Reportes', 'insert_chart', 'report.index', 0, '2024-07-23 13:17:52', '2024-07-23 13:17:55'),
	(6, 0, 'Configuración de usuarios', 'settings', NULL, 0, '2024-07-23 13:17:58', '2024-07-23 13:17:57'),
	(7, 2, 'Categorias', NULL, 'category.index', 0, '2024-07-23 13:17:50', '2024-07-23 13:17:57'),
	(8, 2, 'Productos', NULL, 'product.index', 0, '2024-07-23 13:17:49', '2024-07-23 13:17:59'),
	(9, 2, 'Proveedores', NULL, 'supplier.index', 0, '2024-07-23 13:17:49', '2024-07-23 13:18:00'),
	(10, 6, 'Roles', 'admin_panel_settings', 'role.index', 0, '2024-07-23 13:17:43', '2024-07-23 13:17:45'),
	(11, 6, 'Usuarios', 'person', 'user.index', 0, '2024-07-23 13:17:42', '2024-07-23 13:16:37');

-- Volcando estructura para tabla db_inventory.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla db_inventory.migrations: ~16 rows (aproximadamente)
DELETE FROM `migrations`;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2018_12_10_051212_create_products_table', 2),
	(4, '2018_12_10_052440_create_vendors_table', 2),
	(5, '2018_12_10_052501_create_customers_table', 2),
	(6, '2018_12_10_052521_create_stocks_table', 2),
	(7, '2018_12_10_052610_create_sells_table', 2),
	(8, '2018_12_10_052631_create_sell_details_table', 2),
	(9, '2018_12_10_075236_create_branches_table', 2),
	(10, '2018_12_31_160432_create_categories_table', 3),
	(11, '2019_01_12_163604_create_payments_table', 4),
	(12, '2019_01_19_152250_biye--tabl', 5),
	(13, '2019_02_10_113651_create_roles_table', 6),
	(14, '2019_02_10_114632_create_permissions_table', 6),
	(15, '2019_02_10_114735_create_menus_table', 6),
	(16, '2019_02_14_130126_create_companies_table', 7);

-- Volcando estructura para tabla db_inventory.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla db_inventory.password_resets: ~0 rows (aproximadamente)
DELETE FROM `password_resets`;

-- Volcando estructura para tabla db_inventory.payments
CREATE TABLE IF NOT EXISTS `payments` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `sell_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `user_id` int NOT NULL,
  `date` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `paid_in` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_information` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `amount` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sell_id` (`sell_id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Volcando estructura para tabla db_inventory.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int NOT NULL,
  `menu_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=744 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla db_inventory.permissions: ~45 rows (aproximadamente)
DELETE FROM `permissions`;
INSERT INTO `permissions` (`id`, `role_id`, `menu_id`) VALUES
	(124, 5, 1),
	(125, 5, 2),
	(126, 5, 3),
	(127, 5, 4),
	(128, 5, 5),
	(129, 5, 6),
	(130, 5, 9),
	(131, 5, 8),
	(132, 5, 7),
	(133, 5, 10),
	(134, 5, 11),
	(135, 5, 12),
	(136, 5, 15),
	(137, 6, 1),
	(138, 6, 3),
	(139, 6, 6),
	(140, 6, 15),
	(706, 4, 11),
	(707, 4, 2),
	(708, 4, 4),
	(709, 4, 15),
	(710, 4, 6),
	(721, 3, 1),
	(722, 3, 9),
	(723, 3, 8),
	(724, 3, 7),
	(725, 3, 2),
	(726, 3, 10),
	(727, 3, 11),
	(728, 3, 3),
	(729, 2, 1),
	(730, 2, 9),
	(731, 2, 8),
	(732, 2, 7),
	(733, 2, 2),
	(734, 2, 10),
	(735, 2, 11),
	(736, 2, 3),
	(737, 2, 12),
	(738, 2, 13),
	(739, 2, 4),
	(740, 2, 5),
	(741, 2, 14),
	(742, 2, 15),
	(743, 2, 6);

-- Volcando estructura para tabla db_inventory.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `unit_id` int NOT NULL,
  `stock` int NOT NULL DEFAULT '0',,
  `critico` int NOT NULL DEFAULT '0',,
  `product_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `marca` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=236 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando estructura para tabla db_inventory.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla db_inventory.roles: ~4 rows (aproximadamente)
DELETE FROM `roles`;
INSERT INTO `roles` (`id`, `role_name`, `created_at`, `updated_at`) VALUES
	(2, 'Administrador', '2024-07-23 03:59:54', '2024-07-23 04:53:28'),
	(12, 'Encargado-Molina', '2024-07-23 00:07:41', '2024-07-23 04:35:56'),
	(13, 'Encargado-Linares', '2024-07-23 01:34:11', '2024-07-23 04:36:08'),
	(15, 'JefeTaller-Molina', '2024-07-23 05:53:15', '2024-07-23 06:41:36');
	(16, 'JefeTaller-Linares', '2024-07-23 05:53:15', '2024-07-23 06:51:30');
	(18, 'Técnico-Linares', '2024-07-23 05:53:15', '2024-07-23 06:58:50');
	(19, 'Técnico-Molina', '2024-07-23 05:53:15', '2024-07-23 09:20:20');

-- Volcando estructura para tabla db_inventory.sells
CREATE TABLE IF NOT EXISTS `sells` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `branch_id` int NOT NULL DEFAULT '1',
  `total_amount` double NOT NULL,
  `paid_amount` double NOT NULL DEFAULT '0',
  `sell_date` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_amount` double NOT NULL DEFAULT '0',
  `payment_method` tinyint NOT NULL DEFAULT '0',
  `payment_status` tinyint NOT NULL DEFAULT '0',
  `marca_modelo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `patente` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observaciones` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sede_lista_solicitud` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando estructura para tabla db_inventory.sell_details
CREATE TABLE IF NOT EXISTS `sell_details` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `stock_id` int NOT NULL,
  `sell_id` int NOT NULL,
  `product_id` int NOT NULL,
  `category_id` int NOT NULL,
  `vendor_id` int NOT NULL,
  `user_id` int NOT NULL,
  `chalan_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `selling_date` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sold_quantity` int NOT NULL,
  `buy_price` double NOT NULL,
  `sold_price` double NOT NULL,
  `total_buy_price` double NOT NULL,
  `total_sold_price` double NOT NULL,
  `discount` double NOT NULL,
  `discount_type` tinyint NOT NULL,
  `discount_amount` double NOT NULL,
  `estado` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stock_id` (`stock_id`),
  KEY `selling_date` (`selling_date`),
  KEY `product_id` (`product_id`),
  KEY `category_id` (`category_id`),
  KEY `vendor_id` (`vendor_id`),
  KEY `user_id` (`user_id`),
  KEY `sell_id` (`sell_id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando estructura para tabla db_inventory.stocks
CREATE TABLE IF NOT EXISTS `stocks` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `product_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` int NOT NULL,
  `vendor_id` int NOT NULL,
  `user_id` int NOT NULL,
  `orden` int NOT NULL,
  `chalan_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `buying_price` double NOT NULL,
  `selling_price` double NOT NULL,
  `discount` double NOT NULL DEFAULT '0',
  `stock_quantity` int NOT NULL,
  `current_quantity` int NOT NULL DEFAULT '0',
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint NOT NULL DEFAULT '1',
  `stock_minimum` int NOT NULL DEFAULT '0',
  `current_quantity_consume` double NOT NULL DEFAULT '0',
  `iva` double NOT NULL DEFAULT '0',
  `bodega_stock_quantity` double NOT NULL DEFAULT '0',
  `new_qty` double NOT NULL DEFAULT '0',
  `factura` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `vendor_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `product_id` (`product_id`),
  KEY `vendor_id` (`vendor_id`),
  KEY `stock_quantity` (`stock_quantity`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando estructura para tabla db_inventory.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_id` int NOT NULL DEFAULT '1',
  `role_id` int NOT NULL DEFAULT '1',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `place` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `roles` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla db_inventory.users: ~1 rows (aproximadamente)
DELETE FROM `users`;
INSERT INTO `users` (`id`, `name`, `email`, `password`, `branch_id`, `role_id`, `remember_token`, `place`, `roles`, `created_at`, `updated_at`) VALUES
	(12, 'Carolina Urzúa', 'curzua@tallerurzua.cl', '$2y$10$W/nqTuN0X.JaGtGBkpw01OTSL0I3aShYL9QusP8Q5kIZ2AviqQHKC', 1, 2, '6zd4CxMA9RCTnuJaxtyhByrBYJsPfV9GtAB4pJE3Ht6YTsIvQ7ETjUVO1jlv', 'todo', '', '2024-07-23 19:20:15', '2024-07-23 20:30:40');

-- Volcando estructura para tabla db_inventory.vendors
CREATE TABLE IF NOT EXISTS `vendors` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rut` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `soporte_nombre` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `soporte_correo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `soporte_phone` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `region` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `comuna` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;