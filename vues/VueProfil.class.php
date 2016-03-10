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
    /**
    * @var array $oeuvreVisiter qui dit les oeuvres visiter
    * @access private
    */
    private $oeuvreVisiter;
    
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
    public function setData($nbrOeuvreVisite,$profilUtilisateur,$informationsAModifier,$msgErreurs,$oeuvreVisiter) {
        $this->nbrOeuvreVisite = $nbrOeuvreVisite;
        $this->profilUtilisateur = $profilUtilisateur;
        $this->informationsAModifier = $informationsAModifier;
        $this->msgErreurs = $msgErreurs;
        $this->oeuvreVisiter = $oeuvreVisiter;
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
        
            
        <div class="profileUser" id="">
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
            <h4>Description du profil: </h4>
            <?php echo "<div class='profileUserBio'>".$this->profilUtilisateur['descriptionProfil']."</div>"; ?>
            <h4>Quantité d'oeuvres Visités</h4> 
            <?php echo "<p>".$this->nbrOeuvreVisite['COUNT(*)']."</p>"; ?>
            <h4>Nombres de points:</h4>
            <?php echo "<p>".(5*$this->nbrOeuvreVisite['COUNT(*)'])."</p>"; ?>
             <h4>Nom des oeuvres Visités:</h4>
            <?php 
            for ($i = 0; $i < count($this->oeuvreVisiter); $i++)
                {    
                echo "<p>".$this->oeuvreVisiter[$i]["titre"]."</p>";
                echo "<p><a class='pourEnSavoirPlusProfil' href=http://".$_SERVER['HTTP_HOST']."?r=oeuvre&o=".$this->oeuvreVisiter[$i]["idOeuvre"]."'>Pour en savoir plus...</a>"."</p>";
                }
            ?>
            <a id ="lienGestion4" class="boutonMoyenne boutonsLiens boutonHover" href="javascript:;">Modifier informations</a>
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
        
       
        
<?php
        }     
    }
}
?>