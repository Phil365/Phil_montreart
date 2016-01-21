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
                if($_GET['action'] == 'envoyer')
                {
                    $this->enregistrerOeuvre();
                }
                else
                {
                    $this->oeuvre();    
                }
                
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
        $photosOeuvre = $photo->getPhotosByOeuvre($_GET["o"]);
        
        $this->oVue = new VueOeuvre();
        $this->oVue->setDataGlobal('oeuvre', "page d'une oeuvre", $this->langueAffichage, $this->pOeuvre);
        $this->oVue->setData($oeuvreAffichee, $commentairesOeuvre, $photosOeuvre, $this->langueAffichage);      
        $this->oVue->afficherMeta();
        $this->oVue->afficherEntete();
        $this->oVue->afficherBody();
        $this->oVue->afficherPiedPage();
    }
    
     private function enregistrerOeuvre() {
        
        $oeuvre = new Oeuvre();
        $oeuvreAffichee = $oeuvre->getOeuvreById($_GET["o"], $this->langueAffichage);
        
        $commentaire = new Commentaire();
        $commentairesOeuvre = $commentaire->getCommentairesByOeuvre($_GET["o"], $this->langueAffichage);
        
        $photo = new Photo();
        $photosOeuvre = $photo->getPhotosByOeuvre($_GET["o"]);
        $photosEnvoie = $photo->inserePhotoBdd($_GET["o"]);
         
        $this->oVue = new VueOeuvre();
         $this->oVue->setDataGlobal('oeuvre', "page d'une oeuvre", $this->langueAffichage, $this->pOeuvre);
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
        
        $this->oVue = new VueSoumission();
        $this->oVue->setDataGlobal('soumission', "page de soumission d'oeuvre", $this->langueAffichage, $this->pSoumission);
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
    private function admin(){
        $photo = new Photo();
        $photoAllUnauthorized = $photo->getAllUnauthorizedPhoto();
        $photoAReviser = $photo->getPhotoById();
        $oeuvre = new Oeuvre;
        $oeuvre->updaterOeuvresVille();
        $date = $oeuvre->getDateDernierUpdate();
        $this->oVue = new VueAdmin(); 
        $this->oVue->setData($photoAllUnauthorized);
        $this->oVue->setData($photoAReviser);
        $this->oVue->afficherMeta();
        $this->oVue->afficherEnteteAdmin();
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
        
        switch ($_GET["pageActuelle"]) {
            case $this->pAccueil:
                $this->oVue = new VueAccueil();
                $this->oVue->setDataGlobal("Accueil", "page d'accueil", $this->langueAffichage, $this->pAccueil);
                break;
            case $this->pOeuvre:
                $this->oVue = new VueOeuvre();
                $this->oVue->setDataGlobal("Oeuvre", "page d'une oeuvre", $this->langueAffichage, $this->pOeuvre);
                break;
            case $this->pTrajet:
                $this->oVue = new VueTrajet();
                $this->oVue->setDataGlobal("Trajet", "page de création d'un trajet", $this->langueAffichage, $this->pTrajet);
                break;
            case $this->pSoumission:
                $this->oVue = new VueSoumission();
                $this->oVue->setDataGlobal("Soumission", "page de soumission", $this->langueAffichage, $this->pSoumission);
                break;
            case $this->pProfil:
                $this->oVue = new VueProfil();
                $this->oVue->setDataGlobal("Profil", "page de profil utilisateur", $this->langueAffichage, $this->pProfil);
                break;
            case $this->pRecherche:
                $this->oVue = new VueRecherche();
                $this->oVue->setDataGlobal("Recherche", "page de résultats de recherche", $this->langueAffichage, $this->pRecherche);
                break;
            default:
                $this->oVue = new VueAccueil();
                $this->oVue->setDataGlobal("Accueil", "page d'accueil", $this->langueAffichage, $this->pAccueil);
                break;
        }
        
        if (isset($_POST["typeRecherche"])) {//Pour remplir le 2e select de la recherche.
            
            if ($_POST["typeRecherche"] == "categorie") {
                $nouvelleCategorie = new Categorie();
                $categories = $nouvelleCategorie->getAllCategories($this->langueAffichage);
                $this->oVue->setSelectRecherche($categories);
            }
            else if ($_POST["typeRecherche"] == "arrondissement") {
                $nouvelArrondissement = new Arrondissement();
                $arrondissement = $nouvelArrondissement->getAllArrondissements();
                $this->oVue->setSelectRecherche($arrondissement);
            }
            
            if (isset($_POST["selectCategorie"]) && $_POST["selectCategorie"] != "") {//Effecetue la recherche et affiche les résultats.
                $oeuvre = new Oeuvre();
                $oeuvres = $oeuvre->getAllOeuvresByCategorie($_POST["selectCategorie"]);
                $this->oVue = new VueRecherche();
                $this->oVue->setDataGlobal('recherche', 'page de recherche', $this->langueAffichage, $this->pRecherche);
                $this->oVue->setOeuvres($oeuvres);  
            }
            else if (isset($_POST["selectArrondissement"]) && $_POST["selectArrondissement"] != "") {//Effecetue la recherche et affiche les résultats.
                $oeuvre = new Oeuvre();
                $oeuvres = $oeuvre->getAllOeuvresByArrondissement($_POST["selectArrondissement"]);
                $this->oVue = new VueRecherche();
                $this->oVue->setDataGlobal('recherche', 'page de recherche', $this->langueAffichage, $this->pRecherche);
                $this->oVue->setOeuvres($oeuvres);  
            }
        }
        $this->oVue->afficherMeta();
        $this->oVue->afficherEntete();
        $this->oVue->afficherBody();
        $this->oVue->afficherPiedPage();
    }
    
    // Placer les méthodes du controleur ici.
}
?>















