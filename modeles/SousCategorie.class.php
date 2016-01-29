<?php

/**
* @brief class SousCategorie
* @author David Lachambre
* @version 1.0
* @update 2016-01-13
*/
class SousCategorie {
	
    private static $database;
    
	function __construct() {
        
        if (!isset(self::$database)) {//Connection à la BDD si pas déjà connecté
            
            self::$database = BaseDeDonnees::getInstance();
        }
    }
		
	/**
    * @brief Méthode qui récupère toutes les sous-catégories dans la BDD.
    * @param string $langue
    * @access public
    * @return array
    */
	public function getAllSousCategories($langue) {
				
        $infoSousCategories = array();
        
        self::$database->query('SELECT idSousCategorie, sousCategorie' . $langue . ' FROM SousCategories');
        
        //Lie les paramètres aux valeurs
        self::$database->bind(':langue', $langue);
        
        if ($sousCategories = self::$database->resultset()) {
            foreach ($sousCategories as $sousCategorie) {
                $infoSousCategories[] = $sousCategorie;
            }
        }
        return $infoSousCategories;
	}
    
    /**
    * @brief Méthode qui récupère l'ID en fonction du nom passé en paramètre, s'il existe.
    * @param string $nomSousCategorie
    * @access public
    * @return string ou boolean
    */
    public function getSousCategorieIdByName($nomSousCategorie) {
        
        self::$database->query('SELECT idSousCategorie FROM SousCategories WHERE SousCategories.sousCategorieFR = :nomSousCategorie OR SousCategories.sousCategorieEN = :nomSousCategorie');

        //Lie les paramètres aux valeurs
        self::$database->bind(':nomSousCategorie', $nomSousCategorie);

        if ($SousCategorie = self::$database->uneLigne()) {//Si trouvé dans la BDD
            return $SousCategorie["idSousCategorie"];
        }
        else {
            return false;
        }
    }
    
    /**
    * @brief Méthode qui ajoute une sous-catégorie à la BDD.
    * @param string $nomSousCategorieFR
    * @param string $nomSousCategorieEN
    * @access private
    * @return void
    */
    public function ajouterSousCategorie($nomSousCategorieFR, $nomSousCategorieEN) {
        try {
            self::$database->query('INSERT INTO SousCategories (sousCategorieFR, sousCategorieEN) VALUES (:nomSousCategorieFR, :nomSousCategorieEN)');
            self::$database->bind(':nomSousCategorieFR', $nomSousCategorieFR);
            self::$database->bind(':nomSousCategorieEN', $nomSousCategorieEN);
            self::$database->execute();
        }
        catch(Exception $e) {
            echo "erreur lors de l'insertion : " . $e;
            exit;
        } 
    }
}
?>