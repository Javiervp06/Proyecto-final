-- ============================================
-- 📌 CREAR BASE DE DATOS
-- ============================================
CREATE DATABASE IF NOT EXISTS padelorgaz
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE padelorgaz;

-- ============================================
-- 📌 TABLA USUARIOS
-- ============================================
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    telefono VARCHAR(20),
    email VARCHAR(100),
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    apellidos VARCHAR(100),
    alias VARCHAR(50),
    sexo VARCHAR(20),
    posicion VARCHAR(20),
    nivel DECIMAL(3,2),
    avatar VARCHAR(255),
    password VARCHAR(255) NOT NULL
);

-- ============================================
-- 📌 TABLA PISTAS
-- ============================================
CREATE TABLE pistas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    descripcion TEXT,
    imagen VARCHAR(255)
);

-- ============================================
-- 📌 TABLA RESERVAS
-- ============================================
CREATE TABLE reservas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dia DATE NOT NULL,
    hora_inicio TIME NOT NULL,
    hora_fin TIME NOT NULL,
    pista_id INT NOT NULL,
    id_usuario INT NOT NULL,
    nivel VARCHAR(50),
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    -- Relaciones
    FOREIGN KEY (pista_id) REFERENCES pistas(id),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);
