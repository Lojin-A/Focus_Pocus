-- Create the database
CREATE DATABASE focus_pocus_db;
USE focus_pocus_db;

-- 1. Users Table
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Weekly Voting Table 
CREATE TABLE weekly_votes (
    vote_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    game_name VARCHAR(50),
    voted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- 3. Whack-a-Mole Scores 
CREATE TABLE score_whack (
    stat_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNIQUE, -- UNIQUE ensures one summary row per player
    total_played INT DEFAULT 0,
    total_wins INT DEFAULT 0,
    total_losses INT DEFAULT 0,
    high_score INT DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- 4. Guess the Number Scores 
CREATE TABLE score_guess (
    stat_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNIQUE,
    total_played INT DEFAULT 0,
    fewest_attempts INT DEFAULT 0, -- 0 means they haven't won yet!
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- 5. Memory Match Scores 
CREATE TABLE score_memory (
    stat_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNIQUE,
    total_played INT DEFAULT 0,
    total_wins INT DEFAULT 0,
    total_losses INT DEFAULT 0,
    fewest_flips INT DEFAULT 0,
    best_time_seconds INT DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- 6. Rock Paper Scissors Scores
CREATE TABLE score_rps (
    stat_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNIQUE,
    total_played INT DEFAULT 0,
    total_wins INT DEFAULT 0,
    total_losses INT DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Insert a test user so your games have a 'Player' to record scores for
INSERT IGNORE INTO users (user_id, username, email) VALUES (1, 'GuestPlayer', 'guest@example.com');