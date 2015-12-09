DROP TABLE IF EXISTS Oeuvres ;
CREATE TABLE Oeuvres (idOeuvre INT  AUTO_INCREMENT NOT NULL,
titre VARCHAR(50),
noInterneMtl INT(5),
latitude VARCHAR(10),
longitude VARCHAR(10),
parc VARCHAR(50),
batiment VARCHAR(50),
adresse VARCHAR(100),
descriptionFR TEXT,
descriptionEN TEXT,
idCollection INT,
idCategorie INT,
idArrondissement INT,
idArtiste INT,
PRIMARY KEY (idOeuvre) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS Collections ;
CREATE TABLE Collections (idCollection INT  AUTO_INCREMENT NOT NULL,
nomCollectionFR VARCHAR(50),
nomCollectionEN VARCHAR(50),
PRIMARY KEY (idCollection) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS Categories ;
CREATE TABLE Categories (idCategorie INT  AUTO_INCREMENT NOT NULL,
nomCategorieFR VARCHAR(50),
nomCategorieEN VARCHAR(50),
sousCategorieFR VARCHAR(50),
sousCategorieEN VARCHAR(50),
PRIMARY KEY (idCategorie) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS Arrondissements ;
CREATE TABLE Arrondissements (idArrondissement INT  AUTO_INCREMENT NOT NULL,
nomArrondissement VARCHAR(50),
PRIMARY KEY (idArrondissement) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS Artistes ;
CREATE TABLE Artistes (idArtiste INT  AUTO_INCREMENT NOT NULL,
prenomArtiste VARCHAR(50),
nomArtiste VARCHAR(50),
PRIMARY KEY (idArtiste) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS Photos ;
CREATE TABLE Photos (idPhoto INT  AUTO_INCREMENT NOT NULL,
urlPhoto VARCHAR(100),
idOeuvre INT NOT NULL,
PRIMARY KEY (idPhoto) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS Utilisateurs ;
CREATE TABLE Utilisateurs (idUtilisateur INT  AUTO_INCREMENT NOT NULL,
nomUsager VARCHAR(50),
motPasse VARCHAR(32),
prenom VARCHAR(50),
nom VARCHAR(50),
courriel VARCHAR(50),
descriptionProfil TEXT,
urlPhotoProfil VARCHAR(100),
administrateur BOOL,
PRIMARY KEY (idUtilisateur) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS Commentaires ;
CREATE TABLE Commentaires (idCommentaire INT  AUTO_INCREMENT NOT NULL,
texteCommentaire TEXT,
voteCommentaire SMALLINT,
langueCommentaire CHAR(2),
idOeuvre INT NOT NULL,
idUtilisateur INT NOT NULL,
PRIMARY KEY (idCommentaire) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS PhotosSoumises ;
CREATE TABLE PhotosSoumises (idPhotoSoumise INT  AUTO_INCREMENT NOT NULL,
urlPhotoSoumise VARCHAR(100),
idOeuvre INT NOT NULL,
PRIMARY KEY (idPhotoSoumise) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS CommentairesSoumis ;
CREATE TABLE CommentairesSoumis (idCommentaireSoumis INT  AUTO_INCREMENT NOT NULL,
commentaireSoumis TEXT,
voteCommentaireSoumis SMALLINT,
langueCommentaireSoumis CHAR(2),
idOeuvre INT NOT NULL,
idUtilisateur INT NOT NULL,
PRIMARY KEY (idCommentaireSoumis) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS OeuvresSoumises ;
CREATE TABLE OeuvresSoumises (idOeuvreSoumise INT  AUTO_INCREMENT NOT NULL,
titreOeuvreSoumise VARCHAR(50),
descriptionOeuvreSoumise TEXT,
adresseOeuvreSoumise VARCHAR(100),
langueOeuvreSoumise CHAR(2),
urlPhotoOeuvreSoumise VARCHAR(100),
PRIMARY KEY (idOeuvreSoumise) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS Visitent ;
CREATE TABLE Visitent (idOeuvre INT  AUTO_INCREMENT NOT NULL,
idUtilisateur INT NOT NULL,
dateVisite DATE,
PRIMARY KEY (idOeuvre,
 idUtilisateur) ) ENGINE=InnoDB;

ALTER TABLE Oeuvres ADD CONSTRAINT FK_Oeuvres_idCollection FOREIGN KEY (idCollection) REFERENCES Collections (idCollection);

ALTER TABLE Oeuvres ADD CONSTRAINT FK_Oeuvres_idCategorie FOREIGN KEY (idCategorie) REFERENCES Categories (idCategorie);
ALTER TABLE Oeuvres ADD CONSTRAINT FK_Oeuvres_idArrondissement FOREIGN KEY (idArrondissement) REFERENCES Arrondissements (idArrondissement);
ALTER TABLE Oeuvres ADD CONSTRAINT FK_Oeuvres_idArtiste FOREIGN KEY (idArtiste) REFERENCES Artistes (idArtiste);
ALTER TABLE Photos ADD CONSTRAINT FK_Photos_idOeuvre FOREIGN KEY (idOeuvre) REFERENCES Oeuvres (idOeuvre) ON DELETE CASCADE;
ALTER TABLE Commentaires ADD CONSTRAINT FK_Commentaires_idOeuvre FOREIGN KEY (idOeuvre) REFERENCES Oeuvres (idOeuvre) ON DELETE CASCADE;
ALTER TABLE Commentaires ADD CONSTRAINT FK_Commentaires_idUtilisateur FOREIGN KEY (idUtilisateur) REFERENCES Utilisateurs (idUtilisateur);
ALTER TABLE PhotosSoumises ADD CONSTRAINT FK_PhotosSoumises_idOeuvre FOREIGN KEY (idOeuvre) REFERENCES Oeuvres (idOeuvre) ON DELETE CASCADE;
ALTER TABLE CommentairesSoumis ADD CONSTRAINT FK_CommentairesSoumis_idOeuvre FOREIGN KEY (idOeuvre) REFERENCES Oeuvres (idOeuvre) ON DELETE CASCADE;
ALTER TABLE CommentairesSoumis ADD CONSTRAINT FK_CommentairesSoumis_idUtilisateur FOREIGN KEY (idUtilisateur) REFERENCES Utilisateurs (idUtilisateur);
ALTER TABLE Visitent ADD CONSTRAINT FK_Visitent_idOeuvre FOREIGN KEY (idOeuvre) REFERENCES Oeuvres (idOeuvre);
ALTER TABLE Visitent ADD CONSTRAINT FK_Visitent_idUtilisateur FOREIGN KEY (idUtilisateur) REFERENCES Utilisateurs (idUtilisateur) ON DELETE CASCADE;

INSERT INTO Collections VALUES (1,"Art public","Public art");
INSERT INTO Categories VALUES (1,"Beaux-arts","Fine Arts","Sculpture","Sculpture");
INSERT INTO Arrondissements VALUES (1,"Côte-des-Neiges–Notre-Dame-de-Grâce");
INSERT INTO Artistes VALUES (1,"Patrick","Coutu");
INSERT INTO Oeuvres VALUES ( 1,"Source", 960,45.466405,-73.631648,"Parc Benny","Centre sportif Notre-Dame-de Grâce","6445, avenue Monkland, Montréal","super magnifique","super beautyfull",1,1,1,1);
INSERT INTO Photos VALUES (1,"http://artpublicmontreal.ca/wp-content/uploads/imported/962_4344.jpg",1);


INSERT INTO Categories VALUES (2,"Beaux-arts","Fine Arts","Installation","Installation");
INSERT INTO Arrondissements VALUES (2,"Ville-Marie");
INSERT INTO Artistes VALUES (2,"Jocelyne","Alloucherie");
INSERT INTO Oeuvres VALUES ( 2,"Porte de jour",1098,45.512090,-73.550979,"Square Dalhousie","","","super magnifique","super beautyfull",1,2,2,2);
INSERT INTO Photos VALUES (2,"http://artpublicmontreal.ca/wp-content/uploads/imported/1099_5287.jpg",2);


INSERT INTO Arrondissements VALUES (3,"Rosemont–La Petite-Patrie");
INSERT INTO Oeuvres VALUES ( 3,"Regarder les pommetiers", 1098,45.561585,-73.562673,"Jardin botanique","Jardin botanique","4101, rue Sherbrooke Est, Montréal (QC) H1X 2B2","super magnifique","super beautyfull",1,2,3,2);
INSERT INTO Photos VALUES (3,"http://artpublicmontreal.ca/wp-content/uploads/imported/1119_4036.jpg",3);

INSERT INTO OeuvresSoumises VALUES ( 1,"Le chat de Gaspar", "c'est un chat semble t'il magnifique","3306 pie-ix montreal","fr","http://imalbum.aufeminin.com/album/D20070810/323931_IKO56WMIT41K5WFAKCLVMOBNYZDNMI_chat-land-animaux-00237_H150344_L.jpg");
INSERT INTO OeuvresSoumises VALUES ( 2,"Intemporel", "Arts it's like a box of chocolate you never what you're getting","5985 Turenne Montreal","en","http://www.courtemanchecommunications.com/site/wp-content/uploads/Pinzon_naturalbeauty_.jpg");
