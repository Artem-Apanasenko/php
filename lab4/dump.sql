CREATE DATABASE users_db;
USE users_db;

CREATE TABLE users (
                       id INT PRIMARY KEY IDENTITY(1,1),
                       username VARCHAR(50) UNIQUE NOT NULL,
                       email VARCHAR(100) UNIQUE NOT NULL,
                       password VARCHAR(255) NOT NULL
);
