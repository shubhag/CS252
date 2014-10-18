use test;
DROP TABLE if exists upfiles;

CREATE TABLE upfiles(
User VARCHAR(100) NOT NULL,
IsSaved VARCHAR(10) NOT NULL,
OriginalFilename VARCHAR(100) NOT NULL,
ModifiedFilename VARCHAR(100) NOT NULL,
Time Timestamp NOT NULL
);