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
    * @var integer $id Id de la photo.
    * @access private
    */
    private $id;
    
    /**
    * @var string $image Nom de l'image, incluant l'extension du fichier.
    * @access private
    */
    private $image;
    
    /**
    * @var boolean $authorise Détermine si l'euvre a passé l'étape de l'audit.
    * @access private
    */
    private $authorise;

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
    * @brief Méthode qui assigne des valeurs aux propriétés de la photo
    * @param integer $id
    * @param string $image
    * @param boolean $authorise
    * @return void
    */
    public function setData($id, $image, $authorise) {
        
		$this->id = $id;
		$this->image = $image;
		$this->authorise = $authorise;
	}
		
	/**
    * @brief méthode qui récupère les valeurs des propriétés de cet objet.
    * @access public
    * @return array
    */
	public function getData() {
        
        $resutlat = array("id"=>$this->id, "image"=>$this->image, "authorise"=>$this->authorise);
        
        return $resutlat;
	}
    
    /**
    * @brief méthode qui récupère toutes les photos associées à une oeuvre.
    * @param $id integer
    * @param $langue string
    * @access public
    * @return array
    */
    public function getPhotosByOeuvre($idOeuvre) {
        
        $infoPhotos = array();
        
        self::$database->query('SELECT * FROM Photos WHERE Photos.idOeuvre = :id AND Photos.authorise = true');
        
        //Lie les paramètres aux valeurs
        self::$database->bind(':id', $idOeuvre);
        
        if ($photosBDD = self::$database->resultset()) {
            foreach ($photosBDD as $photo) {
                $unePhoto = array("image"=>$photo["image"]);
                $infoPhotos[] = $unePhoto;
            }
        }
        return $infoPhotos;
    }
}
?>