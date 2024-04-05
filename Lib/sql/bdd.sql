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
    `photo_url` VARCHAR(255)
);

CREATE TABLE `Animal` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(255),
    `breed` VARCHAR(255),
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
    `description` TEXT
);

INSERT INTO `Role` (`role`)
VALUES
    ('Admin'),
    ('Employer'),
    ('Vétérinaire');

-- INSERT INTO User (username, email, password, role) VALUES ('fregreaagera', 'admin@admin.com', 'azerty', 'Admin');
-- INSERT INTO User (username, email, password, role) VALUES ('Admgferazfgerain', 'Employerr@Employerr.com', 'azerty', 'Employer');
-- INSERT INTO User (username, email, password, role) VALUES ('Agreagreadmin', 'Vétérinaire@Vétérinaire.com', 'azerty', 'Vétérinaire');
-- INSERT INTO User (username, email, password, role) VALUES ('Admgreagreain', 'Vétérinairee@Vétérinairee.com', 'azerty', 'Vétérinaire');
-- INSERT INTO User (username, email, password, role) VALUES ('gtrzgtrz', 'a@a', 'a', 'Admin');