DROP TABLE IF EXISTS Oeuvres ;
CREATE TABLE Oeuvres (idOeuvre INT  AUTO_INCREMENT NOT NULL,
titre VARCHAR(50),
noInterneMtl INT(5) UNIQUE,
latitude VARCHAR(10),
longitude VARCHAR(10),
parc VARCHAR(50),
batiment VARCHAR(50),
adresse VARCHAR(100),
descriptionFR TEXT,
descriptionEN TEXT,
authorise boolean NOT NULL,
idCollection INT,
idCategorie INT,
idArrondissement INT,
idArtiste INT,
PRIMARY KEY (idOeuvre) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS Collections ;
CREATE TABLE Collections (idCollection INT  AUTO_INCREMENT NOT NULL,
nomCollectionFR VARCHAR(50) UNIQUE,
nomCollectionEN VARCHAR(50) UNIQUE,
PRIMARY KEY (idCollection) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS Categories ;
CREATE TABLE Categories (idCategorie INT  AUTO_INCREMENT NOT NULL,
nomCategorieFR VARCHAR(50) UNIQUE,
nomCategorieEN VARCHAR(50) UNIQUE,
PRIMARY KEY (idCategorie) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS SousCategories ;
CREATE TABLE SousCategories (idSousCategorie INT  AUTO_INCREMENT NOT NULL,
sousCategorieFR VARCHAR(50),
sousCategorieEN VARCHAR(50),
idCategorie INT NOT NULL,
PRIMARY KEY (idSousCategorie) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS Arrondissements ;
CREATE TABLE Arrondissements (idArrondissement INT  AUTO_INCREMENT NOT NULL,
nomArrondissement VARCHAR(50) UNIQUE,
PRIMARY KEY (idArrondissement) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS Artistes ;
CREATE TABLE Artistes (idArtiste INT  AUTO_INCREMENT NOT NULL,
prenomArtiste VARCHAR(50),
nomArtiste VARCHAR(50),
PRIMARY KEY (idArtiste) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS Photos ;
CREATE TABLE Photos (idPhoto INT  AUTO_INCREMENT NOT NULL,
image VARCHAR(100) UNIQUE,
authorise boolean NOT NULL,
idOeuvre INT NOT NULL,
PRIMARY KEY (idPhoto) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS Utilisateurs ;
CREATE TABLE Utilisateurs (idUtilisateur INT  AUTO_INCREMENT NOT NULL,
nomUsager VARCHAR(50) UNIQUE,
motPasse VARCHAR(32),
prenom VARCHAR(50),
nom VARCHAR(50),
courriel VARCHAR(50) UNIQUE,
descriptionProfil TEXT,
photoProfil VARCHAR(100) UNIQUE,
administrateur BOOL,
PRIMARY KEY (idUtilisateur) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS Commentaires ;
CREATE TABLE Commentaires (idCommentaire INT  AUTO_INCREMENT NOT NULL,
texteCommentaire TEXT,
voteCommentaire SMALLINT,
langueCommentaire CHAR(2),
authorise boolean NOT NULL,
idOeuvre INT NOT NULL,
idUtilisateur INT NOT NULL,
PRIMARY KEY (idCommentaire) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS Visitent ;
CREATE TABLE Visitent (idOeuvre INT  AUTO_INCREMENT NOT NULL,
idUtilisateur INT NOT NULL,
dateVisite DATE,
PRIMARY KEY (idOeuvre,
 idUtilisateur) ) ENGINE=InnoDB;

ALTER TABLE SousCategories ADD CONSTRAINT FK_SousCategories_idCategorie FOREIGN KEY (idCategorie) REFERENCES Categories (idCategorie) ON DELETE CASCADE;
ALTER TABLE Oeuvres ADD CONSTRAINT FK_Oeuvres_idCollection FOREIGN KEY (idCollection) REFERENCES Collections (idCollection);
ALTER TABLE Oeuvres ADD CONSTRAINT FK_Oeuvres_idCategorie FOREIGN KEY (idCategorie) REFERENCES Categories (idCategorie);
ALTER TABLE Oeuvres ADD CONSTRAINT FK_Oeuvres_idArrondissement FOREIGN KEY (idArrondissement) REFERENCES Arrondissements (idArrondissement);
ALTER TABLE Oeuvres ADD CONSTRAINT FK_Oeuvres_idArtiste FOREIGN KEY (idArtiste) REFERENCES Artistes (idArtiste);
ALTER TABLE Photos ADD CONSTRAINT FK_Photos_idOeuvre FOREIGN KEY (idOeuvre) REFERENCES Oeuvres (idOeuvre) ON DELETE CASCADE;
ALTER TABLE Commentaires ADD CONSTRAINT FK_Commentaires_idOeuvre FOREIGN KEY (idOeuvre) REFERENCES Oeuvres (idOeuvre) ON DELETE CASCADE;
ALTER TABLE Commentaires ADD CONSTRAINT FK_Commentaires_idUtilisateur FOREIGN KEY (idUtilisateur) REFERENCES Utilisateurs (idUtilisateur);
ALTER TABLE Visitent ADD CONSTRAINT FK_Visitent_idOeuvre FOREIGN KEY (idOeuvre) REFERENCES Oeuvres (idOeuvre);
ALTER TABLE Visitent ADD CONSTRAINT FK_Visitent_idUtilisateur FOREIGN KEY (idUtilisateur) REFERENCES Utilisateurs (idUtilisateur) ON DELETE CASCADE;

INSERT INTO Collections VALUES (1,"Art public","Public art");
INSERT INTO Categories VALUES (1,"Beaux-arts","Fine Arts");
INSERT INTO SousCategories VALUES (1,"Sculpture","Sculpture", 1);
INSERT INTO Arrondissements VALUES (1,"Côte-des-Neiges–Notre-Dame-de-Grâce");
INSERT INTO Artistes VALUES (1,"Patrick","Coutu");
INSERT INTO Oeuvres VALUES (1,"Source", 960,45.466405,-73.631648,"Parc Benny","Centre sportif Notre-Dame-de Grâce","6445, avenue Monkland, Montréal","super magnifique","super beautyfull",true,1,1,1,1);
INSERT INTO Photos VALUES (1,"source.jpg",true,1);
INSERT INTO SousCategories VALUES (2,"Installation","Installation", 1);
INSERT INTO Arrondissements VALUES (2,"Ville-Marie");
INSERT INTO Artistes VALUES (2,"Jocelyne","Alloucherie");
INSERT INTO Oeuvres VALUES ( 2,"Porte de jour",1098,45.512090,-73.550979,"Square Dalhousie",null,null,"super magnifique","super beautyfull",true,1,1,2,2);
INSERT INTO Photos VALUES (2,"porte.jpg",true,2);
INSERT INTO Arrondissements VALUES (3,"Rosemont–La Petite-Patrie");
INSERT INTO Oeuvres VALUES ( 3,"Regarder les pommetiers", 1119,45.561585,-73.562673,"Jardin botanique","Jardin botanique","4101, rue Sherbrooke Est, Montréal (QC) H1X 2B2","super magnifique","super beautyfull",true,1,1,3,2);
INSERT INTO Photos VALUES (3,"pommetiers.jpg",true,3);
INSERT INTO Oeuvres VALUES ( 4,"Le chat de Gaspar", null, null, null, null, null, "3306 pie-ix montreal", "c'est un chat semble t'il magnifique", null,true,1,1,1,1);
INSERT INTO Oeuvres VALUES ( 5,"Intemporel", null, null, null, null, null, "5985 Turenne Montreal", null, "Arts it's like a box of chocolate you never know what you're getting",false,1,1,1,1);
INSERT INTO Photos VALUES (4,"lion.jpg",false,5);
INSERT INTO Photos VALUES (5,"chat.jpg",true,4);
INSERT INTO Utilisateurs VALUES ( 1,"dlachambre", "dl12345","David","Lachambre","dlachambre@montreart.net", "J'aime les marches sur la plage et le tricot extrême.", "photoProfilDefaut.jpg", true);
INSERT INTO Commentaires VALUES (1,"Trop hot !", 5, "FR", true, 3, 1);
