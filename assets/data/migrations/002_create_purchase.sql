-- Creates purchase table for orders and downloads
CREATE TABLE IF NOT EXISTS purchase (
  id INT AUTO_INCREMENT PRIMARY KEY,
  proyecto_id INT NOT NULL,
  nombre VARCHAR(120) NOT NULL,
  email VARCHAR(160) NOT NULL,
  metodo VARCHAR(30) NOT NULL,
  monto DECIMAL(12,2) NULL,
  moneda VARCHAR(10) NULL,
  status ENUM('pending','paid','failed') NOT NULL DEFAULT 'pending',
  provider_txn_id VARCHAR(191) NULL,
  referencia VARCHAR(191) NULL,
  recibo_path VARCHAR(255) NULL,
  download_token VARCHAR(191) NULL,
  expires_at DATETIME NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (proyecto_id) REFERENCES proyecto(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
