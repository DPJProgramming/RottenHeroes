

-- Create user table
CREATE TABLE IF NOT EXISTS `user` (
    userId INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    isAdmin BOOLEAN NOT NULL
);

-- Create comment table
CREATE TABLE IF NOT EXISTS comment (
    commentId INT AUTO_INCREMENT PRIMARY KEY,
    body TEXT NOT NULL,
    userId INT NOT NULL,
    userName TEXT NOT NULL,
    rating INT NOT NULL,
    heroId INT NOT NULL,
    isBlog BOOLEAN NOT NULL,
    created_at DATETIME NOT NULL,
    FOREIGN KEY (userId) REFERENCES user(userId)
);

-- Create comment_replies table
CREATE TABLE IF NOT EXISTS comment_replies (
    replyId INT AUTO_INCREMENT PRIMARY KEY,
    commentId INT NOT NULL,
    userId INT NOT NULL,
    FOREIGN KEY (userId) REFERENCES user(userId),
    rating INT NOT NULL,
    FOREIGN KEY (commentId) REFERENCES comment(commentId),
    FOREIGN KEY (userId) REFERENCES user(userId)
);

-- Create hero table  
CREATE TABLE IF NOT EXISTS hero (
    userId INT PRIMARY KEY,
    FOREIGN KEY (userId) REFERENCES user(userId),
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    image VARCHAR(255) NOT NULL,
    rating VARCHAR(255) DEFAULT 'Not Rated',
    strength VARCHAR(255) DEFAULT 'Unknown',
    intellect VARCHAR(255) DEFAULT 'Unknown',
    energy VARCHAR(255) DEFAULT 'Unknown',
    speed VARCHAR(255) DEFAULT 'Unknown',
    powers TEXT DEFAULT 'none'
);

-- insert some heroes
INSERT INTO user (name, email, password, isAdmin) 
VALUES('Spider-Man', 'spiderman@example.com', 'password123', FALSE);
SET @spidermanId = LAST_INSERT_ID();

INSERT INTO user (name, email, password, isAdmin) 
VALUES ('Batman', 'batman@example.com', 'password123', FALSE);
SET @batmanId = LAST_INSERT_ID();

INSERT INTO user (name, email, password, isAdmin) 
VALUES('Kite-Man', 'kiteman@example.com', 'password123', FALSE);
SET @kitemanId = LAST_INSERT_ID();

INSERT INTO user (name, email, password, isAdmin) 
VALUES('Spawn', 'spawn@example.com', 'password123', FALSE);
SET @spawnId = LAST_INSERT_ID();

INSERT INTO user (name, email, password, isAdmin) 
VALUES('Homelander', 'homelander@example.com', 'password123', TRUE);
SET @homelanderId = LAST_INSERT_ID();

-- Insert into hero table
INSERT INTO hero (userId, name, description, image, rating, strength, intellect, energy, speed, powers) 
VALUES
	(@spidermanId, 'Spider-Man', 'A superhero with spider-like abilities.', 'spiderman.jpg', 5, 8, 9, 7, 8, 'Wall-crawling, web-shooting, spider-sense'),
	(@batmanId, 'Batman', 'A vigilante superhero from Gotham City.', 'batman.jpg', 5, 6, 10, 4, 6, 'Martial arts, detective skills, high-tech equipment'),
	(@kitemanId, 'Kite-Man', 'A villain who uses kites to commit crimes.', 'kiteman.jpg', 2, 3, 5, 2, 3, 'Flight with kite'),
	(@spawnId, 'Spawn', 'A former CIA agent who becomes a demonic anti-hero.', 'spawn.jpg', 5, 9, 7, 8, 7, 'Necroplasm powers, immortality'),
	(@homelanderId, 'Homelander', 'A powerful and morally ambiguous superhero.', 'homelander.jpg', 5, 10, 6, 10, 10, 'Flight, super strength, laser vision');
    
    -- Insert regular users
INSERT INTO user (name, email, password, isAdmin) 
VALUES
('Alice', 'alice@example.com', 'password123', FALSE),
('Bob', 'bob@example.com', 'password123', FALSE),
('Charlie', 'charlie@example.com', 'password123', FALSE),
('David', 'david@example.com', 'password123', FALSE),
('Eve', 'eve@example.com', 'password123', FALSE);

-- Insert comments for Spider-Man
INSERT INTO comment (body, userId, userName, rating, heroId, isBlog, created_at) 
VALUES
('Spider-Man is an iconic superhero loved by many!', 6, 'Alice', 85, 1, FALSE, NOW()),
('I admire Spider-Man''s sense of responsibility and bravery.', 7, 'Charlie', 92, 1, FALSE, NOW()),
('Can anyone spot me a cuple bucks for rent?', 1, 'Spider-Man', 85, 1, TRUE, NOW());

-- Insert comments for Batman
INSERT INTO comment (body, userId, userName, rating, heroId, isBlog, created_at) 
VALUES
('Batman is a symbol of justice and determination.', 3, 'Kite-Man', 90, 2, FALSE, NOW()),
('I respect Batman''s intelligence and strategic thinking.', 10, 'Eve', 88, 2, FALSE, NOW()),
('I am BATMAN', 2, 'Batman', 90, 2, TRUE, NOW());

-- Insert comments for Kite-Man
INSERT INTO comment (body, userId, userName, rating, heroId, isBlog, created_at) 
VALUES
('Kite-Man may not be as famous as others, but he has his own style.', 5, 'Homelander', 70, 3, FALSE, NOW()),
('Kite-Man''s kite-themed crimes are quite creative!', 7, 'Bob', 75, 3, FALSE, NOW()),
('I love the wind', 3, ' Kite-Man', 70, 3, TRUE, NOW()),
('I am the coolest', 3, ' Kite-Man', 70, 3, TRUE, NOW()),
('The best way to predict your future is to create it.', 3, ' Kite-Man', 70, 3, TRUE, NOW());

-- Insert comments for Spawn
INSERT INTO comment (body, userId, userName, rating, heroId, isBlog, created_at) VALUES
('Spawn''s dark and gritty story is captivating.', 10, 'Eve', 85, 4, FALSE, NOW()),
('I find Spawn''s anti-hero persona intriguing.', 7, 'Bob', 80, 4, FALSE, NOW()),
('The violator will not escape', 4, 'Spawn', 85, 4, TRUE, NOW()),
('I only have 8945 energy left', 4, 'Spawn', 85, 4, TRUE, NOW()),
('Has anyone seen my wife?', 4, 'Spawn', 85, 4, TRUE, NOW());

-- Insert comments for Homelander
INSERT INTO comment (body, userId, userName, rating, heroId, isBlog, created_at) VALUES
('Homelander''s superpowers make him one of the most formidable heroes.', 9, 'David', 95, 5, FALSE, NOW()),
('Homelander''s guy\'s complexity adds depth to America.', 7, 'Bob', 88, 5, FALSE, NOW()),
('I LOVE YOU!!!', 9, 'David', 88, 5, FALSE, NOW()),
('I LOVE MY FANS', 5, 'Homelander', 88, 5, TRUE, NOW()),
('I AM GREAT', 5, 'Homelander', 88, 5, TRUE, NOW()),
('AMERICA DESERVES ME', 5, 'Homelander', 88, 5, TRUE, NOW());
