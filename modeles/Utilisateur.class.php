<?php

/**
* @brief class Utilisateur
* @author Cristina Mahneke
* @version 1.0
* @update 2016-02-05
*/
//require_once "lib/BDD/BaseDeDonnees.class.php";
class Utilisateur {
	 /**
    * @var integer $idUtilisateur id d'un utilisateur
    * @access private
    */ 
	private $idUtilisateur;
	
	 /**
    * @var string $nomUsager identifiant choisi par l'utilisateur
    * @access private
    */
	private $nomUsager;
	
	
	 /**
    * @var string $motPasse mot de passe de l'utilisateur
    * @access private
    */
	 private $motPasse;
	 
	 /**
    * @var string $prenom  prenom de l'utilisateur
    * @access private
    */
	 private $prenom;
	 
	  /**
    * @var string $nom nom de l'utilisateur
    * @access private
    */
	 private $nom;
	 
	   /**
    * @var string $courriel courriel electronique de l'utilisateur
    * @access private
    */
	 private $courriel;
	 
	   /**
    * @var string $descriptionProfil texte du description du profil de l'utilisateur
    * @access private
    */
	 private $descriptionProfil;
	 
	   /**
    * @var string $photoProfil chemin et nom du fichier image du profil de l'utilisateur
    * @access private
    */
	 private $photoProfil; 
	 
	  
	 
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
	
	/**
    * @brief Méthode qui assigne des valeurs aux propriétés de l'objet Utilisateur
     * @param string $nomUsager
    * @param string $motPasse
    * @param string $prenom
    * @param string $nom
	* @param string $courriel
	* @param string $descriptionProfil
	* @param string $photoProfil
	* @param string $administrateur
    * @access private
    * @return void
    */
	public function setData($idUtilisateur, $nomUsager, $motPasse, $prenom, $nom, $courriel, $descriptionProfil, $photoProfil, $administrateur){
		$this->idUtilisateur = $idUtilisateur;
		$this->nomUsager = $nomUsager;
		$this->motPasse = $motPasse;
		$this->prenom = $prenom;
		$this->nom = $nom;
		$this->courriel = $courriel;
		$this->descriptionProfil = $descriptionProfil;
		$this->photoProfil = $photoProfil;
		$this->administrateur = $administrateur;
	}
	
	/**
    * @brief méthode qui récupère les valeurs des propriétés de cet objet.
    * @access public
    * @return array
    */
	public function getData(){
		
		$resultat = array("idUtilisateur"=>$this->idUtilisateur, "nomUsager"=>$this->nomUsager, "motPasse"=>$this->motPasse, "prenom"=>$this->prenom, "nom"=>$this->nom, "courriel"=>$this->courriel, "descriptionProfil"=>$this->descriptionProfil, "photoProfil"=>$this->photoProfil, "administrateur"=>$this->administrateur);
		
		return $resultat;
	}
	
     /**
    * @brief Méthode qui ajoute un utilisateur à la BDD.
    * @param string $nomUsager
    * @param string $motPasse
    * @param string $prenom
    * @param string $nom
	* @param string $courriel
	* @param string $descriptionProfil
	* @param string $administrateur
    * @access private
    * @return void
    */
    public function AjouterUtilisateur($nomUsager, $motPasse, $prenom, $nom, $courriel, $descriptionProfil, $administrateur){
		$msgErreurs = $this->validerFormAjoutUtilisateur($nomUsager, $motPasse, $prenom, $nom, $courriel);
		 if (!empty($msgErreurs)) {
            return $msgErreurs;//Retourne le/les message(s) d'erreur de la validation.
        }
        else {
			try{
				
				self::$database->query('INSERT INTO utilisateurs (nomUsager, motPasse, prenom, nom, courriel, descriptionProfil, administrateur) VALUES (:nomUsager, :motPasse, :prenom, :nom, :courriel, :descriptionProfil, :administrateur)');
				self::$database->bind(':nomUsager', $nomUsager);
				self::$database->bind(':motPasse', $motPasse);
				self::$database->bind(':prenom', $prenom);
				self::$database->bind(':nom', $nom);
				self::$database->bind(':courriel', $courriel);
				self::$database->bind(':descriptionProfil', $descriptionProfil);
				self::$database->bind(':administrateur', $administrateur);
				self::$database->execute();
				$msgInsertPhoto=$this->insererPhotoProfil($nomUsager);
				if ($msgInsertPhoto != "" && $_FILES["photoProfil"]["error"] != 4) {
	                   $msgErreurs["errPhoto"] = $msgInsertPhoto;
	                }
			}catch(Exception $e){
				 echo "erreur lors de l'insertion : " . $e;
				exit;
			}
		 }
        return $msgErreurs;//array vide = succès. 
    }
	/**
    * @brief Méthode qui insere/met a jour la photo profil d'un utilisateur à la BDD par son nom usager.
    * @param string $nomUsager
    * @access private
    * @return string
    */
	public function insererPhotoProfil($nomUsager){
		 $msgUtilisateur = "";
        $erreurs = false;
        
        if ($_FILES["photoProfil"]["error"] != 4) {

            $target_dir = "images/photosUsagers/";
            $temp = explode(".", $_FILES["photoProfil"]["name"]);
            $nouveauNomImage = round(microtime(true)) . '.' . end($temp);      
            $target_file = $target_dir .$nouveauNomImage;
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            $pic=($_FILES["photoProfil"]["name"]);
            
			
			// Valider l'extension et taille de l'image
                
                if ($_FILES["photoProfil"]["size"] > 5000000 || ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif")) {
                    $erreurs = true;
                    $msgUtilisateur = "Votre fichier doit être de type Jpeg ou Png et inférieur à 5Mb.<br>";
                }
                if (!$erreurs) {
                    self::$database->query("UPDATE utilisateurs SET photoProfil = 'images/photosUsagers/$nouveauNomImage' WHERE nomUsager = :nomUsager");

                    self::$database->bind(':nomUsager', $nomUsager);
                   

                    try {
                        $result = self::$database->execute();
                        move_uploaded_file($_FILES["photoProfil"]["tmp_name"], $target_file);
                    }
                    catch(Exception $e) {
                        $erreurs = true;
                        $msgUtilisateur = "erreur lors du traitement".$e->getMessage();
                    }
                }
            
        }
        else {
            $erreurs = true;
            $msgUtilisateur = "Vous devez d'abord choisir une image.";
        }
        return $msgUtilisateur;
    }
		
	
	/**
    * @brief méthode qui récupère les donnees d'un utilisateur par son nom usager et son mot de passe
    * @access public
    * @return array
    */
	
	public function getUtilisateurByNomUsager($nomUsager, $motPasse){
		
		self::$database->query('SELECT * FROM utilisateurs WHERE utilisateurs.nomUsager = :nomUsager AND utilisateurs.motPasse = :motPasse');
		self::$database->bind(':nomUsager', $nomUsager);
		self::$database->bind(':motPasse', $motPasse);
		
		if($Utilisateur = self::$database->uneLigne()){
			return $Utilisateur;
		}else{
			return false;
		}
	}
	/**
    * @brief Méthode qui valide les champs du formulaire de ajoute utilisateur
    * @param string $nomUsager
    * @param string $motPasse
    * @param string $nom
    * @param string $prenom
    * @param string $courriel
    * @access private
    * @return array
    */
    private function validerFormAjoutUtilisateur($nomUsager, $motPasse, $prenom, $nom, $courriel) {
		$msgErreurs = array();//Initialise les messages d'erreur à un tableau vide.
        
        $nomUsager = trim($nomUsager);
        if (empty($nomUsager)) {
            $msgErreurs["errNomUsager"] = "Veuillez choisir un nom usager";
        }
        $motPasse = trim($motPasse);
        if (empty($motPasse)) {
            $msgErreurs["errMotPasse"] = "Veuillez ecrire un mot de passe.";
        }
		
		$prenom = trim($prenom);
        if (empty($prenom)) {
            $msgErreurs["errPrenom"] = "Veuillez entrer votre prenom";
        }

        $nom = trim($nom);
        if (empty($nom)) {
            $msgErreurs["errNom"] = "Veuillez entrer votre nom de famille";
        }

        $courriel = trim($courriel);
        if (empty($courriel)) {
            $msgErreurs["errCourriel"] = "Veuillez entrer votre courriel";
        }
		 else if (!preg_match("^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$^",$courriel)) {
                 $msgErreurs["errMotPasse"] = "Veuillez reviser le format de votre courriel.";
        }
        return $msgErreurs;
	}
        
}//fin class Utilisateur