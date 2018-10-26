DROP DATABASE IF EXISTS development_shpala;
CREATE DATABASE development_shpala CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS articles (
	id INT NOT NULL AUTO_INCREMENT,
	url VARCHAR(100) NOT NULL UNIQUE,
	keywords VARCHAR(255) NOT NULL,
	author VARCHAR(100) NOT NULL,
	source VARCHAR(150) NOT NULL,
	title VARCHAR(255) NOT NULL,
	preview TEXT NOT NULL,
	body TEXT NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (id)
);