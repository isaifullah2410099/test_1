CREATE DATABASE IF NOT EXISTS uiu_collabhub;
USE uiu_collabhub;

CREATE TABLE IF NOT EXISTS users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    student_id VARCHAR(20) UNIQUE NOT NULL,
    name VARCHAR(60) NOT NULL,
    email VARCHAR(80) NOT NULL,
    department VARCHAR(30) NOT NULL,
    password VARCHAR(255) NOT NULL,
    security_question VARCHAR(150) NOT NULL,
    security_answer VARCHAR(255) NOT NULL,
    skills VARCHAR(255),
    bio VARCHAR(500)
);

CREATE TABLE IF NOT EXISTS projects (
    project_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    title VARCHAR(120) NOT NULL,
    project_type VARCHAR(40) NOT NULL,
    description VARCHAR(1000) NOT NULL,
    skills_needed VARCHAR(255) NOT NULL,
    team_size INT NOT NULL,
    deadline DATE,
    status VARCHAR(20) DEFAULT 'Open',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS applications (
    application_id INT PRIMARY KEY AUTO_INCREMENT,
    project_id INT NOT NULL,
    applicant_id INT NOT NULL,
    proposal VARCHAR(700) NOT NULL,
    status VARCHAR(20) DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(project_id, applicant_id)
);

CREATE TABLE IF NOT EXISTS portfolio (
    portfolio_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    title VARCHAR(120) NOT NULL,
    description VARCHAR(700) NOT NULL,
    skills VARCHAR(255)
);


-- =========================
-- DUMMY STUDENTS
-- Password for all students: 123456
-- Security answer for all students: blue
-- =========================

INSERT IGNORE INTO users
(student_id, name, email, department, password, security_question, security_answer, skills, bio)
VALUES
(
    '011223344',
    'Rahim Ahmed',
    'rahim@gmail.com',
    'CSE',
    '$2y$12$poTkD/BLeu53WzMWa5r1pumIoWHIvdJ8pbZpCYjD4sPgRXsP7GIAe',
    'What is your favourite food?',
    '$2y$12$mlyPBfQf9MKBMoKvSWJEfedk3T.RDUd1891MByk/zt45t8.vh9QW6',
    'HTML, CSS, PHP',
    'Interested in web development and student projects.'
),
(
    '011223355',
    'Sara Islam',
    'sara@gmail.com',
    'CSE',
    '$2y$12$poTkD/BLeu53WzMWa5r1pumIoWHIvdJ8pbZpCYjD4sPgRXsP7GIAe',
    'What is your favourite food?',
    '$2y$12$mlyPBfQf9MKBMoKvSWJEfedk3T.RDUd1891MByk/zt45t8.vh9QW6',
    'PHP, MySQL, JavaScript',
    'I enjoy backend development and database projects.'
),
(
    '011223366',
    'Nabil Hasan',
    'nabil@gmail.com',
    'EEE',
    '$2y$12$poTkD/BLeu53WzMWa5r1pumIoWHIvdJ8pbZpCYjD4sPgRXsP7GIAe',
    'What is your favourite food?',
    '$2y$12$mlyPBfQf9MKBMoKvSWJEfedk3T.RDUd1891MByk/zt45t8.vh9QW6',
    'Graphic Design, HTML, CSS',
    'Interested in design and frontend development.'
);


-- =========================
-- DUMMY PROJECTS
-- =========================

INSERT INTO projects
(user_id, title, project_type, description, skills_needed, team_size, deadline, status)
VALUES
(
    (SELECT user_id FROM users WHERE student_id='011223344'),
    'UIU Lost and Found Website',
    'Personal Project',
    'A website where UIU students can post and search for lost items inside the university.',
    'HTML, CSS, PHP, MySQL',
    3,
    '2026-12-15',
    'Open'
);

INSERT INTO projects
(user_id, title, project_type, description, skills_needed, team_size, deadline, status)
VALUES
(
    (SELECT user_id FROM users WHERE student_id='011223355'),
    'Student Research Survey',
    'Research',
    'A web application for collecting survey responses from university students.',
    'PHP, MySQL, HTML',
    4,
    '2026-12-20',
    'Open'
);

INSERT INTO projects
(user_id, title, project_type, description, skills_needed, team_size, deadline, status)
VALUES
(
    (SELECT user_id FROM users WHERE student_id='011223366'),
    'UIU Event Management System',
    'Academic Project',
    'A simple system for displaying university events and managing participants.',
    'HTML, CSS, JavaScript, PHP',
    3,
    '2027-01-10',
    'Open'
);