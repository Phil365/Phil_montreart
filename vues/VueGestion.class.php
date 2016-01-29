<?php
/**
 * @brief Class VueGestion
 * @author David Lachambre
 * @author Cristina Mahneke
 * @version 1.0
 * @update 2016-01-14
 * 
 */
header('Content-Type: text/html; charset=utf-8');//Affichage du UTF-8 par PHP.

class VueGestion extends Vue {
    
    /**
    * @var string $dateDernierUpdate date de la dernière mise à jour des oeuvres de la villes dans la BDD.
    * @access private
    */
    private $dateDernierUpdate;
    
    /**
    * @var array $oeuvreAModifier Oeuvre qui doit être modifiée par l'administrateur.
    * @access private
    */
    private $oeuvreAModifier;
    
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
    * @var array $msgErreursModif Tous les messages d'erreurs liés à la tentative de modification d'une oeuvre.
    * @access private
    */
    private $msgErreursModif;
    
    function __construct() {
        
    }
    
    /**
    * @brief Méthode qui affecte des valeurs aux propriétés privées
    * @param string $dateDernierUpdate
    * @param array $oeuvreAModifier
    * @param array $oeuvresBDD
    * @param array $arrondissementsBDD
    * @param array $categoriesBDD
    * @param array $msgErreursModif
    * @access public
    * @return void
    */
    public function setData($dateDernierUpdate, $oeuvreAModifier, $oeuvresBDD, $arrondissementsBDD, $categoriesBDD, $msgErreursModif) {
        
        $this->dateDernierUpdate = $dateDernierUpdate;
        $this->oeuvreAModifier = $oeuvreAModifier;
        $this->oeuvresBDD = $oeuvresBDD;
        $this->arrondissementsBDD = $arrondissementsBDD;
        $this->categoriesBDD = $categoriesBDD;
        $this->msgErreursModif = $msgErreursModif;
    }
       
    /**
    * @brief Méthode qui affiche le corps du document HTML
    * @access public
    * @return void
    */
    public function afficherBody() {
        
        $titreModif='';
        $adresse='';
        $idSousCategorie='';
        $idArrondissement='';
        $description='';
        
        if (!empty($this->oeuvreAModifier)){//S'il y a une oeuvre à modifier...
            
            $titreModif = $this->oeuvreAModifier['titre'];
            $adresse = $this->oeuvreAModifier['adresse'];
            $idSousCategorie = $this->oeuvreAModifier['idSousCategorie'];
            $idArrondissement = $this->oeuvreAModifier['idArrondissement'];
            if ($this->langue == "FR") {
                $description = $this->oeuvreAModifier['descriptionFR'];
            }
            else if ($this->langue == "EN") {
                $description = $this->oeuvreAModifier['descriptionEN'];
            }
        
        }
     
        $msgAjout = "";
        $msgSupp = "";
        $msgModif = "";
        if (!isset($this->dateDernierUpdate["dateDernierUpdate"])) {
            $date = "Jamais mis à jour";
        }
        else {
            $date = "<br>La dernière mise à jour a été effectuée le " . $this->dateDernierUpdate["dateDernierUpdate"] . " à " . $this->dateDernierUpdate["heureDernierUpdate"];
        }
    ?>
        <h2>Administration</h2>

        <div>
            <?php
                echo "<h3 id ='MAJgestion'>Dernière mise à jour des oeuvres de la ville :</h3>";
                echo $date;
            ?>
            
            <!-- ----- METTRE OEUVRES VILLE À JOUR ------- -->
            <form action="?r=gestion" method="post">
                <input class="boutonMoyenne" type="submit" id="misAJour" name='misAJour' class="boutonMoyenne" value='Mettre à Jour' />
            </form>
            
            <!-- ----- AJOUT OEUVRE ------- -->
        
            <div id="Onglet-1">
                <h2>Ajouter une oeuvre</h2>
                          
                <form method="POST" name="formAjoutOeuvre" onsubmit="return valideAjoutOeuvreJS();" action="?r=gestion" enctype="multipart/form-data" >
                    <input type='text' class="inputGestion" name='titreAjout' id='titreAjout' placeholder="Titre de l'oeuvre"/>
                    <br> <span  id="erreurTitreOeuvre" class="erreur"></span><br>                  
                   
                    <input type='text' class="inputGestion" name='prenomArtisteAjout' id='prenomArtisteAjout' value="" placeholder="Prénom de l'artiste"/>
                    <br> <span class="erreur" id="erreurPrenomArtisteAjout"></span><br>
                  
                    <input type='text' class="inputGestion" name='nomArtisteAjout' id='nomArtisteAjout' value="" placeholder="Nom de l'artiste "/>
                    <br>  <span class="erreur" id="erreurNomArtisteAjout"></span><br>
                  
                    <input type='text' class="inputGestion" name='adresseAjout' id='adresseAjout' value="" placeholder="Adresse "/>
                    <br>  <span class="erreur" id="erreurAdresseOeuvre"></span><br>
                  
                    <textarea name='descriptionAjout' class="inputGestion" id='descriptionAjout' placeholder="Description "></textarea>
                    <br>  <span class="erreur" id="erreurDescription"></span><br>
                  
                    <select name="selectArrondissement"  id="selectArrondissement" class="selectGestion">
                        <option value="">Choisir un arrondissement</option>
                        <?php
                            foreach ($this->arrondissementsBDD as $arrondissement) {
                                echo "<option value='".$arrondissement["idArrondissement"]."'>".$arrondissement["nomArrondissement"];
                            }
                            echo "</select>";
                        ?>
                    </select>
                    <br>  <span class="erreur" id="erreurSelectArrondissement"></span><br>
                    <select name="selectSousCategorie"  id="selectSousCategorie" class="selectGestion">
                        <option value="">Choisir une catégorie</option>
                        <?php
                            foreach ($this->categoriesBDD as $categorie) {
                                echo "<option value='".$categorie["idSousCategorie"]."'>".$categorie["sousCategorie$this->langue"];
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
                    <input class="boutonMoyenne" type='submit' name='boutonAjoutOeuvre' value='Ajouter'>
                </form>
                <span class="msgUser">
                <?php
                echo $msgAjout;
                ?>  
                </span>
            </div> 
            
            <!--- jQuery pour afficher les onglets -->

            <script type="text/javascript">

                /**
                 * @brief fonction jQuery qui affiche et masque les sections en fonction du lien cliqué par l'utilisateur.
                 */
//                $(document).ready(function(){
//                    
//                    $("#click1").click(function(){
//                        
//                        $("#Onglet-1").slideToggle(1000);
//                        $("#Onglet-2").slideUp(500);
//                        $("#Onglet-3").slideUp(500);
//                        $("#Onglet-4").slideUp(500);
//                        $("#Onglet-5").slideUp(500);
//                    });
//                    $("#click2").click(function(){
//                        
//                        $("#Onglet-2").slideToggle(1000);
//                        $("#Onglet-1").slideUp(500);
//                        $("#Onglet-3").slideUp(500);
//                        $("#Onglet-4").slideUp(500);
//                        $("#Onglet-5").slideUp(500);
//                    });
//                    $("#click3").click(function(){
//                        
//                        $("#Onglet-3").slideToggle(1000);
//                        $("#Onglet-1").slideUp(500);
//                        $("#Onglet-2").slideUp(500);
//                        $("#Onglet-4").slideUp(500);
//                        $("#Onglet-5").slideUp(500);
//                    });
//                    $("#click4").click(function(){
//                        
//                        $("#Onglet-4").slideToggle(1000);
//                        $("#Onglet-1").slideUp(500);
//                        $("#Onglet-2").slideUp(500);
//                        $("#Onglet-3").slideUp(500);
//                        $("#Onglet-5").slideUp(500);
//                    });
//                    $("#click5").click(function(){
//                        
//                        $("#Onglet-5").slideToggle(1000);
//                        $("#Onglet-1").slideUp(500);
//                        $("#Onglet-2").slideUp(500);
//                        $("#Onglet-3").slideUp(500);
//                        $("#Onglet-4").slideUp(500);
//                    });
//                });
            </script>

            <!-- ----- SUPPRESSION OEUVRE ------- -->

            <div id="Onglet-2">  
                <h2>Supprimer une oeuvre</h2>
                <form method="POST" name="formSuppOeuvre" action="?r=gestion"  onsubmit="return valideSupprimerOeuvreJS();">

                    <select name="selectOeuvreSupp" id='selectOeuvreSupp' class="selectGestion">
                        <?php
                        echo "<option value=''>choisir une oeuvre</option>";
                        foreach ($this->oeuvresBDD as $oeuvre) {
                            echo "<option value='".$oeuvre["idOeuvre"]."'>".$oeuvre["titre"]."</option>";
                        }
                        echo "</select>";
                        ?>
                    </select>
                    <br><span class="erreur" id='erreurSelectSuppression'></span><br>

                    <input class="boutonMoyenne" type='submit' name='boutonSuppOeuvre' value='Supprimer'>
                </form>
                <span class="msgUser">
                <?php
                echo $msgSupp;
                ?>  
                </span>
            </div> 
            
            <!-- ----- MODIFICATION OEUVRE ------- -->

           <div id="Onglet-3">
                <h2>Modifier une oeuvre</h2>
                <form method="POST" name="formModifOeuvre" id='formModifSelectOeuvre' action="?r=gestion&action=modifierOeuvre" onsubmit="return valideModifierOeuvreJS();">
                     
                    <select name="selectOeuvreModif" id='selectOeuvreModif' onchange="this.form.submit()">
                        <?php
                        echo "<option value=''>choisir une oeuvre</option>";
                        foreach ($this->oeuvresBDD as $oeuvre) {
                            if ($_POST["selectOeuvreModif"] == $oeuvre["idOeuvre"]) {
                                $selection = "selected";
                            }
                            else {
                                $selection = "";
                            }
                            echo "<option value='".$oeuvre["idOeuvre"]."'".$selection.">".$oeuvre["titre"]."</option>";
                        }
                ?>
                        </select>
                        <span class="erreur" id='erreurSelectModif'></span>

                <?php
                    if (isset($_POST['selectOeuvreModif']) && $_POST['selectOeuvreModif'] != "") {
                ?>                                
                    <input type='text' class="inputGestion" name='titreModif' id='titreModif' placeholder="Titre de l'oeuvre" value='<?php echo $titreModif?>'/>
                    <br><span class="erreur" id="erreurTitreOeuvreModif"><?php if (isset($this->msgErreursModif["errTitre"])) {echo $this->msgErreursModif["errTitre"];} ?></span>
                        
                    <input type='text' class="inputGestion" name='adresseModif' id='adresseModif'  placeholder="Adresse " value='<?php echo $adresse?>'/>
                    <br><span class="erreur" id="erreurAdresseOeuvreModif"><?php if (isset($this->msgErreursModif["errAdresse"])) {echo $this->msgErreursModif["errAdresse"];} ?></span>

                    <br>
                    <textarea name='descriptionModif' class="inputGestion" id='descriptionModif' placeholder="Description "><?php echo $description?></textarea>
                    <br><span class="erreur" id="erreurDescriptionModif"><?php if (isset($this->msgErreursModif["errDescription"])) {echo $this->msgErreursModif["errDescription"];} ?></span>

                    <select name="selectArrondissement"  id="selectArrondissementModif" class="selectGestion">
                        
                        <option value="">Choisir un arrondissement</option>
                        <?php
                            foreach ($this->arrondissementsBDD as $arrondissement) {
                                if ($arrondissement["idArrondissement"] == $idArrondissement) {
                                    $selection = "selected";
                                }
                                else {
                                    $selection = "";
                                }
                                echo "<option value='".$arrondissement["idArrondissement"]."'".$selection.">".$arrondissement["nomArrondissement"];
                            }
                        
                        ?>
                    </select>
                    <br><span class="erreur" id="erreurSelectArrondissementModif"><?php if (isset($this->msgErreursModif["errArrondissement"])) {echo $this->msgErreursModif["errArrondissement"];} ?></span>
                    
                    <select name="selectSousCategorie" id="selectSousCategorieModif" class="selectGestion">
                        
                        <option value="">Choisir une catégorie</option>
                        <?php
                            foreach ($this->categoriesBDD as $categorie) {
                                if ($categorie["idSousCategorie"] == $idSousCategorie) {
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
                    <br><span class="erreur" id="erreurSelectCategorieModif"><?php if (isset($this->msgErreursModif["errCategorie"])) {echo $this->msgErreursModif["errCategorie"];} ?></span>
                        
                    <br><input class="boutonMoyenne" type='submit' name='boutonModifOeuvre' value='Modifer'>
                </form>
              

                <span class="msgUser">
                <?php
                echo $msgModif;
                ?>  
                </span>
            </div> 
        </div>
     <?php
        }
    } 
}
?>