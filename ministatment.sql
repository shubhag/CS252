use test;

drop table if exists minis;

CREATE TABLE minis(
user1 VARCHAR(100) NOT NULL,
user2 VARCHAR(100),
transaction VARCHAR(100) NOT NULL,
deposited INT(20),
withdrawl INT(20),
transfer INT(20),
balance INT(20) NOT NULL,
Time Timestamp NOT NULL,
PRIMARY KEY (Time,user1)
);