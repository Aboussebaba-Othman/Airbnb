-- Création du type ENUM pour les catégories
CREATE TYPE CategorieType AS ENUM ('Appartement', 'Maison', 'Villa', 'Cabane');

-- Création du type ENUM pour les disponibilités
CREATE TYPE DisponibiliteType AS ENUM ('louer', 'nonLouer');

-- Création du type ENUM pour la validation
CREATE TYPE ValidationType AS ENUM ('valider', 'nonValider');

-- Table des rôles
CREATE TABLE ROLES (
    id SERIAL PRIMARY KEY,
    title VARCHAR(50) NOT NULL
);

-- Table des utilisateurs
CREATE TABLE Users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    photo TEXT,
    description VARCHAR(255),
    role_id INT,
    FOREIGN KEY (role_id) REFERENCES ROLES(id) ON DELETE CASCADE
);

-- Table des annonces (logements)
CREATE TABLE Annonces (
    id SERIAL PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    photo TEXT,
    prix DECIMAL(10,2) NOT NULL,
    equipements TEXT, -- Stocke une liste d'équipements sous forme JSON
    description TEXT,
    categorie CategorieType NOT NULL,
    disponibilites DisponibiliteType NOT NULL DEFAULT 'nonLouer',
    validate ValidationType NOT NULL DEFAULT 'nonValider',
    owner_id INT NOT NULL,
    FOREIGN KEY (owner_id) REFERENCES Users(id) ON DELETE CASCADE
);

-- Table des réservations
CREATE TABLE Reservations (
    id SERIAL PRIMARY KEY,
    reservationDate DATE NOT NULL DEFAULT CURRENT_DATE,
    datedebut DATE NOT NULL,
    datefin DATE NOT NULL,
    user_id INT NOT NULL,
    logement_id INT NOT NULL,
    statut VARCHAR(50) NOT NULL DEFAULT 'confirmée', -- "confirmée", "annulée"
    FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE,
    FOREIGN KEY (logement_id) REFERENCES Annonces(id) ON DELETE CASCADE
);

-- Table des paiements
CREATE TABLE Paiements (
    id SERIAL PRIMARY KEY,
    reservation_id INT NOT NULL,
    user_id INT NOT NULL,
    montant DECIMAL(10,2) NOT NULL,
    date_paiement TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    methode VARCHAR(50) NOT NULL CHECK (methode IN ('Stripe', 'PayPal')),
    FOREIGN KEY (reservation_id) REFERENCES Reservations(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE
);

-- Table des avis et notations
CREATE TABLE Avis (
    id SERIAL PRIMARY KEY,
    logement_id INT NOT NULL,
    user_id INT NOT NULL,
    note INT CHECK (note BETWEEN 1 AND 5),
    commentaire TEXT,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (logement_id) REFERENCES Annonces(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE
);

-- Table de la messagerie
CREATE TABLE Messages (
    id SERIAL PRIMARY KEY,
    sender_id INT NOT NULL,
    receiver_id INT NOT NULL,
    annonce_id INT, 
    message TEXT NOT NULL,
    date_envoi TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES Users(id) ON DELETE CASCADE,
    FOREIGN KEY (receiver_id) REFERENCES Users(id) ON DELETE CASCADE,
    FOREIGN KEY (annonce_id) REFERENCES Annonces(id) ON DELETE CASCADE
);

-- Table des promotions
CREATE TABLE Promotions (
    id SERIAL PRIMARY KEY,
    annonce_id INT NOT NULL,
    pourcentage_reduction DECIMAL(5,2) CHECK (pourcentage_reduction BETWEEN 0 AND 100),
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    FOREIGN KEY (annonce_id) REFERENCES Annonces(id) ON DELETE CASCADE
);