<?php
/**
 * @brief Class VueProfil
 * @author David Lachambre
 * @version 1.0
 * @update 2015-12-16
 * 
 */
header('Content-Type: text/html; charset=utf-8');//Affichage du UTF-8 par PHP.

class VueProfil extends Vue {
    
    function __construct() {
        $this->titrePage = "MontréArt - Profil";
        $this->descriptionPage = "La page de profil d'un utilisateur du site MontréArt";
    }
    
    /**
    * @brief Méthode qui affiche le corps du document HTML
    * @access public
    * @return void
    */
    public function afficherBody() {
    ?>
         <div class="dummy"><!--    Ne mettez rien ici--></div>
            <!-- Espace de l'utilisateur -->
        
            
        <div class="section1" id="profileUser">
            <h3>NomUser</h3>
            <h3>Bio</h3>
        
            <a href="contribuerArticle.php" ><h3>Contribuer article</h3></a>
                
            <a href="#" onclick="montrer_form()"><h3>Gérer mon profil</h3></a>
        </div>
        
        <div class="section2" id="mesPunaises">Mes punaises</div>
        

        <div class="section3" id="OeuvreEnVedette">
    
            Oeuvre en Vedette
        </div>
        
        <div class="section4" id="visites">Oeuvres Visités</div>
        
        
        
        <div class="section5">
            sponsors section5
        </div>
        

        <div id="div_bgform">
            <div id="div_form">

                <form action="#" id="form_profil" method="post" name="form_profil">
                    <button id="fermer" onclick ="fermer()">X</button>


                    <h3>Actualiser ma photo</h3>
                        <input type="file" name="photoTelecharger" id="photoTelecharger" value="Choisir image">

                        <div id="ImageProfile">image du user</div>

                        <h3>À propos de moi:</h3>
                        <textarea rows="10" cols="20"></textarea>

                        <h3>Nom usager:</h3>
                        <input type="nomUsager" name="nomUsager" value="">

                        <h3>Mot de passe:</h3>
                        <input type="motPasse" name="motPasse" value="">

                        <h3>Mot de passe répété:</h3>
                        <input type="motPasse" name="motPasse" value="">

                        <h3>Mon courriel:</h3>
                        <input type="courriel" name="courriel" value="">        

                    <button onclick="validerform()" class="submit">Envoyer</button>
                </form>
            </div>
        </div>