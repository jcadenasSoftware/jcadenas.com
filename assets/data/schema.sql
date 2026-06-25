-- SQL schema for portfolio system

CREATE TABLE categoria (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) NOT NULL,
  slug VARCHAR(50) UNIQUE NOT NULL
);

CREATE TABLE proyecto (
  id INT AUTO_INCREMENT PRIMARY KEY,
  categoria_id INT NOT NULL,
  titulo VARCHAR(100) NOT NULL,
  slug VARCHAR(100) UNIQUE,
  descripcion TEXT,
  repo_url VARCHAR(255),
  precio DECIMAL(8,2),
  destacado TINYINT(1) DEFAULT 0,
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (categoria_id) REFERENCES categoria(id)
);

CREATE TABLE media (
  id INT AUTO_INCREMENT PRIMARY KEY,
  proyecto_id INT NOT NULL,
  tipo ENUM('imagen','video') NOT NULL,
  ruta VARCHAR(255) NOT NULL,
  orden TINYINT DEFAULT 0,
  FOREIGN KEY (proyecto_id) REFERENCES proyecto(id)
);

-- Example-- Tabla de usuarios
CREATE TABLE IF NOT EXISTS usuario (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Usuario administrador por defecto (password: admin123)
INSERT INTO usuario (username,password_hash) VALUES ('admin', '$2y$10$4CNiD6uWzVxG1i7cq.3MhePazTA/gkGEXUXMaLLq5yRvCNrI6VOGa');

-- Example seed data
INSERT INTO categoria (nombre, slug) VALUES
 ('Java','java'),('Python','python'),('Web','web'),('Android','android');

INSERT INTO proyecto (categoria_id, titulo, slug, descripcion, repo_url, precio, destacado) VALUES
 (1,'Sistema de Facturación','sistema-facturacion','Aplicación Java Swing para gestionar facturas.','https://github.com/usuario/proy1',39.99,1);

INSERT INTO media (proyecto_id,tipo,ruta,orden) VALUES
 (1,'imagen','/assets/img/portfolio/facturacion.jpg',0);
