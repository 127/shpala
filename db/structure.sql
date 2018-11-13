CREATE TABLE shpala_schema_migrations (
  version varchar(255) NOT NULL,
  UNIQUE KEY `shpala_unique_schema_migrations` (`version`)
) ENGINE=InnoDB;

CREATE TABLE shpala_articles (
	id INT NOT NULL AUTO_INCREMENT,
	url VARCHAR(150) NOT NULL UNIQUE,
	keywords VARCHAR(255) NOT NULL,
	author VARCHAR(100) NOT NULL,
	source VARCHAR(150) NOT NULL,
	title VARCHAR(255) NOT NULL,
	preview TEXT NOT NULL,
	body TEXT NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	uuid VARCHAR(100) NOT NULL UNIQUE,
	PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=0;

CREATE TABLE shpala_tags (
	id INT NOT NULL AUTO_INCREMENT,
	url VARCHAR(150) NOT NULL UNIQUE,
	title VARCHAR(255) NOT NULL, 
	description VARCHAR(255) NOT NULL,
	keywords VARCHAR(255) NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=0;

CREATE TABLE shpala_tags_articles (
	tag_id INT NOT NULL,
	article_id INT NOT NULL,
    KEY `shpala_tags_articles_tag_id_fk` (`tag_id`),
    KEY `shpala_tags_articles_article_id_fk` (`article_id`),
    CONSTRAINT `shpala_tags_articles_tag_id_fk` FOREIGN KEY (`tag_id`) REFERENCES `shpala_tags` (`id`),
    CONSTRAINT `shpala_tags_articles_article_id_fk` FOREIGN KEY (`article_id`) REFERENCES `shpala_articles` (`id`)
) ENGINE=InnoDB;