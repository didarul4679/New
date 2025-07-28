-- Database setup for contact form
CREATE DATABASE IF NOT EXISTS contact_form_db;
USE contact_form_db;

-- Create courses table
CREATE TABLE IF NOT EXISTS courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_name VARCHAR(100) NOT NULL,
    course_code VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample courses
INSERT INTO courses (course_name, course_code) VALUES
('Web Development', 'WD101'),
('Mobile App Development', 'MAD101'),
('Data Science', 'DS101'),
('Digital Marketing', 'DM101'),
('Graphic Design', 'GD101'),
('Cybersecurity', 'CS101'),
('Machine Learning', 'ML101'),
('Database Administration', 'DBA101');

-- Create contacts table
CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    age INT NOT NULL,
    gender ENUM('male', 'female', 'other') NOT NULL,
    password VARCHAR(255) NOT NULL,
    course_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES courses(id)
);