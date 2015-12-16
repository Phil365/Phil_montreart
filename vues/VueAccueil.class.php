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