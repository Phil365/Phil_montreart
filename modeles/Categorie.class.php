<?php

class Categorie {
	
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
	public function getAllCategories($langue) {
				
        $infoCategories = array();
        
        self::$database->query('SELECT idCategorie, nomCategorie' . $langue . ' FROM Categories');
        
        //Lie les paramètres aux valeurs
        self::$database->bind(':langue', $langue);
        
        if ($categories = self::$database->resultset()) {
            foreach ($categories as $categorie) {
                $infoCategories[] = $categorie;
            }
        }
        return $infoCategories;
	}
    
    /**
    * @brief Méthode qui récupère l'ID en fonction du nom passé en paramètre, s'il existe.
    * @param string $nomCategorie
    * @access private
    * @return string ou boolean
    */
    public function getCategorieIdByName($nomCategorie) {
        
        self::$database->query('SELECT idCategorie FROM Categories WHERE Categories.nomCategorieFR = :nomCategorie OR Categories.nomCategorieEN = :nomCategorie');

        //Lie les paramètres aux valeurs
        self::$database->bind(':nomCategorie', $nomCategorie);

        if ($categorie = self::$database->uneLigne()) {//Si trouvé dans la BDD
            return $categorie["idCategorie"];
        }
        else {
            return false;
        }
    }
    
    /**
    * @brief Méthode qui ajoute une catégorie à la BDD.
    * @param string $nomCategorieFR
    * @param string $nomCategorieEN
    * @access public
    * @return void
    */
    public function ajouterCategorie($nomCategorieFR, $nomCategorieEN) {
        try {
            self::$database->query('INSERT INTO Categories (nomCategorieFR, nomCategorieEN) VALUES (:nomCategorieFR, :nomCategorieEN)');
            self::$database->bind(':nomCategorieFR', $nomCategorieFR);
            self::$database->bind(':nomCategorieEN', $nomCategorieEN);
            self::$database->execute();
        }
        catch(Exception $e) {
            echo "erreur lors de l'insertion : " . $e;
            exit;
        } 
    }
    
//    function chercheParCategorie($keyword) {
//        
//    
//    self::$database->query("SELECT idCategorie, nomCategorie ".$langue." FROM Categories;");
//                           /*SELECT nomCategorieFR, nomCategorieEN  FROM categories JOIN oeuvres ON oeuvres.idCategorie = categories.idCategorie Group By nomCategorieFR*/
//                           /*SELECT nomCategorieFR, nomCategorieEN, idOeuvre FROM categories, oeuvres Where oeuvres.idCategorie = categories.idCategorie Group By idOeuvre*/
//    $keyword = $keyword.'%';
//
//    self::$database->bind(1, $keyword);
//    
//    $results = array();
//
//   if ($oeuvreBDD = self::$database->uneLigne()) {//Si trouvé dans la BDD
//        $results = array("idOeuvre"=>$oeuvreBDD['idOeuvre'],"titre"=>$oeuvreBDD['titre']);
//    }
//
//    return $results;
//
//    }
}
?>