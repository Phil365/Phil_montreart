<?php
/**
 * @file Photo.class.php
 * @brief class Photo
 * @author David Lachambre
 * @version 0.1
 * @update 2015-12-13
 */
class Photo {
    
    /**
    * @var integer id de la photo
    */
    private $id;
    
    private $image;
    private $authorise;

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
    * @brief Méthode qui assigne des valeurs aux propriétés de la photo
    * @param integer $id
    * @param string $image
    * @param boolean $authorise
    * @return Void
    */
    public function setData($id, $image, $authorise) {
        
		$this->id = $id;
		$this->image = $image;
		$this->authorise = $authorise;
	}
		
	/**
    * @brief méthode qui récupère les valeurs des propriétés de cet objet.
    * @access public
    * @return Array
    */
	public function getData() {
        
        $resutlat = ["id"=>$this->id, "image"=>$this->image, "authorise"=>$this->authorise];
        
        return $resutlat;
	}
    
    /**
    * @brief méthode qui récupère toutes les photos associées à une oeuvre.
    * @param $id integer
    * @param $langue string
    * @access public
    * @return Array
    */
    public function getPhotosByOeuvre($idOeuvre) {
        
        $infoPhotos = [];
        
        self::$database->query('SELECT * FROM Photos WHERE Photos.idOeuvre = :id AND Photos.authorise = true');
        
        //Lie les paramètres aux valeurs
        self::$database->bind(':id', $idOeuvre);
        
        if ($photosBDD = self::$database->resultset()) {
            foreach ($photosBDD as $photo) {
                $unePhoto = ["image"=>$photo["image"]];
                $infoPhotos[] = $unePhoto;
            }
        }
        return $infoPhotos;
    }
}
?>