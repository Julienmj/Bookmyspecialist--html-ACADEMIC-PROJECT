-- BookMySpecialist Database Setup
-- Create database if it doesn't exist
CREATE DATABASE IF NOT EXISTS bookmyspecialist_db;

-- Use the database
USE bookmyspecialist_db;

-- Create appointments table
CREATE TABLE IF NOT EXISTS appointments (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    department VARCHAR(100) NOT NULL,
    doctor VARCHAR(200) NOT NULL,
    fullName VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Reset auto increment (optional)
ALTER TABLE appointments AUTO_INCREMENT = 1;
