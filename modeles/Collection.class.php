<?php

/**
* @brief class Collection
* @author David Lachambre
* @version 1.0
* @update 2016-01-13
*/
class Collection {
	
    private static $database;
    
	function __construct() {
        
        if (!isset(self::$database)) {//Connection à la BDD si pas déjà connecté
            
            self::$database = BaseDeDonnees::getInstance();
        }
    }
		
	/**
    * @brief Méthode qui récupère toutes les collections dans la BDD.
    * @param string $langue
    * @access public
    * @return array
    */
	public function getAllCollections($langue) {
				
        $infoCollections = array();
        
        self::$database->query('SELECT idCategorie, nomCategorie' . $langue . ' FROM Categories');
        
        //Lie les paramètres aux valeurs
        self::$database->bind(':langue', $langue);
        
        if ($collections = self::$database->resultset()) {
            foreach ($collections as $collection) {
                $infoCollections[] = $collection;
            }
        }
        return $infoCollections;
	}
    
    /**
    * @brief Méthode qui récupère l'ID en fonction du nom passé en paramètre, s'il existe.
    * @param string $nomCollection
    * @access private
    * @return string ou boolean
    */
    public function getCollectionIdByName($nomCollection) {
        
        self::$database->query('SELECT idCollection FROM Collections WHERE Collections.nomCollectionFR = :nomCollection OR Collections.nomCollectionEN = :nomCollection');

        //Lie les paramètres aux valeurs
        self::$database->bind(':nomCollection', $nomCollection);

        if ($collection = self::$database->uneLigne()) {//Si trouvé dans la BDD
            return $collection["idCollection"];
        }
        else {
            return false;
        }
    }
    
    /**
    * @brief Méthode qui ajoute une collection à la BDD.
    * @param string $nomCollectionFR
    * @param string $nomCollectionEN
    * @access private
    * @return void
    */
    public function ajouterCollection($nomCollectionFR, $nomCollectionEN) {
        try {
            self::$database->query('INSERT INTO Collections (nomCollectionFR, nomCollectionEN) VALUES (:nomCollectionFR, :nomCollectionEN)');
            self::$database->bind(':nomCollectionFR', $nomCollectionFR);
            self::$database->bind(':nomCollectionEN', $nomCollectionEN);
            self::$database->execute();
        }
        catch(Exception $e) {
            echo "erreur lors de l'insertion : " . $e;
            exit;
        } 
    }
}
?>