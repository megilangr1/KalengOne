
-- Table Users
-- DROP TABLE users;
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
INSERT INTO users (nama_depan, nama_belakang, username, email, password, level, status_verifikasi)
SELECT * FROM (SELECT 'Admin', 'Pro', 'administrator', 'admin@mail.com', 'admin123', 0, 1) AS tmp
WHERE NOT EXISTS (
  SELECT email FROM users WHERE email = 'admin@mail.com'
) LIMIT 1;


-- Table Album
-- DROP TABLE albums;
CREATE TABLE IF NOT EXISTS albums (
	id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
	nama_album VARCHAR(255) NOT NULL,
  tanggal_rilis DATE NOT NULL,
  studio TEXT NULL,
	genre_album VARCHAR(255) NOT NULL,

	file_album VARCHAR(255) NULL,
  lokasi_file TEXT NULL,
  user_id BIGINT UNSIGNED NOT NULL,
  
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (id)
);
