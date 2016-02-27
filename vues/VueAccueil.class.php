<?php
/**
 * @brief Class VueAccueil
 * @author David Lachambre
 * @version 1.0
 * @update 2016-12-15
 * 
 */
header('Content-Type: text/html; charset=utf-8');//Affichage du UTF-8 par PHP.

class VueAccueil extends Vue {
    
    /**
    * @var array $photos Photos associées à l'oeuvre
    * @access private
    */
    private $photosAll;

    function __construct() {
        $this->titrePage = "MontréArt - Accueil";
        $this->descriptionPage = "La page d'accueil du site MontréArt";
    }
    public function setData($photosAll) {
        $this->photosAll = $photosAll;
    }
    /**
    * @brief Méthode qui affiche le corps du document HTML
    * @access public
    * @return void
    */
    public function afficherBody() {
        
    ?>          
        <h4 id="aProposMontreart">A propos de MontréArt</h4>
        <p class="textStandard" id="texteAccueil">
Bienvenue sur le site de Montréart, où les oeuvres publiques les plus fantastiques en ville sont répertoriées. Idéal pour en apprendre sur les artistes les plus branchés, des techniques de création des plus diverses et des pièces d'art à couper le souffle. Vous pourrez vous balader et partager vos trouvailles avec vos propres photos, et exprimer vos opinions en ligne. En plus de découvrir l'art d'ici, vous avec la possibilité de gagner des rabais incroyables grâce à notre système dès que vous vous trouvez proche d'une oeuvre! Partez à l'aventure, ça en vaut le coup!
        </p>
    <div id="map"></div>
    <div id="distanceMarqueur"></div>

     <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBX7W9IA4ew3pHEhUYUId7DYSRaVaUrDJM&signed_in=true&callback=initMap"></script>
<script type="text/javascript" src="js/vendor/js-marker-clusterer-gh-pages/src/markerclusterer.js"></script>

    <div class="oeuvreVedette">
           <img src="images/LionBelfortDesktop.png" id="lionDesktop">
           <img src="images/LionBelfortMobile.png" id="lionMobile">
    </div>

    <div class="pubAccueil">
        <img src="images/Promo.png">
    </div>
    <?php
    }
}
?>