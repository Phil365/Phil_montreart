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
     public function inserePhotoBdd($idOeuvre) {
        if (!$_FILES["fileToUpload"]["error"]) {
               
            
         $message='';
             $target_dir = "images/images_soumises/";
            $temp = explode(".", $_FILES["fileToUpload"]["name"]);
            $newfilename = round(microtime(true)) . '.' . end($temp);      
            $target_file = $target_dir .$newfilename;
            $uploadOk = 1;
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            $pic=($_FILES["fileToUpload"]["name"]);
            // Check if image file is a actual image or fake image

            if(isset($_POST["submit"])) {

                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if($check !== false) {
                    echo "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    echo "File is not an image.";
                    $uploadOk = 0;
                }
            }
            // Check if file already exists
        /*    if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;
            }*/
            // Check file size
            if ($_FILES["fileToUpload"]["size"] > 500000 ) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }
             
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
            } else {   

              

          self::$database->query("INSERT INTO photos VALUES ('','$newfilename',false,'$idOeuvre')");
            
             $result =  self::$database->execute();
          
            if (!$result) {
              die('Invalid query: ' . mysql_error ());
                    }
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

             "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
            } else {
               "Sorry, there was an error uploading your file.";
            }

        }
    }else  
    echo "<script>alert(\"Veuillez mettre une image\")</script>"; 
                $uploadOk = 0;
}
}
?>