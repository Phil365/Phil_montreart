<?php
/**
 * Class Controler
 * Gère les requêtes HTTP
 * 
 * @author Jonathan Martel
 * @author David Lachambre
 * @version 1.1
 * @update 2015-12-14
 * @license Creative Commons BY-NC 3.0 (Licence Creative Commons Attribution - Pas d’utilisation commerciale 3.0 non transposé)
 * @license http://creativecommons.org/licenses/by-nc/3.0/deed.fr
 * 
 */

class Controler {
    
    /**
    * @var object $oVue Contient la composante vue du MVC
    * @access private
    */
    private $oVue;
    
    /**
    * @var object $oCookie Cookie du site
    * @access private
    */
    private $oCookie;
    
    /**
    * @var string $metaPageAccueil Contenu personnalisé à intégrer dans le head de la page d'accueil
    * @access private
    */
    private $metaPageAccueil;
    
    /**
    * @var string $metaPageOeuvre Contenu personnalisé à intégrer dans le head de la page d'une oeuvre
    * @access private
    */
    private $metaPageOeuvre;
    
    /**
    * @var string $pageActuelle Page présentement affichée par l'utilisateur
    * @access private
    */
    private $pAccueil = "accueil";
    private $pOeuvre = "oeuvre";
    private $pTrajet = "trajet";
    private $pSoumission = "soumission";
    private $pProfil = "profil";
    private $pRecherche = "recherche";
    private $pAdmin = "admin";
    private $pGestion = "gestion";
    
    /**
    * @var string $langueAffichage Langue d'affichage du site
    * @access private
    */
    private $langueAffichage;
    
    /**
    * @brief Constructeur, initialise les propriétés
    * @access public
    * @return void
    */
    public function __construct() {
        
        $this->pAccueil = "accueil";
        $this->pOeuvre = "oeuvre";
        $this->pTrajet = "trajet";
        $this->pSoumission = "soumission";
        $this->pProfil = "profil";
        $this->pRecherche = "recherche";
        $this->pAdmin = "admin";
        
        $this->oCookie = new Cookie();
        $this->langueAffichage = $this->oCookie->getLangue();
        
//        if ($this->langueAffichage == "EN") {
//            $this->metaPageAccueil = ["titre"=>"MontreArt - Home Page", "description"=>""];
//            $this->metaPageOeuvre = ["titre"=>"Montréart - Art Page", "description"=>""];
//        }
//        else {
//            $this->metaPageAccueil = ["titre"=>"MontréArt - page d'accueil", "description"=>""];
//            $this->metaPageOeuvre = ["titre"=>"Montréart - page d'une oeuvre", "description"=>""];
//        }
    }
    /**
    * @brief Traite la requête GET
    * @access public
    * @return void
    */
     public function gerer() {
        
        switch ($_GET['r']) {//requête
            case $this->pAccueil:
                $this->accueil();
                break;
            case $this->pOeuvre:
                $this->oeuvre();
                break;
            case $this->pTrajet:
                $this->trajet();
                break;
            case $this->pSoumission:
                $this->soumission();
                break;
            case $this->pProfil:
                $this->profil();
                break;
            case 'updateOeuvresVille':
                $this->updateOeuvresVille();
                break;
            case $this->pRecherche:
                $this->recherche();
                break;
            case $this->pAdmin:
                $this->admin();
                break;
            case $this->pGestion:
                $this->gestion();
                break;
            case 'selectArrondissement';
                $this->creerSelectArrondissement();
            default:
                $this->accueil();
                break;
        }
    }
    
    
    /**
    * @brief Méthode qui appelle la vue d'affichage de la page d'accueil
    * @access private
    * @return void
    */
    private function accueil() {
        
     $photo = new Photo();
     $photosAll = $photo->getAllPhoto();
     $this->oVue = new VueAccueil();  
     $this->oVue->setDataGlobal("Accueil", "Page d'accueil", $this->langueAffichage, $this->pAccueil); 
     $this->oVue->setData($photosAll);
     $this->oVue->afficherMeta();
     $this->oVue->afficherEntete();
     $this->oVue->afficherBody();
     $this->oVue->afficherPiedPage();
    }
    
    /**
    * @brief Méthode qui appelle la vue d'affichage de la page d'une oeuvre
    * @access private
    * @return void
    */
    private function oeuvre() {
        
        $oeuvre = new Oeuvre();
        $oeuvreAffichee = $oeuvre->getOeuvreById($_GET["o"], $this->langueAffichage);
        
        $commentaire = new Commentaire();
        $commentairesOeuvre = $commentaire->getCommentairesByOeuvre($_GET["o"], $this->langueAffichage);
        
        $photo = new Photo();
        $photosOeuvre = $photo->getPhotosByOeuvre($_GET["o"], false);
        
        if (isset($_GET['action']) && $_GET['action'] == 'envoyerPhoto') {
            $msgInsertPhoto = $photo->inserePhotoBdd($_GET["o"], false);
        }
        else {
            $msgInsertPhoto = null;
        }
        
        $artiste = new Artiste();
        $artistesOeuvre = $artiste->getArtistesbyOeuvreId ($_GET["o"]);
        
        $this->oVue = new VueOeuvre();
        $this->oVue->setDataGlobal('oeuvre', "page d'une oeuvre", $this->langueAffichage, $this->pOeuvre);
        $this->oVue->setData($oeuvreAffichee, $commentairesOeuvre, $photosOeuvre, $artistesOeuvre, $this->langueAffichage);
        $this->oVue->setMsgPhoto($msgInsertPhoto);
        $this->oVue->afficherMeta();
        $this->oVue->afficherEntete();
        $this->oVue->afficherBody();
        $this->oVue->afficherPiedPage();
        
        
    }

    /**
    * @brief Méthode qui appelle la vue d'affichage de la page de trajet
    * @access private
    * @return void
    */
    private function trajet() {
        
        $this->oVue = new VueTrajet();
        $this->oVue->setDataGlobal('trajet', "page de création d'un trajet", $this->langueAffichage, $this->pTrajet);
        $this->oVue->afficherMeta();
        $this->oVue->afficherEntete();
        $this->oVue->afficherBody();
        $this->oVue->afficherPiedPage();
    }
    
    /**
    * @brief Méthode qui appelle la vue d'affichage de la page de soumission
    * @access private
    * @return void
    */
    private function soumission() {
        $nouvelArrondissement = new Arrondissement();
        $arrondissements = $nouvelArrondissement->getAllArrondissements();
        
        $nouvelSousCategorie = new SousCategorie();
        $sousCategories = $nouvelSousCategorie->getAllSousCategories('FR');

        $oeuvre = new Oeuvre();
        $arrondissement = new Arrondissement();
        $categorie = new SousCategorie();
        
        $authorise = false;
        
        if(isset($_POST['boutonAjoutOeuvre'])) {

            $oeuvre->ajouterOeuvre($_POST['titreAjout'], $_POST['adresseAjout'], $_POST['prenomArtisteAjout'], $_POST['nomArtisteAjout'], $_POST['descriptionAjout'], $_POST["selectSousCategorie"], $_POST["selectArrondissement"], $authorise, $this->langueAffichage);
        }
        
        $oeuvresBDD = $oeuvre->getAllOeuvres();
        $arrondissementsBDD = $arrondissement->getAllArrondissements();
        $categorieBDD = $categorie->getAllSousCategories($this->langueAffichage);

        $this->oVue = new VueSoumission();
        $this->oVue->setDataGlobal('soumission', "page de soumission d'oeuvre", $this->langueAffichage, $this->pSoumission);
        $this->oVue->setData($oeuvresBDD, $arrondissementsBDD, $categorieBDD);
        $this->oVue->afficherMeta();
        $this->oVue->setData($arrondissements, $sousCategories);
        $this->oVue->afficherEntete();
        $this->oVue->afficherBody();
        $this->oVue->afficherPiedPage();
        
      /*   $oeuvre = new Oeuvre();
        
            if($_GET['action'] == 'soumetOeuvre')
            {  $oeuvreAjouter = $oeuvre->ajouterOeuvre($_POST['titre'],$_POST['adresse'], $_POST['description'], $_POST['idArtiste'], $_POST['idSousCategorie'], $_POST['idArrondissement'], $_POST['photo']);
             var_dump($_POST['idArrondissement']);
            }*/ 
    }
    
    /**
    * @brief Méthode qui appelle la vue d'affichage de la page de profil
    * @access private
    * @return void
    */
    private function profil() {
        
        $this->oVue = new VueProfil();
        $this->oVue->setDataGlobal('profil', "page de profil utilisateur", $this->langueAffichage, $this->pProfil);
        $this->oVue->afficherMeta();
        $this->oVue->afficherEntete();
        $this->oVue->afficherBody();
        $this->oVue->afficherPiedPage();
    }
    /**
    * @brief Méthode qui appelle la vue d'affichage de la page admin
    * @access private
    * @return void
    */
//    private function admin(){
//        
//        $photo = new Photo();
//        $photoAllUnauthorized = $photo->getAllUnauthorizedPhoto();
//        $photoAReviser = $photo->getPhotoById();
//        $oeuvre = new Oeuvre;
//        $oeuvre->updaterOeuvresVille();
//        $date = $oeuvre->getDateDernierUpdate();
//        $this->oVue = new VueAdmin();
//        $this->oVue->setDataGlobal("Admin", "page d'administration", $this->langueAffichage, $this->pAdmin);
//        $this->oVue->setData($photoAllUnauthorized);
//        $this->oVue->setData($photoAReviser);
//        $this->oVue->afficherMeta();
//        $this->oVue->afficherEntete();
//        $this->oVue->afficherBody();
//        $this->oVue->afficherPiedPage();
//    }
    
    /**
    * @brief Méthode qui appelle la vue d'affichage de la page gestion
    * @access private
    * @return void
    */
    private function gestion() {
        
        $oeuvre = new Oeuvre();
        $arrondissement = new Arrondissement();
        $categorie = new SousCategorie();
        
        if (isset($_POST["misAJour"])) {
            $oeuvre->updaterOeuvresVille();
        }
        $date = $oeuvre->getDateDernierUpdate();
        
        if (isset($_GET["ajouterOeuvre"])) {
            $oeuvreAModifier = $oeuvre->afficheArticlePourModif(1);
        }
        else {
            $oeuvreAModifier = "";
        }
        
        //Suppression d'une oeuvre.
        if (isset($_POST["boutonSuppOeuvre"]) && $_POST["selectOeuvreSupp"] != "") {
            $oeuvre->supprimerOeuvre($_POST["selectOeuvreSupp"]);
        }
        
        //Ajout d'une oeuvre.
        $authorise = true;
        
        if(isset($_POST['boutonAjoutOeuvre'])) {

            $oeuvre->ajouterOeuvre($_POST['titreAjout'], $_POST['adresseAjout'], $_POST['prenomArtisteAjout'], $_POST['nomArtisteAjout'], $_POST['descriptionAjout'], $_POST["selectSousCategorie"], $_POST["selectArrondissement"], $authorise, $this->langueAffichage);
        }
        
        //Modification d'une oeuvre ici.
        
        
        
        
        $oeuvresBDD = $oeuvre->getAllOeuvres();
        $arrondissementsBDD = $arrondissement->getAllArrondissements();
        $categorieBDD = $categorie->getAllSousCategories($this->langueAffichage);
        
        $this->oVue = new VueGestion();
        $this->oVue->setDataGlobal("Gestion", "page de gestion par l'administrateur", $this->langueAffichage, $this->pGestion);
        $this->oVue->setData($date, $oeuvreAModifier, $oeuvresBDD, $arrondissementsBDD, $categorieBDD);
        $this->oVue->afficherMeta();
        $this->oVue->afficherEntete();
        $this->oVue->afficherBody();
        $this->oVue->afficherPiedPage();
    }
    
    /**
    * @brief Méthode qui appelle la déclenche la mise à jour des données de la ville de Montréal
    * @access private
    * @return void
    */
    private function updateOeuvresVille() {
        
        $oeuvre = new Oeuvre();
        $oeuvre->updaterOeuvresVille();
    }   
    
    private function recherche() {
        
        $oeuvres = array();
        
        if (isset($_POST["boutonRecherche"])) {
            
            if (isset($_POST["selectArrondissement"]) && $_POST["selectArrondissement"] != "") {
                $oeuvre = new Oeuvre();
                $oeuvres = $oeuvre->getAllOeuvresByArrondissement($_POST["selectArrondissement"]);    
            }
            else if (isset($_POST["selectCategorie"]) && $_POST["selectCategorie"] != "") {
                $oeuvre = new Oeuvre();
                $oeuvres = $oeuvre->getAllOeuvresByCategorie($_POST["selectCategorie"]);
            }
        }
        else if (isset($_GET["rechercheParArtiste"])) {
            $oeuvre = new Oeuvre();
            $oeuvres = $oeuvre->getAllOeuvresByArtiste($_GET["rechercheParArtiste"]);
        }
        $this->oVue = new VueRecherche();
        $this->oVue->setDataGlobal('recherche', 'page de recherche', $this->langueAffichage, $this->pRecherche);
        $this->oVue->setOeuvres($oeuvres);
        $this->oVue->afficherMeta();
        $this->oVue->afficherEntete();
        $this->oVue->afficherBody();
        $this->oVue->afficherPiedPage();
    }
    

    // Placer les méthodes du controleur ici.
}
?>