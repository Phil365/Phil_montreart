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
    * @var string $idSousCategorie Catégorie de l'oeuvre
    * @access private
    */
    private $idSousCategorie;
    
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
    
    private $test;
    
    function __construct() {
        
        $this->test = 0;
        $this->test2 = 0;
        
        if (!isset(self::$database)) {//Connection à la BDD si pas déjà connecté
            
            self::$database = BaseDeDonnees::getInstance();
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
    public function setData($id, $titre, $noInterneMtl, $latitude, $longitude, $parc, $batiment, $adresse, $description, $idCollection, $idCategorie, $idSousCategorie, $idArrondissement, $idArtiste, $authorise, $photos, $commentaires) {
        
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
        $this->idSousCategorie = $idSousCategorie;
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
        
        self::$database->query('SELECT * FROM Oeuvres JOIN Collections ON Oeuvres.idCollection = Collections.idCollection JOIN Categories ON Oeuvres.idCategorie = Categories.idCategorie JOIN SousCategories ON Oeuvres.idSousCategorie = SousCategories.idSousCategorie JOIN Arrondissements ON Arrondissements.idArrondissement = Oeuvres.idArrondissement JOIN Artistes ON Artistes.idArtiste = Oeuvres.idArtiste WHERE Oeuvres.idOeuvre = :id AND Oeuvres.authorise = true');
        
        //Lie les paramètres aux valeurs
        self::$database->bind(':id', $id);
        
        $infoOeuvre = array();
        
        if ($oeuvreBDD = self::$database->uneLigne()) {//Si trouvé dans la BDD
            $infoOeuvre = $oeuvreBDD;
        }
        return $infoOeuvre;
    }
    
    public function getAllOeuvreWithPhoto() {
    
    self::$database->query('SELECT * FROM oeuvres join photos on photos.idOeuvre = oeuvres.idOeuvre');
        if ($lignes = self::$database->resultset()) {
            foreach ($lignes as $ligne) {
                $uneOeuvre = array("idOeuvre"=>$ligne['idOeuvre'], "titre"=>$ligne['titre'], "longitude"=>$ligne['longitude'], "latitude"=>$ligne['latitude'], "image"=>$ligne['image']);
                $oeuvres[] = $uneOeuvre;
            }
            return $oeuvres;
        }
    }
    
    /**
    * @brief Méthode qui récupère les oeuvres du Json de la ville de Montréal et met à jour la BDD.
    * @access public
    * @return void
    */
    public function updaterOeuvresVille() {
        
        $oeuvresVilleMtl = json_decode(file_get_contents("http://donnees.ville.montreal.qc.ca/dataset/2980db3a-9eb4-4c0e-b7c6-a6584cb769c9/resource/18705524-c8a6-49a0-bca7-92f493e6d329/download/oeuvresdonneesouvertes.json"), true);
        
        foreach ($oeuvresVilleMtl as $oeuvreVilleMtl) {
            
            if (isset($oeuvreVilleMtl["NoInterne"])) {
                $oeuvreMtlBDD = $this->getOeuvreByNoInterne($oeuvreVilleMtl["NoInterne"]);
                
                $this->getFKOeuvreByName($oeuvreVilleMtl);
                
                if (empty($oeuvreMtlBDD)) {
                    $action = "inserer";
                    $this->test2++;
                }
                else {
                    $action = "updater";
                    $this->test++;
                }
                $this->insererUpdaterOeuvreVille($oeuvreVilleMtl, $action);
            }
        }
        $this->changerDateUpdate();
    }
    
    /**
    * @brief Méthode qui récupère les foreign key associées à l'oeuvre à insérer / updater.
    * @param array $oeuvre
    * @access private
    * @return void
    */
    private function getFKOeuvreByName($oeuvre) {
        //Collections
        try {
            $collection = new Collection();
            $idCollection = false;
            if (isset($oeuvre["NomCollection"])) {
                $idCollection = $collection->getCollectionIdByName($oeuvre["NomCollection"]);//Récupère l'ID en fonction des noms passés en paramètres
            }
            else if (isset($oeuvre["NomCollectionAng"])) {
                $idCollection = $collection->getCollectionIdByName($oeuvre["NomCollectionAng"]);//Récupère l'ID en fonction des noms passés en paramètres
            }
            if (!$idCollection) {//Si la collection n'existe pas...
                try {
                    $collection->ajouterCollection($oeuvre["NomCollection"], $oeuvre["NomCollectionAng"]);//Fait l'insertion si non trouvé dans la BDD
                    $idCollection = $collection->getCollectionIdByName($oeuvre["NomCollection"]);//Récupère l'ID en fonction des noms passés en paramètres
                }
                catch(Exception $e) {
                    echo "erreur lors de l'insertion : " . $e;
                    exit;
                }
            }
            $this->idCollection = $idCollection;//Mets à jour la propriété avec l'ID trouvé
        }
        catch(Exception $e) {
            echo "erreur lors de l'insertion : " . $e;
            exit;
        }
        //Catégories
        try {
            $categorie = new Categorie();
            $idCategorie = false;
            if (isset($oeuvre["CategorieObjet"])) {
                $idCategorie = $categorie->getCategorieIdByName($oeuvre["CategorieObjet"]);//Récupère l'ID en fonction des noms passés en paramètres
            }
            else if (isset($oeuvre["CategorieObjetAng"])) {
                $idCategorie = $categorie->getCategorieIdByName($oeuvre["CategorieObjetAng"]);//Récupère l'ID en fonction des noms passés en paramètres
            }
            if (!$idCategorie) {//Si la catégorie n'existe pas...
                try {
                    $categorie->ajouterCategorie($oeuvre["CategorieObjet"], $oeuvre["CategorieObjetAng"]);//Fait l'insertion si non trouvé dans la BDD
                    $idCategorie = $categorie->getCategorieIdByName($oeuvre["CategorieObjet"]);//Récupère l'ID en fonction des noms passés en paramètres
                }
                catch(Exception $e) {
                    echo "erreur lors de l'insertion : " . $e;
                    exit;
                }
            }
            $this->idCategorie = $idCategorie;//Mets à jour la propriété avec l'ID trouvé
        }
        catch(Exception $e) {
            echo "erreur lors de l'insertion : " . $e;
            exit;
        }
        //Sous-Catégories
        try {
            $souCategorie = new SousCategorie();
            $idSousCategorie = false;
            if (isset($oeuvre["SousCategorieObjet"])) {
                $idSousCategorie = $souCategorie->getSousCategorieIdByName($oeuvre["SousCategorieObjet"]);//Récupère l'ID en fonction des noms passés en paramètres
            }
            else if (isset($oeuvre["SousCategorieObjetAng"])) {
                $idSousCategorie = $souCategorie->getSousCategorieIdByName($oeuvre["SousCategorieObjetAng"]);//Récupère l'ID en fonction des noms passés en paramètres
            }
            if (!$idSousCategorie) {//Si la sous-catégorie n'existe pas...
                try {
                    $souCategorie->ajouterSousCategorie($oeuvre["SousCategorieObjet"], $oeuvre["SousCategorieObjetAng"]);//Fait l'insertion si non trouvé dans la BDD
                    $idSousCategorie = $souCategorie->getSousCategorieIdByName($oeuvre["SousCategorieObjet"]);//Récupère l'ID en fonction des noms passés en paramètres
                }
                catch(Exception $e) {
                    echo "erreur lors de l'insertion : " . $e;
                    exit;
                }
            }
            $this->idSousCategorie = $idSousCategorie;//Mets à jour la propriété avec l'ID trouvé
        }
        catch(Exception $e) {
            echo "erreur lors de l'insertion : " . $e;
            exit;
        }
        //Arrondissements
        try {
            $arrondissement = new Arrondissement();
            $idArrondissement = false;
            if (isset($oeuvre["Arrondissement"])) {
                $idArrondissement = $arrondissement->getArrondissementIdByName($oeuvre["Arrondissement"]);//Récupère l'ID en fonction des noms passés en paramètres
            }
            if (!$idArrondissement) {//Si larrondissement n'existe pas...
                try {
                    $arrondissement->ajouterArrondissement($oeuvre["Arrondissement"], $oeuvre["Arrondissement"]);//Fait l'insertion si non trouvé dans la BDD
                    $idArrondissement = $arrondissement->getArrondissementIdByName($oeuvre["Arrondissement"]);//Récupère l'ID en fonction des noms passés en paramètres
                }
                catch(Exception $e) {
                    echo "erreur lors de l'insertion : " . $e;
                    exit;
                }
            }
            $this->idArrondissement = $idArrondissement;//Mets à jour la propriété avec l'ID trouvé
        }
        catch(Exception $e) {
            echo "erreur lors de l'insertion : " . $e;
            exit;
        }
        //Artistes
        try {
            $artiste = new Artiste();
            $idArtiste = false;
            $idArtiste = $artiste->getArtisteIdByName($oeuvre["Artistes"][0]["Prenom"], $oeuvre["Artistes"][0]["Nom"], $oeuvre["Artistes"][0]["NomCollectif"]);//Récupère l'ID en fonction des noms passés en paramètres
            
            if (!$idArtiste) {//Si l'artiste n'existe pas...
                try {
                    $artiste->ajouterArtiste($oeuvre["Artistes"][0]["Prenom"], $oeuvre["Artistes"][0]["Nom"], $oeuvre["Artistes"][0]["NomCollectif"]);//Fait l'insertion si non trouvé dans la BDD
                    $idArtiste = $artiste->getArtisteIdByName($oeuvre["Artistes"][0]["Prenom"], $oeuvre["Artistes"][0]["Nom"], $oeuvre["Artistes"][0]["NomCollectif"]);//Récupère l'ID en fonction des noms passés en paramètres
                }
                catch(Exception $e) {
                    echo "erreur lors de l'insertion : " . $e;
                    exit;
                }
            }
            $this->idArtiste = $idArtiste;//Mets à jour la propriété avec l'ID trouvé
        }
        catch(Exception $e) {
            echo "erreur lors de l'insertion : " . $e;
            exit;
        }
    }
    
    /**
    * @brief Méthode qui insert ou update les oeuvres de la ville dans la BDD en fonction de l'action passée en paramètre.
    * @param array $oeuvre
    * @param string $action
    * @access private
    * @return void
    */
    private function insererUpdaterOeuvreVille($oeuvre, $action) {

        try {            
            if ($action === "inserer") {//Requête pour insérer une oeuvre
                self::$database->query('INSERT INTO Oeuvres (titre, noInterneMtl, latitude, longitude, parc, batiment, adresse, descriptionFR, descriptionEN, authorise, idCollection, idCategorie, idSousCategorie, idArrondissement, idArtiste) VALUES (:titre, :noInterneMtl, :latitude, :longitude, :parc, :batiment, :adresse, :descriptionFR, :descriptionEN, :authorise, :idCollection, :idCategorie, :idSousCategorie, :idArrondissement, :idArtiste)');
                
                self::$database->bind(':descriptionFR', "Aucune description disponible");
                self::$database->bind(':descriptionEN', "No description available.");
                self::$database->bind(':authorise', true);
            }
            else if ($action === "updater") {//Requête pour mettre à jour une oeuvre
                self::$database->query('UPDATE Oeuvres SET titre=:titre, latitude=:latitude, longitude=:longitude, parc=:parc, batiment=:batiment, adresse=:adresse, idCollection=:idCollection, idCategorie=:idCategorie, idSousCategorie=:idSousCategorie, idArrondissement=:idArrondissement, idArtiste=:idArtiste WHERE noInterneMtl = :noInterneMtl');
            }

            self::$database->bind(':titre', $oeuvre["Titre"]);
            self::$database->bind(':noInterneMtl', $oeuvre["NoInterne"]);
            self::$database->bind(':latitude', $oeuvre["CoordonneeLatitude"]);
            self::$database->bind(':longitude', $oeuvre["CoordonneeLongitude"]);
            self::$database->bind(':parc', $oeuvre["Parc"]);
            self::$database->bind(':batiment', $oeuvre["Batiment"]);
            self::$database->bind(':adresse', $oeuvre["AdresseCivique"]);
            self::$database->bind(':idCollection', $this->idCollection);
            self::$database->bind(':idCategorie', $this->idCategorie);
            self::$database->bind(':idSousCategorie', $this->idSousCategorie);
            self::$database->bind(':idArrondissement', $this->idArrondissement);
            self::$database->bind(':idArtiste', $this->idArtiste);
            
            self::$database->execute();
        }
        catch(Exception $e) {
            echo "erreur lors de l'insertion : " . $e;
            exit;
        }  
    }
    
    /**
    * @brief Méthode qui récupère les oeuvres de la ville présentes dans la BDD.
    * @param string $noInterneMtl
    * @access private
    * @return array
    */
    private function getOeuvreByNoInterne($noInterneMtl) {
        
        $oeuvreMtlBDD = array();

        try {
            self::$database->query('SELECT * FROM oeuvres JOIN Collections ON Oeuvres.idCollection = Collections.idCollection JOIN Categories ON Oeuvres.idCategorie = Categories.idCategorie JOIN SousCategories ON Categories.idCategorie = SousCategories.idSousCategorie JOIN Arrondissements ON Arrondissements.idArrondissement = Oeuvres.idArrondissement JOIN Artistes ON Artistes.idArtiste = Oeuvres.idArtiste WHERE Oeuvres.noInterneMtl = :noInterneMtl');

            //Lie les paramètres aux valeurs
            self::$database->bind(':noInterneMtl', $noInterneMtl);

            if ($oeuvre = self::$database->uneLigne()) {//Si trouvé dans la BDD
                $oeuvreMtlBDD = $oeuvre; 
            }
            return $oeuvreMtlBDD;
        }
        catch(Exception $e) {
            echo "erreur lors de l'insertion : " . $e;
            exit;
        }
    }
    
    /**
    * @brief Méthode qui change la date de la dernière mise à jour des données de la ville.
    * @access private
    * @return void
    */
    private function changerDateUpdate() {
        
        self::$database->query('SELECT idUpdate FROM UpdateListeOeuvresVille');
        
        if ($date = self::$database->uneLigne()) {
            try {
                self::$database->query('UPDATE UpdateListeOeuvresVille SET dateDernierUpdate=CURDATE(), heureDernierUpdate=CURTIME() WHERE UpdateListeOeuvresVille.idUpdate = 1');
                self::$database->execute();
            }
            catch(Exception $e) {
                echo "erreur lors de l'insertion : " . $e;
                exit;
            } 
        }
        else {
            try {
                self::$database->query('INSERT INTO UpdateListeOeuvresVille (dateDernierUpdate, heureDernierUpdate) VALUES (CURDATE(), CURTIME())');
                self::$database->execute();
            }
            catch(Exception $e) {
                echo "erreur lors de l'insertion : " . $e;
                exit;
            }
        }
    }
    
    /**
    * @brief Méthode qui renvoi la date et l'heure de la dernière mise à jour des données de la ville.
    * @access public
    * @return array
    */
    public function getDateDernierUpdate() {
        
        self::$database->query('SELECT * FROM UpdateListeOeuvresVille');
        
        if ($date = self::$database->uneLigne()) {
            return $date;
        }
        else {
            return array();
        }
    }
    
    /**
    * @brief Méthode qui affiche les résultats du test unitaire pour la fonctionalité du Json.
    * @access public
    * @return void
    */
    public function afficherTestJson() {
        //Test pour déterminer si toutes les oeuvres ont été insérées dans la BDD.
        if (($this->test + $this->test2) > 0) {
            echo "<p>Le contenu doit être rechargé une fois pour voir les résultats :</p>";
            echo "<br>";
            echo "Nombre d'oeuvres du Json présentes dans la BDD Montreart : " . $this->test;
            echo "<br>";
            echo "Nombre d'oeuvres du Json manquantes dans la BDD Montreart : " . $this->test2;
            echo "<br>";
            echo "Nombre total d'oeuvres dans le Json de la ville : " . ($this->test + $this->test2);
        }
    }
        
    function chercheParTitre($keyword) {
    
        self::$database->query("SELECT titre, idOeuvre FROM oeuvres WHERE titre LIKE  ? and authorise = true");

        $keyword = $keyword.'%';

        self::$database->bind(1, $keyword);
        //var_dump(self::$database->bind(1, $keyword));
        //var_dump(self::$database->query("SELECT titre FROM oeuvres WHERE titre LIKE 'le%'"));
        $results = array();

       if ($oeuvreBDD = self::$database->uneLigne()) {//Si trouvé dans la BDD
            $results = array("idOeuvre"=>$oeuvreBDD['idOeuvre'],"titre"=>$oeuvreBDD['titre']);
        }
        return $results;

    }
    
    public function getAllOeuvresByCategorie ($id) {
        $infoOeuvres = array();
        
        self::$database->query('SELECT * FROM Oeuvres JOIN Categories ON Oeuvres.idCategorie = Categories.idCategorie JOIN Artistes ON Artistes.idArtiste = Oeuvres.idArtiste WHERE Oeuvres.authorise = true AND Categories.idCategorie = :id GROUP BY Oeuvres.idOeuvre');
            
        //Lie les paramètres aux valeurs
        self::$database->bind(':id', $id);
        
        if ($oeuvres = self::$database->resultset()) {
            foreach ($oeuvres as $oeuvre) {
                $infoOeuvres[] = $oeuvre;
            }
        }
        return $infoOeuvres;
    }
    
    public function getAllOeuvresByArrondissement ($id) {
        $infoOeuvres = array();
        
        self::$database->query('SELECT * FROM Oeuvres JOIN Categories ON Oeuvres.idCategorie = Categories.idCategorie JOIN Artistes ON Artistes.idArtiste = Oeuvres.idArtiste JOIN Arrondissements ON Arrondissements.idArrondissement = Oeuvres.idArrondissement WHERE Oeuvres.authorise = true AND Arrondissements.idArrondissement = :id GROUP BY Oeuvres.idOeuvre');
            
        //Lie les paramètres aux valeurs
        self::$database->bind(':id', $id);
        
        if ($oeuvres = self::$database->resultset()) {
            foreach ($oeuvres as $oeuvre) {
                $infoOeuvres[] = $oeuvre;
            }
        }
        return $infoOeuvres;
    }
    
    /**
	 * @access public
	 * @return Array
	 */
	public function getAllOeuvres() 
	{
				
        $infoOeuvress = array();
        
        self::$database->query('SELECT idOeuvre, titre FROM Oeuvres');
        
        if ($oeuvres = self::$database->resultset()) {
            foreach ($oeuvres as $oeuvre) {
                $infoOeuvres[] = $oeuvre;
            }
        }
        return $infoOeuvres;
	}
}
?>