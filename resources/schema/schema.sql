CREATE TABLE `customers` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `number` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
 `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
 `street` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
 `postal_code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
 `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
 `country` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
 `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
 PRIMARY KEY (`id`),
 UNIQUE KEY `number` (`number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
