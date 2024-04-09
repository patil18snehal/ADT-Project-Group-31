-- SNEHAL PATIL
SELECT * FROM indianplaces;

CREATE TABLE Zone (
    zone_id INT AUTO_INCREMENT PRIMARY KEY,
    zone_name VARCHAR(255) NOT NULL
);

INSERT INTO Zone (zone_name)
SELECT DISTINCT Zone
FROM IndianPlaces;

SELECT * FROM Zone;

CREATE TABLE State (
    state_id INT AUTO_INCREMENT PRIMARY KEY,
    state_name VARCHAR(255) NOT NULL,
    zone_id INT,
    FOREIGN KEY (zone_id) REFERENCES Zone(zone_id)
);

INSERT INTO State (state_name, zone_id)
SELECT DISTINCT ip.State, z.zone_id
FROM IndianPlaces ip
JOIN Zone z ON ip.Zone = z.zone_name;

SELECT * FROM State;

CREATE TABLE City (
    city_id INT AUTO_INCREMENT PRIMARY KEY,
    city_name VARCHAR(255) NOT NULL,
    state_id INT,
    FOREIGN KEY (state_id) REFERENCES State(state_id)
);

INSERT INTO City (city_name, state_id)
SELECT DISTINCT ip.City, s.state_id
FROM IndianPlaces ip
JOIN State s ON ip.State = s.state_name;

SELECT * FROM City;

DROP table TouristSpot
-- Create TouristSpot table
CREATE TABLE TouristSpot (
    tourist_spot_id INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL,
    Type VARCHAR(255),
    Establishment_Year INT,
    time_needed_to_visit_in_hrs DECIMAL(5,2),
    Entrance_Fee_in_INR DECIMAL(10,2),
    Airport_with_50km_Radius text,
    Weekly_Off VARCHAR(20),
    Significance VARCHAR(255),
    DSLR_Allowed text,
    Best_Time_to_visit VARCHAR(255),
    City_ID INT,
    FOREIGN KEY (City_ID) REFERENCES City(city_id)
);

-- Transfer data from IndianPlaces to TouristSpot
INSERT INTO TouristSpot (Name, Type, Establishment_Year, time_needed_to_visit_in_hrs, Entrance_Fee_in_INR, Airport_with_50km_Radius, Weekly_Off, Significance, DSLR_Allowed, Best_Time_to_visit, City_ID)
SELECT Name, Type, `Establishment Year`, `time needed to visit in hrs`, `Entrance Fee in INR`, `Airport with 50km Radius`, `Weekly Off`, Significance, `DSLR Allowed`, `Best Time to Visit`, c.city_id
FROM IndianPlaces ip
JOIN City c ON ip.City = c.city_name;

-- Create ReviewRatings table
CREATE TABLE ReviewRatings (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Spot_ID INT,
    Google_Review_Rating DECIMAL(3,2),
    Number_of_Google_Reviews DECIMAL(10,2),
    FOREIGN KEY (Spot_ID) REFERENCES TouristSpot(tourist_spot_id)
);

-- Insert data into ReviewRatings from IndianPlaces
INSERT INTO ReviewRatings ( Google_Review_Rating, Number_of_Google_Reviews)
SELECT  ip.`Google Review Rating`, ip.`Number of google review in lakhs`
FROM IndianPlaces ip;

INSERT INTO ReviewRatings (ID, Google_Review_Rating, Number_of_Google_Reviews, Spot_ID)
SELECT NULL, ip.`Google Review Rating`, ip.`Number of Google Review in lakhs`, ts.tourist_spot_id
FROM IndianPlaces ip
JOIN TouristSpot ts ON ip.Name = ts.Name AND ip.Type = ts.Type;

SELECT * FROM ReviewRatings;


-- Give me list of religious places I can visit in Uttarakhand where DSLR is allowed and Best time to visit is in Morning

SELECT ts.Name, s.State_name, c.city_name,ts.DSLR_Allowed, ts.Best_Time_to_visit
FROM TouristSpot ts 
JOIN City c 
ON ts.city_id = c.city_id
JOIN State s
on c.state_id = s.state_id
WHERE s.state_name = 'Uttarakhand'
AND ts.DSLR_Allowed= 'Yes'
AND ts.Best_Time_to_visit='Morning';


-- Give me historical places in Delhi I can visit in  under 2 hours having google rating more than 3

SELECT name, significance, city_name, Google_Review_Rating
FROM CITY c
JOIN TouristSpot ts
ON ts.City_ID= c.city_id
JOIN ReviewRatings rr
on rr.spot_id = ts.tourist_spot_id
WHERE c.City_name = 'Delhi'
AND significance = 'Historical'
AND time_needed_to_visit_in_hrs <= 2
AND rr.Google_Review_Rating >= 4.5;



