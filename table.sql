use test;
DROP TABLE if exists register;

CREATE TABLE register(
account INT(15) NOT NULL AUTO_INCREMENT,
username VARCHAR(100) NOT NULL UNIQUE,
password VARCHAR(100) NOT NULL,
email VARCHAR(100) NOT NULL,
resetstr VARCHAR(200) DEFAULT "helloworld" NOT NULL,
PRIMARY KEY (account)
);
