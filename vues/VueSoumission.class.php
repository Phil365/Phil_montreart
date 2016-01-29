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
    
    /**
    * @var array $oeuvresBDD Toutes les oeuvres de la BDD.
    * @access private
    */
    private $oeuvresBDD;
    
    /**
    * @var array $arrondissementsBDD Tous les arrondissements de la BDD.
    * @access private
    */
    private $arrondissementsBDD;
    
    /**
    * @var array $categoriesBDD Toutes les catégories de la BDD.
    * @access private
    */
    private $categoriesBDD;
    
    function __construct() {
        $this->titrePage = "MontréArt - Soumission";
        $this->descriptionPage = "La page de soumission d'une oeuvre du site MontréArt";
    }
    
    /**
    * @brief Méthode qui affecte des valeurs aux propriétés privées
    * @param array $oeuvresBDD
    * @param array $arrondissementsBDD
    * @param array $categoriesBDD
    * @access public
    * @return void
    */
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

            <form method="POST" name="formAjoutOeuvre" action="?r=soumission" enctype="multipart/form-data" onsubmit="return valideAjoutOeuvreJS();">
                
                <input type='text' id="titreAjout" name='titreAjout' value="" placeholder="Titre de l'oeuvre"/>
                <br><span class="erreur" id="erreurTitreOeuvre"></span>
                <input type='text' name='prenomArtisteAjout' value="" placeholder="Prénom de l'artiste (si connu)"/>
                <input type='text' name='nomArtisteAjout' value="" placeholder="Nom de l'artiste (si connu)"/>
                <input type='text' id="adresseAjout" name='adresseAjout' value="" placeholder="Adresse (obligatoire)"/>
                <br><span class="erreur" id="erreurAdresseOeuvre" ></span><br>
                <textarea id="descriptionAjout" name='descriptionAjout' placeholder="Description (obligatoire)"></textarea>
                <br><span class="erreur" id="erreurDescription"></span><br>
                <select id="selectArrondissement" name="selectArrondissement">
                    <option value="">Choisir un arrondissement</option>
                    <?php
                        foreach ($this->arrondissementsBDD as $arrondissement) {
                            echo "<option value='".$arrondissement["idArrondissement"]."'>".$arrondissement["nomArrondissement"];
                        }
                    ?>
                </select> 
                <br><span class="erreur" id="erreurSelectArrondissement"></span>
                <select id="selectSousCategorie" name="selectSousCategorie">
                    <option value="">Choisir une catégorie</option>
                    <?php
                        foreach ($this->categoriesBDD as $categorie) {
                            echo "<option value='".$categorie["idSousCategorie"]."'>".$categorie["sousCategorie$this->langue"];
                        }
                        echo "</select>";
                    ?>
                </select>
                <br><span class="erreur" id="erreurSelectCategorie"></span>
                    <h3>Téléversez l'image de l'oeuvre</h3>
                <input type="file" name="fileToUpload" id="fileToUpload" value="">
                <input class="boutonMoyenne" type='submit' name='boutonAjoutOeuvre' value='Ajouter'>
            </form>
        </main>

    <?php
    }
}
    
?>