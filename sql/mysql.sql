
#
# Structure table for `quotes_quote` (7 fields)
#

CREATE TABLE  `quotes_quote` (
`id` INT (11)  NOT NULL  AUTO_INCREMENT,
`cid` INT (8)  NOT NULL DEFAULT 0,
`author_id` INT  NOT NULL ,
`quote` TEXT  NOT NULL ,
`online` TINYINT (1)  NOT NULL DEFAULT 1,
`created` INT (11) UNSIGNED NOT NULL ,
`updated` INT (11) UNSIGNED NOT NULL DEFAULT 0,
PRIMARY KEY (`id`)
) 
  ENGINE = MyISAM;
#
# Structure table for `quotes_category` (8 fields)
#

CREATE TABLE  `quotes_category` (
`id` INT (8)  NOT NULL  AUTO_INCREMENT,
`pid` INT (8)  NOT NULL DEFAULT 0,
`title` VARCHAR (255)  NOT NULL ,
`description` TEXT  NULL ,
`image` VARCHAR (255)  NULL ,
`weight` INT (5)  NOT NULL DEFAULT 0,
`color` VARCHAR (10)  NOT NULL DEFAULT '0',
`online` TINYINT (1)  NOT NULL DEFAULT 1,
PRIMARY KEY (`id`)
) 
  ENGINE = MyISAM;
#
# Structure table for `quotes_author` (7 fields)
#

CREATE TABLE  `quotes_author` (
`id` INT (8)  NOT NULL  AUTO_INCREMENT,
`name` VARCHAR (50)  NOT NULL ,
`country` VARCHAR (3)  NOT NULL ,
`bio` TEXT  NOT NULL ,
`photo` VARCHAR (50)  NOT NULL ,
`created` INT (11) UNSIGNED NOT NULL DEFAULT 0,
`updated` INT (11)  NOT NULL DEFAULT 0,
PRIMARY KEY (`id`)
) 
  ENGINE = MyISAM;