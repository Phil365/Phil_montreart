<?php
/**
 * @brief Class VueOeuvre
 * @author David Lachambre
 * @version 1.0
 * @update 2015-12-15
 * 
 */
header('Content-Type: text/html; charset=utf-8');//Affichage du UTF-8 par PHP.

class VueOeuvre extends Vue {
    
    /**
    * @var array $oeuvre Information sur l'oeuvre
    * @access private
    */
    private $oeuvre;
    
    /**
    * @var array $commentaires Commentaires associés à l'oeuvre
    * @access private
    */
    private $commentaires;
    
    /**
    * @var array $photos Photos associées à l'oeuvre
    * @access private
    */
    private $photos;
    
    
    /**
    * @var array $artistes Artistes associés à l'oeuvre
    * @access private
    */
    private $artistes;
    
    /**
    * @var string $langue Langue d'affichage
    * @access protected
    */
    protected $langue;
    
    /**
    * @var string $msgPhoto Message destiné à l'utilisateur lors de la soumission d'une photo unique
    * @access protected
    */
    protected $msgPhoto;
    
    /**
    * @brief Constructeur. Initialise les propriétés communes de la classe mère
    * @access public
    * @return voids
    */
    function __construct() {
        
        $this->titrePage = "MontréArt - Oeuvre";
        $this->descriptionPage = "Cette page affiche une oeuvre spécifique du site MontréArt";
    }
    
    /**
    * @brief Méthode qui assigne des valeurs aux propriétés de la vue
    * @param array $oeuvre
    * @param array $photos
    * @param array $commentaires
    * @param array $artistes
    * @param string $langue
    * @access public
    * @return void
    */
    public function setData($oeuvre, $commentaires, $photos, $artistes, $langue) {
        
        $this->oeuvre = $oeuvre;
        $this->commentaires = $commentaires;
        $this->photos = $photos;
        $this->artistes = $artistes;
        $this->langue = $langue;
    }
    
    /**
    * @brief Méthode qui assigne une valeur à la propriété msgPhoto
    * @param string $msg
    * @access public
    * @return void
    */
    public function setMsgPhoto($msg) {
        
        $this->msgPhoto = $msg;
    }
    
    /**
    * @brief Méthode qui affiche le corps du document HTML
    * @access public
    * @return void
    */
    public function afficherBody() {
    ?> 
        <body>
    <?php
        if (empty($this->oeuvre)) {
            echo "<p>Cette oeuvre n'a pas été trouvée dans la base de données</p>";
        }
        else {
            
    ?>
    <?php echo "<div class='dummy'><!--    Ne mettez rien ici--></div>";
                
                    echo "<div class='sliderOeuvre'>";
                    if ($this->photos) {//Si des photos existent pour cette oeuvre...
                        for ($i = 0; $i < count($this->photos); $i++) {
                            $imgPhoto = $this->photos[$i]['image'];
                            echo "<img src = '$imgPhoto'>";
                        }
                    }
                    else {//Image par défaut
                        $imgDefaut = "images/imgDefaut".$this->langue.".png";
                        echo "<img src = '$imgDefaut'>";
                    }
                    echo "</div>"; //fin div sliderOeuvre
                    $idOeuvreencours=$this->oeuvre["idOeuvre"]
            ?>


                    <form name="formPhotoUnique" id="formPhotoUnique" action="?r=oeuvre&o=<?php echo($idOeuvreencours);?>&action=envoyerPhoto" onsubmit="return validePhotoSubmit();" method="post" enctype="multipart/form-data">
                        <h4 id="selectImageUpload">Sélectionnez une image :</h4>
                        <input class='boutonMoyenne' type="file" name="fileToUpload" id="fileToUpload">
                        <span id="erreurPhotoVide" class="erreur"></span><br>
                        <span id="erreurPhotoSize" class="erreur"></span><br>
                        <span id="erreurPhotoType" class="erreur"></span><br>
                        <span class="erreur"> <?php if (isset($this->msgPhoto)) {echo $this->msgPhoto;} ?></span>
                        <input class='boutonMoyenne' type="submit" value="Upload Image" name="submit">

                    </form>
            <?php
                    echo "<div class='infosOeuvre'>
                    <h4>Titre: </h4>";
                echo  "<p>".$this->oeuvre['titre']."</p>"; 
                    echo "<h4>Classement:</h4>
                <div class='rating'>
                    
                </div>";
                
                    echo "<h4>Artiste(s) : </h4><p>";
                    foreach ($this->artistes as $artiste) {
                        if (isset($artiste["nomArtiste"])) {
                            
                            if (isset($artiste["prenomArtiste"])) {
                                echo  $artiste["prenomArtiste"]." ";
                            }
                            echo  $artiste["nomArtiste"];
                        }
                        else if (isset($artiste["nomCollectif"])) {
                            echo $artiste["nomCollectif"];
                        }
                        else {
                            echo "artiste inconnu";
                        }
                        echo "</p>";
                    }
        
                    if (isset($this->oeuvre["nomCollection" . $this->langue])) {
                        echo "<h4>Collection : </h4>"."<p>". $this->oeuvre["nomCollection" . $this->langue]."</p>";
                    }
                    if (isset($this->oeuvre["nomCategorie" . $this->langue])) {
                        echo "<h4>Catégorie : </h4>"."<p>". $this->oeuvre["nomCategorie" . $this->langue]."</p>";
                    }
                    if (isset($this->oeuvre["sousCategorie" . $this->langue])) {
                        echo "<h4>Sous-catégorie : </h4>"."<p>". $this->oeuvre["sousCategorie" . $this->langue]."</p>";
                    }
                ?>
                
                <?php
                    if ( $this->oeuvre["parc"]) {
                        echo "<h4>Parc : </h4>"."<p>". $this->oeuvre["parc"]."</p>";
                    }
                    if ( $this->oeuvre["batiment"]) {
                        echo "<h4>Bâtiment : </h4>"."<p>". $this->oeuvre["batiment"]."</p>";
                    }
                    if ( $this->oeuvre["adresse"]) {
                        echo "<h4>Adresse : </h4>"."<p>". $this->oeuvre["adresse"]."</p>";
                    }
                    if ( $this->oeuvre["nomArrondissement"]) {
                        echo "<h4>Arrondissement : </h4>"."<p>". $this->oeuvre["nomArrondissement"]."</p>";
                    }
                    echo "<button class='boutonMoyenne' id='boutonDirection' href='?r=trajet'>Directions</button></div>";//fin div infosOeuvre
                    
                    if (isset($this->oeuvre["description" . $this->langue])) {
                        echo "<div class='description'>
                <h3>Description :</h3>
                <p class='noIndent'>".$this->oeuvre["description" . $this->langue]."</p></div>";
                    }//fin div description
                    
                   
                    echo " <div class='sectionCommentaires'><h3>Commentaires</h3><button class='boutonMoyenne' id='boutonCommentaire' onclick=''>Laisser Commentaire</button>";
                  
                    if ($this->commentaires) {//Si des commentaires existent pour cette oeuvre dans la langue d'affichage...
                        for ($i = 0; $i < count($this->commentaires); $i++) {
                            echo "<div class='unCommentaire'>";
                            switch ($this->commentaires[$i]['voteCommentaire']) {//Sélection de l'image d'étoile appropriée selon le vote
                                case 1:
                                    $imgVote = "etoiles_1.png";
                                    break;
                                case 2:
                                    $imgVote = "etoiles_2.png";
                                    break;
                                case 3:
                                    $imgVote = "etoiles_3.png";
                                    break;
                                case 4:
                                    $imgVote = "etoiles_4.png";
                                    break;
                                case 5:
                                    $imgVote = "etoiles_5.png";
                                    break;
                                default:
                                    $imgVote = "etoiles_0.png";
                                    break;
                            }
                            $imgPhoto = $this->commentaires[$i]['photoProfil'];


                            echo "<img class='thumbnail' src = '$imgPhoto'><br>";
                            echo "<h5 id='idUtilisateur'>".$this->commentaires[$i]["nomUsager"]."</h5>";

                            echo "<div class='ratingUtilisateur'><img src = 'images/$imgVote'></div>";
                            echo "<p>".$this->commentaires[$i]["texteCommentaire"]."</p>"."</div>";
                            //fin div unCommentaire
                        }
                    }
                    else {
                        echo "<p>Aucun commentaire</p>";
                    }//fin div commentaires 
            echo "</div> 
     
                <div id='sponsorsPageOeuvre'>
                    Sponsors
                </div>";
                    echo "</body>";
           
                ?>
            
    <?php
        }
    }
}
    
?>