CREATE DATABASE mysite;
USE mysite;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) NOT NULL,
    password VARCHAR(32) NOT NULL,
    salt VARCHAR(10) NOT NULL,
    is_admin TINYINT(1) DEFAULT 0,
    reg_date DATETIME NOT NULL
);

-- Создание администратора (пароль: admin123)
INSERT INTO users (login, password, salt, is_admin, reg_date) 
VALUES ('admin', 'c0e024d9200b5705bc4804722636378a', 'a1b2c3d4e5', 1, NOW());
