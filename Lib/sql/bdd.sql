-- SQLBook: Code
CREATE TABLE `Role` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `role` VARCHAR(50) UNIQUE NOT NULL
);

CREATE TABLE `User` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `username` VARCHAR(50) UNIQUE NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `active` BIT NOT NULL DEFAULT 1,
    `id_role` INT NOT NULL,
    FOREIGN KEY (`id_role`) REFERENCES `Role`(`id`)
);

CREATE TABLE `Habitat` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(255),
    `description` TEXT,
    `picture_url` VARCHAR(255)
);

CREATE TABLE `Animal` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(255),
    `breed` VARCHAR(255),
    `picture_url` VARCHAR(255)
    `id_habitat` INT,
    FOREIGN KEY (`id_habitat`) REFERENCES `Habitat`(`id`)
);

CREATE TABLE `Assessment`(
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `state`VARCHAR(20) NOT NULL
);

CREATE TABLE `AnimalReport` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `state` int,
    `proposed_food` VARCHAR(255),
    `food_amount` INT,
    `passage_date` DATE,
    `state_detail` TEXT,
    `id_animal` INT,
    FOREIGN KEY (`id_animal`) REFERENCES `Animal`(`id`),
    FOREIGN KEY (`state`) REFERENCES `Assessment`(`id`)

);

CREATE TABLE `HabitatReport` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `opinion` int,
    `state` int,
    `improvement` TEXT,
    `date` DATE,
    `id_habitat` INT,
    FOREIGN KEY (`id_habitat`) REFERENCES `Habitat`(`id`),
    FOREIGN KEY (`state`) REFERENCES `Assessment`(`id`),
    Foreign Key (`opinion`) REFERENCES `Assessment`(`id`)
);

CREATE TABLE `Review` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `pseudo` VARCHAR(255),
    `review` TEXT,
    `status` BIT
);

CREATE TABLE `Service` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(255),
    `description` TEXT,
    `picture_url`VARCHAR(255),
);

CREATE TABLE `Hour`(
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `day`VARCHAR(20) NOT NULL,
    `opening_time` TIME NOT NULL,
    `closing_time` TIME NOT NULL
);

CREATE TABLE `FoodGiven`(
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `day`VARCHAR(20) NOT NULL,
    `hour` TIME NOT NULL,
    `food` VARCHAR(255) NOT NULL,
    `quantity` VARCHAR(255) NOT NULL,
    `id_user` INT,
    `id_animal` INT,
    FOREIGN KEY (`id_user`) REFERENCES `User`(`id`),
    FOREIGN KEY (`id_animal`) REFERENCES `Animal`(`id`)
);



INSERT INTO `Role` (`role`)
VALUES
    ('Admin'),
    ('Employer'),
    ('Vétérinaire');

INSERT INTO `Assessment` (`state`)
VALUES
    ('Excellent'),
    ('Moyen'),
    ('Mauvais');



INSERT INTO Animal (name, breed) VALUES ('Léo', 'Lion');
INSERT INTO Habitat (name, description) VALUES ('Terre Chaude', 'blablabla');

SELECT * 
FROM `Habitat` h  
LEFT JOIN `Animal` a 
ON a.id_habitat = h.id

