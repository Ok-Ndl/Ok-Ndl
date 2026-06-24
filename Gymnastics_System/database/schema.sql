CREATE DATABASE IF NOT EXISTS gymnastics_system;
USE gymnastics_system;

CREATE TABLE IF NOT EXISTS gymnasts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(100) NOT NULL,
  membership_id VARCHAR(30) NOT NULL UNIQUE,
  email VARCHAR(100) NOT NULL UNIQUE,
  contact_no VARCHAR(30) NOT NULL,
  date_of_birth DATE NOT NULL,
  training_program VARCHAR(30) NOT NULL,
  enrollment_date DATE NOT NULL,
  status VARCHAR(20) NOT NULL DEFAULT 'ACTIVE',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CHECK (status IN ('ACTIVE','ON_HOLD','COMPLETED','PENDING')),
  CHECK (training_program IN ('Beginner','Intermediate','Advanced'))
);
