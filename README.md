# EdCamps
COEN 161 Final Project


#Creating the mysql Database on your machine

CREATE DATABASE EdCamps;


create TABLE Comments (name VARCHAR(30), createdAt DATE, comment VARCHAR(300));


create TABLE Students(name VARCHAR(30), dob DATE, parentName VARCHAR(30), parentEmail VARCHAR(20), parentPhone VARCHAR(15), grade INT, school VARCHAR(30), specialInstructions VARCHAR(100), creditCard VARCHAR(20), duration INT);


create TABLE Camps(location VARCHAR(20), startDate date, endDate date, description VARCHAR(100))

create TABLE Catalog(name VARCHAR(30), price float, id VARCHAR(10));