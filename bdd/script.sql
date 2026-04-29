CREATE DATABASE IF NOT EXISTS padelorgaz
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE padelorgaz;


CREATE TABLE IF NOT EXISTS usuarios (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    telefono VARCHAR(20) DEFAULT NULL,
    email VARCHAR(100) DEFAULT NULL,
    creado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    apellidos VARCHAR(100) DEFAULT NULL,
    alias VARCHAR(50) DEFAULT NULL,
    sexo VARCHAR(20) DEFAULT NULL,
    posicion VARCHAR(20) DEFAULT NULL,
    nivel DECIMAL(3,2) DEFAULT NULL,
    avatar VARCHAR(255) DEFAULT NULL,
    password VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_general_ci;


INSERT INTO usuarios 
(id, nombre, telefono, email, creado_en, apellidos, alias, sexo, posicion, nivel, avatar, password)
VALUES
(2, 'Javier', '600000000', 'jvidartep05@educarex.es', '2026-04-13 14:26:54', 'Pulido', 'jvp', 'masculino', 'drive', 1.00, '1776264419_whatsapp.jpg', '$2y$10$ouf78g2GI85ReVV7K81pUuOa8HEndaXfw2NsCVv0LMu...'),
(4, 'Invitado', '600000004', 'invitado@yahoo.es', '2026-04-15 16:24:47', 'invitado', 'miau', 'masculino', 'reves', 1.00, '1776436659_default-avatar.jpg', '$2y$10$YMulSpJe3SW9PxFTyeTAWuI2jXBIIpXwApedaLHbNP3...'),
(6, 'Jose', '743245983', 'Josepp@yahoo.es', '2026-04-17 17:28:47', 'Pulido', 'Josete', 'masculino', 'drive', 1.00, '1776439824_oso-saludo.jpg', '$2y$10$vkF4RCWYA8A86h5rTMMuF.rT.QBZ3J0O.oAhL70Uf4D...'),
(8, 'Hola', '600000000', 'holahola@yahoo.es', '2026-04-27 18:03:58', 'miaullll', 'Juan', 'Femenino', 'Ambas', 2.00, NULL, '$2y$10$Z04HViujlV02NeEwGt7b6.7fzavj5qn4Vf4e0kkil.j...');


CREATE TABLE IF NOT EXISTS pistas (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    descripcion TEXT DEFAULT NULL,
    imagen VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_general_ci;



INSERT INTO pistas (id, nombre, descripcion, imagen)
VALUES
(1, 'Pista 1', 'Pista exterior', 'pista1.jpg'),
(2, 'Pista 2', 'Pista exterior', 'pista2.jpg');

CREATE TABLE IF NOT EXISTS reservas (
    id INT(11) NOT NULL AUTO_INCREMENT,
    dia DATE NOT NULL,
    hora_inicio TIME NOT NULL,
    hora_fin TIME NOT NULL,
    pista_id INT(11) NOT NULL,
    id_usuario INT(11) NOT NULL,
    usuario VARCHAR(100) DEFAULT NULL,
    telefono VARCHAR(20) DEFAULT NULL,
    creado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    nivel VARCHAR(50) NOT NULL,
    jugadores INT(11) NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_reserva_usuario FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_reserva_pista FOREIGN KEY (pista_id) REFERENCES pistas(id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_general_ci;
ALTER TABLE reservas DROP FOREIGN KEY reservas_ibfk_1;

