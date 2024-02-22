CREATE TABLE Role (
    roleId INT PRIMARY KEY AUTO_INCREMENT,
    roleName VARCHAR(50) UNIQUE NOT NULL
);


CREATE TABLE User (
    userId INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(255) NOT NULL,
    password CHAR(60) NOT NULL,
    roleId INT,
    FOREIGN KEY (roleId) REFERENCES Role(roleId)
);


CREATE TABLE Habitat (
    habitatId INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    description TEXT
);

CREATE TABLE Animal (
    animalId INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    breed VARCHAR(255),
    habitatId INT,
    FOREIGN KEY (habitatId) REFERENCES Habitat(habitatId)
);

CREATE TABLE AnimalReport (
    reportId INT PRIMARY KEY AUTO_INCREMENT,
    animalId INT,
    state VARCHAR(255),
    proposedFood VARCHAR(255),
    foodAmount INT,
    passageDate DATE,
    stateDetail TEXT,
    FOREIGN KEY (animalId) REFERENCES Animal(animalId)
);

CREATE TABLE Review (
    reviewId INT PRIMARY KEY AUTO_INCREMENT,
    pseudo VARCHAR(255),
    review TEXT,
    status VARCHAR(255)
);

CREATE TABLE Service (
    serviceId INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    description TEXT
);

INSERT INTO Role (roleName) VALUES ('admin'), ('employee'), ('veterinarian');
INSERT INTO User (username, email, password, roleId) VALUES ('bfciuyea', 'admin@test.com', '123', 1);
INSERT INTO User (username, email, password, roleId) VALUES ('aaaaa', 'a@a', 'a', 1);
INSERT INTO User (username, email, password, roleId) VALUES ('btgrfreshr', 'employee@test.com', '123', 2);
INSERT INTO User (username, email, password, roleId) VALUES ('feazffrez', 'vet@test.com', '123', 3);

INSERT INTO Animal (name, breed) VALUES ('Léo', 'Lion');
INSERT INTO Animal (name, breed) VALUES ('Milo', 'Tigre');
INSERT INTO Animal (name, breed) VALUES ('Luna', 'Panthère');
INSERT INTO Animal (name, breed) VALUES ('Max', 'Jaguar');
INSERT INTO Animal (name, breed) VALUES ('Bella', 'Lynx');
INSERT INTO Animal (name, breed) VALUES ('Simba', 'Leopard');
INSERT INTO Animal (name, breed) VALUES ('Nala', 'Guépard');
INSERT INTO Animal (name, breed) VALUES ('Rocky', 'Ours');
INSERT INTO Animal (name, breed) VALUES ('Buddy', 'Loup');
INSERT INTO Animal (name, breed) VALUES ('Ginger', 'Renard');




