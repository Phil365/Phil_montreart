<?php
/**
 * @brief Class VueTrajet
 * @author Cristina Mahneke
 * @version 1.0
 * @update 2015-01-14
 * 
 */
header('Content-Type: text/html; charset=utf-8');//Affichage du UTF-8 par PHP.

class VueGestion extends Vue {
    
    private $dateDernierUpdate;
    
    private $oeuvreAModifier;
    
    private $oeuvresBDD;
    
    private $arrondissementsBDD;
    
    private $categoriesBDD;
    
    function __construct() {
        
    }
    
    public function setData($dateDernierUpdate, $oeuvreAModifier, $oeuvresBDD, $arrondissementsBDD, $categoriesBDD) {
        $this->dateDernierUpdate = $dateDernierUpdate;
        $this->oeuvreAModifier = $oeuvreAModifier;
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
// var_dump($this->oeuvreAModifier);
        $titreModif='';
        $adresse='';
        $idSousCategorie='';
        $idArrondissement='';
        $descriptionFR='';
        
        if (isset($this->oeuvreAModifier['titre']) && isset($this->oeuvreAModifier['adresse']) && isset($this->oeuvreAModifier['idSousCategorie']) && isset($this->oeuvreAModifier['idArrondissement']) && isset($this->oeuvreAModifier['descriptionFR'])){
        $titreModif = $this->oeuvreAModifier['titre'];
        $adresse = $this->oeuvreAModifier['adresse'];
        $idSousCategorie = $this->oeuvreAModifier['idSousCategorie'];
        $idArrondissement = $this->oeuvreAModifier['idArrondissement'];
        $descriptionFR = $this->oeuvreAModifier['descriptionFR'];
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
        
        /*----- MÉMORISATION DES SECTIONS OUVERTES -----*/

//        session_start();
//        if (!isset($_SESSION['sectionGestion'])) {//Pour empêcher le jQuery de fermer les sections après chaque soumission de formulaire.
//            $_SESSION['sectionGestion'] = 0;
//        }
    ?>
        <h2>Administration</h2>

        <div>
            <?php
            //Ajout des autres liens si l'usager est de type administrateur.
                //echo '<a id ="click1" href="?r=gestion">Ajouter oeuvre</a>';
                //echo '<a id ="click2" href="?r=gestion">Supprimer oeuvre</a>';
                //echo '<a id ="click3" href="?r=gestion">Modifier oeuvre</a>';
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
                   <br> <span  id="erreurTitreOeuvre" class="erreur"></span><br>                  
                    <input type='text' class="inputGestion" name='titreAjout' id='titreAjout' placeholder="Titre de l'oeuvre"/>
                   <br> <span class="erreur" id="erreurPrenomArtisteAjout"></span><br>
                    <input type='text' class="inputGestion" name='prenomArtisteAjout' id='prenomArtisteAjout' value="" placeholder="Prénom de l'artiste"/>
                  <br>  <span class="erreur" id="erreurNomArtisteAjout"></span><br>
                    <input type='text' class="inputGestion" name='nomArtisteAjout' id='nomArtisteAjout' value="" placeholder="Nom de l'artiste "/>
                  <br>  <span class="erreur" id="erreurAdresseOeuvre"></span><br>
                    <input type='text' class="inputGestion" name='adresseAjout' id='adresseAjout' value="" placeholder="Adresse "/>
                  <br>  <span class="erreur" id="erreurDescription"></span><br>
                    <textarea name='descriptionAjout' class="inputGestion" id='descriptionAjout' placeholder="Description "></textarea>
                  <br>  <span class="erreur" id="erreurSelectArrondissement"></span><br>
                    <select name="selectArrondissement"  id="selectArrondissement" class="selectGestion">
                        <option value="">Choisir un arrondissement</option>
                        <?php
                            foreach ($this->arrondissementsBDD as $arrondissement) {
                                echo "<option value='".$arrondissement["idArrondissement"]."'>".$arrondissement["nomArrondissement"];
                            }
                            echo "</select>";
                        ?>
                    </select><br>
                 <br>   <span class="erreur" id="erreurSelectSousCategorie"></span><br>
                    <select name="selectSousCategorie"  id="selectSousCategorie" class="selectGestion">
                        <option value="">Choisir une catégorie</option>
                        <?php
                            foreach ($this->categoriesBDD as $categorie) {
                                echo "<option value='".$categorie["idSousCategorie"]."'>".$categorie["sousCategorie$this->langue"];
                            }
                            echo "</select>";
                        ?>
                    </select>                    
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

                    <span class="erreur" id='erreurSelectSupression'></span>
                    <select name="selectOeuvreSupp" id='selectOeuvreSupp' class="selectGestion">
                        <?php
                        echo "<option value=''>choisir une oeuvre</option>";
                        foreach ($this->oeuvresBDD as $oeuvre) {
                            echo "<option value='".$oeuvre["idOeuvre"]."'>".$oeuvre["titre"]."</option>";
                        }
                        echo "</select>";
                        ?>
                    </select>

                    <input class="boutonMoyenne" type='submit' name='boutonSuppOeuvre' value='Supprimer'>
                </form>
                <span class="msgUser">
                <?php
                echo $msgSupp;
                ?>  
                </span>
            </div> 
        </div>
     <?php
    } 
}
?>