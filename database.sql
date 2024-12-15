CREATE DATABASE IF NOT EXISTS letter_edu;

USE letter_edu;

CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(30) NOT NULL,
    last_name VARCHAR(30) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    username VARCHAR(30) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    profile_picture VARCHAR(255) DEFAULT 'default.png',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE contact (
    id INT AUTO_INCREMENT PRIMARY KEY,
    twitter VARCHAR(255),
    facebook VARCHAR(255),
    instagram VARCHAR(255),
    linkedin VARCHAR(255)
);

INSERT INTO
    users (
        first_name,
        last_name,
        email,
        username,
        password
    )
VALUES
    (
        'Iqbolshoh',
        'Ilhomjonov',
        'iilhomjonov777@gmail.com',
        'iqbolshoh',
        '65c2a32982abe41b1e6ff888d351ee6b7ade33affd4a595667ea7db910aecaa8'
    ),
    (
        'user',
        'user',
        'user@gmail.com',
        'user',
        '65c2a32982abe41b1e6ff888d351ee6b7ade33affd4a595667ea7db910aecaa8'
    )