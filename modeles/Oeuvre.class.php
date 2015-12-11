<?php
/**
 * @file Oeuvre.class.php
 * @brief class Oeuvre
 * @author David Lachambre
 * @version 0.1
 * @update 2015-12-10
 */
class Oeuvre {
    
    /**
    * @var integer id de l'oeuvre.
    */
    private $id;
    private $titre;
    private $noInterneMtl;
    private $latitude;
    private $longitude;
    private $parc;
    private $batiment;
    private $adresse;
    private $description;
    private $idCollection;
    private $idCategorie;
    private $idArrondissement;
    private $idArtiste;
    private $photos;
    private $commentaires;

    /**
    * @var BaseDeDonnee Objet base de données qui permet la connexion.
    */
    private static $database;
    
	function __construct() {
		
        if (!isset(self::$database)) {
            
            self::$database = new BaseDeDonnees();
        }
	}
	
	function __destruct() {
		
	}
    
    /**
    * @brief Méthode qui assigne des valeurs aux propriétés de l'oeuvre
    * @param integer $id
    * @param string $titre
    * @param integer $noInterneMtl
    * @param string $latitude
    * @param string $longitude
    * @param string $batiment
    * @param string $adresse
    * @param string $description
    * @param integer $idCollection
    * @param integer $idCategorie
    * @param integer $idArrondissement
    * @param integer $idArtiste
    * @param array $photos
    * @param array $commentaires
    * @access public
    * @return Void
    */
    public function setData($id, $titre, $noInterneMtl, $latitude, $longitude, $parc, $batiment, $adresse, $description, $idCollection, $idCategorie, $idArrondissement, $idArtiste, $photos, $commentaires) {
        
		$this->id = $id;
		$this->titre = $titre;
		$this->noInterneMtl = $noInterneMtl;
		$this->latitude = $latitude;
		$this->longitude = $longitude;
		$this->parc = $parc;
		$this->batiment = $batiment;
		$this->adresse = $adresse;
		$this->description = $description;
		$this->idCollection = $idCollection;
		$this->idCategorie = $idCategorie;
		$this->idArrondissement = $idArrondissement;
		$this->idArtiste = $idArtiste;
		$this->photos = $photos;
		$this->commentaires = $commentaires;
	}
		
	/**
	 * @access public
	 * @return Array
	 */
	public function getData() {
        
        $resutlat = ["id"=>$this->id, "titre"=>$this->titre, "noInterneMtl"=>$this->noInterneMtl, "latitude"=>$this->latitude, "longitude"=>$this->longitude, "parc"=>$this->parc, "batiment"=>$this->batiment, "adresse"=>$this->adresse, "description"=>$this->description, "idCollection"=>$this->idCollection, "idCategorie"=>$this->idCategorie, "idArrondissement"=>$this->idArrondissement, "idArtiste"=>$this->idArtiste, "photos"=>$this->photos, "commentaires"=>$this->commentaires];
        
        return $resutlat;
	}
}
?>