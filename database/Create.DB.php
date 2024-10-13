<?php


namespace Database;


class CreateDB extends Database {

    private $queries = [
        "CREATE TABLE `users` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `username` VARCHAR(255) NOT NULL,
            `email` VARCHAR(255) NOT NULL UNIQUE,
            `password` VARCHAR(255) NOT NULL,
            `status` TINYINT NOT NULL DEFAULT 0,
            `type` TINYINT NOT NULL DEFAULT 0,
            `created_at` DATETIME DEFAULT NOW(),
            `updated_at` DATETIME DEFAULT NOW(),
            PRIMARY KEY (`id`)
        ); " , 
        "CREATE TABLE `test` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `test` VARCHAR(255),
            PRIMARY KEY (`id`)
        ); "
    ];

    public function run(): void
    {
        foreach($this->queries as $query) {
            $this->createTable($query);
        }
    }
}