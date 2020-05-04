CREATE DATABASE unasp_pids_projeto_2;

USE unasp_pids_projeto_2;

CREATE TABLE usuario
(
	id INT PRIMARY KEY AUTO_INCREMENT,
	username VARCHAR(30) UNIQUE NOT NULL,
	name VARCHAR(30),
	passwordhash CHAR(32),
	salthash CHAR(32)
);

CREATE TABLE contato
(
	id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
	telefone VARCHAR(20),
	email VARCHAR(50),
	endereco VARCHAR(200),
	userid INT NOT NULL,
	FOREIGN KEY (userid) REFERENCES usuario(id) ON DELETE CASCADE
);

CREATE TABLE publicacao
(
	id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
	datapublicacao DATE,
	conteudo VARCHAR(200),
	userid INT NOT NULL,
	FOREIGN KEY (userid) REFERENCES usuario(id) ON DELETE CASCADE
);
