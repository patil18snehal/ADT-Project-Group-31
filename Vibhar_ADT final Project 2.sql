--ADT Final Project 2
--Vidushi Bhargava (vibhar)
--Spring 2024


CREATE TABLE Zone (
    Zone_ID INT AUTO_INCREMENT PRIMARY KEY,
    Zone_Name VARCHAR(100)
);

CREATE TABLE State (
    State_ID INT AUTO_INCREMENT PRIMARY KEY,
    State_Name VARCHAR(100),
    Zone_ID INT,
    FOREIGN KEY (Zone_ID) REFERENCES Zone(Zone_ID)
);

CREATE TABLE City (
    City_ID INT AUTO_INCREMENT PRIMARY KEY,
    City_Name VARCHAR(100),
    State_ID INT,
    FOREIGN KEY (State_ID) REFERENCES State(State_ID)
);

CREATE TABLE TouristSpot (
    Spot_ID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100),
    Type VARCHAR(100),
    Establishment_Year INT,
    Time_Needed DECIMAL(5,2),
    Entrance_Fee_INR DECIMAL(10,2),
    Airport_Within_50km BOOLEAN,
    Weekly_Off VARCHAR(20),
    Significance VARCHAR(100),
    DSLR_Allowed BOOLEAN,
    Best_Time_to_Visit VARCHAR(50),
    City_ID INT,
    FOREIGN KEY (City_ID) REFERENCES City(City_ID)
);

CREATE TABLE ReviewRatings (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Spot_ID INT,
    Google_Review_Rating DECIMAL(3,2),
    Number_of_Google_Reviews DECIMAL(10,2),
    FOREIGN KEY (Spot_ID) REFERENCES TouristSpot(Spot_ID)
);

INSERT INTO Zone (Zone_Name)
SELECT DISTINCT Zone
FROM top_indian_places_to_visit;

SELECT * FROM Zone;

INSERT INTO State (State_Name, Zone_ID)
SELECT DISTINCT State, z.Zone_ID
FROM top_indian_places_to_visit t
JOIN Zone z ON t.Zone = z.Zone_Name;

SELECT * FROM State;

INSERT INTO City (City_Name, State_ID)
SELECT DISTINCT City, s.State_ID
FROM top_indian_places_to_visit t
JOIN State s ON t.State = s.State_Name;

SELECT * FROM City;

INSERT INTO TouristSpot (Name, Type, Establishment_Year, Time_Needed,  Entrance_Fee_INR, Airport_Within_50km, Weekly_Off, Significance, DSLR_Allowed, Best_Time_to_Visit, City_ID)
SELECT Name, Type, Establishment_Year, time_needed_to_visit_in_hrs, Entrance_Fee_in_INR, Airport_with_50km_Radius, Weekly_Off, Significance, DSLR_Allowed,Best_Time_to_visit, c.City_ID
FROM visit t
JOIN City c ON t.City = c.City_Name;

SELECT * FROM TouristSpot ;

INSERT INTO ReviewRatings (ID, Google_Review_Rating, Number_of_Google_Reviews, Spot_ID)
SELECT NULL, Google_review_rating, Number_of_google_review_in_lakhs, s.Spot_ID
FROM visit t
JOIN TouristSpot s ON t.Name = s.Name AND t.Type = s.Type;

SELECT * FROM ReviewRatings;


-- Average Google Rating of top 10 Spots in Maharashtra 
SELECT t.City_ID, c.City_Name, t.Name,AVG(rr.Google_Review_Rating) AS Avg_Review_Rating
FROM TouristSpot t
JOIN ReviewRatings rr ON t.Spot_ID = rr.Spot_ID
JOIN CITY c ON t.CITY_ID = c.City_ID
JOIN State s ON s.State_ID = c.City_ID
WHERE State_Name = "Maharastra"
GROUP BY t.City_ID, c.City_Name,t.Name
ORDER BY Avg_Review_Rating desc
LIMIT 10 ;

SELECT Name, Type, Entrance_Fee_INR, DSLR_Allowed
FROM TouristSpot t
JOIN ReviewRatings ON t.Spot_ID = ReviewRatings.Spot_ID
join City ON City.City_ID = t.City_ID
WHERE Best_Time_to_Visit = 'Afternoon' or Best_Time_to_Visit =  'Evening'
and Google_Review_Rating > 4.50
And City.City_Name = 'Mysore';

SELECT * FROM City;








