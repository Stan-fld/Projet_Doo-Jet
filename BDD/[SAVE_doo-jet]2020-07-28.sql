-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mar. 28 juil. 2020 à 12:14
-- Version du serveur :  5.7.24
-- Version de PHP : 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `doo-jet`
--

DELIMITER $$
--
-- Procédures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `select_client` (IN `VID_Personne` INT)  BEGIN
    SELECT ID_Personne, Nom, Prenom, DATE_FORMAT(Date_Naissance, "%d/%m/%Y") as anniv, Telephone, N_Permis, Adresse.ID_Adresse, Rue, Numero_Rue, Nom_Ville, Code_Postal, Nom_Pays
    FROM personne 
    LEFT JOIN adresse ON Personne.ID_Adresse = Adresse.ID_Adresse
    LEFT JOIN ville ON adresse.ID_Ville = ville.ID_Ville

    WHERE ( 
    Statut = 'Client' and
    ID_Personne = VID_Personne
    );
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `select_client_all` ()  READS SQL DATA
SELECT ID_Personne, Nom, Prenom, DATE_FORMAT(Date_Naissance, "%d/%m/%Y") as anniv, Telephone, N_Permis, Adresse.ID_Adresse, Rue, Numero_Rue, Nom_Ville, Code_Postal, Nom_Pays
FROM personne 
LEFT JOIN adresse ON Personne.ID_Adresse = Adresse.ID_Adresse
LEFT JOIN ville ON adresse.ID_Ville = ville.ID_Ville

WHERE ( 
Statut = 'Client'
)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `select_employe` (IN `VID_Personne` INT)  BEGIN
    SELECT 	personne.ID_Personne, Nom, Prenom, DATE_FORMAT(Date_Naissance, "%d/%m/%Y") as anniv, Telephone, N_Permis, N_Securite_Sociale, N_BEES, N_Permis, Contrat, DATE_FORMAT(Date_Embauche, "%d/%m/%Y") as dateembau, DATE_FORMAT(Date_Visite_Medicale, "%d/%m/%Y") as datevisit ,Adresse.ID_Adresse, Rue, Numero_Rue, Nom_Ville, Code_Postal, Nom_Pays, Motif, DATE_FORMAT(Date_Debut_Inactivite, "%d/%m/%Y") as max_date_debut, DATE_FORMAT(Date_Fin_Inactivite, "%d/%m/%Y") as max_date_fin
    FROM personne 
    LEFT JOIN adresse ON Personne.ID_Adresse = Adresse.ID_Adresse
    LEFT JOIN ville ON adresse.ID_Ville = ville.ID_Ville
    LEFT JOIN (SELECT ID_Personne FROM employe_malade GROUP BY ID_Personne) as EPM ON EPM.ID_Personne = personne.ID_Personne
    LEFT JOIN (SELECT MAX(ID_Inactivite) as maxid FROM periode_inactivite) AS pi ON EPM.ID_Personne = pi.maxid
    LEFT JOIN periode_inactivite as pi2 ON pi.maxid = pi2.ID_Inactivite

    WHERE ( 
        Statut = 'Employé' AND
        Personne.ID_Personne = VID_Personne
    	);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `select_employe_all` ()  BEGIN
    SELECT 	personne.ID_Personne, Nom, Prenom, DATE_FORMAT(Date_Naissance, "%d/%m/%Y") as anniv, Telephone, N_Permis, N_Securite_Sociale, N_BEES, N_Permis, Contrat, DATE_FORMAT(Date_Embauche, "%d/%m/%Y") as dateembau, DATE_FORMAT(Date_Visite_Medicale, "%d/%m/%Y") as datevisit ,Adresse.ID_Adresse, Rue, Numero_Rue, Nom_Ville, Code_Postal, Nom_Pays, Motif, DATE_FORMAT(Date_Debut_Inactivite, "%d/%m/%Y") as max_date_debut, DATE_FORMAT(Date_Fin_Inactivite, "%d/%m/%Y") as max_date_fin
    FROM personne 
    LEFT JOIN adresse ON Personne.ID_Adresse = Adresse.ID_Adresse
    LEFT JOIN ville ON adresse.ID_Ville = ville.ID_Ville
    LEFT JOIN (SELECT ID_Personne FROM employe_malade GROUP BY ID_Personne) as EPM ON EPM.ID_Personne = personne.ID_Personne
    LEFT JOIN (SELECT MAX(ID_Inactivite) as maxid FROM periode_inactivite) AS pi ON EPM.ID_Personne = pi.maxid
    LEFT JOIN periode_inactivite as pi2 ON pi.maxid = pi2.ID_Inactivite

    WHERE ( 
        Statut = 'Employé'
    	);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_employe` (IN `VID_Personne` INT, IN `vnom` CHAR(50), IN `vprenom` CHAR(50), IN `vdate_naissance` DATE, IN `vtelephone` INT, IN `vpermis` VARCHAR(20), IN `vsecu` VARCHAR(13), IN `vbees` VARCHAR(20), IN `vcontrat` CHAR(50), IN `vembauche` DATE, IN `vmedical` DATE, IN `vnumero_rue` INT, IN `vrue` CHAR(50), IN `vville` CHAR(50), IN `vcode_postal` VARCHAR(255), IN `vpays` CHAR(50), IN `vmotif` CHAR(50), IN `vdate_debut` DATE, IN `vdate_fin` DATE)  BEGIN
	UPDATE personne
	LEFT JOIN adresse ON Personne.ID_Adresse = adresse.ID_Adresse
    LEFT JOIN ville ON adresse.ID_Ville = ville.ID_Ville
    LEFT JOIN (SELECT ID_Personne FROM employe_malade GROUP BY ID_Personne) as EPM ON EPM.ID_Personne = personne.ID_Personne
    LEFT JOIN (SELECT MAX(ID_Inactivite) as maxid FROM periode_inactivite) AS pi ON EPM.ID_Personne = pi.maxid
    LEFT JOIN periode_inactivite as pi2 ON pi.maxid = pi2.ID_Inactivite
    
    
SET personne.Nom = vnom, 
    personne.Prenom = vprenom,
    personne.Date_Naissance = DATE_FORMAT(vdate_naissance, "%d/%m/%Y"),
    personne.Telephone = vtelephone,
    personne.N_Permis = vpermis,
    personne.N_Securite_Sociale = vsecu,
    personne.N_BEES = vbees,
    personne.Contrat = vcontrat,
    personne.Date_Embauche = DATE_FORMAT(vembauche, "%d/%m/%Y"),
    personne.Date_Visite_Medicale = DATE_FORMAT(vmedical, "%d/%m/%Y"),
    adresse.Numero_Rue = vnumero_rue, 
    adresse.rue = vrue,
    ville.Nom_Ville = vville,
    ville.Code_Postal = vcode_postal,
    ville.Nom_Pays = vpays,
    periode_inactivite.Motif = vmotif,
    periode_inactivite.Date_Debut_Inactivite = DATE_FORMAT(vdate_debut, "%d/%m/%Y"),
    periode_inactivite.Date_Fin_Inactivite = DATE_FORMAT(vdate_fin, "%d/%m/%Y")
    
WHERE ( 
        Statut = 'Employé' AND
        Personne.ID_Personne = VID_Personne
    	); 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_employe_personne` (IN `VID_Personne` INT, IN `vnom` CHAR(50), IN `vprenom` CHAR(50), IN `vdate_naissance` DATE, IN `vtelephone` VARCHAR(15), IN `vpermis` VARCHAR(20), IN `vsecu` VARCHAR(13), IN `vbees` VARCHAR(20), IN `vcontrat` CHAR(50), IN `vembauche` DATE, IN `vmedical` DATE)  BEGIN

UPDATE personne
    
SET personne.Nom = vnom, 
    personne.Prenom = vprenom,
    personne.Date_Naissance = vdate_naissance,
    personne.Telephone = vtelephone,
    personne.N_Permis = vpermis,
    personne.N_Securite_Sociale = vsecu,
    personne.N_BEES = vbees,
    personne.Contrat = vcontrat,
    personne.Date_Embauche = vembauche,
    personne.Date_Visite_Medicale = vmedical
    
WHERE ( 
        Statut = 'Employé' AND
        Personne.ID_Personne = VID_Personne
    	); 
 
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `adresse`
--

CREATE TABLE `adresse` (
  `ID_Adresse` int(11) NOT NULL,
  `Rue` char(50) COLLATE utf8_general_ci NOT NULL,
  `Numero_Rue` int(11) NOT NULL,
  `ID_Ville` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `adresse`
--

INSERT INTO `adresse` (`ID_Adresse`, `Rue`, `Numero_Rue`, `ID_Ville`) VALUES
(1, 'Rue Neil Armstrong', 245, 1),
(2, 'Rue Neil Armstrong', 295, 1);

-- --------------------------------------------------------

--
-- Structure de la table `employe_malade`
--

CREATE TABLE `employe_malade` (
  `ID_Personne` int(11) NOT NULL,
  `ID_Inactivite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `employe_malade`
--

INSERT INTO `employe_malade` (`ID_Personne`, `ID_Inactivite`) VALUES
(2, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `equipement`
--

CREATE TABLE `equipement` (
  `ID_Equipement` int(11) NOT NULL,
  `Nom_Equipement` char(50) COLLATE utf8_general_ci NOT NULL,
  `Commentaire` char(100) COLLATE utf8_general_ci NOT NULL,
  `Puissance` int(11) NOT NULL,
  `Service` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `equipement_reserve`
--

CREATE TABLE `equipement_reserve` (
  `ID_Equipement` int(11) NOT NULL,
  `ID_Reservation` int(11) NOT NULL,
  `Date_Heure_Debut_Reservation` datetime NOT NULL,
  `Date_Heure_Fin_Reservation` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `pays`
--

CREATE TABLE `pays` (
  `Nom_Pays` char(50) COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `pays`
--

INSERT INTO `pays` (`Nom_Pays`) VALUES
('Afghanistan'),
('Afrique du Sud'),
('Albanie'),
('Algérie'),
('Allemagne'),
('Andorre'),
('Angola'),
('Anguilla'),
('Antarctique'),
('Antigua-et-Barbuda'),
('Antilles Néerlandaises'),
('Arabie Saoudite'),
('Argentine'),
('Arménie'),
('Aruba'),
('Australie'),
('Autriche'),
('Azerbaïdjan'),
('Bahamas'),
('Bahreïn'),
('Bangladesh'),
('Barbade'),
('Belgique'),
('Belize'),
('Bermudes'),
('Bhoutan'),
('Bolivie'),
('Bosnie-Herzégovine'),
('Botswana'),
('Brunéi Darussalam'),
('Brésil'),
('Bulgarie'),
('Burkina Faso'),
('Burundi'),
('Bélarus'),
('Bénin'),
('Cambodge'),
('Cameroun'),
('Canada'),
('Cap-vert'),
('Chili'),
('Chine'),
('Chypre'),
('Colombie'),
('Comores'),
('Costa Rica'),
('Croatie'),
('Cuba'),
('Côte d\'Ivoire'),
('Danemark'),
('Djibouti'),
('Dominique'),
('El Salvador'),
('Espagne'),
('Estonie'),
('Fidji'),
('Finlande'),
('France'),
('Fédération de Russie'),
('Gabon'),
('Gambie'),
('Ghana'),
('Gibraltar'),
('Grenade'),
('Groenland'),
('Grèce'),
('Guadeloupe'),
('Guam'),
('Guatemala'),
('Guinée'),
('Guinée Équatoriale'),
('Guinée-Bissau'),
('Guyana'),
('Guyane Française'),
('Géorgie'),
('Géorgie du Sud et les Îles Sandwich du Sud'),
('Haïti'),
('Honduras'),
('Hong-Kong'),
('Hongrie'),
('Inde'),
('Indonésie'),
('Iraq'),
('Irlande'),
('Islande'),
('Israël'),
('Italie'),
('Jamahiriya Arabe Libyenne'),
('Jamaïque'),
('Japon'),
('Jordanie'),
('Kazakhstan'),
('Kenya'),
('Kirghizistan'),
('Kiribati'),
('Koweït'),
('L\'ex-République Yougoslave de Macédoine'),
('Lesotho'),
('Lettonie'),
('Liban'),
('Libéria'),
('Liechtenstein'),
('Lituanie'),
('Luxembourg'),
('Macao'),
('Madagascar'),
('Malaisie'),
('Malawi'),
('Maldives'),
('Mali'),
('Malte'),
('Maroc'),
('Martinique'),
('Maurice'),
('Mauritanie'),
('Mayotte'),
('Mexique'),
('Monaco'),
('Mongolie'),
('Montserrat'),
('Mozambique'),
('Myanmar'),
('Namibie'),
('Nauru'),
('Nicaragua'),
('Niger'),
('Nigéria'),
('Niué'),
('Norvège'),
('Nouvelle-Calédonie'),
('Nouvelle-Zélande'),
('Népal'),
('Oman'),
('Ouganda'),
('Ouzbékistan'),
('Pakistan'),
('Palaos'),
('Panama'),
('Papouasie-Nouvelle-Guinée'),
('Paraguay'),
('Pays-Bas'),
('Philippines'),
('Pitcairn'),
('Pologne'),
('Polynésie Française'),
('Porto Rico'),
('Portugal'),
('Pérou'),
('Qatar'),
('Roumanie'),
('Royaume-Uni'),
('Rwanda'),
('République Arabe Syrienne'),
('République Centrafricaine'),
('République Dominicaine'),
('République Démocratique Populaire Lao'),
('République Démocratique du Congo'),
('République Islamique d\'Iran'),
('République Populaire Démocratique de Corée'),
('République Tchèque'),
('République de Corée'),
('République de Moldova'),
('République du Congo'),
('République-Unie de Tanzanie'),
('Réunion'),
('Sahara Occidental'),
('Saint-Kitts-et-Nevis'),
('Saint-Marin'),
('Saint-Pierre-et-Miquelon'),
('Saint-Siège (état de la Cité du Vatican)'),
('Saint-Vincent-et-les Grenadines'),
('Sainte-Hélène'),
('Sainte-Lucie'),
('Samoa'),
('Samoa Américaines'),
('Sao Tomé-et-Principe'),
('Serbie-et-Monténégro'),
('Seychelles'),
('Sierra Leone'),
('Singapour'),
('Slovaquie'),
('Slovénie'),
('Somalie'),
('Soudan'),
('Sri Lanka'),
('Suisse'),
('Suriname'),
('Suède'),
('Svalbard etÎle Jan Mayen'),
('Swaziland'),
('Sénégal'),
('Tadjikistan'),
('Taïwan'),
('Tchad'),
('Terres Australes Françaises'),
('Territoire Britannique de l\'Océan Indien'),
('Territoire Palestinien Occupé'),
('Thaïlande'),
('Timor-Leste'),
('Togo'),
('Tokelau'),
('Tonga'),
('Trinité-et-Tobago'),
('Tunisie'),
('Turkménistan'),
('Turquie'),
('Tuvalu'),
('Ukraine'),
('Uruguay'),
('Vanuatu'),
('Venezuela'),
('Viet Nam'),
('Wallis et Futuna'),
('Yémen'),
('Zambie'),
('Zimbabwe'),
('Égypte'),
('Émirats Arabes Unis'),
('Équateur'),
('Érythrée'),
('États Fédérés de Micronésie'),
('États-Unis'),
('Éthiopie'),
('Île Bouvet'),
('Île Christmas'),
('Île Norfolk'),
('Île de Man'),
('Îles (malvinas) Falkland'),
('Îles Caïmanes'),
('Îles Cocos (Keeling)'),
('Îles Cook'),
('Îles Féroé'),
('Îles Heard et Mcdonald'),
('Îles Mariannes du Nord'),
('Îles Marshall'),
('Îles Mineures Éloignées des États-Unis'),
('Îles Salomon'),
('Îles Turks et Caïques'),
('Îles Vierges Britanniques'),
('Îles Vierges des États-Unis'),
('Îles Åland');

-- --------------------------------------------------------

--
-- Structure de la table `periode_inactivite`
--

CREATE TABLE `periode_inactivite` (
  `ID_Inactivite` int(11) NOT NULL,
  `Motif` char(50) COLLATE utf8_general_ci NOT NULL,
  `Date_Debut_Inactivite` date NOT NULL,
  `Date_Fin_Inactivite` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `periode_inactivite`
--

INSERT INTO `periode_inactivite` (`ID_Inactivite`, `Motif`, `Date_Debut_Inactivite`, `Date_Fin_Inactivite`) VALUES
(1, 'Médical', '2020-07-01', '2020-07-16'),
(2, 'Fracture', '2020-08-03', '2020-09-09');

-- --------------------------------------------------------

--
-- Structure de la table `personne`
--

CREATE TABLE `personne` (
  `ID_Personne` int(11) NOT NULL,
  `Statut` char(50) COLLATE utf8_general_ci NOT NULL,
  `Nom` char(50) COLLATE utf8_general_ci NOT NULL,
  `Prenom` char(50) COLLATE utf8_general_ci NOT NULL,
  `Date_Naissance` date NOT NULL,
  `Telephone` varchar(15) COLLATE utf8_general_ci NOT NULL,
  `Password` varchar(30) COLLATE utf8_general_ci DEFAULT NULL,
  `N_Securite_Sociale` varchar(13) COLLATE utf8_general_ci DEFAULT NULL,
  `N_BEES` varchar(20) COLLATE utf8_general_ci DEFAULT NULL,
  `N_Permis` varchar(20) COLLATE utf8_general_ci DEFAULT NULL,
  `Contrat` char(50) COLLATE utf8_general_ci DEFAULT NULL,
  `Date_Embauche` date DEFAULT NULL,
  `Date_Visite_Medicale` date DEFAULT NULL,
  `ID_Adresse` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `personne`
--

INSERT INTO `personne` (`ID_Personne`, `Statut`, `Nom`, `Prenom`, `Date_Naissance`, `Telephone`, `Password`, `N_Securite_Sociale`, `N_BEES`, `N_Permis`, `Contrat`, `Date_Embauche`, `Date_Visite_Medicale`, `ID_Adresse`) VALUES
(1, 'Client', 'Foillard', 'Stanislas', '2000-12-03', '+33783297606', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(2, 'Employé', 'Foillard', 'Maxime', '2000-03-25', '+33606060606', NULL, '1234547687', '432543564', '432567883', 'CDI', '2020-04-01', '2020-04-03', 2),
(3, 'Employé', 'Foillard', 'Jean', '1965-02-22', '+33606078606', NULL, '1234547687', '432543564', '432567883', 'CDD', '2020-04-01', '2020-04-03', 2),
(4, 'Client', 'Marcon', 'Baptiste', '1999-06-30', '+33666666376', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `prix_horaire`
--

CREATE TABLE `prix_horaire` (
  `ID_Prix_Horaire` int(11) NOT NULL,
  `Duree` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `prix_horaire_equipement`
--

CREATE TABLE `prix_horaire_equipement` (
  `ID_Prix_Horaire` int(11) NOT NULL,
  `ID_Equipement` int(11) NOT NULL,
  `Prix` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

CREATE TABLE `reservation` (
  `ID_Reservation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reservation_client_employe`
--

CREATE TABLE `reservation_client_employe` (
  `ID_Reservation` int(11) NOT NULL,
  `ID_Personne` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ville`
--

CREATE TABLE `ville` (
  `ID_Ville` int(11) NOT NULL,
  `Nom_Ville` char(50) COLLATE utf8_general_ci NOT NULL,
  `Code_Postal` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `Nom_Pays` char(50) COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `ville`
--

INSERT INTO `ville` (`ID_Ville`, `Nom_Ville`, `Code_Postal`, `Nom_Pays`) VALUES
(1, 'AIX EN PROVENCE', '13100', 'France');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `adresse`
--
ALTER TABLE `adresse`
  ADD PRIMARY KEY (`ID_Adresse`),
  ADD KEY `Adresse_Ville_FK` (`ID_Ville`);

--
-- Index pour la table `employe_malade`
--
ALTER TABLE `employe_malade`
  ADD PRIMARY KEY (`ID_Personne`,`ID_Inactivite`),
  ADD KEY `Employe_Malade_Periode_Inactivite0_FK` (`ID_Inactivite`);

--
-- Index pour la table `equipement`
--
ALTER TABLE `equipement`
  ADD PRIMARY KEY (`ID_Equipement`);

--
-- Index pour la table `equipement_reserve`
--
ALTER TABLE `equipement_reserve`
  ADD PRIMARY KEY (`ID_Equipement`,`ID_Reservation`),
  ADD KEY `Equipement_Reserve_Reservation0_FK` (`ID_Reservation`);

--
-- Index pour la table `pays`
--
ALTER TABLE `pays`
  ADD PRIMARY KEY (`Nom_Pays`);

--
-- Index pour la table `periode_inactivite`
--
ALTER TABLE `periode_inactivite`
  ADD PRIMARY KEY (`ID_Inactivite`);

--
-- Index pour la table `personne`
--
ALTER TABLE `personne`
  ADD PRIMARY KEY (`ID_Personne`),
  ADD KEY `Personne_Adresse_FK` (`ID_Adresse`);

--
-- Index pour la table `prix_horaire`
--
ALTER TABLE `prix_horaire`
  ADD PRIMARY KEY (`ID_Prix_Horaire`);

--
-- Index pour la table `prix_horaire_equipement`
--
ALTER TABLE `prix_horaire_equipement`
  ADD PRIMARY KEY (`ID_Prix_Horaire`,`ID_Equipement`),
  ADD KEY `Prix_Horaire_Equipement_Equipement0_FK` (`ID_Equipement`);

--
-- Index pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`ID_Reservation`);

--
-- Index pour la table `reservation_client_employe`
--
ALTER TABLE `reservation_client_employe`
  ADD PRIMARY KEY (`ID_Reservation`,`ID_Personne`),
  ADD KEY `Reservation_Client_Employe_Personne0_FK` (`ID_Personne`);

--
-- Index pour la table `ville`
--
ALTER TABLE `ville`
  ADD PRIMARY KEY (`ID_Ville`),
  ADD KEY `Ville_Pays_FK` (`Nom_Pays`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `adresse`
--
ALTER TABLE `adresse`
  MODIFY `ID_Adresse` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `equipement`
--
ALTER TABLE `equipement`
  MODIFY `ID_Equipement` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `periode_inactivite`
--
ALTER TABLE `periode_inactivite`
  MODIFY `ID_Inactivite` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `personne`
--
ALTER TABLE `personne`
  MODIFY `ID_Personne` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `prix_horaire`
--
ALTER TABLE `prix_horaire`
  MODIFY `ID_Prix_Horaire` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `ID_Reservation` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `ville`
--
ALTER TABLE `ville`
  MODIFY `ID_Ville` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46331;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `adresse`
--
ALTER TABLE `adresse`
  ADD CONSTRAINT `Adresse_Ville_FK` FOREIGN KEY (`ID_Ville`) REFERENCES `ville` (`ID_Ville`);

--
-- Contraintes pour la table `employe_malade`
--
ALTER TABLE `employe_malade`
  ADD CONSTRAINT `Employe_Malade_Periode_Inactivite0_FK` FOREIGN KEY (`ID_Inactivite`) REFERENCES `periode_inactivite` (`ID_Inactivite`),
  ADD CONSTRAINT `Employe_Malade_Personne_FK` FOREIGN KEY (`ID_Personne`) REFERENCES `personne` (`ID_Personne`);

--
-- Contraintes pour la table `equipement_reserve`
--
ALTER TABLE `equipement_reserve`
  ADD CONSTRAINT `Equipement_Reserve_Equipement_FK` FOREIGN KEY (`ID_Equipement`) REFERENCES `equipement` (`ID_Equipement`),
  ADD CONSTRAINT `Equipement_Reserve_Reservation0_FK` FOREIGN KEY (`ID_Reservation`) REFERENCES `reservation` (`ID_Reservation`);

--
-- Contraintes pour la table `personne`
--
ALTER TABLE `personne`
  ADD CONSTRAINT `Personne_Adresse_FK` FOREIGN KEY (`ID_Adresse`) REFERENCES `adresse` (`ID_Adresse`);

--
-- Contraintes pour la table `prix_horaire_equipement`
--
ALTER TABLE `prix_horaire_equipement`
  ADD CONSTRAINT `Prix_Horaire_Equipement_Equipement0_FK` FOREIGN KEY (`ID_Equipement`) REFERENCES `equipement` (`ID_Equipement`),
  ADD CONSTRAINT `Prix_Horaire_Equipement_Prix_Horaire_FK` FOREIGN KEY (`ID_Prix_Horaire`) REFERENCES `prix_horaire` (`ID_Prix_Horaire`);

--
-- Contraintes pour la table `reservation_client_employe`
--
ALTER TABLE `reservation_client_employe`
  ADD CONSTRAINT `Reservation_Client_Employe_Personne0_FK` FOREIGN KEY (`ID_Personne`) REFERENCES `personne` (`ID_Personne`),
  ADD CONSTRAINT `Reservation_Client_Employe_Reservation_FK` FOREIGN KEY (`ID_Reservation`) REFERENCES `reservation` (`ID_Reservation`);

--
-- Contraintes pour la table `ville`
--
ALTER TABLE `ville`
  ADD CONSTRAINT `Ville_Pays_FK` FOREIGN KEY (`Nom_Pays`) REFERENCES `pays` (`Nom_Pays`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
