CREATE TABLE Role (
    id_Role INT PRIMARY KEY AUTO_INCREMENT,
    role VARCHAR(50) UNIQUE NOT NULL
);


CREATE TABLE User (
    id_User INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50),
    FOREIGN KEY (role) REFERENCES Role(role)
);


CREATE TABLE Habitat (
    id_Habitat INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    description TEXT,
    photo_url VARCHAR(255)
);

CREATE TABLE Animal (
    id_Animal INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    breed VARCHAR(255),
    id_Habitat INT,
    FOREIGN KEY (id_Habitat) REFERENCES Habitat(id_Habitat)
);

CREATE TABLE AnimalReport (
    id_AnimalReport INT PRIMARY KEY AUTO_INCREMENT,
    state VARCHAR(255),
    proposedFood VARCHAR(255),
    foodAmount INT,
    passageDate DATE,
    stateDetail TEXT,
    id_Animal INT,
    FOREIGN KEY (id_Animal) REFERENCES Animal(id_Animal)
);

CREATE TABLE Review (
    id_Review INT PRIMARY KEY AUTO_INCREMENT,
    pseudo VARCHAR(255),
    review TEXT,
    status VARCHAR(255)
);

CREATE TABLE Service (
    id_Service INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    description TEXT
);

INSERT INTO Role (role) VALUES ('Admin'), ('Employer'), ('Vétérinaire');

INSERT INTO User (username, email, password, role) VALUES ('fregreaagera', 'admin@admin.com', 'azerty', 'Admin');
INSERT INTO User (username, email, password, role) VALUES ('Admgferazfgerain', 'Employerr@Employerr.com', 'azerty', 'Employer');
INSERT INTO User (username, email, password, role) VALUES ('Agreagreadmin', 'Vétérinaire@Vétérinaire.com', 'azerty', 'Vétérinaire');
INSERT INTO User (username, email, password, role) VALUES ('Admgreagreain', 'Vétérinairee@Vétérinairee.com', 'azerty', 'Vétérinaire');







