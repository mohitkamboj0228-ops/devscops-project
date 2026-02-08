CREATE TABLE users (
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100),
 email VARCHAR(100) UNIQUE,
 password VARCHAR(255),
 role ENUM('admin','architect','engineer','contractor','electrician','plumber','labor','shopkeeper','customer'),
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE projects (
 id INT AUTO_INCREMENT PRIMARY KEY,
 customer_id INT,
 architect_id INT,
 title VARCHAR(150),
 description TEXT,
 status ENUM('pending','approved','rejected') DEFAULT 'pending',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE messages (
 id INT AUTO_INCREMENT PRIMARY KEY,
 sender_id INT,
 receiver_id INT,
 message TEXT,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
