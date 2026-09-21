-- ONLY run this if you already created todo_db earlier (old version without login).
-- This adds the users table and links tasks to users.
-- If you're starting FRESH, ignore this file and just use database.sql instead.

USE todo_db;

CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Add user_id column to existing tasks table
ALTER TABLE tasks ADD COLUMN user_id INT(11) NOT NULL DEFAULT 1 AFTER id;
ALTER TABLE tasks ADD FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE;

-- Note: any old tasks will be assigned to user_id = 1.
-- Create your account via register.php first (it will likely become user_id = 1),
-- or manually update old rows in phpMyAdmin after creating your account.
