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
    
    private $oeuvresBDD;
    
    private $arrondissementsBDD;
    
    private $categoriesBDD;
    
    function __construct() {
        $this->titrePage = "MontréArt - Soumission";
        $this->descriptionPage = "La page de soumission d'une oeuvre du site MontréArt";
    }
    
    public function setData($oeuvresBDD, $arrondissementsBDD, $categoriesBDD) {
        $this->oeuvresBDD = $oeuvresBDD;
        $this->arrondissementsBDD = $arrondissementsBDD;
        $this->categoriesBDD = $categoriesBDD;
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

            <form method="POST" name="formAjoutOeuvre" action="?r=soumission" enctype="multipart/form-data">
                <span class="erreur"></span>
                <input type='text' name='titreAjout' value="" placeholder="Titre de l'oeuvre (si connu)"/>
                <span class="erreur"></span>
                <input type='text' name='prenomArtisteAjout' value="" placeholder="Prénom de l'artiste (si connu)"/>
                <span class="erreur"></span>
                <input type='text' name='nomArtisteAjout' value="" placeholder="Nom de l'artiste (si connu)"/>
                <span class="erreur"></span>
                <input type='text' name='adresseAjout' value="" placeholder="Adresse (obligatoire)"/>
                <span class="erreur"></span>
                <textarea name='descriptionAjout' placeholder="Description (obligatoire)"></textarea>
                <select name="selectArrondissement">
                    <option value="">Choisir un arrondissement</option>
                    <?php
                        foreach ($this->arrondissementsBDD as $arrondissement) {
                            echo "<option value='".$arrondissement["idArrondissement"]."'>".$arrondissement["nomArrondissement"];
                        }
                        echo "</select>";
                    ?>
                </select><br>
                <select name="selectSousCategorie">
                    <option value="">Choisir une catégorie</option>
                    <?php
                        foreach ($this->categoriesBDD as $categorie) {
                            echo "<option value='".$categorie["idSousCategorie"]."'>".$categorie["sousCategorie$this->langue"];
                        }
                        echo "</select>";
                    ?>
                </select>
                    <h3>Téléversez l'image de l'oeuvre</h3>
                <input type="file" name="fileToUpload" id="fileToUpload" value="">
                <span class="erreur"></span>
                <input class="boutonMoyenne" type='submit' name='boutonAjoutOeuvre' value='Ajouter'>
            </form>
        </main>

    <?php
    }
}
    
?>