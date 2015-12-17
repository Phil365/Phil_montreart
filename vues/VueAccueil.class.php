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
        <div class="dummy"><!--    Ne mettez rien ici--></div>

            <div class="section1">
                   <div class="single-item">
<?php
               
                        for ($i = 0; $i < count($this->photosAll); $i++) {
                            $imgPhoto = $this->photosAll[$i]['image'];
                            echo "<div><img src ='$imgPhoto'></div>";
                        }
                 
                   
                    ?>
  </div>
  

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script type="text/javascript" src="js/vendor/slick-1.5.9/slick/slick.min.js"></script>

  <script type="text/javascript">
    $(document).ready(function(){
      $('.single-item').slick({
autoplay: true,
  autoplaySpeed: 2000,
  dots: false,
  infinite: true,
  speed: 500,
  fade: true,
  cssEase: 'linear',
  adaptiveHeight: false,
   adaptiveWidth: true
    
        });
    });
  </script>
            </div>

            <div class="section2">

               <div id="map" style="width: 100%; height: 100%;"></div>
             <script type="text/javascript" src="js/googleMap.js"></script>
              <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBX7W9IA4ew3pHEhUYUId7DYSRaVaUrDJM&signed_in=true&callback=initMap"></script>
            </div> 

            <div class="section3">

                    section3 Oeuvre en Vedette
            </div>
            <div class="section4">
                    A propos section4
            </div>
             <div class="section5">
                    sponsors section5
            </div>

              <div id="div_bgform">
            <div id="div_form">
                <!-- Formulaire login -->
                <form action="#" id="formlogin" method="post" name="formlogin">
                    <button id="fermer" onclick ="fermer()">X</button>
                <h2>Connectez vous</h2>

                    <input id="nomutilisateur" name="nomutilisateur" placeholder="Votre identifiant" type="text">
                    <input id="motpasse" name="motpasse" placeholder="Mot de passe" type="password">

                    <button onclick="validerform()" class="submit" id="submit">Envoyer</button>
                    </form>
                </div>
        </div>
    <?php
    }
}
    
?>