<?php
/**
 * Class Modele
 * Template de classe modèle. Dupliquer et modifier pour votre usage.
 * 
 * @author Jonathan Martel
 * @version 1.0
 * @update 2013-12-11
 * @license Creative Commons BY-NC 3.0 (Licence Creative Commons Attribution - Pas d’utilisation commerciale 3.0 non transposé)
 * @license http://creativecommons.org/licenses/by-nc/3.0/deed.fr
 * 
 */
class Categorie {
	
    
	function __construct ()
	{
		
	}
	
	function __destruct ()
	{
		
	}
	
		
	/**
	 * @access public
	 * @return Array
	 */
	public function getAllCategories($langue) 
	{
				
        $infoCategorie = array();
        
        self::$database->query('SELECT idCategorie, nomCategorie:langue FROM Categories');
        
        //Lie les paramètres aux valeurs
        self::$database->bind(':langue', $langue);
        
        if ($categoriesBDD = self::$database->resultset()) {
            foreach ($categoriesBDD as $categorie) {
                $uneCategorie = array("idCategorie"=>$categorie["idCategorie"], "nomCategorie"=>$categorie["idCategorie"]);
                $infoCategories[] = $uneCategorie;
            }
        }
        return $infoCategories;
		
	}
}




?>