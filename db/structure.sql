CREATE TABLE shpala_schema_migrations (
  version varchar(255) NOT NULL,
  UNIQUE KEY `shpala_unique_schema_migrations` (`version`)
) ENGINE=InnoDB;

CREATE TABLE shpala_examples (
		id INT NOT NULL AUTO_INCREMENT,
		url VARCHAR(150) NOT NULL,	
		PRIMARY KEY (id)
) ENGINE=InnoDB;