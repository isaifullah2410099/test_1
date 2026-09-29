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
