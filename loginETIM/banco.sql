CREATE DATABASE IF NOT EXISTS etimContato DEFAULT CHARACTER SET utf8;
USE etimContato;
CREATE TABLE IF NOT EXISTS usuarios(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome varchar(100),
    email varchar(100),
    senha varchar(32)
);

