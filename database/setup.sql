-- ============================================================
--  Script de base de datos para: CRUD Usuarios - Arquitectura Hexagonal
--  Ejecutar en: MySQL / MariaDB
-- ============================================================

-- 1. Crear la base de datos
CREATE DATABASE IF NOT EXISTS crud_usuarios
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE crud_usuarios;

-- 2. Crear la tabla de usuarios
CREATE TABLE IF NOT EXISTS users (
    id         VARCHAR(36)  NOT NULL,
    name       VARCHAR(120) NOT NULL,
    email      VARCHAR(180) NOT NULL,
    password   VARCHAR(255) NOT NULL,
    role       VARCHAR(20)  NOT NULL DEFAULT 'MEMBER',
    status     VARCHAR(20)  NOT NULL DEFAULT 'PENDING',
    created_at DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    UNIQUE KEY uq_users_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Insertar un usuario administrador de prueba
--    Contraseña: Admin1234
--    (bcrypt hash generado con password_hash('Admin1234', PASSWORD_BCRYPT))
INSERT INTO users (id, name, email, password, role, status) VALUES (
    'a1b2c3d4-e5f6-4a7b-8c9d-0e1f2a3b4c5d',
    'Administrador',
    'admin@ejemplo.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'ADMIN',
    'ACTIVE'
);
-- NOTA: La contraseña del usuario de prueba es: password
-- Cámbiala después del primer login desde el formulario de edición.
