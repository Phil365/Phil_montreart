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
    * @var array $arrondissements tableau des informations pour select arrondissements
    * @access private
    */
    private $arrondissements;
    
      /**
    * @var array $sousCategories tableau des informations pour select Categories
    * @access private
    */
    private $sousCategories;
     /**
    * @brief Méthode qui assigne des valeurs aux propriétés de la vue
    * @param string $arrondissements
    * @access public
    * @return void
    */
    function setData($arrondissements, $sousCategories){
        $this->arrondissements= $arrondissements;
        $this->sousCategories = $sousCategories;
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
            
            <form action="?r=soumission&action=soumetOeuvre" name="contribuer_oeuvre" id="contribuer_oeuvre" method="post" enctype="multipart/form-data">
            <h3>Titre, si connu: </h3>
                <input type="text" name="titre" value="">
        
                <h3>Artiste, si connu: </h3>
                <h4>Prénom de l'Artiste</h4>
                <input type="text" name="prenom" value="">
                 <h4>Nom de l'Artiste</h4>
                <input type="text" name="nom" value="">
<!--                <input class="text" name="artiste" type="text" placeholder="Entrez le nom de l'artiste" id="keyword" name="inputArtiste" onkeyup="autoCompleteArtistes('artiste')" >
                
           <div id="results"></div>-->

                
                <h3>Catégorie:</h3>
                <select name="idSousCategorie"><option value="">Choisir la catégorie...</option>
                     <?php
                     $sousCategorie = '';
                 $sousCategories = $this->sousCategories;
        foreach ($sousCategories as $sousCategorie) {
                echo '<option value="'.$sousCategorie["idSousCategorie"].'">'.$sousCategorie["sousCategorieFR"].'</option>';
                    }
                    ?>
                </select>
                <h3>Adresse ou intersection: </h3>
                <input type="text" name="adresse" value="">
                <h3>Arrondissement:</h3>
                <select name="idArrondissement"><option value="">Choisir l'arrondissement...</option>";
                 <?php
                 $arrondissement = '';
                 $arrondissements = $this->arrondissements;
        foreach ($arrondissements as $arrondissement) {
                echo '<option value="'.$arrondissement["idArrondissement"].'">'.$arrondissement["nomArrondissement"].'</option>';
            }
                      
                ?>
                    
                </select>
                <h3>Description:</h3>
                <textarea rows="10" cols="60" name="description"></textarea>
                <h3>Téléversez l'image de l'oeuvre</h3>
                <input name="photo" type="file" type="file" name="fileToUpload" id="fileToUpload">
                <input class="submit" type="submit" value="Envoyer" name="contr_article">
            
                <div id="capcha"></div>
            
            </form>
        </main>

    <?php
    }
}
    
?>