<?php
/**
 * Class Controler
 * Gère les requêtes HTTP
 * 
 * @author Jonathan Martel
 * @author David Lachambre
 * @version 1.1
 * @update 2015-12-10
 * @license Creative Commons BY-NC 3.0 (Licence Creative Commons Attribution - Pas d’utilisation commerciale 3.0 non transposé)
 * @license http://creativecommons.org/licenses/by-nc/3.0/deed.fr
 * 
 */

class Controler {
    
    private $oVue;
    private $oCookie;
    private $metaPageAccueil;
    private $metaPageOeuvre;
    private $pageActuelle;
    private $langueAffichage;
    
    public function __construct() {
        
        $this->oVue = new Vue();
        
        $this->oCookie = new Cookie();
        $this->langueAffichage = $this->oCookie->getLangue();
        
        if ($this->langueAffichage == "EN") {
            $this->metaPageAccueil = ["titre"=>"MontreArt - Home Page", "description"=>""];
            $this->metaPageOeuvre = ["titre"=>"Montréart - Art Page", "description"=>""];
        }
        else {
            $this->metaPageAccueil = ["titre"=>"MontréArt - page d'accueil", "description"=>""];
            $this->metaPageOeuvre = ["titre"=>"Montréart - page d'une oeuvre", "description"=>""];
        }
        
        $this->pageActuelle = $_GET['r'];
    }
    /**
     * Traite la requête
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
            default:
                $this->accueil();
                break;
        }
    }
    private function accueil() {
        
        $this->oVue->afficheMeta($this->metaPageAccueil);
        $this->oVue->afficheEntete($this->pageActuelle);
        $this->oVue->afficheAccueil();
        $this->oVue->affichePiedPage();
    }
    private function oeuvre() {
        
        $oeuvre = new Oeuvre();
        $oeuvreAffichee = $oeuvre->getOeuvreById($_GET["o"], $this->langueAffichage);
        
        $commentaire = new Commentaire();
        $commentairesOeuvre = $commentaire->getCommentairesByOeuvre($_GET["o"], $this->langueAffichage);
        
        $photo = new Photo();
        $photosOeuvre = $photo->getPhotosByOeuvre($_GET["o"]);
        
        $this->oVue->afficheMeta($this->metaPageOeuvre);
        $this->oVue->afficheEntete($this->pageActuelle);
        $this->oVue->affichePageOeuvre($oeuvreAffichee, $commentairesOeuvre, $photosOeuvre, $this->langueAffichage);
        $this->oVue->affichePiedPage();
    }
    // Placer les méthodes du controleur.
}
?>















