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
    
    public function __construct() {
        
        $this->oVue = new Vue();
    }
    /**
     * Traite la requête
     * @return void
     */
    public function gerer() {
        
        $this->meta();
        $this->entete();
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
        $this->piedPage();
    }
    private function meta() {
        
        $this->oVue->afficheMeta();
    }
    private function entete() {
        
        $this->oVue->afficheEntete();
    }
    private function accueil() {
        
        $this->oVue->afficheAccueil();
    }
    private function oeuvre() {
        
        $oeuvre = new Oeuvre();
        $oeuvre->setData(1, "titre test", 1234, "45.554", "56.534645", null, null, "adresse test", "description test", 1, 1, 1, 1, ["photo1", "photo2"], ["commentaire1", "commentaire2"]);
        $this->oVue->affichePageOeuvre($oeuvre);
    }
    private function piedPage() {
        
        $this->oVue->affichePiedPage();
    }
    // Placer les méthodes du controleur.
}
?>















