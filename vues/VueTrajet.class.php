<?php
/**
 * @brief Class VueTrajet
 * @author Cristina Mahneke
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
         
        
         <div class="section1" id="itineraire">
             <form action="#" id="form_itineraire" method="post" name="form_itineraire">
                <h3>Point A</h3>
                <input type="text" name="pointA" value="">
                <h3>Point B</h3>
                <input type="text" name="pointB" value="">
                
                <input class="submit" type="submit" value="Envoyer" name="Envoyer">
            </form>
            </div>
         <div class="section2" id="carte">
           
         </div>
        
        <div id="votreTrajet"><p>Votre trajet</p>
        </div>
        
        <div id="sponsorsTrajet">
            <p>sponsors</p>
        </div>
    <?php
    }
}
    
?>