 <?php

/**
* @brief class Utilisateur
* @author Cristina Mahneke
* @version 1.0
* @update 2016-02-05
*/
class Membre extends Utilisateur {
 /**
    * @var integer $administrateur gere si l'utilisateur a droits d'administration sur la page ou pas
    * @access private
    */
	 private $administrateur;
     
   
      /**
    * @var object $database Connection à la BDD.
    * @access private
    */
    private static $database;
    
  function __construct() {
        
        if (!isset(self::$database)) {//Connection à la BDD si pas déjà connecté
            
            self::$database = BaseDeDonnees::getInstance();
        }
    }
    
   	public function setData($idUtilisateur, $nomUsager, $motPasse, $prenom, $nom, $courriel, $descriptionProfil, $photoProfil, $administrateur){
        $this->administrateur = 0;
		parent::setData($idUtilisateur, $nomUsager, $motPasse, $prenom, $nom, $courriel, $descriptionProfil, $photoProfil, $administrateur);
        
		
	}
     public function AjouterUtilisateur($nomUsager, $motPasse, $prenom, $nom, $courriel, $descriptionProfil, $administrateur){
        $this->administrateur = 0;
        parent::AjouterUtilisateur($nomUsager, $motPasse, $prenom, $nom, $courriel, $descriptionProfil, $administrateur);
     }
}
?>