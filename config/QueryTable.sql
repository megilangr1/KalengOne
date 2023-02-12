
-- Table Users
CREATE TABLE IF NOT EXISTS users (
	id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
	nama_depan VARCHAR(255) NOT NULL,
  nama_belakang VARCHAR(255) NOT NULL,
  username VARCHAR(255) NOT NULL UNIQUE,
  email VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  level TINYINT(4) NOT NULL DEFAULT 0,
  status_verifikasi BOOLEAN DEFAULT 0,
  nama_rekening_pengirim VARCHAR(255) NULL,
	nama_bank_pengirim VARCHAR(255) NULL,
	nama_file VARCHAR(255) NULL,
  lokasi_file TEXT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (id)
);

-- Insert Administrator
-- INSERT INTO users VALUES (null, 'Admin', 'Pro', 'administrator', 'admin@mail.com', 'admin123', 0, now(), now());
INSERT INTO users (nama_depan, nama_belakang, username, email, password, level)
SELECT * FROM (SELECT 'Admin', 'Pro', 'administrator', 'admin@mail.com', 'admin123', 0) AS tmp
WHERE NOT EXISTS (
  SELECT email FROM users WHERE email = 'admin@mail.com'
) LIMIT 1;


-- Table User Verifies
CREATE TABLE IF NOT EXISTS user_verifies (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
	user_id BIGINT UNSIGNED NOT NULL,
  nama_pengirim VARCHAR(255) NOT NULL,
	bank_pengirim VARCHAR(255) NOT NULL,
	nama_file VARCHAR(255) NOT NULL,
  lokasi_file TEXT NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (id)  
);

-- Table Album
-- CREATE TABLE IF NOT EXISTS albums (
-- 	id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
-- 	nama_album VARCHAR(255) NOT NULL,
--   deskripsi TEXT NULL,
--   status BOOLEAN DEFAULT false,
--   publish BOOLEAN DEFAULT false,
--   user_id BIGINT UNSIGNED NOT NULL,
--   created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
--   updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
-- 	PRIMARY KEY (id)
-- );
