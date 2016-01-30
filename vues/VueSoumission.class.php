<?php
/**
 * @brief Class VueSoumission
 * @author David Lachambre
 * @author Cristina Mahneke
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
    
      /**
    * @var array $oeuvreASoumettre Oeuvre qui a ete soumis par l'usager.
    * @access private
    */
    private $oeuvreASoumettre;
    
     /**
    * @var array $msgErreursSoumission Tous les messages d'erreurs liés à la tentative de insertion d'une oeuvre.
    * @access private
    */
    private $msgErreursSoumission;
    
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
    public function setData($oeuvresBDD, $arrondissementsBDD, $categoriesBDD, $oeuvreASoumettre, $msgErreursSoumission) {
        $this->oeuvresBDD = $oeuvresBDD;
        $this->arrondissementsBDD = $arrondissementsBDD;
        $this->categoriesBDD = $categoriesBDD;
        $this->oeuvreASoumettre =$oeuvreASoumettre;
        $this->msgErreursSoumission = $msgErreursSoumission;
    }
    
    /**
    * @brief Méthode qui affiche le corps du document HTML
    * @access public
    * @return void
    */
    public function afficherBody() {
        $titreSoumis='';
        $prenomArtisteSoumis='';
        $nomArtisteSoumis='';
        $idSousCategorieSoumis='';
        $adresseSoumis = '';
        $idArrondissementSoumis='';
        $descriptionSoumis='';
        
        if (!empty($this->oeuvreASoumettre)){//S'il y a une oeuvre à ajouter...
             
            $titreSoumis = $this->oeuvreASoumettre['titre'];
            $adresseSoumis = $this->oeuvreASoumettre['adresse'];
            $prenomArtisteSoumis= $this->oeuvreASoumettre['prenomArtiste'];
            $nomArtisteSoumis= $this->oeuvreASoumettre['nomArtiste'];
            $idSousCategorieSoumis= $this->oeuvreASoumettre['idSousCategorie'];
            $idArrondissementSoumis = $this->oeuvreASoumettre['idArrondissement'];
            if ($this->langue == "FR") {
                $descriptionSoumis = $this->oeuvreASoumettre['descriptionFR'];
            }
            else if ($this->langue == "EN") {
                $descriptionSoumis = $this->oeuvreASoumettre['descriptionEN'];
            }
        
        }
        //var_dump($oeuvreASoumettre);
    ?>
       
        
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

              <form method="POST" name="formSoumissionOeuvre" onsubmit="return valideAjoutOeuvreJS();" action="?r=soumission&action=soumettreOeuvre" enctype="multipart/form-data" >
                    <input type='text' class="inputGestion" name='titreSoumis' id='titreAjout' placeholder="Titre de l'oeuvre" value="<?php echo  $titreSoumis?>"/>
                    <br> <span  id="erreurTitreOeuvre" class="erreur"></span><br>                  
                   
                    <input type='text' class="inputGestion" name='prenomArtisteSoumis' id='prenomArtisteAjout' value="<?php echo  $prenomArtisteSoumis?>" placeholder="Prénom de l'artiste"/>
                    <br> <span class="erreur" id="erreurPrenomArtisteAjout"></span><br>
                  
                    <input type='text' class="inputGestion" name='nomArtisteSoumis' id='nomArtisteAjout' value="<?php echo $nomArtisteSoumis ?>" placeholder="Nom de l'artiste "/>
                    <br>  <span class="erreur" id="erreurNomArtisteAjout"></span><br>
                  
                    <input type='text' class="inputGestion" name='adresseSoumis' id='adresseAjout' value="<?php echo $adresseSoumis ?>" placeholder="Adresse "/>
                    <br>  <span class="erreur" id="erreurAdresseOeuvre"></span><br>
                  
                    <textarea name='descriptionSoumis' class="inputGestion" id='descriptionAjout' placeholder="Description "><?php echo $descriptionSoumis ?></textarea>
                    <br>  <span class="erreur" id="erreurDescription"></span><br>
                  
                    <select name="selectArrondissement"  id="selectArrondissement" class="selectGestion">
                        <option value="">Choisir un arrondissement</option>
                        <?php
                            foreach ($this->arrondissementsBDD as $arrondissement) {
                                if ($arrondissement["idArrondissement"] == $idArrondissementSoumis) {
                                    $selection = "selected";
                                }
                                else {
                                    $selection = "";
                                }
                                echo "<option value='".$arrondissement["idArrondissement"]."'".$selection.">".$arrondissement["nomArrondissement"];
                            }
                        
                        ?>
                    </select>
                    <br>  <span class="erreur" id="erreurSelectArrondissement"></span><br>
                    <select name="selectSousCategorie"  id="selectSousCategorie" class="selectGestion">
                        <option value="">Choisir une catégorie</option>
                        <?php
                            foreach ($this->categoriesBDD as $categorie) {
                                if ($categorie["idSousCategorie"] == $idSousCategorieSoumis) {
                                    $selection = "selected";
                                }
                                else {
                                    $selection = "";
                                }
                                echo "<option value='".$categorie["idSousCategorie"]."'".$selection.">".$categorie["sousCategorie$this->langue"];
                            }
                            echo "</select>";
                        ?>
                    </select>   
                    <br><span class="erreur" id="erreurSelectCategorie"></span><br>
                    <h3 class="televersionTexteGestion">Téléversez l'image de l'oeuvre</h3>
                    <input type="file" name="fileToUpload" id="fileToUpload" value="" class="fileToUploadGestion">
                   <span id="erreurPhotoVide" class="erreur"></span><br>
                        <span id="erreurPhotoSize" class="erreur"></span><br>
                        <span id="erreurPhotoType" class="erreur"></span><br>
                    <input class="boutonMoyenne" type='submit' name='boutonSoumissionOeuvre' value='Soumettre'>
                </form>
        </main>

    <?php
    }
}
    
?>