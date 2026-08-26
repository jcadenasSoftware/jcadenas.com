CREATE TABLE IF NOT EXISTS electricista_admin_users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(80) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_electricista_admin_username (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS electricista_categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    slug VARCHAR(140) NOT NULL,
    description VARCHAR(255) DEFAULT NULL,
    sort_order SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_electricista_category_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS electricista_works (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id INT UNSIGNED NOT NULL,
    title VARCHAR(180) NOT NULL,
    slug VARCHAR(200) NOT NULL,
    short_description TEXT NOT NULL,
    description LONGTEXT NOT NULL,
    location VARCHAR(180) DEFAULT NULL,
    work_date DATE DEFAULT NULL,
    cover_image VARCHAR(255) NOT NULL,
    cover_image_alt VARCHAR(255) DEFAULT NULL,
    is_featured TINYINT(1) NOT NULL DEFAULT 0,
    status ENUM('draft', 'published') NOT NULL DEFAULT 'draft',
    published_at DATETIME DEFAULT NULL,
    created_by INT UNSIGNED DEFAULT NULL,
    updated_by INT UNSIGNED DEFAULT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_electricista_work_slug (slug),
    KEY idx_electricista_work_status (status),
    KEY idx_electricista_work_featured (is_featured),
    KEY idx_electricista_work_date (work_date),
    KEY idx_electricista_work_category (category_id),
    CONSTRAINT fk_electricista_work_category FOREIGN KEY (category_id) REFERENCES electricista_categories(id) ON UPDATE CASCADE,
    CONSTRAINT fk_electricista_work_created_by FOREIGN KEY (created_by) REFERENCES electricista_admin_users(id) ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT fk_electricista_work_updated_by FOREIGN KEY (updated_by) REFERENCES electricista_admin_users(id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS electricista_work_images (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    work_id INT UNSIGNED NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    alt_text VARCHAR(255) DEFAULT NULL,
    sort_order INT UNSIGNED NOT NULL DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY idx_electricista_work_images_work (work_id, sort_order),
    CONSTRAINT fk_electricista_work_images_work FOREIGN KEY (work_id) REFERENCES electricista_works(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO electricista_categories (name, slug, description, sort_order, is_active)
VALUES
    ('Instalaciones y soluciones eléctricas', 'instalaciones-y-soluciones-electricas', 'Trabajos de instalaciones, adecuaciones, reparaciones, iluminación y apoyo eléctrico.', 1, 1),
    ('Seguridad electrónica y videovigilancia', 'seguridad-electronica-y-videovigilancia', 'Sistemas de videovigilancia, alarmas y soluciones de monitoreo.', 2, 1),
    ('Redes y cableado estructurado', 'redes-y-cableado-estructurado', 'Trabajos de conectividad, puntos de red y cableado estructurado.', 3, 1),
    ('Mantenimiento de UPS y respaldo eléctrico', 'mantenimiento-de-ups-y-respaldo-electrico', 'Mantenimiento técnico y respaldo eléctrico para continuidad operativa.', 4, 1)
ON DUPLICATE KEY UPDATE
    name = VALUES(name),
    description = VALUES(description),
    sort_order = VALUES(sort_order),
    is_active = VALUES(is_active);
