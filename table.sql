use test;
DROP TABLE if exists register;

CREATE TABLE register(
username VARCHAR(100) NOT NULL,
password VARCHAR(100) NOT NULL,
email VARCHAR(100) NOT NULL,
resetstr VARCHAR(200) DEFAULT "helloworld" NOT NULL,
PRIMARY KEY (username)
);
