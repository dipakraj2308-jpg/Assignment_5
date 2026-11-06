CREATE DATABASE IF NOT EXISTS lab5_db;
USE lab5_db;

CREATE TABLE `2024CSB082` (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50),
  gender VARCHAR(10),
  dept VARCHAR(30),
  marks INT
);

INSERT INTO `2024CSB082` (name, gender, dept, marks) VALUES
('Rahul Das', 'Male', 'CSE', 85),
('Priya Sen', 'Female', 'ECE', 72),
('Amit Roy', 'Male', 'ME', 58),
('Sneha Paul', 'Female', 'CSE', 91),
('Arjun Ghosh', 'Male', 'IT', 66);