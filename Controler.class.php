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
    private $pageActuelle;
    
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
        
        $this->pageActuelle = $_GET['r'];
    }
    /**
    * @brief Traite la requête GET
    * @access public
    * @return void
    */
    public function gerer() {
        
        switch ($_GET['r']) {//requête
            case 'accueil':
                $this->accueil();
                break;
            case 'oeuvre':
                $this->oeuvre();
                break;
            case 'trajet':
                $this->trajet();
                break;
            case 'soumission':
                $this->soumission();
                break;
            case 'profil':
                $this->profil();
                break;
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
        $photosOeuvre = $photo->getPhotosByOeuvre($_GET["o"]);
        
        $this->oVue = new VueOeuvre();
        $this->oVue->setData($oeuvreAffichee, $commentairesOeuvre, $photosOeuvre, $this->langueAffichage);      
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
        
        $this->oVue = new VueSoumission();        
        $this->oVue->afficherMeta();
        $this->oVue->afficherEntete();
        $this->oVue->afficherBody();
        $this->oVue->afficherPiedPage();
    }
    
    /**
    * @brief Méthode qui appelle la vue d'affichage de la page de profil
    * @access private
    * @return void
    */
    private function profil() {
        
        $this->oVue = new VueProfil();        
        $this->oVue->afficherMeta();
        $this->oVue->afficherEntete();
        $this->oVue->afficherBody();
        $this->oVue->afficherPiedPage();
    }
    
    
    // Placer les méthodes du controleur ici.
}
?>















