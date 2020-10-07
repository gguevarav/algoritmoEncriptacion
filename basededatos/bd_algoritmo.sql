DROP DATABASE IF EXISTS bd_algoritmo;

CREATE DATABASE bd_algoritmo;

USE bd_algoritmo;

CREATE TABLE usuarios(
    idUsuario               TINYINT             NOT NULL                PRIMARY KEY             AUTO_INCREMENT,
    NombreApellidoUsuario   VARCHAR(50)         NOT NULL,
    ContraseniaUsuario      VARCHAR(30)         NOT NULL,
    ContraseniaEncriptada   VARCHAR(50)         NOT NULL,
    created_at				TIMESTAMP			NULL,
	updated_at				TIMESTAMP			NULL
)ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_spanish_ci;
