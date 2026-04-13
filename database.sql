-- Creación de la base de datos (por si acaso, aunque ya la tengas creada)
CREATE DATABASE IF NOT EXISTS agecso;
USE agecso;

-- Tabla de Roles (Administrador, Comprador, Vendedor)
CREATE TABLE IF NOT EXISTS roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE
);

INSERT INTO roles (nombre) VALUES ('Administrador'), ('Comprador'), ('Vendedor');

-- Tabla de Usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(100) NOT NULL,
    correo VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol_id INT,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (rol_id) REFERENCES roles(id)
);

-- Tabla de Empresas
CREATE TABLE IF NOT EXISTS empresas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    nombre_empresa VARCHAR(200) NOT NULL,
    nit VARCHAR(50),
    descripcion TEXT,
    contacto_nombre VARCHAR(150),
    telefono VARCHAR(20),
    sector VARCHAR(100),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Tabla de Ruedas de Negocios (Eventos)
CREATE TABLE IF NOT EXISTS ruedas_negocios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(200) NOT NULL,
    descripcion TEXT,
    fecha_inicio DATE,
    fecha_fin DATE,
    estado ENUM('abierta', 'cerrada', 'finalizada') DEFAULT 'cerrada',
    creado_por INT,
    FOREIGN KEY (creado_por) REFERENCES usuarios(id)
);

-- Tabla de Oferta (Vendedores)
CREATE TABLE IF NOT EXISTS ofertas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    empresa_id INT,
    producto_servicio VARCHAR(255) NOT NULL,
    descripcion TEXT,
    FOREIGN KEY (empresa_id) REFERENCES empresas(id)
);

-- Tabla de Demanda (Compradores)
CREATE TABLE IF NOT EXISTS demandas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    empresa_id INT,
    requerimiento VARCHAR(255) NOT NULL,
    descripcion TEXT,
    FOREIGN KEY (empresa_id) REFERENCES empresas(id)
);

-- Tabla de Reuniones (Citas)
CREATE TABLE IF NOT EXISTS reuniones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rueda_id INT,
    comprador_id INT, -- ID de la empresa compradora
    vendedor_id INT,  -- ID de la empresa vendedora
    fecha_hora DATETIME,
    estado ENUM('pendiente', 'aceptada', 'rechazada', 'realizada', 'cancelada') DEFAULT 'pendiente',
    calificacion_comprador INT, -- 1 a 5
    calificacion_vendedor INT,  -- 1 a 5
    observaciones TEXT,
    monto_negocio DECIMAL(15,2), -- Para medir impacto económico
    FOREIGN KEY (rueda_id) REFERENCES ruedas_negocios(id),
    FOREIGN KEY (comprador_id) REFERENCES empresas(id),
    FOREIGN KEY (vendedor_id) REFERENCES empresas(id)
);
