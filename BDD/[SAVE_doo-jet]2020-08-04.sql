-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mar. 04 août 2020 à 16:04
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `create_equipement` (IN `vnom` CHAR(50), IN `vcommentaire` CHAR(100), IN `vpuissance` INT, IN `vservice` TINYINT(1))  BEGIN
   INSERT INTO equipement (Nom_Equipement, Commentaire, Puissance , Service) VALUES(vnom, vcommentaire, vpuissance, vservice);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `create_personne` (IN `vstatut` CHAR(50), IN `vnom` CHAR(50), IN `vprenom` CHAR(50), IN `vdate_naissance` DATE, IN `vtelephone` VARCHAR(15), IN `vpermis` VARCHAR(20), IN `vville` CHAR(50), IN `vcode_postal` VARCHAR(255), IN `vpays` CHAR(50), IN `vnumero_rue` INT, IN `vrue` CHAR(50), IN `vvoie` CHAR(50), IN `vsecu` VARCHAR(13), IN `vbees` VARCHAR(20), IN `vcontrat` CHAR(50), IN `vembauche` DATE, IN `vmedical` DATE, IN `vpassword` VARCHAR(30))  BEGIN

IF NOT EXISTS 
(SELECT * FROM personne 
 WHERE
 (Statut = vstatut and
  personne.Nom = vnom and 
  personne.Prenom = vprenom and
  personne.Date_Naissance = vdate_naissance or
  personne.N_Permis = vpermis or 
  personne.N_BEES = vbees))
  THEN

  IF EXISTS
  (SELECT ID_Ville FROM ville 
  WHERE(Nom_Ville = vville and Code_Postal = vcode_postal and Nom_Pays = vpays))

  THEN

   INSERT INTO adresse (Rue, Numero_Rue, Type_Voie, ID_Ville) VALUES(vrue, vnumero_rue, vvoie, (SELECT ID_Ville FROM Ville WHERE ville.Nom_Ville = vville and ville.Code_Postal = vcode_postal and ville.Nom_Pays = vpays));
   INSERT INTO personne(Statut, Nom, Prenom, Date_Naissance, Telephone, N_Permis, ID_Adresse, N_Securite_Sociale, N_BEES, Contrat, Date_Embauche, Date_Visite_Medicale, Password) VALUES(vstatut, vnom, vprenom, vdate_naissance, vtelephone, vpermis, LAST_INSERT_ID(), vsecu, vbees, vcontrat, vembauche, vmedical, vpassword);

  ELSE
  
  INSERT INTO ville (Nom_Ville, Code_Postal, Nom_Pays) VALUES(vville, vcode_postal, vpays);
  INSERT INTO adresse (Rue, Numero_Rue, Type_Voie, ID_Ville) VALUES(vrue, vnumero_rue, vvoie, LAST_INSERT_ID());
  INSERT INTO personne(Statut, Nom, Prenom, Date_Naissance, Telephone, N_Permis, ID_Adresse, N_Securite_Sociale, N_BEES, Contrat, Date_Embauche, Date_Visite_Medicale, Password) VALUES(vstatut, vnom, vprenom, vdate_naissance, vtelephone, vpermis, LAST_INSERT_ID(), vsecu, vbees, vcontrat, vembauche, vmedical, vpassword);
  END IF;

    ELSE
       SIGNAL SQLSTATE '45000';
    END IF;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_equipement` (IN `videquipement` INT)  MODIFIES SQL DATA
BEGIN
DELETE FROM equipement WHERE(ID_Equipement = videquipement);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_personne` (IN `vid_personne` INT, IN `vstatut` CHAR(50))  MODIFIES SQL DATA
BEGIN
DELETE FROM Personne
WHERE (personne.ID_Personne = vid_personne  and Statut = vstatut);
DELETE FROM Adresse
WHERE (adresse.ID_Adresse = (SELECT ID_Adresse FROM Personne WHERE (personne.ID_Personne = vid_personne and Statut = vstatut)));

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `select_client` (IN `VID_Personne` INT)  BEGIN
    SELECT personne.ID_Personne, Nom, Prenom, DATE_FORMAT(Date_Naissance, "%d/%m/%Y") as anniv, Telephone, N_Permis, N_Permis, Adresse.ID_Adresse, Rue, Numero_Rue, Nom_Ville, Code_Postal, Type_Voie, Nom_Pays
    FROM personne 
    LEFT JOIN adresse ON Personne.ID_Adresse = Adresse.ID_Adresse
    LEFT JOIN ville ON adresse.ID_Ville = ville.ID_Ville

    WHERE ( 
    Statut = 'Client' and
    ID_Personne = VID_Personne
    );
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `select_client_all` ()  READS SQL DATA
SELECT ID_Personne, Nom, Prenom, DATE_FORMAT(Date_Naissance, "%d/%m/%Y") as anniv, Telephone, N_Permis, Adresse.ID_Adresse, Rue, Numero_Rue, Type_Voie, Nom_Ville, Code_Postal, Nom_Pays
FROM personne 
LEFT JOIN adresse ON Personne.ID_Adresse = Adresse.ID_Adresse
LEFT JOIN ville ON adresse.ID_Ville = ville.ID_Ville
WHERE ( 
Statut = 'Client'
)
ORDER BY `personne`.ID_Personne DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `select_employe` (IN `VID_Personne` INT)  BEGIN
    SELECT personne.ID_Personne, Nom, Prenom, DATE_FORMAT(Date_Naissance, "%d/%m/%Y") as anniv, Telephone, N_Permis, N_Securite_Sociale, N_BEES, N_Permis, Contrat, DATE_FORMAT(Date_Embauche, "%d/%m/%Y") as dateembau, DATE_FORMAT(Date_Visite_Medicale, "%d/%m/%Y") as datevisit ,Adresse.ID_Adresse, Rue, Numero_Rue, Nom_Ville, Code_Postal, Type_Voie, Nom_Pays, Motif, DATE_FORMAT(Date_Debut_Inactivite, "%d/%m/%Y") as max_date_debut, DATE_FORMAT(Date_Fin_Inactivite, "%d/%m/%Y") as max_date_fin
    FROM personne 
    LEFT JOIN adresse ON Personne.ID_Adresse = Adresse.ID_Adresse
    LEFT JOIN ville ON adresse.ID_Ville = ville.ID_Ville
    LEFT JOIN periode_inactivite as pi ON pi.ID_Inactivite = (SELECT MAX(ID_Inactivite)as maxid FROM employe_malade WHERE employe_malade.ID_Personne = VID_Personne)

    WHERE ( 
        Statut = 'Employé' AND
        Personne.ID_Personne = VID_Personne
    	);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `select_employe_all` ()  SELECT 	personne.ID_Personne, Nom, Prenom, DATE_FORMAT(Date_Naissance, "%d/%m/%Y") as anniv, Telephone, N_Permis, N_Securite_Sociale, N_BEES, N_Permis, Contrat, DATE_FORMAT(Date_Embauche, "%d/%m/%Y") as dateembau, DATE_FORMAT(Date_Visite_Medicale, "%d/%m/%Y") as datevisit ,Adresse.ID_Adresse, Rue, Numero_Rue, Type_Voie, Nom_Ville, Code_Postal, Nom_Pays, Motif, DATE_FORMAT(Date_Debut_Inactivite, "%d/%m/%Y") as max_date_debut, DATE_FORMAT(Date_Fin_Inactivite, "%d/%m/%Y") as max_date_fin
    FROM personne 
    LEFT JOIN adresse ON Personne.ID_Adresse = Adresse.ID_Adresse
    LEFT JOIN ville ON adresse.ID_Ville = ville.ID_Ville
    LEFT JOIN (SELECT ID_Personne FROM employe_malade GROUP BY ID_Personne) as EPM ON EPM.ID_Personne = personne.ID_Personne
    LEFT JOIN (SELECT MAX(ID_Inactivite) as maxid FROM periode_inactivite) AS pi ON EPM.ID_Personne = pi.maxid
    LEFT JOIN periode_inactivite as pi2 ON pi.maxid = pi2.ID_Inactivite

WHERE (Statut = 'Employé')
ORDER BY `personne`.ID_Personne DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `select_equipement` (IN `videquipement` INT)  READS SQL DATA
SELECT ID_Equipement, Nom_Equipement, Commentaire, Puissance, Service FROM equipement WHERE(ID_Equipement = videquipement)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `select_equipement_all` ()  SELECT ID_Equipement, Nom_Equipement, Commentaire, Puissance, Service FROM equipement
ORDER BY `equipement`.Service DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `select_prix` (IN `videq` INT, IN `vtemp` INT)  BEGIN
SELECT Prix FROM prix_horaire_equipement 
LEFT JOIN prix_horaire ON prix_horaire_equipement.ID_Prix_Horaire = prix_horaire.ID_Prix_Horaire
WHERE(prix_horaire.Duree = vtemp and prix_horaire_equipement.ID_Equipement = videq);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `select_reservation` (IN `vidresa` INT)  BEGIN

SELECT equipement_reserve.ID_Equipement, personne.ID_Personne, Nom, Prenom, Telephone, N_Permis, Nom_Equipement, Commentaire, Puissance, DATE_FORMAT(equipement_reserve.Date_Heure_Debut_Reservation, "%d/%m/%Y %H:%i:%s") as debut, DATE_FORMAT(equipement_reserve.Date_Heure_Fin_Reservation, "%d/%m/%Y %H:%i:%s") as fin  FROM equipement_reserve
LEFT JOIN equipement ON equipement_reserve.ID_Equipement = equipement.ID_Equipement 
LEFT JOIN reservation_client_employe ON equipement_reserve.ID_Reservation = reservation_client_employe.ID_Reservation
LEFT JOIN personne ON reservation_client_employe.ID_Personne = personne.ID_Personne
WHERE(equipement_reserve.ID_Reservation = vidresa);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `select_reservation_all` ()  BEGIN
CREATE TEMPORARY TABLE resa SELECT equipement_reserve.ID_Reservation, DATE_FORMAT(MIN(equipement_reserve.Date_Heure_Debut_Reservation), "%d/%m/%Y %Hh%i") as debut, DATE_FORMAT(MAX(equipement_reserve.Date_Heure_Fin_Reservation), "%d/%m/%Y %Hh%i") as fin FROM equipement_reserve GROUP BY ID_Reservation;

SELECT Nom, Prenom, Telephone, resa.ID_Reservation, personne.ID_Personne, resa.debut, resa.fin FROM resa 
LEFT JOIN reservation_client_employe as rce ON resa.ID_Reservation = rce.ID_Reservation
LEFT JOIN personne ON rce.ID_Personne = personne.ID_Personne;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_adresse` (IN `vid_adresse` INT, IN `vnumero_rue` INT, IN `vrue` CHAR(50), IN `vvoie` CHAR(50))  MODIFIES SQL DATA
BEGIN
	UPDATE adresse
    SET adresse.Rue = vrue,
    	adresse.Numero_Rue = vnumero_rue,
        adresse.Type_Voie = vvoie
    WHERE (adresse.ID_Adresse = vid_adresse);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_equipement` (IN `vid_equipement` INT, IN `vnom` CHAR(50), IN `vcommentaire` CHAR(100), IN `vpuissance` INT, IN `vservice` TINYINT(1))  MODIFIES SQL DATA
BEGIN
	UPDATE equipement
    SET equipement.Nom_Equipement = vnom,
    	equipement.Commentaire = vcommentaire,
        equipement.Puissance = vpuissance,
        equipement.Service = vservice
    WHERE (equipement.ID_Equipement = vid_equipement);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_tb_personne_client` (IN `VID_Personne` INT, IN `vnom` CHAR(50), IN `vprenom` CHAR(50), IN `vdate_naissance` DATE, IN `vtelephone` VARCHAR(15), IN `vpermis` VARCHAR(20))  MODIFIES SQL DATA
BEGIN

UPDATE personne

SET personne.Nom = vnom, 
    personne.Prenom = vprenom,
    personne.Date_Naissance = vdate_naissance,
    personne.Telephone = vtelephone,
    personne.N_Permis = vpermis
    
WHERE ( 
        Statut = 'Client' AND
        Personne.ID_Personne = VID_Personne
    	); 
 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_tb_personne_employe` (IN `VID_Personne` INT, IN `vnom` CHAR(50), IN `vprenom` CHAR(50), IN `vdate_naissance` DATE, IN `vtelephone` VARCHAR(15), IN `vpermis` VARCHAR(20), IN `vsecu` VARCHAR(13), IN `vbees` VARCHAR(20), IN `vcontrat` CHAR(50), IN `vembauche` DATE, IN `vmedical` DATE)  MODIFIES SQL DATA
BEGIN

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

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_ville` (IN `vid_adresse` INT, IN `vville` CHAR(50), IN `vcode_postal` VARCHAR(255), IN `vpays` CHAR(50))  MODIFIES SQL DATA
BEGIN
IF EXISTS (SELECT ID_Ville FROM Ville WHERE ville.Nom_Ville = vville and ville.Code_Postal = vcode_postal)

	THEN
    
	UPDATE adresse
    SET adresse.ID_Ville = (SELECT ID_Ville FROM Ville WHERE ville.Nom_Ville = vville and ville.Code_Postal = vcode_postal)
    WHERE (adresse.ID_Adresse = vid_adresse);
    
     ELSE
     
        INSERT INTO ville (Nom_Ville, Code_Postal, Nom_Pays) VALUES(vville, vcode_postal, vpays);
        
        UPDATE adresse
        SET adresse.ID_Ville = LAST_INSERT_ID() 
        WHERE (adresse.ID_Adresse = vid_adresse);
        
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `adresse`
--

CREATE TABLE `adresse` (
  `ID_Adresse` int(11) NOT NULL,
  `Rue` char(50) NOT NULL,
  `Numero_Rue` int(11) NOT NULL,
  `Type_Voie` char(50) NOT NULL,
  `ID_Ville` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `adresse`
--

INSERT INTO `adresse` (`ID_Adresse`, `Rue`, `Numero_Rue`, `Type_Voie`, `ID_Ville`) VALUES
(1, 'Neil Armstrong', 245, 'Rue', 1),
(2, 'Neil Armstrong', 295, 'Rue', 2),
(3, 'des Platanes', 240, 'Chemin', 3),
(4, 'des Platrières', 1255, 'Chemin', 4),
(27, 'du Mas', 13, 'Chemin', 46342),
(28, 'du Mas', 13, 'Chemin', 46342),
(29, 'Jean Pierre Saez', 125, 'Rue', 1),
(30, 'de la République', 56, 'Rue', 46343);

-- --------------------------------------------------------

--
-- Structure de la table `employe_malade`
--

CREATE TABLE `employe_malade` (
  `ID_Personne` int(11) NOT NULL,
  `ID_Inactivite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `employe_malade`
--

INSERT INTO `employe_malade` (`ID_Personne`, `ID_Inactivite`) VALUES
(8, 12);

-- --------------------------------------------------------

--
-- Structure de la table `equipement`
--

CREATE TABLE `equipement` (
  `ID_Equipement` int(11) NOT NULL,
  `Nom_Equipement` char(50) NOT NULL,
  `Commentaire` char(100) NOT NULL,
  `Puissance` int(11) NOT NULL,
  `Service` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `equipement`
--

INSERT INTO `equipement` (`ID_Equipement`, `Nom_Equipement`, `Commentaire`, `Puissance`, `Service`) VALUES
(1, 'JETSKI', 'Kawasaki STX 15F', 152, 0),
(2, 'JETSKI', 'See-Doo 4tec', 155, 1),
(3, 'JETSKI', 'Yamaha Fx SHO', 210, 1),
(4, 'BOUEE', 'Bouée', 0, 1),
(5, 'WAKE-BOARD', 'Wake-board', 0, 1),
(6, 'BATEAU', 'Bateau', 0, 1),
(7, 'SKI-NAUTIQUE', 'Ski-Nautique', 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `equipement_reserve`
--

CREATE TABLE `equipement_reserve` (
  `ID_Equipement` int(11) NOT NULL,
  `ID_Reservation` int(11) NOT NULL,
  `Date_Heure_Debut_Reservation` datetime NOT NULL,
  `Date_Heure_Fin_Reservation` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `equipement_reserve`
--

INSERT INTO `equipement_reserve` (`ID_Equipement`, `ID_Reservation`, `Date_Heure_Debut_Reservation`, `Date_Heure_Fin_Reservation`) VALUES
(1, 1, '2020-08-12 12:15:00', '2020-08-12 13:15:00'),
(4, 1, '2020-08-12 13:30:00', '2020-08-12 14:00:00'),
(6, 2, '2020-08-13 13:30:00', '2020-08-13 14:30:00');

-- --------------------------------------------------------

--
-- Structure de la table `pays`
--

CREATE TABLE `pays` (
  `Nom_Pays` char(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
('Bélarus'),
('Belgique'),
('Belize'),
('Bénin'),
('Bermudes'),
('Bhoutan'),
('Bolivie'),
('Bosnie-Herzégovine'),
('Botswana'),
('Brésil'),
('Brunéi Darussalam'),
('Bulgarie'),
('Burkina Faso'),
('Burundi'),
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
('Côte d\'Ivoire'),
('Croatie'),
('Cuba'),
('Danemark'),
('Djibouti'),
('Dominique'),
('Égypte'),
('El Salvador'),
('Émirats Arabes Unis'),
('Équateur'),
('Érythrée'),
('Espagne'),
('Estonie'),
('États Fédérés de Micronésie'),
('États-Unis'),
('Éthiopie'),
('Fédération de Russie'),
('Fidji'),
('Finlande'),
('France'),
('Gabon'),
('Gambie'),
('Géorgie'),
('Géorgie du Sud et les Îles Sandwich du Sud'),
('Ghana'),
('Gibraltar'),
('Grèce'),
('Grenade'),
('Groenland'),
('Guadeloupe'),
('Guam'),
('Guatemala'),
('Guinée'),
('Guinée Équatoriale'),
('Guinée-Bissau'),
('Guyana'),
('Guyane Française'),
('Haïti'),
('Honduras'),
('Hong-Kong'),
('Hongrie'),
('Île Bouvet'),
('Île Christmas'),
('Île de Man'),
('Île Norfolk'),
('Îles (malvinas) Falkland'),
('Îles Åland'),
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
('Népal'),
('Nicaragua'),
('Niger'),
('Nigéria'),
('Niué'),
('Norvège'),
('Nouvelle-Calédonie'),
('Nouvelle-Zélande'),
('Oman'),
('Ouganda'),
('Ouzbékistan'),
('Pakistan'),
('Palaos'),
('Panama'),
('Papouasie-Nouvelle-Guinée'),
('Paraguay'),
('Pays-Bas'),
('Pérou'),
('Philippines'),
('Pitcairn'),
('Pologne'),
('Polynésie Française'),
('Porto Rico'),
('Portugal'),
('Qatar'),
('République Arabe Syrienne'),
('République Centrafricaine'),
('République de Corée'),
('République de Moldova'),
('République Démocratique du Congo'),
('République Démocratique Populaire Lao'),
('République Dominicaine'),
('République du Congo'),
('République Islamique d\'Iran'),
('République Populaire Démocratique de Corée'),
('République Tchèque'),
('République-Unie de Tanzanie'),
('Réunion'),
('Roumanie'),
('Royaume-Uni'),
('Rwanda'),
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
('Sénégal'),
('Serbie-et-Monténégro'),
('Seychelles'),
('Sierra Leone'),
('Singapour'),
('Slovaquie'),
('Slovénie'),
('Somalie'),
('Soudan'),
('Sri Lanka'),
('Suède'),
('Suisse'),
('Suriname'),
('Svalbard etÎle Jan Mayen'),
('Swaziland'),
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
('Zimbabwe');

-- --------------------------------------------------------

--
-- Structure de la table `periode_inactivite`
--

CREATE TABLE `periode_inactivite` (
  `ID_Inactivite` int(11) NOT NULL,
  `Motif` char(50) NOT NULL,
  `Date_Debut_Inactivite` date NOT NULL,
  `Date_Fin_Inactivite` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `periode_inactivite`
--

INSERT INTO `periode_inactivite` (`ID_Inactivite`, `Motif`, `Date_Debut_Inactivite`, `Date_Fin_Inactivite`) VALUES
(6, 'Maladie', '2020-07-28', '2020-07-29'),
(12, 'Grippe', '2020-06-12', '2020-07-12');

-- --------------------------------------------------------

--
-- Structure de la table `personne`
--

CREATE TABLE `personne` (
  `ID_Personne` int(11) NOT NULL,
  `Statut` char(50) NOT NULL,
  `Nom` char(50) NOT NULL,
  `Prenom` char(50) NOT NULL,
  `Date_Naissance` date NOT NULL,
  `Telephone` varchar(15) NOT NULL,
  `Password` varchar(30) DEFAULT NULL,
  `N_Securite_Sociale` varchar(13) DEFAULT NULL,
  `N_BEES` varchar(20) DEFAULT NULL,
  `N_Permis` varchar(20) DEFAULT NULL,
  `Contrat` char(50) DEFAULT NULL,
  `Date_Embauche` date DEFAULT NULL,
  `Date_Visite_Medicale` date DEFAULT NULL,
  `ID_Adresse` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `personne`
--

INSERT INTO `personne` (`ID_Personne`, `Statut`, `Nom`, `Prenom`, `Date_Naissance`, `Telephone`, `Password`, `N_Securite_Sociale`, `N_BEES`, `N_Permis`, `Contrat`, `Date_Embauche`, `Date_Visite_Medicale`, `ID_Adresse`) VALUES
(4, 'Client', 'Marcon', 'Baptiste', '1999-06-30', '+336664366312', NULL, NULL, NULL, '', NULL, NULL, NULL, 4),
(8, 'Employé', 'Foillard', 'Jean', '1965-02-22', '+33606078606', NULL, '1234547687', '432543564', '432027483', 'CDD', '2020-04-01', '2020-04-03', 3),
(9, 'Client', 'Foillard', 'Benoit', '2000-12-03', '+33643537645', NULL, NULL, NULL, '', NULL, NULL, NULL, 27),
(10, 'Client', 'Foillard', 'Fabienne', '2000-12-03', '+33643537645', NULL, NULL, NULL, '', NULL, NULL, NULL, 28),
(11, 'Employé', 'Reynaud', 'Bastien', '2000-07-06', '+33672781633', NULL, '1234547687', '3232453433', '43256788', 'CDI', '2020-05-01', '2020-05-03', 29),
(15, 'Employé', 'Foillard', 'Maxime', '2000-03-25', '+33606060606', NULL, '1234547687', '432543564', '432567883', 'CDI', '2020-04-01', '2020-04-03', 2),
(16, 'Employé', 'Tétrault', 'Alexandrie', '1998-10-22', '+33629384921', NULL, '23468651829', '2849371039', '32132142312', 'CDI', '2019-07-01', '2020-07-10', 30);

-- --------------------------------------------------------

--
-- Structure de la table `prix_horaire`
--

CREATE TABLE `prix_horaire` (
  `ID_Prix_Horaire` int(11) NOT NULL,
  `Duree` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `prix_horaire`
--

INSERT INTO `prix_horaire` (`ID_Prix_Horaire`, `Duree`) VALUES
(1, 30),
(2, 60),
(3, 120);

-- --------------------------------------------------------

--
-- Structure de la table `prix_horaire_equipement`
--

CREATE TABLE `prix_horaire_equipement` (
  `ID_Prix_Horaire` int(11) NOT NULL,
  `ID_Equipement` int(11) NOT NULL,
  `Prix` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `prix_horaire_equipement`
--

INSERT INTO `prix_horaire_equipement` (`ID_Prix_Horaire`, `ID_Equipement`, `Prix`) VALUES
(1, 1, 80),
(1, 2, 70),
(1, 3, 90),
(1, 4, 40),
(1, 5, 40),
(1, 7, 40),
(2, 1, 130),
(2, 2, 120),
(2, 3, 140),
(2, 6, 100),
(3, 1, 220),
(3, 2, 200),
(3, 3, 240),
(3, 6, 180);

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

CREATE TABLE `reservation` (
  `ID_Reservation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `reservation`
--

INSERT INTO `reservation` (`ID_Reservation`) VALUES
(1),
(2);

-- --------------------------------------------------------

--
-- Structure de la table `reservation_client_employe`
--

CREATE TABLE `reservation_client_employe` (
  `ID_Reservation` int(11) NOT NULL,
  `ID_Personne` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `reservation_client_employe`
--

INSERT INTO `reservation_client_employe` (`ID_Reservation`, `ID_Personne`) VALUES
(1, 4),
(2, 9);

-- --------------------------------------------------------

--
-- Structure de la table `ville`
--

CREATE TABLE `ville` (
  `ID_Ville` int(11) NOT NULL,
  `Nom_Ville` char(50) NOT NULL,
  `Code_Postal` varchar(255) NOT NULL,
  `Nom_Pays` char(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ville`
--

INSERT INTO `ville` (`ID_Ville`, `Nom_Ville`, `Code_Postal`, `Nom_Pays`) VALUES
(1, 'AIX EN PROVENCE', '13100', 'France'),
(2, 'CANNES', '06400', 'France'),
(3, 'AIX EN PROVENCE', '13090', 'France'),
(4, 'AIX EN PROVENCE', '13540', 'France'),
(46342, 'PORT LOUIS', '56290', 'Maurice'),
(46343, 'LYON', '69003', 'France');

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
  MODIFY `ID_Adresse` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `equipement`
--
ALTER TABLE `equipement`
  MODIFY `ID_Equipement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `periode_inactivite`
--
ALTER TABLE `periode_inactivite`
  MODIFY `ID_Inactivite` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `personne`
--
ALTER TABLE `personne`
  MODIFY `ID_Personne` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `prix_horaire`
--
ALTER TABLE `prix_horaire`
  MODIFY `ID_Prix_Horaire` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `ID_Reservation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `ville`
--
ALTER TABLE `ville`
  MODIFY `ID_Ville` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46344;

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
