ALTER TABLE proyecto
  ADD COLUMN download_path VARCHAR(255) NULL,
  ADD COLUMN download_mime VARCHAR(60) NULL,
  ADD COLUMN download_size INT NULL,
  ADD COLUMN password_encrypted TEXT NULL,
  ADD COLUMN password_hint VARCHAR(120) NULL,
  ADD COLUMN updated_at DATETIME NULL;
