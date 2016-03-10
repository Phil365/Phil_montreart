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
         /**
    * @var array $msgErreurs Tous les messages d'erreurs liés aux requêtes du formulaire d'ajout
    * @access private
    */
    private $msgErreurs;
     /**
    * @var array $oeuvreAModifier Oeuvre qui doit être modifiée par l'administrateur.
    * @access private
    */
    private $informationsAModifier;
    /**
    * @var array $nbrOeuvreVisite nombre d'oeuvre visité
    * @access private
    */
    private $nbrOeuvreVisite;
     /**
    * @var array $nbrOeuvreVisite nombre d'oeuvre visité
    * @access private
    */
    private $profilUtilisateur;
    
    function __construct() {
        $this->titrePage = "MontréArt - Profil";
        $this->descriptionPage = "La page de profil d'un utilisateur du site MontréArt";
    }
     /**
    * @brief Méthode qui assigne des valeurs aux propriétés de la vue
    * @param array $nbrOeuvreVisite
    * @access public
    * @return void
    */
    public function setData($nbrOeuvreVisite,$profilUtilisateur,$informationsAModifier,$msgErreurs) {
        $this->nbrOeuvreVisite = $nbrOeuvreVisite;
        $this->profilUtilisateur = $profilUtilisateur;
        $this->informationsAModifier = $informationsAModifier;
        $this->msgErreurs = $msgErreurs;
    }
    
    /**
    * @brief Méthode qui affiche le corps du document HTML
    * @access public
    * @return void
    */
    public function afficherBody() {
                //MODIF OEUVRE
        //-----------------------------------------------------
        $prenomModif = "";
        $nomModif = "";
        $descriptionModif = "";
        $motdepasseModif = "";
        
        if (!empty($this->informationsAModifier)){//S'il y a une oeuvre à modifier...
            
            $prenomModif = $this->informationsAModifier['prenom'];
            $nomModif = $this->informationsAModifier['nom'];
            $descriptionModif = $this->informationsAModifier['descriptionProfil'];
        }
        
        if (isset($_POST["boutonModifOeuvre"]) && empty($this->msgErreurs)) {
            $msgModif = "<div style='color:green' class='erreur'>Modification complétée !</div>";
            $prenomModif = "";
            $nomModif = "";
            $descriptionModif = "";
        }
        else if (isset($this->msgErreurs["errRequeteModif"])) {
            $msgModif = $this->msgErreurs["errRequeteModif"];
        }
        else {
            $msgModif = "";
        }
         if (!isset($_SESSION["idUsager"]) || $_SESSION["idUsager"] === "1") {
            echo "<p class='msgAccesNonAuthorise'>Vous devez être connecté pour accéder à cette page</p>";
        } else {
    ?>
            <!-- Espace de l'utilisateur -->
        
            
        <div class="section1" id="profileUser">
            <h3>NomUser</h3>
            <p><?php echo $this->profilUtilisateur['nomUsager']; ?></p>
            <h3>Photo de profil</h3>
            <p class="imageProfile">
            <?php
            if ($this->profilUtilisateur['photoProfil'] != null) {//Si des photos existent pour cette oeuvre...
                        $imgPhoto = $this->profilUtilisateur['photoProfil'];
                        echo "<img src = '$imgPhoto'>";
                    
                }
                else {//Image par défaut
                    $imgDefaut = "images/photoProfilDefaut.jpg";
                    echo "<img src = '$imgDefaut'>";
                }?>
               
            </p>
            <h3>Bio</h3>
            <p><?php echo $this->profilUtilisateur['descriptionProfil']; ?></p>
            <p> Oeuvres Visités  <?php echo $this->nbrOeuvreVisite['COUNT(*)']; ?></p>
            <p>nombres de points: <?php echo (5*$this->nbrOeuvreVisite['COUNT(*)']); ?></p>
            <a id ="lienGestion4" class="boutonMoyenne boutonsLiens boutonHover" href="javascript:;">Modifier informations</a>
<!--    
            <a href="contribuerArticle.php" ><h3>Contribuer article</h3></a>
                
            <a href="javascript:;" onclick="montrer_form()"><h3>Gérer mon profil</h3></a>
-->
        </div>
        
               <!-- ----- MODIFICATION Utilisateur ------- -->

       <div id="Onglet-4">
            <h2 class="h2PageGestion">Modifier Informations</h2>
      
           <div id="formModif">

            
            <form method="POST"   enctype="multipart/form-data" name="formModifOeuvre" id='formModifSelectOeuvre' action="?r=profil" onsubmit="return valideModifierUtilisateur();" >
                <input type='text' class="inputGestion" name='prenomModif' id='prenomModif'  value='<?php echo $prenomModif; ?>'/>
                <br><span class="erreur" id="erreurPrenomUtilisateurModif"><?php if (isset($this->msgErreurs["errTitre"])) {echo $this->msgErreurs["errTitre"];} ?></span>

                <input type='text' class="inputGestion" name='nomModif' id='nomModif'  placeholder="Votre nom " value='<?php echo $nomModif; ?>'/>
                <br><span class="erreur" id="erreurNomUtilisateurModif"><?php if (isset($this->msgErreurs["errAdresse"])) {echo $this->msgErreurs["errAdresse"];} ?></span>

                <br>
                <textarea name='descriptionModif' class="inputGestion textAreaGestion" id="descriptionModif" placeholder="Votre description"><?php echo $descriptionModif; ?></textarea>
                <br><span class="erreur" id="erreurDescriptionModif"><?php if (isset($this->msgErreurs["errDescription"])) {echo $this->msgErreurs["errDescription"];} ?></span>
                <br>
                
                 <input type='password' class="inputGestion" name='motdepasseModif' id='motdepasseModif'   placeholder="nouveau mot de passe (optionnel)" value='<?php echo $motdepasseModif; ?>'/>
                <br><span class="erreur" id="erreurMotdepasseModif"><?php if (isset($this->msgErreurs["errMotdepasse"])) {echo $this->msgErreurs["errMotdepasse"];} ?></span>
                <input type="hidden" id='idUtilisateur' value='<?php echo $_SESSION["idUsager"]; ?>'/>
                <input type="file" name="fileToUpload" id="fileToUpload" class="fileToUploadGestion">
                <br> 
                <span id="erreurPhoto" class="erreur"><?php if (isset($this->msgErreurs["errPhoto"])) {echo $this->msgErreurs["errPhoto"];} ?></span><br>
                <br><input class="boutonHover boutonMoyenne" id="btnModCat" type='submit' name='boutonModifOeuvre' value='Modifer'>
            </form>

     
        </div>
            <span class="erreur" id="msgModif">
            <?php
            echo $msgModif;
            ?>  
            </span>
        </div>
        

        <div class="section3" id="visites">
          
        </div>
        
       
        

<!--
        <div id="div_bgform">
            <div id="div_form">

                <form action="#" id="form_profil" method="post" name="form_profil">
                    <button id="fermer" onclick ="fermer()">X</button>
-->

<!--

                    <h3>Actualiser ma photo</h3>
                       

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

                     <input class="boutonMoyenne" type='submit' name='boutonAjoutUtilisateur' value='Envoyer'>
-->
<!--
                </form>
            </div>
        </div>
-->
<?php
        }     
    }
}
?>