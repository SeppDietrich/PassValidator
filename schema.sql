-- Rulează acest fișier în phpMyAdmin (tab-ul SQL) sau din consola MySQL.
CREATE DATABASE IF NOT EXISTS transabon CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE transabon;

CREATE TABLE IF NOT EXISTS utilizatori (
    id                   INT AUTO_INCREMENT PRIMARY KEY,
    nume                 VARCHAR(100) NOT NULL,
    prenume              VARCHAR(100) NOT NULL,
    email                VARCHAR(200) NOT NULL UNIQUE,
    parola_hash          VARCHAR(255) NOT NULL,
    rol                  ENUM('client','controlor','administrator') NOT NULL DEFAULT 'client',
    activ                TINYINT(1) NOT NULL DEFAULT 1,
    data_inregistrarii   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    ultima_autentificare DATETIME NULL
);
