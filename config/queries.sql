CREATE DATABASE garden
    DEFAULT CHARACTER SET = 'utf8mb4';

use garden;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE themes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    color VARCHAR(20) NOT NULL,
    user_id INT NOT NULL,

    CONSTRAINT fk_theme_user
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE CASCADE
);

CREATE TABLE notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    content TEXT NOT NULL,
    importance INT NOT NULL CHECK (importance BETWEEN 1 AND 5),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    user_id INT NOT NULL,
    theme_id INT NOT NULL,

    CONSTRAINT fk_note_user
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE CASCADE,

    CONSTRAINT fk_note_theme
    FOREIGN KEY (theme_id) REFERENCES themes(id)
    ON DELETE CASCADE
);

CREATE TABLE tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);

INSERT INTO themes (name, color, user_id) VALUES
('Productivity', '#22c55e', 1),
('Travel', '#3b82f6', 1),
('Ideas', '#f59e0b', 1);

INSERT INTO notes (title, content, importance, user_id, theme_id) VALUES
(
  'Daily planning',
  'Create a daily to-do list and prioritize tasks.',
  4,
  1,
  1
),
(
  'Learn Tailwind',
  'Practice Tailwind CSS to improve UI design.',
  3,
  1,
  1
);

CREATE TABLE tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    user_id INT NOT NULL,
    UNIQUE (name, user_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE theme_tag (
    theme_id INT NOT NULL,
    tag_id INT NOT NULL,
    PRIMARY KEY (theme_id, tag_id),
    FOREIGN KEY (theme_id) REFERENCES themes(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
);

CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title ENUM("admin","gardener") DEFAULT "gardener" NOT NULL
);

CREATE TABLE user_role (
    user_id INT NOT NULL,
    role_id INT NOT NULL,
    PRIMARY KEY (user_id, role_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
);


