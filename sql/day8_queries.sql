-- DAY 8 SQL PRACTICE
-- Database: Facility Management System

-- 1. Create tables

CREATE TABLE departments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT
);

CREATE TABLE employees (
    id INT PRIMARY KEY AUTO_INCREMENT,
    department_id INT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE,
    position VARCHAR(100),
    salary DECIMAL(10,2),
    FOREIGN KEY (department_id) REFERENCES departments(id)
);

CREATE TABLE facilities (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(150) NOT NULL,
    location VARCHAR(150),
    description TEXT
);

CREATE TABLE inspections (
    id INT PRIMARY KEY AUTO_INCREMENT,
    facility_id INT,
    employee_id INT,
    inspection_date DATE,
    status VARCHAR(50),
    remarks TEXT,
    FOREIGN KEY (facility_id) REFERENCES facilities(id),
    FOREIGN KEY (employee_id) REFERENCES employees(id)
);

CREATE TABLE complaints (
    id INT PRIMARY KEY AUTO_INCREMENT,
    facility_id INT,
    title VARCHAR(200),
    description TEXT,
    status VARCHAR(50) DEFAULT 'Pending',
    FOREIGN KEY (facility_id) REFERENCES facilities(id)
);

-- 2. Insert sample data

INSERT INTO departments (name, description)
VALUES
('Computer Science', 'Computer Science Department'),
('Human Resources', 'Human Resources Department');

INSERT INTO employees
(department_id, name, email, position, salary)
VALUES
(1, 'Rahul Sharma', 'rahul@example.com', 'Software Developer', 45000),
(1, 'Priya Patil', 'priya@example.com', 'Data Analyst', 50000),
(2, 'Amit Joshi', 'amit@example.com', 'HR Manager', 60000);

INSERT INTO facilities (name, location, description)
VALUES
('City Hospital', 'Nagpur', 'Main public healthcare facility'),
('Community Hall', 'Amravati', 'Public community facility');

INSERT INTO inspections
(facility_id, employee_id, inspection_date, status, remarks)
VALUES
(1, 1, '2026-09-29', 'Good', 'Facility inspection completed successfully'),
(2, 2, '2026-09-28', 'Needs Improvement', 'Some maintenance is required');

INSERT INTO complaints
(facility_id, title, description, status)
VALUES
(1, 'Water Supply Issue', 'Water supply is not available properly.', 'Pending'),
(1, 'Cleanliness Issue', 'Facility requires better cleaning.', 'Resolved'),
(2, 'Maintenance Issue', 'Some equipment needs maintenance.', 'Pending');

-- 3. Employees in a department

SELECT e.name, e.position, e.salary
FROM employees e
JOIN departments d
ON e.department_id = d.id
WHERE d.name = 'Computer Science';

-- 4. Average salary

SELECT AVG(salary) AS average_salary
FROM employees;

-- 5. Highest-paid employee

SELECT *
FROM employees
ORDER BY salary DESC
LIMIT 1;

-- 6. Facilities requiring attention

SELECT *
FROM facilities
WHERE id IN (
    SELECT facility_id
    FROM inspections
    WHERE status = 'Needs Improvement'
);

-- 7. Complaint count for each facility

SELECT f.name, COUNT(c.id) AS complaint_count
FROM facilities f
LEFT JOIN complaints c
ON f.id = c.facility_id
GROUP BY f.id, f.name;

-- 8. Inspection history

SELECT
    f.name AS facility,
    e.name AS inspector,
    i.inspection_date,
    i.status,
    i.remarks
FROM inspections i
JOIN facilities f
ON i.facility_id = f.id
JOIN employees e
ON i.employee_id = e.id
ORDER BY i.inspection_date DESC;