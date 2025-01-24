CREATE DATABASE wallet ENCODING = 'UTF8';

-------------------------------------------------------------------------------------------------------------

CREATE TABLE operation (
    id SERIAL PRIMARY KEY,
    account VARCHAR (255) NOT NULL,
    date_time TIMESTAMP NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    type VARCHAR (50) NOT NULL,
    category VARCHAR (255) NOT NULL
);

INSERT INTO operation (account, date_time, amount, type, category) VALUES (?, ?, ?, ?, ?);

-------------------------------------------------------------------------------------------------------------

-- Création de la table Client
CREATE TABLE Client (
    id SERIAL PRIMARY KEY,
    nomClient VARCHAR(100) NOT NULL,
    prenomClient VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    password_reset_token VARCHAR(255),
    token_expiration TIMESTAMP
);
-- pour inserer le client utilise la fonction insertClient dans process.php qui va hasher le MDP avec BCRYPT

-- indexing the email column to speed up the search
ALTER TABLE client ADD CONSTRAINT unique_email UNIQUE (email);
CREATE INDEX idx_email ON client(email);

-- Création de la table TypeCompte
CREATE TABLE typecompte (
    id SERIAL PRIMARY KEY,
    designation VARCHAR(20) NOT NULL
);
----
INSERT INTO typecompte (designation) VALUES 
('General'),
('Epargne'),
('Credit');


-- Création de la table Compte
CREATE TABLE Compte (
    id SERIAL PRIMARY KEY,
    client_id INTEGER NOT NULL,
    numCompte VARCHAR(100) NOT NULL,
    typecompte_id INTEGER NOT NULL,
    montant_initial DECIMAL (12, 2),
    color VARCHAR(7) NOT NULL,
    FOREIGN KEY (client_id) REFERENCES Client(id) ON DELETE CASCADE,
    FOREIGN KEY (typecompte_id) REFERENCES typecompte(id) ON DELETE CASCADE
);
-----
INSERT INTO compte (client_id, numCompte, typeCompte_id, montant_initial, color) VALUES (1, 'Principal de Dmytro', 1, 2550.50, '#16A18C'),
INSERT INTO compte (client_id, numCompte, typeCompte_id, montant_initial, color) VALUES (1, 'Secondaire de Dmytro', 1, 1750.75, '#EE3939'),
INSERT INTO compte (client_id, numCompte, typeCompte_id, montant_initial, color) VALUES (1, 'Épargne de Dmytro', 2, 3500.00, '#377CF6');

---Ajouter une colonne typecompte
ALTER TABLE Compte
ADD COLUMN typecompte_id INTEGER,
ADD FOREIGN KEY (typecompte_id) REFERENCES typecompte(id) ON DELETE CASCADE;

---Ajouter une colonne montant_initial
ALTER TABLE Compte
ADD COLUMN montant_initial DECIMAL (12, 2);

---Ajouter une colonne color
ALTER TABLE Compte
ADD COLUMN color VARCHAR(7) NOT NULL;
UPDATE Compte SET color = '#16A18C' WHERE ID = 1;
UPDATE Compte SET color = '#EE3939' WHERE ID = 2;
UPDATE Compte SET color = '#377CF6' WHERE ID = 3;

---Ajouter une colonne date_creation
ALTER TABLE Compte
ADD COLUMN date_creation TIMESTAMP NOT NULL;
UPDATE Compte SET date_creation = ' 2024-10-24 15:31:00' where id = 1;
UPDATE Compte SET date_creation = ' 2024-10-24 15:31:00' where id = 2;
UPDATE Compte SET date_creation = ' 2024-10-24 15:31:00' where id = 3;
UPDATE Compte SET date_creation = ' 2025-01-08 15:31:00' where id = 34;
UPDATE Compte SET date_creation = ' 2025-01-08 15:31:00' where id = 36;

-- Création de la table Type
CREATE TABLE Type (
    id SERIAL PRIMARY KEY,
    numType VARCHAR(3) NOT NULL,
    description VARCHAR(20) NOT NULL
);
-----
INSERT INTO type (numType, description) VALUES 
('DEP', 'Dépense'),
('REV', 'Revenu'),
('TRA', 'Transfert');


-- Création de la table Categorie
CREATE TABLE Categorie (
    id SERIAL PRIMARY KEY,
    type_id INTEGER NOT NULL,
    description VARCHAR(50) NOT NULL,
    FOREIGN KEY (type_id) REFERENCES Type(id) ON DELETE CASCADE
);
-----
INSERT INTO categorie (type_id, description) VALUES 
(1, 'Alimentation'),
(1, 'Achat'),
(1, 'Logement'),
(1, 'Transport'),
(1, 'Véhicule'),
(1, 'Loisir'),
(1, 'Multimedia'),
(1, 'Frais Financièrs'),
(1, 'Placement'),
(2, 'Revenu');

-- Ajout d'une colonne dans la table Souscategorie
ALTER TABLE categorie
ADD COLUMN color VARCHAR(7),
ADD COLUMN icone VARCHAR(50);

-- Ajout des valeurs de color
UPDATE categorie SET color = '#ee3939' WHERE ID = 1;
UPDATE categorie SET color = '#377cf6' WHERE ID = 2;
UPDATE categorie SET color = '#9966cc' WHERE ID = 3;
UPDATE categorie SET color = '#91a3b0' WHERE ID = 4;
UPDATE categorie SET color = '#e97451' WHERE ID = 5;
UPDATE categorie SET color = '#78c5ef' WHERE ID = 6;
UPDATE categorie SET color = '#374785' WHERE ID = 7;
UPDATE categorie SET color = '#9c6644' WHERE ID = 8;
UPDATE categorie SET color = '#afd275' WHERE ID = 9;
UPDATE categorie SET color = '#16a18c' WHERE ID = 10;

-- Ajout des valeurs de icone
UPDATE categorie SET icone = 'cart-shopping' WHERE ID = 1;
UPDATE categorie SET icone = 'shirt' WHERE ID = 2;
UPDATE categorie SET icone = 'house' WHERE ID = 3;
UPDATE categorie SET icone = 'bus' WHERE ID = 4;
UPDATE categorie SET icone = 'car' WHERE ID = 5;
UPDATE categorie SET icone = 'dice' WHERE ID = 6;
UPDATE categorie SET icone = 'tv' WHERE ID = 7;
UPDATE categorie SET icone = 'circle-dollar-to-slot' WHERE ID = 8;
UPDATE categorie SET icone = 'coins' WHERE ID = 9;
UPDATE categorie SET icone = 'sack-dollar' WHERE ID = 10;

-- Création de la table Souscategorie
CREATE TABLE Souscategorie (
    id SERIAL PRIMARY KEY,
    categorie_id INTEGER NOT NULL,
    description VARCHAR(50) NOT NULL,
    FOREIGN KEY (categorie_id) REFERENCES Categorie(id) ON DELETE CASCADE
);
-----
INSERT INTO souscategorie (categorie_id, description) VALUES 
(1, 'Alimentation'),
(1, 'Restaurant & fast food'),
(1, 'Bar & café'),
(2, 'Vêtements & chaussures'),
(2, 'Bijoux & accessoires'),
(2, 'Santé et pharmacie'),
(2, 'Beauté & cosmétique'),
(2, 'Maison & jardin'),
(2, 'Enfants'),
(2, 'Animaux'),
(2, 'Électronique'),
(2, 'Cadeaux'),
(3, 'Loyer'),
(3, 'Prêt hypothécaire'),
(3, 'Énergie & services publics'),
(3, 'Maintenance & réparation'),
(3, 'Assurance des biens'),
(4, 'Transport en commun'),
(4, 'Taxi & VTC'),
(4, 'Avions'),
(4, 'Trains'),
(4, 'Voyages d`affaires'),
(4, 'Location courte durée'),
(5, 'Carburant'),
(5, 'Parking'),
(5, 'Entretien & réparation'),
(5, 'Péages'),
(5, 'Assurance du véhicule'),
(5, 'Crédit & LLD'),
(6, 'Cinéma & spectacles'),
(6, 'Sports & fitness'),
(6, 'Livres & magazines'),
(6, 'Jeux & hobbies'),
(6, 'Musique & concerts'),
(6, 'Sorties en famille'),
(6, 'Vacances & voyages'),
(7, 'Internet'),
(7, 'Services mobiles'),
(7, 'Télévision'),
(7, 'Jeux vidéo'),
(7, 'Logiciels & applications'),
(7, 'Appareils électroniques'),
(7, 'Abonnements en ligne'),
(8, 'Frais bancaires'),
(8, 'Intérêts sur les prêts'),
(8, 'Pénalités & amendes'),
(8, 'Assurance vie & santé'),
(8, 'Taxes'),
(8, 'Amendes'),
(8, 'Services publics'),
(9, 'Bien immobilier'),
(9, 'Bourse'),
(9, 'Cryptomonnaies'),
(9, 'Fonds communs de placement'),
(9, 'Retraite & pension'),
(10, 'Salaire'),
(10, 'Revenu locatif'),
(10, 'Intérets & Dividendes'),
(10, 'Travail indépendant'),
(10, 'Rentes & allocations'),
(10, 'Remboursements'),
(10, 'Gains aux jeux'),
(10, 'Á vendre'),
(10, 'Cadeaux');

-- Ajout d'une colonne dans la table Souscategorie
ALTER TABLE souscategorie
ADD COLUMN icone VARCHAR(50),

-- Ajout des valeurs de icones
UPDATE souscategorie SET icone = 'cart-shopping' WHERE ID = 1;
UPDATE souscategorie SET icone = 'utensils' WHERE ID = 2;
UPDATE souscategorie SET icone = 'martini-glass' WHERE ID = 3;
UPDATE souscategorie SET icone = 'shirt' WHERE ID = 4;
UPDATE souscategorie SET icone = 'gem' WHERE ID = 5;
UPDATE souscategorie SET icone = 'pills' WHERE ID = 6;
UPDATE souscategorie SET icone = 'scissors' WHERE ID = 7;
UPDATE souscategorie SET icone = 'house' WHERE ID = 8;
UPDATE souscategorie SET icone = 'baby' WHERE ID = 9;
UPDATE souscategorie SET icone = 'paw' WHERE ID = 10;
UPDATE souscategorie SET icone = 'desktop' WHERE ID = 11;
UPDATE souscategorie SET icone = 'gift' WHERE ID = 12;
UPDATE souscategorie SET icone = 'key' WHERE ID = 13;
UPDATE souscategorie SET icone = 'house-lock' WHERE ID = 14;
UPDATE souscategorie SET icone = 'bolt' WHERE ID = 15;
UPDATE souscategorie SET icone = 'paint-roller' WHERE ID = 16;
UPDATE souscategorie SET icone = 'house-medical-circle-check' WHERE ID = 17;
UPDATE souscategorie SET icone = 'bus' WHERE ID = 18;
UPDATE souscategorie SET icone = 'taxi' WHERE ID = 19;
UPDATE souscategorie SET icone = 'plane' WHERE ID = 20;
UPDATE souscategorie SET icone = 'train' WHERE ID = 21;
UPDATE souscategorie SET icone = 'business-time' WHERE ID = 22;
UPDATE souscategorie SET icone = 'car' WHERE ID = 23;
UPDATE souscategorie SET icone = 'gas-pump' WHERE ID = 24;
UPDATE souscategorie SET icone = 'square-parking' WHERE ID = 25;
UPDATE souscategorie SET icone = 'oil-can' WHERE ID = 26;
UPDATE souscategorie SET icone = 'road-circle-check' WHERE ID = 27;
UPDATE souscategorie SET icone = 'car-burst' WHERE ID = 28;
UPDATE souscategorie SET icone = 'car-rear' WHERE ID = 29;
UPDATE souscategorie SET icone = 'masks-theater' WHERE ID = 30;
UPDATE souscategorie SET icone = 'dumbbell' WHERE ID = 31;
UPDATE souscategorie SET icone = 'book' WHERE ID = 32;
UPDATE souscategorie SET icone = 'chess-knight' WHERE ID = 33;
UPDATE souscategorie SET icone = 'guitar' WHERE ID = 34;
UPDATE souscategorie SET icone = 'ice-cream' WHERE ID = 35;
UPDATE souscategorie SET icone = 'suitcase-rolling' WHERE ID = 36;
UPDATE souscategorie SET icone = 'wifi' WHERE ID = 37;
UPDATE souscategorie SET icone = 'mobile-screen' WHERE ID = 38;
UPDATE souscategorie SET icone = 'tv' WHERE ID = 39;
UPDATE souscategorie SET icone = 'gamepad' WHERE ID = 40;
UPDATE souscategorie SET icone = 'cloud-arrow-down' WHERE ID = 41;
UPDATE souscategorie SET icone = 'tablet-screen-button' WHERE ID = 42;
UPDATE souscategorie SET icone = 'headphones-simple' WHERE ID = 43;
UPDATE souscategorie SET icone = 'percent' WHERE ID = 44;
UPDATE souscategorie SET icone = 'money-bill-trend-up' WHERE ID = 45;
UPDATE souscategorie SET icone = 'circle-dollar-to-slot' WHERE ID = 46;
UPDATE souscategorie SET icone = 'user-injured' WHERE ID = 47;
UPDATE souscategorie SET icone = 'file-invoice-dollar' WHERE ID = 48;
UPDATE souscategorie SET icone = 'gavel' WHERE ID = 49;
UPDATE souscategorie SET icone = 'landmark-dome' WHERE ID = 50;
UPDATE souscategorie SET icone = 'hotel' WHERE ID = 51;
UPDATE souscategorie SET icone = 'landmark' WHERE ID = 52;
UPDATE souscategorie SET icone = 'bitcoin-sign' WHERE ID = 53;
UPDATE souscategorie SET icone = 'coins' WHERE ID = 54;
UPDATE souscategorie SET icone = 'sack-dollar' WHERE ID = 55;
UPDATE souscategorie SET icone = 'money-check' WHERE ID = 56;
UPDATE souscategorie SET icone = 'house-user' WHERE ID = 57;
UPDATE souscategorie SET icone = 'hand-holding-usd' WHERE ID = 58;
UPDATE souscategorie SET icone = 'business-time' WHERE ID = 59;
UPDATE souscategorie SET icone = 'landmark' WHERE ID = 60;
UPDATE souscategorie SET icone = 'donate' WHERE ID = 61;
UPDATE souscategorie SET icone = 'dice' WHERE ID = 62;
UPDATE souscategorie SET icone = 'comments-dollar' WHERE ID = 63;
UPDATE souscategorie SET icone = 'gifts' WHERE ID = 64;


-- Création de la table Operation
CREATE TABLE Operation (
    id SERIAL PRIMARY KEY,
    compte_id INTEGER NOT NULL,
    compte_destinataire_id INTEGER,
    timestamp TIMESTAMP NOT NULL,
    montant NUMERIC(10, 2) NOT NULL,
    type_id INTEGER NOT NULL,
    categorie_id INTEGER,
    souscategorie_id INTEGER,
    client_id INTEGER NOT NULL,
    FOREIGN KEY (compte_id) REFERENCES Compte(id) ON DELETE CASCADE,
    FOREIGN KEY (compte_destinataire_id) REFERENCES Compte(id),
    FOREIGN KEY (type_id) REFERENCES Type(id),
    FOREIGN KEY (categorie_id) REFERENCES Categorie(id),
    FOREIGN KEY (souscategorie_id) REFERENCES Souscategorie(id),
    FOREIGN KEY (client_id) REFERENCES client(id) ON DELETE CASCADE;
);
-----
INSERT INTO operation (compte_id, timestamp, montant, type_id, categorie_id, souscategorie_id, client_id) VALUES 
(1, CURRENT_TIMESTAMP, 250.00, 1, 1, 2, 1),
(1, CURRENT_TIMESTAMP, 1950.00, 2, 10, 56, 1),
(1, CURRENT_TIMESTAMP, 550.00, 1, 3, 13, 1),
(2, CURRENT_TIMESTAMP, 100.00, 1, 5, 24, 1);
