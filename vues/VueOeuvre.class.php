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
    * @var string $langue Langue d'affichage
    * @access private
    */
    private $langue;
    
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
    * @param array $idArtiste
    * @param array $photos
    * @param array $commentaires
    * @param string $langue
    * @access public
    * @return void
    */
    public function setData($oeuvre, $commentaires, $photos, $langue) {
        
        $this->oeuvre = $oeuvre;
        $this->commentaires = $commentaires;
        $this->photos = $photos;
        $this->langue = $langue;
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
    <?php echo "<div class='dummy'><!--    Ne mettez rien ici--></div>
    <div class='aside1'  id='DevenirMembre'>
            Devenir membre a ses avantages!
        </div>
        
 
        <div class='aside2' id='sponsors'>
            Sponsors
        </div>
    <main id='pageOeuvres'>
        
            <div class='infosOeuvre'>
                <h5>Titre: </h5>";
                echo  "<p>".$this->oeuvre['titre']."</p>"; ?>
                    <?php echo "<h5>Classement:</h5>
                <div class='rating'>
                    
                </div>";
                
                 if ( $this->oeuvre["nomArtiste"]) {
                        echo "<h5>Artiste : </h5>";
                        if ( $this->oeuvre["prenomArtiste"]) {
                            echo  "<p>".$this->oeuvre["prenomArtiste"]." ";
                        }
                        echo  $this->oeuvre["nomArtiste"]."</p>";
                    }
                    if ( $this->oeuvre["nomCollection"]) {
                        echo "<h5>Collection : </h5>"."<p>". $this->oeuvre["nomCollection"]."</p>";
                    }
                    if ( $this->oeuvre["nomCategorie"]) {
                        echo "<h5>Catégorie : </h5>"."<p>". $this->oeuvre["nomCategorie"]."</p>";
                    }
                    if ( $this->oeuvre["sousCategorie"]) {
                        echo "<h5>Sous-catégorie : </h5>"."<p>". $this->oeuvre["sousCategorie"]."</p>";
                    }
                ?>
                
                <?php
                    if ( $this->oeuvre["parc"]) {
                        echo "<h5>Parc : </h5>"."<p>". $this->oeuvre["parc"]."</p>";
                    }
                    if ( $this->oeuvre["batiment"]) {
                        echo "<h5>Bâtiment : </h5>"."<p>". $this->oeuvre["batiment"]."</p>";
                    }
                    if ( $this->oeuvre["adresse"]) {
                        echo "<h5>Adresse : </h5>"."<p>". $this->oeuvre["adresse"]."</p>";
                    }
                    if ( $this->oeuvre["nomArrondissement"]) {
                        echo "<h5>Arrondissement : </h5>"."<p>". $this->oeuvre["nomArrondissement"]."</p>";
                    }
                    echo "<a class='boutonMoyenne' href='?r=trajet'>Directions</a></div>";//fin div infosOeuvre
                    ?>
                <?php
                    echo "<div class='sliderOeuvre'>";
                    if ($this->photos) {//Si des photos existent pour cette oeuvre...
                        for ($i = 0; $i < count($this->photos); $i++) {
                            $imgPhoto = $this->photos[$i]['image'];
                            echo "<img src = 'images/$imgPhoto'>";
                        }
                    }
                    else {//Image par défaut
                        $imgDefaut = "imgDefaut".$this->langue.".png";
                        echo "<img src = 'images/$imgDefaut'>";
                    }
                    echo "<button class='boutonMoyenne' onclick=''>Contribuer une image</button></div>";//fin div sliderOeuvre
                    
                    if ( $this->oeuvre["description"]) {
                        echo " <div class='description'>
                <h5>Description :</h5>
                <p class='noIndent'>".$this->oeuvre["description"]."</p></div>";
                    }
                    
                   
                    echo " <div class='sectionCommentaires'><h3>Commentaires</h3><button class='boutonMoyenne' onclick=''>Laisser Commentaire</button>";
                  
                    if ($this->commentaires) {//Si des commentaires existent pour cette oeuvre dans la langue d'affichage...
                        for ($i = 0; $i < count($this->commentaires); $i++) {
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

                            echo "<img class='thumbnail' src = 'images/$imgPhoto'><br>";
                            echo "<h5 id='idUtilisateur'>".$this->commentaires[$i]["nomUsager"]."</h5>";
                            echo "<div class='ratingUtilisateur'><img src = 'images/$imgVote'></div>";
                            echo "<p>".$this->commentaires[$i]["texteCommentaire"]."</p>";
                        }
                    }
                    else {
                        echo "Aucun commentaire";
                    }
                    echo "</div></main></body>";//fin divs sectionCommentaires affichageComm
                ?>
            
    <?php
        }
    }
}
    
?>