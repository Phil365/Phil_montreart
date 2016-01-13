<?php
/**
 * @brief Class VueSoumission
 * @author David Lachambre
 * @version 1.0
 * @update 2015-12-16
 * 
 */
header('Content-Type: text/html; charset=utf-8');//Affichage du UTF-8 par PHP.

class VueSoumission extends Vue {
    
    function __construct() {
        $this->titrePage = "MontréArt - Soumission";
        $this->descriptionPage = "La page de soumission d'une oeuvre du site MontréArt";
    }
    
    /**
    * @brief Méthode qui affiche le corps du document HTML
    * @access public
    * @return void
    */
    public function afficherBody() {
    ?>
        <div class="dummy"><!--    Ne mettez rien ici--></div>  
        
        <div class="aside1"  id="DevenirMembre">
            Devenir membre a ses avantages!
        </div>
        
 
        <div class="aside2" id="Sponsors">
            Sponsors
        </div>
        
        <main>
            <h2>Contribuez à Montréart!</h2>
            <p class="noIndent">Vous avez trouvé une oeuvre, qui, selon vous, devrait être sur notre site?</p>
            <p class="noIndent">Veuillez remplir le formulaire ci-dessous avec les informations de l'oeuvre en question.
            Toute contribution sera sujette à une approbation de la part d'un administrateur.</p>
            
            <form name="contribuer_article" id="contribuer_article" method="post">
                <h3>Titre, si connu: </h3>
                <input type="text" name="titre" value="">
        
                <h3>Auteur, si connu: </h3>
                <input type="text" name="auteur" value="">
                
                <h3>Date de création, si connue: </h3>
                <input type="text" name="date" value="">
                
                <h3>Adresse ou intersection: </h3>
                <input type="text" name="date" value="">
                <h3>Description:</h3>
                <textarea rows="10" cols="30"></textarea>
                <h3>Téléversez l'image de l'oeuvre</h3>
                <input type="file" name="photoTeleverser" id="photoTeleverser">
                <input class="submit" type="submit" value="Envoyer" name="contr_article">
            
                <div id="capcha">capcha</div>
            
            </form>
        </main>

    <?php
    }
}
    
?>