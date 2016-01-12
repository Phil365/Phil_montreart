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
    * @brief Méthode qui affiche le corps du document HTML
    * @access public
    * @return void
    */
    public function afficherBody() {
    ?>
        <div class="dummy"><!--    Ne mettez rien ici--></div>

            <div class="section1">

               section 1     Participe au projet
            </div> 
            <div class="section2">
                    slider section2
            </div>

            <div class="section3">

                    section3 Oeuvre en Vedette
            </div>
            <div class="section4">
                <h4>A propos de MontréArt</h4>
                    <p class="textStandard">​
Bienvenue sur le site de Montréart, où les oeuvres publiques les plus fantastiques en ville sont répertoriées. Idéal pour en apprendre sur les artistes les plus branchés, des techniques de création des plus diverses et des pièces d'art à couper le souffle. Vous pourrez vous balader et partager vos trouvailles avec vos propres photos, et exprimer vos opinions en ligne. En plus de découvrir l'art d'ici, vous avec la possibilité de gagner des rabais incroyables grâce à notre système dès que vous vous trouvez proche d'une oeuvre! Partez à l'aventure, ça en vaut le coup!</p>
            </div>
             <div class="section5">
                   <img id="SponsorImg" src="images/Sponsors.png" alt="sponsorsImg">
            </div>

    <?php
    }
}
    
?>