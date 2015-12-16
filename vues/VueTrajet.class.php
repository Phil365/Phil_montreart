<?php
/**
 * @brief Class VueTrajet
 * @author David Lachambre
 * @version 1.0
 * @update 2015-12-16
 * 
 */
header('Content-Type: text/html; charset=utf-8');//Affichage du UTF-8 par PHP.

class VueTrajet extends Vue {
    
    function __construct() {
        $this->titrePage = "MontréArt - Trajet";
        $this->descriptionPage = "La page de création d'un trajet du site MontréArt";
    }
    
    /**
    * @brief Méthode qui affiche le corps du document HTML
    * @access public
    * @return void
    */
    public function afficherBody() {
    ?>
        <!-- HTML ICI -->
    <?php
    }
}
    
?>