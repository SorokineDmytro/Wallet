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
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- pour inserer le client utilise la fonction insertClient dans process.php qui va hasher le MDP avec BCRYPT

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
    FOREIGN KEY (client_id) REFERENCES Client(id) ON DELETE CASCADE
);
-----
INSERT INTO compte (client_id, numCompte, typeCompte_id) VALUES (1, 'Principal de Dmytro', 1, 2550.50);

---Ajouter une colonne typecompte
ALTER TABLE Compte
ADD COLUMN typecompte_id INTEGER,
ADD FOREIGN KEY (typecompte_id) REFERENCES typecompte(id) ON DELETE CASCADE;

---Ajouter une colonne montant_initial
ALTER TABLE Compte
ADD COLUMN montant_initial DECIMAL (12, 2);




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
(2, 'Électronque'),
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
    FOREIGN KEY (compte_id) REFERENCES Compte(id) ON DELETE CASCADE,
    FOREIGN KEY (compte_destinataire_id) REFERENCES Compte(id),
    FOREIGN KEY (type_id) REFERENCES Type(id),
    FOREIGN KEY (categorie_id) REFERENCES Categorie(id),
    FOREIGN KEY (souscategorie_id) REFERENCES Souscategorie(id)
);