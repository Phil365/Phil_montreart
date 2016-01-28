<?php

/**
* @brief class Artiste
* @author David Lachambre
* @version 1.0
* @update 2016-01-13
*/
class Artiste {
	
    private static $database;
    
	function __construct() {
        
        if (!isset(self::$database)) {//Connection à la BDD si pas déjà connecté
            
            self::$database = BaseDeDonnees::getInstance();
        }
    }
		
	/**
    * @brief Méthode qui tous les artistes dans la BDD.
    * @access public
    * @return array
    */
	public function getAllArtistes() 
	{
				
        $infoArtistes = array();
        
        self::$database->query('SELECT * FROM Artistes');
        
        if ($artistes = self::$database->resultset()) {
            foreach ($artistes as $artiste) {
                $infoArtistes[] = $artiste;
            }
        }
        return $infoArtistes;
	}
    
    function chercheParArtiste($keyword) {
    
        $infoOeuvres = array();
            
        self::$database->query("SELECT Oeuvres.titre, Oeuvres.idOeuvre, CONCAT(prenomArtiste, ' ', nomArtiste) AS nomCompletArtiste, nomCollectif, Artistes.idArtiste FROM Oeuvres JOIN OeuvresArtistes ON Oeuvres.idOeuvre = OeuvresArtistes.idOeuvre JOIN Artistes ON OeuvresArtistes.idArtiste = Artistes.idArtiste WHERE (nomArtiste IS NOT NULL OR nomCollectif IS NOT NULL) AND authorise = true AND (prenomArtiste LIKE :keyword OR nomArtiste LIKE :keyword OR nomCollectif LIKE :keyword) GROUP BY idArtiste");

        $keyword = '%'.$keyword.'%';

        self::$database->bind(':keyword', $keyword);
        $results = array();

       if ($oeuvreBDD = self::$database->resultset()) {//Si trouvé dans la BDD
            foreach ($oeuvreBDD as $oeuvre) {
                $infoOeuvres[] = $oeuvre;
            }
        }
        return $infoOeuvres;
    }
    
    /**
    * @brief Méthode qui ajoute un artiste à la BDD.
    * @param string $prenomArtiste
    * @param string $nomArtiste
    * @param string $nomCollectif
    * @access private
    * @return void
    */
    public function ajouterArtiste($prenomArtiste, $nomArtiste, $nomCollectif) {
        try {
            self::$database->query('INSERT INTO Artistes (prenomArtiste, nomArtiste, nomCollectif) VALUES (:prenomArtiste, :nomArtiste, :nomCollectif)');
            self::$database->bind(':prenomArtiste', $prenomArtiste);
            self::$database->bind(':nomArtiste', $nomArtiste);
            self::$database->bind(':nomCollectif', $nomCollectif);
            self::$database->execute();
        }
        catch(Exception $e) {
            echo "erreur lors de l'insertion : " . $e;
            exit;
        } 
    }
    
    /**
    * @brief Méthode qui récupère l'ID en fonction du nom passé en paramètre, s'il existe.
    * @param string $prenomArtiste
    * @param string $nomArtiste
    * @param string $nomCollectif
    * @access private
    * @return string ou boolean
    */
    public function getArtisteIdByName($prenomArtiste, $nomArtiste, $nomCollectif) {
        
        if (isset($nomCollectif)) {//Si l'artiste est un collectif...

            self::$database->query('SELECT idArtiste FROM Artistes WHERE Artistes.nomCollectif = :nomCollectif');
            self::$database->bind(':nomCollectif', $nomCollectif);
        }
        else if (isset($nomArtiste)) {
            if (isset($prenomArtiste)) {//Si l'artiste à un nom et un prénom...
                self::$database->query('SELECT idArtiste FROM Artistes WHERE Artistes.nomArtiste = :nomArtiste AND Artistes.prenomArtiste = :prenomArtiste');
                self::$database->bind(':prenomArtiste', $prenomArtiste);
            }
            else {//Sans prénom...
                self::$database->query('SELECT idArtiste FROM Artistes WHERE Artistes.nomArtiste = :nomArtiste AND Artistes.prenomArtiste IS NULL');
            }
            self::$database->bind(':nomArtiste', $nomArtiste);
        }
        else {//Artiste anonyme...
            return "1";//ID pour les entrées anonymes dans la BDD
        }

        if ($Artiste = self::$database->uneLigne()) {//Si trouvé dans la BDD
            return $Artiste["idArtiste"];
        }
        else {
            return false;
        }
    }
    
    /**
    * @brief Méthode qui récupère les artistes d'une oeuvre.
    * @param int $idOeuvre
    * @access public
    * @return array
    */
    public function getArtistesbyOeuvreId ($idOeuvre) {
        
        $artistes = array();
        
        self::$database->query('SELECT * FROM Artistes JOIN OeuvresArtistes ON OeuvresArtistes.idArtiste = Artistes.idArtiste WHERE OeuvresArtistes.idOeuvre = :idOeuvre');
        self::$database->bind(':idOeuvre', $idOeuvre);
        
        if ($lignes = self::$database->resultset()) {
            foreach ($lignes as $ligne) {
                $artistes[] = $ligne;
            }
            return $artistes;
        }
    }
    
    /**
    * @brief Méthode qui crée le lien entre oeuvre et artistes dans la BDD.
    * @param int $idOeuvre
    * @param array $idArtistes
    * @access public
    * @return void
    */
    public function lierArtistesOeuvre ($idOeuvre, $idArtistes) {
        
        foreach ($idArtistes as $idArtiste) {
            
            self::$database->query('INSERT INTO OeuvresArtistes (idOeuvre, idArtiste) VALUES (:idOeuvre, :idArtiste)');
        
            self::$database->bind(':idOeuvre', $idOeuvre);
            self::$database->bind(':idArtiste', $idArtiste);

            self::$database->execute();
        }
    }
    
    public function lierArtistesOeuvrePoursoummision ($idOeuvre, $idArtiste) {
        
        self::$database->query('INSERT INTO OeuvresArtistes (idOeuvre, idArtiste) VALUES (:idOeuvre, :idArtiste)');

        self::$database->bind(':idOeuvre', $idOeuvre);
        self::$database->bind(':idArtiste', $idArtiste);

        self::$database->execute();  
    }
}
?>