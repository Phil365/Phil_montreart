<?php
/**
 * @brief class Oeuvre
 * @author David Lachambre
 * @version 1.0
 * @update 2015-12-14
 */
class Oeuvre {
    
    /**
    * @var integer $id Id de l'oeuvre
    * @access private
    */
    private $id;
    
    /**
    * @var string $titre Titre de l'oeuvre
    * @access private
    */
    private $titre;
    
    /**
    * @var integer $noInterneMtl Numéro interne de l'oeuvre à la ville de Montréal
    * @access private
    */
    private $noInterneMtl;
    
    /**
    * @var string $latitude Coordonnées de latitude de l'oeuvre
    * @access private
    */
    private $latitude;
    
    /**
    * @var string $longitude Coordonnées de longitude de l'oeuvre
    * @access private
    */
    private $longitude;
    
    /**
    * @var string $parc Parc dans lequel se trouve l'oeuvre
    * @access private
    */
    private $parc;
    
    /**
    * @var string $batiment Bâtiment dans lequel se trouve l'oeuvre
    * @access private
    */
    private $batiment;
    
    /**
    * @var string $adresse Adresse se trouve l'oeuvre
    * @access private
    */
    private $adresse;
    
    /**
    * @var string $description Description de l'oeuvre
    * @access private
    */
    private $description;
    
    /**
    * @var string $idCollection Collection contenant l'oeuvre
    * @access private
    */
    private $idCollection;
    
    /**
    * @var string $idCategorie Catégorie de l'oeuvre
    * @access private
    */
    private $idCategorie;
    
    /**
    * @var string $idArrondissement Arrondissement où se trouve l'oeuvre
    * @access private
    */
    private $idArrondissement;
    
    /**
    * @var string $idArtiste Artiste ayant créé l'oeuvre
    * @access private
    */
    private $idArtiste;
    
    /**
    * @var string $authorise Détermine si l'oeuvre a passé l'étape de l'audit
    * @access private
    */
    private $authorise;
    
    /**
    * @var array $photos Photos de l'oeuvre
    * @access private
    */
    private $photos;
    
    /**
    * @var array $commentaires Commentaires liés à l'oeuvre
    * @access private
    */
    private $commentaires;

    /**
    * @var object $database Connection à la BDD
    */
    private static $database;
    
	function __construct() {
		
        if (!isset(self::$database)) {//Connection à la BDD si pas déjà connecté
            
            self::$database = new BaseDeDonnees();
        }
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
    * @param boolean $authorise
    * @param array $photos
    * @param array $commentaires
    * @access public
    * @return void
    */
    public function setData($id, $titre, $noInterneMtl, $latitude, $longitude, $parc, $batiment, $adresse, $description, $idCollection, $idCategorie, $idArrondissement, $idArtiste, $authorise, $photos, $commentaires) {
        
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
		$this->authorise = $authorise;
		$this->photos = $photos;
		$this->commentaires = $commentaires;
	}
		
	/**
    * @brief Méthode qui récupère les valeurs des propriétés de cet objet
    * @access public
    * @return array
    */
	public function getData() {
        
        $resutlat = array("id"=>$this->id, "titre"=>$this->titre, "noInterneMtl"=>$this->noInterneMtl, "latitude"=>$this->latitude, "longitude"=>$this->longitude, "parc"=>$this->parc, "batiment"=>$this->batiment, "adresse"=>$this->adresse, "description"=>$this->description, "idCollection"=>$this->idCollection, "idCategorie"=>$this->idCategorie, "idArrondissement"=>$this->idArrondissement, "idArtiste"=>$this->idArtiste, "authorise"=>$this->authorise, "photos"=>$this->photos, "commentaires"=>$this->commentaires);
        
        return $resutlat;
	}
    
    /**
    * @brief Méthode qui récupère une oeuvre dans la BD
    * @param integer $id
    * @param string $langue
    * @access public
    * @return array
    */
    public function getOeuvreById($id, $langue) {
        
        self::$database->query('SELECT * FROM Oeuvres JOIN Collections ON Oeuvres.idCollection = Collections.idCollection JOIN Categories ON Oeuvres.idCategorie = Categories.idCategorie JOIN SousCategories ON Categories.idCategorie = SousCategories.idCategorie JOIN Arrondissements ON Arrondissements.idArrondissement = Oeuvres.idArrondissement JOIN Artistes ON Artistes.idArtiste = Oeuvres.idArtiste WHERE Oeuvres.idOeuvre = :id AND Oeuvres.authorise = true');
        
        //Lie les paramètres aux valeurs
        self::$database->bind(':id', $id);
        
        $infoOeuvre = array();
        
        if ($oeuvreBDD = self::$database->uneLigne()) {//Si trouvé dans la BDD
            $infoOeuvre = array("id"=>$oeuvreBDD['idOeuvre'], "titre"=>$oeuvreBDD['titre'], "parc"=>$oeuvreBDD['parc'], "batiment"=>$oeuvreBDD['batiment'], "adresse"=>$oeuvreBDD['adresse'], "description"=>$oeuvreBDD['description'.$langue], "nomCollection"=>$oeuvreBDD['nomCollection'.$langue], "nomCategorie"=>$oeuvreBDD['nomCategorie'.$langue], "sousCategorie"=>$oeuvreBDD['sousCategorie'.$langue], "nomArrondissement"=>$oeuvreBDD['nomArrondissement'], "prenomArtiste"=>$oeuvreBDD['prenomArtiste'], "nomArtiste"=>$oeuvreBDD['nomArtiste']);
        }
        return $infoOeuvre;
    }
      public function getAllOeuvreWithPhoto() {
      
        self::$database->query('SELECT * FROM oeuvres join photos on photos.idOeuvre = oeuvres.idOeuvre');

        $oeuvreBDD = self::$database->resultset(); //Si trouvé dans la BDD       
          return $oeuvreBDD;      
        }
    
    
}
?>