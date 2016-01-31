<?php
/**
* @brief class Photo
* @author David Lachambre
* @version 1.0
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
    
    /**
    * @brief Méthode qui récupère toutes les photos de la BDD.
    * @access public
    * @return array
    */
    public function getAllPhoto() {
        
        $photoAll = array();
        
        self::$database->query('SELECT * FROM Photos WHERE Photos.authorise = true');
        
               
        if ($photosBDD = self::$database->resultset()) {
            foreach ($photosBDD as $photo) {
                $unePhoto = array("image"=>$photo["image"]);
                $photoAll[] = $unePhoto;
            }
        }
        return $photoAll;
    }
    
    /**
    * @brief méthode qui récupère toutes les photos n'aillant pas encore été vetés par l'administrateur
    * @access public
    * @return array
    */
    public function getAllUnauthorizedPhoto() {
        
        $photoAllUnauthorized = array();
        
        self::$database->query('SELECT * FROM Photos WHERE Photos.authorise = false');
        
               
        if ($photosBDD = self::$database->resultset()) {
            foreach ($photosBDD as $photo) {
                $unePhoto = array("idPhoto"=>$photo["idPhoto"]);
                $photoAllUnauthorized[] = $unePhoto;
            }
        }
        return $photoAllUnauthorized;
    }
     public function getPhotoById(){
        
        if(isset($_POST['liPhotoId'])){
        
            $idPhoto = $_POST['liPhotoId'];
            
            self::$database->query('SELECT * FROM photos where photos.idPhoto = :idPhoto');
            self::$database->bind(':id', $idPhoto);
            
            $infoPhoto = array();
            
            if($photoBDD = self::$database->uneLigne()){
            
                $infoPhoto = $photoBDD;
            }
            return $infoPhoto;
        }
        
    }

    /**
    * @brief Méthode qui insère une photo dans la BDD.
    * @param string $idOeuvre
    * @param boolean $authorise
    * @access public
    * @return string
    */
    public function inserePhotoBdd($idOeuvre, $authorise) {
         
        $msgUtilisateur = "";
        $erreurs = false;
        
        if ($_FILES["fileToUpload"]["error"] != 4) {

            $target_dir = "images/photosOeuvres/";
            $temp = explode(".", $_FILES["fileToUpload"]["name"]);
            $nouveauNomImage = round(microtime(true)) . '.' . end($temp);      
            $target_file = $target_dir .$nouveauNomImage;
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            $pic=($_FILES["fileToUpload"]["name"]);
            // Check if image file is a actual image or fake image

            if (isset($_POST["submit"]) || isset($_POST["boutonAjoutOeuvre"])) {
                
                if ($_FILES["fileToUpload"]["size"] > 5000000 || ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif")) {
                    $erreurs = true;
                    $msgUtilisateur = "Votre fichier doit être de type Jpeg ou Png et inférieur à 5Mb.<br>";
                }
                if (!$erreurs) {
                    self::$database->query("INSERT INTO photos (image, authorise, idOeuvre) VALUES ('images/photosOeuvres/$nouveauNomImage', :authorise, :idOeuvre)");
//                    self::$database->bind(':newfilename', $nouveauNomImage);
                    self::$database->bind(':idOeuvre', $idOeuvre);
                    self::$database->bind(':authorise', $authorise);

                    try {
                        $result = self::$database->execute();
                        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
                    }
                    catch(Exception $e) {
                        $erreurs = true;
                        $msgUtilisateur = "erreur lors du traitement".$e->getMessage();
                    }
                }
            }
        }
        else {
            $erreurs = true;
            $msgUtilisateur = "Vous devez d'abord choisir une image.";
        }
        return $msgUtilisateur;
    }
}
?>