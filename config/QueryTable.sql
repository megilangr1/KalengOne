
-- Table Users
CREATE TABLE IF NOT EXISTS users (
	id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
	nama_depan VARCHAR(255) NOT NULL,
  nama_belakang VARCHAR(255) NOT NULL,
  username varchar(255) NOT NULL UNIQUE,
  email varchar(255) NOT NULL UNIQUE,
  password varchar(255) NOT NULL,
  level TINYINT(4) NOT NULL DEFAULT 0,
	PRIMARY KEY (id)
);
