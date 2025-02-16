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
    ville VARCHAR(100) NOT NULL ,
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
    statut VARCHAR(50) NOT NULL DEFAULT 'en attante', -- "confirmée", "annulée"
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


-- Insertion de 8 annonces (2 pour chaque catégorie)
INSERT INTO Annonces (title, photo, ville, prix, equipements, description, categorie, disponibilites, validate, owner_id) 
VALUES 
-- Annonces pour Appartement
('Appartement moderne avec vue sur mer', 'image_appartement.jpg', 'Nice', 120.50, '["Wi-Fi", "Climatisation", "Cuisine équipée"]', 'Bel appartement lumineux avec balcon et vue imprenable sur la mer.', 'Appartement', 'nonLouer', 'nonValider', 4),
('Appartement cosy au centre-ville', 'image_appartement2.jpg', 'Lyon', 85.00, '["Wi-Fi", "Cuisine équipée", "TV"]', 'Charmant appartement au cœur de la ville, parfait pour un séjour urbain.', 'Appartement', 'nonLouer', 'nonValider', 4),

-- Annonces pour Maison
('Maison familiale avec jardin', 'image_maison.jpg', 'Marseille', 180.00, '["Wi-Fi", "Jardin", "Barbecue"]', 'Maison spacieuse idéale pour les familles, avec un grand jardin privé.', 'Maison', 'nonLouer', 'nonValider', 4),
('Maison avec terrasse et vue sur montagne', 'image_maison2.jpg', 'Grenoble', 150.00, '["Wi-Fi", "Terrasse", "Cheminée"]', 'Maison chaleureuse avec terrasse offrant une vue magnifique sur les montagnes.', 'Maison', 'nonLouer', 'nonValider', 4),

-- Annonces pour Villa
('Villa de luxe avec piscine', 'image_villa.jpg', 'Cannes', 350.75, '["Piscine", "Wi-Fi", "Vue panoramique"]', 'Villa prestigieuse avec piscine à débordement et vue sur la baie.', 'Villa', 'nonLouer', 'nonValider', 4),
('Villa contemporaine avec jacuzzi', 'image_villa2.jpg', 'Saint-Tropez', 400.00, '["Piscine", "Jacuzzi", "Vue mer"]', 'Villa moderne avec jacuzzi privé et vue imprenable sur la mer.', 'Villa', 'nonLouer', 'nonValider', 4),

-- Annonces pour Cabane
('Cabane dans les arbres', 'image_cabane.jpg', 'Annecy', 90.00, '["Nature", "Balcon", "Petit-déjeuner inclus"]', 'Cabane insolite dans les arbres pour une expérience unique en pleine nature.', 'Cabane', 'nonLouer', 'nonValider', 4),
('Cabane rustique en pleine forêt', 'image_cabane2.jpg', 'Chamonix', 75.00, '["Nature", "Cheminée", "Randonnée"]', 'Cabane rustique idéale pour les amateurs de nature et de tranquillité.', 'Cabane', 'nonLouer', 'nonValider', 4);
