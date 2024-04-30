CREATE DATABASE IF NOT EXISTS swiftkeys;
USE swiftkeys;

CREATE TABLE IF NOT EXISTS users (
    id int PRIMARY KEY AUTO_INCREMENT,
    username varchar(25) UNIQUE NOT NULL,
    email varchar(50) UNIQUE NOT NULL,
    phone varchar(20) NOT NULL,
    pass varchar(100) NOT NULL,
    isAdmin boolean NOT NULL DEFAULT 0,
    createdOn DATETIME NOT NULL DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS quotes (
    quoteId int PRIMARY KEY AUTO_INCREMENT,
    quote varchar(2000) UNIQUE NOT NULL,
    difficulty varchar(10) NOT NULL,
    quoteNumWords int NOT NULL,
    createdOn DATETIME NOT NULL DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS submissions (
    submissionId int PRIMARY KEY AUTO_INCREMENT,
    userId int NOT NULL,
    quoteId int NOT NULL,
    timeTaken float NOT NULL,
    typingSpeedInWpm float NOT NULL,
    createdOn DATETIME NOT NULL DEFAULT NOW(),
    FOREIGN KEY (userId) REFERENCES users(id),
    FOREIGN KEY (quoteId) REFERENCES quotes(quoteId)
);

INSERT INTO quotes (quote, difficulty, quoteNumWords) VALUES("Nice day eh?", "easy", 3);
INSERT INTO quotes (quote, difficulty, quoteNumWords) VALUES("Nice day eht?", "easy", 3);
INSERT INTO quotes (quote, difficulty, quoteNumWords) VALUES("It's time for a milkshake.", "medium", 5);
INSERT INTO quotes (quote, difficulty, quoteNumWords) VALUES("It's shaping up to be a wonderful holiday - not your normal, average everyday.", "hard", 13);
INSERT INTO quotes (quote, difficulty, quoteNumWords) VALUES("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad", "hard", 22);