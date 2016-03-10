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
    private $lat;
    private $lng;
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

         <div id="itineraire">
            <div id="distanceMarqueur"></div>
             <div id="form_itineraire" method="post" name="form_itineraire">
               
                <h3>Point de départ:</h3>
                <p>Veuillez taper une adresse si votre point de départ est différent de celui qui est montré pour l'icône</p>
                <input type="text" id= "depart" name="pointA" value="" placeholder="votre localisation">
                <span id="erreurDepart" class="erreur"></span>
                <br>
                <br><br><br><h3>Destination:</h3>
                
                <span id="erreurDestination" class="erreur"></span>
                
                <select id= "fin" name="fin">
                    <option>Sélectionnez la fin de votre route</option>
                </select>
                
                 <br><br><br><h3>Sélectionnez vos arrêts intermédiaires:</h3>
                 <p>Ctrl+clic pour sélectionner plusieurs options</p>
                 <span id="erreurWaypoints" class="erreur"></span>
                 <select multiple id="waypoints">
                    
                 </select>
                  <span id="erreurPasTrouve" class="erreur"></span>
                <input class="submit" onsubmit="return validerFormTrajet();" id="envoyerTrajetBouton" type="submit" value="Envoyer" name="Envoyer">
            </div>
            </div>
                <div id="directions-panel">
                   
                </div>

         <div id="map">
               <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBX7W9IA4ew3pHEhUYUId7DYSRaVaUrDJM&signed_in=true&callback=initMapTrajet"></script>
                 
        </div>
        
        
    <?php
    }
}
    
?>