CREATE TABLE shpala_schema_migrations (
  version varchar(255) NOT NULL,
  UNIQUE KEY `shpala_unique_schema_migrations` (`version`)
) ENGINE=InnoDB;