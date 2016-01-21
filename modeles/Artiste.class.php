<?php

class Artiste {
	
    private static $database;
    
	function __construct() {
        
        if (!isset(self::$database)) {//Connection à la BDD si pas déjà connecté
            
            self::$database = BaseDeDonnees::getInstance();
        }
    }
		
	/**
	 * @access public
	 * @return Array
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
    
    self::$database->query("SELECT titre, idOeuvre, prenomArtiste FROM oeuvres JOIN Artistes ON Artistes.idArtiste = Oeuvres.idArtiste WHERE prenomArtiste LIKE ? and authorise = true");
                           
    $keyword = $keyword.'%';

    self::$database->bind(1, $keyword);
   
    $results = array();

   if ($oeuvreBDD = self::$database->uneLigne()) {//Si trouvé dans la BDD
            $results = array("idOeuvre"=>$oeuvreBDD['idOeuvre'],"prenomArtiste"=>$oeuvreBDD['prenomArtiste']);
        }

    return $results;

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
}
?>