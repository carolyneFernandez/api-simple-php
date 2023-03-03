CREATE DATABASE IF NOT EXISTS clinique DEFAULT CHARACTER SET utf8mb4;

USE clinique;

CREATE TABLE IF NOT EXISTS owner (
    owner_id  BIGINT(20) NOT NULL AUTO_INCREMENT,
    name VARCHAR(64) NOT NULL,
    lastname VARCHAR(64) NOT NULL,
    phone BIGINT(10) NOT NULL,
    CREATION_DATE TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (owner_id)
    ) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;

INSERT INTO owner ( name,lastname, phone) VALUES 
("Micke","Smith", "0968742569"), 
("Tomas","Jones", "0666321547"), 
("Elias", "Brown","0621355547"), 
("Norway","Wilson","0621456387"), 
("Mary","Cooper","0687412358"), 
("Michelle", "Jones", "0658697412"), 
("Michael","Clark", "0647896588"), 
("Sarah", "Davies",   "0774521144"), 
("Martin", "Taylor","0774521144"),
("Oliver", "Murphy","06632522"),
("Charlie","Walsh", "07884411"), 
("Mason", "Byrne","07896325"), 
("Amelia", "Johnson","0755369865");

CREATE TABLE IF NOT EXISTS animal (
    animal_id BIGINT(20) NOT NULL AUTO_INCREMENT,
    owner_id VARCHAR(64) NOT NULL,
    name VARCHAR(64) NOT NULL,
    type ENUM("DOG", "CAT", "RABBIT", "HAMSTER","BUDGIE") NOT NULL,
    PRIMARY KEY (animal_id)
    ) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;

INSERT INTO animal (owner_id, name, type) VALUES
(1, "Bailey", "DOG"),
(1, "Bella", "CAT"),
(2, "Tawna", "BUDGIE"),
(2, "Whoopi", "HAMSTER"),
(3, "Bailey", "DOG"),
(3, "Bella", "CAT"),
(4, "Darla", "RABBIT"),
(4, "Dunglas", "HAMSTER"),
(5, "Buddy", "DOG"),
(6, "Layna", "CAT"),
(7, "Lyndel", "BUDGIE"),
(8, "Shana", "RABBIT"),
(9, "Janet", "RABBIT"),
(9, "Ruby", "HAMSTER"),
(9, "Haley", "DOG"),
(10, "Abee", "CAT"),
(10, "Sally", "BUDGIE"),
(13, "Lilith", "HAMSTER"),
(11, "Abee", "RABBIT"),
(11, "Shelly", "HAMSTER"),
(12, "Buddy", "DOG"),
(12, "Leah", "CAT");
