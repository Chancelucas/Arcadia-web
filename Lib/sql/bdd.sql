CREATE TABLE `Role` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `role` VARCHAR(50) UNIQUE NOT NULL
);

CREATE TABLE `User` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `username` VARCHAR(50) UNIQUE NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
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

CREATE TABLE `AnimalReport` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `state` VARCHAR(255),
    `proposed_food` VARCHAR(255),
    `food_amount` INT,
    `passage_date` DATE,
    `state_detail` TEXT,
    `id_animal` INT,
    FOREIGN KEY (`id_animal`) REFERENCES `Animal`(`id`)
);

CREATE TABLE `Review` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `pseudo` VARCHAR(255),
    `review` TEXT,
    `status` VARCHAR(255)
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
 
)

INSERT INTO `Role` (`role`)
VALUES
    ('Admin'),
    ('Employer'),
    ('Vétérinaire');



INSERT INTO Animal (name, breed) VALUES ('Léo', 'Lion');
INSERT INTO Habitat (name, description) VALUES ('Terre Chaude', 'blablabla');

SELECT * 
FROM `Habitat` h  
LEFT JOIN `Animal` a 
ON a.id_habitat = h.id

