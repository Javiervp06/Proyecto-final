-- ============================================
--   BASE DE DATOS PARA RESERVA DE PISTAS DE PADEL
-- ============================================

-- Crear base de datos
CREATE DATABASE IF NOT EXISTS padel;
USE padel;

-- 1. Tabla usuarios
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(120) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    rol ENUM('usuario', 'admin') DEFAULT 'usuario',
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 2. Tabla pistas
CREATE TABLE pistas (
    id_pista INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    tipo ENUM('cristal', 'muro', 'indoor', 'outdoor'),
    estado ENUM('activa', 'mantenimiento') DEFAULT 'activa'
);

-- 3. Tabla reservas
CREATE TABLE reservas (
    id_reserva INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_pista INT NOT NULL,
    fecha DATE NOT NULL,
    hora_inicio TIME NOT NULL,
    hora_fin TIME NOT NULL,
    estado ENUM('pendiente','confirmada','cancelada') DEFAULT 'pendiente',
    creada_en DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_pista) REFERENCES pistas(id_pista)
);

-- 4. Evitar solapamientos (versión MySQL)
-- Esta restricción se controla con un trigger

DELIMITER //
CREATE TRIGGER evitar_solapamiento
BEFORE INSERT ON reservas
FOR EACH ROW
BEGIN
    IF EXISTS (
        SELECT 1 FROM reservas
        WHERE id_pista = NEW.id_pista
        AND fecha = NEW.fecha
        AND (
            (NEW.hora_inicio BETWEEN hora_inicio AND hora_fin)
            OR (NEW.hora_fin BETWEEN hora_inicio AND hora_fin)
            OR (hora_inicio BETWEEN NEW.hora_inicio AND NEW.hora_fin)
        )
    ) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'La pista ya está reservada en ese horario';
    END IF;
END //
DELIMITER ;

-- 5. Tabla pagos (opcional)
CREATE TABLE pagos (
    id_pago INT AUTO_INCREMENT PRIMARY KEY,
    id_reserva INT NOT NULL,
    cantidad DECIMAL(6,2),
    metodo ENUM('tarjeta','efectivo','online'),
    fecha_pago DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_reserva) REFERENCES reservas(id_reserva)
);
