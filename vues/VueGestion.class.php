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

//        $titre='';
//        $titre = $this->oeuvreAModifier['titre'];
        $msgAjout = "succès ajout";
        $msgSupp = "succès suppression";
        $msgModif = "succès modif";
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
                echo '<a id ="click1" href="?r=gestion">Ajouter oeuvre</a>';
                echo '<a id ="click2" href="?r=gestion">Supprimer oeuvre</a>';
                echo '<a id ="click3" href="?r=gestion">Modifier oeuvre</a>';
        
                echo "<h3>Dernière mise à jour des oeuvres de la ville :</h3>";
                echo $date;
            ?>
            
            <!-- ----- METTRE OEUVRES VILLE À JOUR ------- -->
            <form action="?r=gestion" method="post">
                <input class="boutonMoyenne" type="submit" id="misAJour" name='misAJour' class="boutonMoyenne" value='Mettre à Jour' />
            </form>
            
            <!-- ----- AJOUT OEUVRE ------- -->
        
            <div id="Onglet-1">
                <h2>Ajouter une oeuvre</h2>
                          
                
                <form method="POST" name="formAjoutOeuvre" action="?r=gestion&action=ajouterOeuvre" enctype="multipart/form-data">
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
                    <input type="file" name="fileToUpload" id="fileToUpload">
                    <span class="erreur"></span>
                    <input class="boutonMoyenne" type='submit' name='boutonAjoutOeuvre' value='Ajouter'>
                </form>
                
                
                
<!--
                <form name="formPhotoUnique" id="formPhotoUnique" action="?r=gestion&action=envoyerPhoto" onsubmit="return validePhotoSubmit();" method="post" enctype="multipart/form-data">
                    <h4 id="selectImageUpload">Sélectionnez une image :</h4>
                    <input class='boutonMoyenne' type="file" name="fileToUpload" id="fileToUpload">
                    <span id="erreurPhotoVide" class="erreur"></span><br>
                    <span id="erreurPhotoSize" class="erreur"></span><br>
                    <span id="erreurPhotoType" class="erreur"></span><br>
                    <span class="erreur"></span>
                    <input class='boutonMoyenne' type="submit" value="Upload Image" name="submit">
                </form>
-->
                
                
                
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
                <form method="POST" name="formSuppOeuvre" action="?r=gestion">

                    <span class="erreur"></span>
                    <select name="selectOeuvreSupp">
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

            <!-- ----- MODIFICATION OEUVRE ------- -->

            <div id="Onglet-1">
                <h2>Modifier une oeuvre</h2>
                <form method="POST" name="formModifOeuvre" action="?r=gestion">
                    <span class="erreur"></span>
                    <input type='text' name='titreModif' value="" placeholder="Titre de l'oeuvre (si connu)"/>
                    <span class="erreur"></span>
                    <input type='text' name='auteurModif' value="" placeholder="Auteur de l'oeuvre (si connu)"/>
                    <span class="erreur"></span>
                    <input type='text' name='adresseModif' value="" placeholder="Adresse (obligatoire)"/>
                    <span class="erreur"></span>
                    <textarea name='descriptionModif' placeholder="Description (obligatoire)"></textarea>
                    <h3>Téléversez l'image de l'oeuvre</h3>
                    <input type="file" name="fileToUpload" id="fileToUpload">
                    <span class="erreur"></span>
                    <input class="boutonMoyenne" type='submit' name='boutonModifOeuvre' value='Modifer'>
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
?>