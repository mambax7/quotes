SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE `quotes_quote` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `cid` INT UNSIGNED NOT NULL DEFAULT 0,
  `author_id` INT UNSIGNED NOT NULL DEFAULT 0,
  `uid` INT UNSIGNED NOT NULL DEFAULT 0,
  `quote` TEXT NOT NULL,
  `online` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
  `created` INT UNSIGNED NOT NULL DEFAULT 0,
  `updated` INT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_category` (`cid`),
  KEY `idx_author` (`author_id`),
  KEY `idx_uid` (`uid`),
  KEY `idx_online_created` (`online`, `created`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `quotes_category` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `pid` INT UNSIGNED NOT NULL DEFAULT 0,
  `title` VARCHAR(255) NOT NULL DEFAULT '',
  `description` TEXT NULL,
  `image` VARCHAR(255) NOT NULL DEFAULT '',
  `weight` SMALLINT UNSIGNED NOT NULL DEFAULT 0,
  `color` VARCHAR(10) NOT NULL DEFAULT '0',
  `online` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `idx_parent` (`pid`),
  KEY `idx_online_weight` (`online`, `weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `quotes_author` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL DEFAULT '',
  `country` CHAR(3) NOT NULL DEFAULT '',
  `bio` TEXT NOT NULL,
  `photo` VARCHAR(50) NOT NULL DEFAULT '',
  `uid` INT UNSIGNED NOT NULL DEFAULT 0,
  `created` INT UNSIGNED NOT NULL DEFAULT 0,
  `updated` INT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_name` (`name`),
  KEY `idx_uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
