-- Create database
CREATE DATABASE IF NOT EXISTS contact_db;
USE contact_db;

-- Create contacts table
CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    age INT NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    course VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert some sample data for testing
INSERT INTO contacts (name, email, age, gender, course) VALUES
('John Doe', 'john@example.com', 25, 'Male', 'Computer Science'),
('Jane Smith', 'jane@example.com', 22, 'Female', 'Business Administration'),
('Mike Johnson', 'mike@example.com', 28, 'Male', 'Engineering');