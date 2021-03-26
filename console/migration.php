<?php

    require_once 'pdo_ini.php';
    require_once 'functions.php';

    $sql = <<<'SQL'
        CREATE TABLE IF NOT EXISTS `users`(
            `id` INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `email` VARCHAR(255) NOT NULL,
            `nick` VARCHAR(255) NOT NULL,
            `password` VARCHAR(255) NOT NULL,
            `url_avatar` VARCHAR(255) NULL,
            `role` VARCHAR(255) NULL,
            `confirm` TINYINT 0
        );
    SQL;
    checkingCorrecDataMigrations($pdo, $sql);

    $sql = <<<'SQL'
        CREATE TABLE IF NOT EXISTS `records`(
            `id` INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `date` DATETIME NULL,
            `status` VARCHAR(255) NOT NULL DEFAULT 'not approved',
            `text` VARCHAR(512) NOT NULL,
            `like` INT(10) NOT NULL DEFAULT 0,
            `dislike` INT(10) NOT NULL DEFAULT 0,
            `user_id` INT(10) UNSIGNED NOT NULL,
            FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
        );
    SQL;
    checkingCorrecDataMigrations($pdo, $sql);

    $sql = <<<'SQL'
        CREATE TABLE IF NOT EXISTS `comments`(
            `id` INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `date` DATETIME NOT NULL,
            `status` VARCHAR(255) NOT NULL DEFAULT 'not approved',
            `text` VARCHAR(512) NOT NULL,
            `like` INT(10) NOT NULL DEFAULT 0,
            `dislike` INT(10) NOT NULL DEFAULT 0,
            `user_id` INT(10) UNSIGNED NOT NULL,
            `record_id` INT(10) UNSIGNED NOT NULL,
            FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
            FOREIGN KEY (`record_id`) REFERENCES `records` (`id`)
        );
    SQL;
    checkingCorrecDataMigrations($pdo, $sql);