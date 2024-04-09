-- ADT Final Project 2
-- Utkarsh Bhosekar
-- Spring 2024

-- Creating the Users table
CREATE TABLE users (
    User_id INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(50) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    Email_id VARCHAR(100) NOT NULL UNIQUE
);

INSERT INTO users (Username, Password, Email_id) VALUES ('vibhar', '12345', 'vibhar@iu.edu');
INSERT INTO users (Username, Password, Email_id) VALUES ('patilsn', '12345', 'patiln@iu.edu');
INSERT INTO users (Username, Password, Email_id) VALUES ('ubhoseka', '12345', 'ubhoseka@iu.edu');

SELECT * FROM users;

-- Creating empty wishlist table for users to add spots
CREATE TABLE wishlist(
	Wishlist_id INT AUTO_INCREMENT PRIMARY KEY,
	User_id_fk INT,
	Spot_ID_fk INT UNIQUE,
	FOREIGN KEY (User_id_fk) REFERENCES users(User_id),
	FOREIGN KEY (Spot_ID_fk) REFERENCES TouristSpot(Spot_ID)
);

SELECT * FROM wishlist;


-- Spots to visit in Delhi with avg rating of 4.5
SELECT DISTINCT t.City_ID, c.City_Name, t.Name
FROM touristspot t, city c, reviewratings rr
WHERE c.City_name = 'Delhi'
	AND rr.Google_Review_Rating > 4.5
LIMIT 10;
