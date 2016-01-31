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
    * @var array $oeuvreAjouter Oeuvre qui doit être ajoute par l'administrateur.
    * @access private
    */
    private $oeuvreAjouter;
    
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
    * @var array $msgErreurs Tous les messages d'erreurs liés aux requêtes de l'administrateur.
    * @access private
    */
    private $msgErreurs;
    
    
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
    public function setData($dateDernierUpdate, $oeuvreAModifier,$oeuvreAjouter, $oeuvresBDD, $arrondissementsBDD, $categoriesBDD, $msgErreurs) {
        
        $this->dateDernierUpdate = $dateDernierUpdate;
        $this->oeuvreAModifier = $oeuvreAModifier;
        $this->oeuvresBDD = $oeuvresBDD;
        $this->arrondissementsBDD = $arrondissementsBDD;
        $this->categoriesBDD = $categoriesBDD;
        $this->msgErreurs = $msgErreurs;
    }
       
    /**
    * @brief Méthode qui affiche le corps du document HTML
    * @access public
    * @return void
    */
    public function afficherBody() {
        
        //AJOUT  OEUVRE

        //Si l'ajout est complété avec succès...
        if (isset($_POST["boutonAjoutOeuvre"]) && empty($this->msgErreurs)) {
            $msgAjout = "<div style='color:green' class='erreur'>Ajout complété !</div>";
            $_POST["titreAjout"] = "";
            $_POST["prenomArtisteAjout"] = "";
            $_POST["nomArtisteAjout"] = "";
            $_POST["adresseAjout"] = "";
            $_POST["descriptionAjout"] = "";
            $_POST["selectArrondissement"] = "";
            $_POST["selectCategorie"] = "";
        }
        else if (isset($this->msgErreurs["errRequeteAjout"])) {
            $msgAjout = $this->msgErreurs["errRequeteAjout"];
        }
        else {
            $msgAjout = "";
        }
        
        //MODIF OEUVRE
        //-----------------------------------------------------
        $titreModif = "";
        $adresseModif = "";
        $idCategorieModif = "";
        $idArrondissementModif = "";
        $descriptionModif = "";
        
        if (!empty($this->oeuvreAModifier)){//S'il y a une oeuvre à modifier...
            
            $titreModif = $this->oeuvreAModifier['titre'];
            $adresseModif = $this->oeuvreAModifier['adresse'];
            $idCategorieModif = $this->oeuvreAModifier['idCategorie'];
            $idArrondissementModif = $this->oeuvreAModifier['idArrondissement'];
            if ($this->langue == "FR") {
                $descriptionModif = $this->oeuvreAModifier['descriptionFR'];
            }
            else if ($this->langue == "EN") {
                $descriptionModif = $this->oeuvreAModifier['descriptionEN'];
            }
        }
        
        if (isset($_POST["boutonModifOeuvre"]) && empty($this->msgErreurs)) {
            $msgModif = "<div style='color:green' class='erreur'>Modification complétée !</div>";
            $titreModif = "";
            $adresseModif = "";
            $idCategorieModif = "";
            $idArrondissementModif = "";
            $descriptionModif = "";
            $_POST["selectOeuvreModif"] = "";
        }
        else if (isset($this->msgErreurs["errRequeteModif"])) {
            $msgModif = $this->msgErreurs["errRequeteModif"];
        }
        else {
            $msgModif = "";
        }
        
        //SUPPRESSION OEUVRE
        //-----------------------------------------------------
        if (isset($_POST["boutonSuppOeuvre"]) && empty($this->msgErreurs)) {
            $msgSupp = "<div style='color:green' class='erreur'>Suppression complétée !</div>";
            $_POST["selectOeuvreSupp"] = "";
        }
        else if (isset($this->msgErreurs["errRequeteSupp"])) {
            $msgSupp = $this->msgErreurs["errRequeteSupp"];
        }
        else {
            $msgSupp = "";
        }
        
        //SUPPRESSION CATEGORIE
        //-----------------------------------------------------
        if (isset($_POST["boutonSuppCategorie"]) && empty($this->msgErreurs)) {
            $msgSuppCat = "<div style='color:green' class='erreur'>Suppression complétée !</div>";
            $_POST["selectOeuvreSupp"] = "";
        }
        else if (isset($this->msgErreurs["errRequeteSuppCat"])) {
            $msgSuppCat = $this->msgErreurs["errRequeteSuppCat"];
        }
        else {
            $msgSuppCat = "";
        }
        
        //AJOUT CATEGORIE
        //-----------------------------------------------------
        if (isset($_POST["boutonAjoutCategorie"]) && empty($this->msgErreurs)) {
            $msgAjoutCat = "<div style='color:green' class='erreur'>Ajout complétée !</div>";
            $_POST["categorieFrAjout"] = "";
            $_POST["categorieEnAjout"] = "";
        }
        else if (isset($this->msgErreurs["errRequeteAjoutCat"])) {
            $msgAjoutCat = $this->msgErreurs["errRequeteAjoutCat"];
        }
        else {
            $msgAjoutCat = "";
        }

        //Récupération de la dernière date de mise à jour
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
            
            <!-- ----- AJOUT CATÉGORIE ------- -->
    
            <div id="Onglet-1">
                <h2>Ajouter une catégorie</h2>
                          
                <form method="POST" name="formAjoutCategorie" action="?r=gestion" onsubmit="return valideAjoutCategorie();">
                    
                    <input type='text' class="inputGestion" name='categorieFrAjout' id='categorieFrAjout' placeholder="nom français de la catégorie" value="<?php echo $_POST["categorieFrAjout"] ?>"/>
                    <br> <span class="erreur" id="erreurAjoutCategorieFR"></span><?php if (isset($this->msgErreurs["errAjoutCategorieFR"])) {echo $this->msgErreurs["errAjoutCategorieFR"];} ?><br>
                    <input type='text' class="inputGestion" name='categorieEnAjout' id='categorieEnAjout' placeholder="nom anglais de la catégorie" value="<?php echo $_POST["categorieEnAjout"] ?>"/>
                    <br> <span class="erreur" id="erreurAjoutCategorieEN"></span><?php if (isset($this->msgErreurs["errAjoutCategorieEN"])) {echo $this->msgErreurs["errAjoutCategorieEN"];} ?><br>                  
                    
                    <input class="boutonMoyenne" type='submit' name='boutonAjoutCategorie' value='Ajouter'>
                </form>
                <span class="erreur">
                <?php
                echo $msgAjoutCat;
                ?>  
                </span>
            </div>
            
            <!-- ----- SUPPRESSION CATÉGORIE ------- -->

            <div id="Onglet-2">  
                <h2>Supprimer une catégorie</h2>
                
                <form method="POST" name="formSuppCategorie" action="?r=gestion"  onsubmit="return valideSuppCategorie();">

                    <select name="selectCategorieSupp" id='selectCategorieSupp' class="selectGestion">
                        <?php
                        echo "<option value=''>choisir une catégorie</option>";
                        foreach ($this->categoriesBDD as $categorie) {
                            echo "<option value='".$categorie["idCategorie"]."'>".$categorie["nomCategorie$this->langue"]."</option>";
                        }
                        echo "</select>";
                        ?>
                    </select>
                    <br><span class="erreur" id='erreurSelectSuppCategorie'><?php if (isset($this->msgErreurs["errSelectCategorieSupp"])) {echo $this->msgErreurs["errSelectCategorieSupp"];} ?></span><br>

                    <input class="boutonMoyenne" type='submit' name='boutonSuppCategorie' value='Supprimer'>
                </form>
                <span class="erreur">
                <?php
                echo $msgSuppCat;
                ?>  
                </span>
            </div>
            
            <!-- ----- AJOUT OEUVRE ------- -->
        
            <div id="Onglet-3">
                <h2>Ajouter une oeuvre</h2>
                          
                <form method="POST" name="formAjoutOeuvre" onsubmit="return valideAjoutOeuvre();" action="?r=gestion" enctype="multipart/form-data" >
                    <input type='text' class="inputGestion" name='titreAjout' id='titreAjout' placeholder="Titre de l'oeuvre" value="<?php echo  $_POST["titreAjout"]; ?>"/>
                    <br> <span  id="erreurTitreOeuvre" class="erreur"><?php if (isset($this->msgErreurs["errTitre"])) {echo $this->msgErreurs["errTitre"];} ?></span><br>                  

                    <input type='text' class="inputGestion" name='prenomArtisteAjout' id='prenomArtisteAjout' value="<?php echo  $_POST["prenomArtisteAjout"]; ?>" placeholder="Prénom de l'artiste"/>

                    <input type='text' class="inputGestion" name='nomArtisteAjout' id='nomArtisteAjout' value="<?php echo $_POST["nomArtisteAjout"]; ?>" placeholder="Nom de l'artiste "/>

                    <input type='text' class="inputGestion" name='adresseAjout' id='adresseAjout' value="<?php echo $_POST["adresseAjout"]; ?>" placeholder="Adresse "/>
                    <br>  <span class="erreur" id="erreurAdresseOeuvre"><?php if (isset($this->msgErreurs["errAdresse"])) {echo $this->msgErreurs["errAdresse"];} ?></span><br>

                    <textarea name='descriptionAjout' class="inputGestion textAreaGestion" id='descriptionAjout' placeholder="Description "><?php echo $_POST["descriptionAjout"]; ?></textarea>
                    <br>  <span class="erreur" id="erreurDescription"><?php if (isset($this->msgErreurs["errDescription"])) {echo $this->msgErreurs["errDescription"];} ?></span><br>

                    <select name="selectArrondissement"  id="selectArrondissement" class="selectGestion">
                        <option value="">Choisir un arrondissement</option>
                        <?php
                            foreach ($this->arrondissementsBDD as $arrondissement) {
                                if ($arrondissement["idArrondissement"] == $_POST["selectArrondissement"]) {
                                    $selection = "selected";
                                }
                                else {
                                    $selection = "";
                                }
                                echo "<option value='".$arrondissement["idArrondissement"]."'".$selection.">".$arrondissement["nomArrondissement"];
                            }

                        ?>
                    </select>
                    <br>  <span class="erreur" id="erreurSelectArrondissement"><?php if (isset($this->msgErreurs["errArrondissement"])) {echo $this->msgErreurs["errArrondissement"];} ?></span><br>
                    <select name="selectCategorie"  id="selectCategorie" class="selectGestion">
                        <option value="">Choisir une catégorie</option>
                        <?php
                            foreach ($this->categoriesBDD as $categorie) {
                                if ($categorie["idCategorie"] == $_POST["selectCategorie"]) {
                                    $selection = "selected";
                                }
                                else {
                                    $selection = "";
                                }
                                echo "<option value='".$categorie["idCategorie"]."'".$selection.">".$categorie["nomCategorie$this->langue"];
                            }
                            echo "</select>";
                        ?>
                    </select>   
                    <br><span class="erreur" id="erreurSelectCategorie"><?php if (isset($this->msgErreurs["errCategorie"])) {echo $this->msgErreurs["errCategorie"];} ?></span><br>
                    <h3 class="televersionTexteGestion">Téléversez l'image de l'oeuvre</h3>
                    <input type="file" name="fileToUpload" id="fileToUpload" class="fileToUploadGestion">
                   <span id="erreurPhoto" class="erreur"><?php if (isset($this->msgErreurs["errPhoto"])) {echo $this->msgErreurs["errPhoto"];} ?></span><br>
                    <input class="boutonMoyenne" type='submit' name='boutonAjoutOeuvre' value='Ajouter'>
                </form>
                <span class="erreur">
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

            <div id="Onglet-4">  
                <h2>Supprimer une oeuvre</h2>
                <form method="POST" name="formSuppOeuvre" action="?r=gestion"  onsubmit="return valideSupprimerOeuvre();">

                    <select name="selectOeuvreSupp" id='selectOeuvreSupp' class="selectGestion">
                        <?php
                        echo "<option value=''>choisir une oeuvre</option>";
                        foreach ($this->oeuvresBDD as $oeuvre) {
                            if ($_POST["selectOeuvreSupp"] == $oeuvre["idOeuvre"]) {
                                $selection = "selected";
                            }
                            else {
                                $selection = "";
                            }
                            echo "<option value='".$oeuvre["idOeuvre"]."'".$selection.">".$oeuvre["titre"]."</option>";
                        }
                        ?>
                    </select>
                    <br><span class="erreur" id='erreurSelectSuppression'><?php if (isset($this->msgErreurs["errSelectOeuvreSupp"])) {echo $this->msgErreurs["errSelectOeuvreSupp"];} ?></span><br>

                    <input class="boutonMoyenne" type='submit' name='boutonSuppOeuvre' value='Supprimer'>
                </form>
                <span class="erreur">
                <?php
                echo $msgSupp;
                ?>  
                </span>
            </div> 
            
            <!-- ----- MODIFICATION OEUVRE ------- -->

           <div id="Onglet-5">
                <h2>Modifier une oeuvre</h2>
                <form method="POST" name="formModifOeuvre" id='formModifSelectOeuvre' action="?r=gestion" onsubmit="return valideModifierOeuvre();">
                     
                    <select name="selectOeuvreModif" class="selectGestion" id='selectOeuvreModif' onchange="this.form.submit()">
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
                        <span class="erreur" id='erreurSelectModif'></span><br>

                <?php
                    if (isset($_POST['selectOeuvreModif']) && $_POST['selectOeuvreModif'] != "") {
                ?>                                
                    <input type='text' class="inputGestion" name='titreModif' id='titreModif' placeholder="Titre de l'oeuvre" value='<?php echo $titreModif; ?>'/>
                    <br><span class="erreur" id="erreurTitreOeuvreModif"><?php if (isset($this->msgErreurs["errTitre"])) {echo $this->msgErreurs["errTitre"];} ?></span>
                        
                    <input type='text' class="inputGestion" name='adresseModif' id='adresseModif'  placeholder="Adresse " value='<?php echo $adresseModif; ?>'/>
                    <br><span class="erreur" id="erreurAdresseOeuvreModif"><?php if (isset($this->msgErreurs["errAdresse"])) {echo $this->msgErreurs["errAdresse"];} ?></span>

                    <br>
                    <textarea name='descriptionModif' class="inputGestion textAreaGestion" id='descriptionModif' placeholder="Description "><?php echo $descriptionModif; ?></textarea>
                    <br><span class="erreur" id="erreurDescriptionModif"><?php if (isset($this->msgErreurs["errDescription"])) {echo $this->msgErreurs["errDescription"];} ?></span>

                    <select name="selectArrondissementModif"  id="selectArrondissementModif" class="selectGestion">
                        
                        <option value="">Choisir un arrondissement</option>
                        <?php
                            foreach ($this->arrondissementsBDD as $arrondissement) {
                                if ($arrondissement["idArrondissement"] == $idArrondissementModif) {
                                    $selection = "selected";
                                }
                                else {
                                    $selection = "";
                                }
                                echo "<option value='".$arrondissement["idArrondissement"]."'".$selection.">".$arrondissement["nomArrondissement"];
                            }
                        ?>
                    </select>
                    <br><span class="erreur" id="erreurSelectArrondissementModif"><?php if (isset($this->msgErreurs["errArrondissement"])) {echo $this->msgErreurs["errArrondissement"];} ?></span>
                    
                    <select name="selectCategorieModif" id="selectCategorieModif" class="selectGestion">
                        
                        <option value="">Choisir une catégorie</option>
                        <?php
                            foreach ($this->categoriesBDD as $categorie) {
                                if ($categorie["idCategorie"] == $idCategorieModif) {
                                    $selection = "selected";
                                }
                                else {
                                    $selection = "";
                                }
                                echo "<option value='".$categorie["idCategorie"]."'".$selection.">".$categorie["nomCategorie$this->langue"];
                            }
                            echo "</select>";
                        ?>
                    </select> 
                    <br><span class="erreur" id="erreurSelectCategorieModif"><?php if (isset($this->msgErreurs["errCategorie"])) {echo $this->msgErreurs["errCategorie"];} ?></span>
                        
                    <br><input class="boutonMoyenne" type='submit' name='boutonModifOeuvre' value='Modifer'>
                </form>
                
           <?php
                }
            ?> 
                <span class="erreur">
                <?php
                echo $msgModif;
                ?>  
                </span>
            </div>
        </div>
    <?php    
    } 
}
?>