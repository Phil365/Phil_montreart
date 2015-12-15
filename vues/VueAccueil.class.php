<?php
/**
 * @brief Class VueAccueil
 * @author David Lachambre
 * @version 1.0
 * @update 2015-12-15
 * 
 */
header('Content-Type: text/html; charset=utf-8');//Affichage du UTF-8 par PHP.

class VueAccueil extends Vue {
    
    function __construct() {
        $this->titrePage = "MontréArt - Accueil";
        $this->descriptionPage = "La page d'accueil du site MontréArt";
    }
    
    /**
	 * Affiche le meta de la page et ouvre les balises html
	 * @access public
	 * 
	 */
    public function afficherBody() {
    ?>
        <body>
            <article>
                <h1>MontréArt</h1>
                <p>Site en construction</p>
            </article>
        </body>
    <?php
    }
}
    
?>