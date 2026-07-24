CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user VARCHAR(255) NOT NULL,
    pass VARCHAR(255) NOT NULL
);
CREATE TABLE files (
    id INT AUTO_INCREMENT PRIMARY KEY,
    filename VARCHAR(255) NOT NULL,
    pathfile VARCHAR(255) NOT NULL,
    filetype VARCHAR(100),
    filesize INT,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
CREATE TABLE music (
    id INT AUTO_INCREMENT PRIMARY KEY,
    filename VARCHAR(255) NOT NULL,
    filepath VARCHAR(255) NOT NULL,
    filetype VARCHAR(100),
    filesize INT,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
CREATE TABLE foto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    filename VARCHAR(255) NOT NULL,
    filepath VARCHAR(255) NOT NULL,
    filetype VARCHAR(100),
    filesize INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id)
);



