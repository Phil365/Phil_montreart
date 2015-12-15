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
            echo "Cette oeuvre n'a pas été trouvée dans la base de données";
        }
        else {
    ?>        
            <article>
                <h1><?php echo  $this->oeuvre["titre"]; ?></h1>
                <p>
                <?php
                    if ($this->photos) {//Si des photos existent pour cette oeuvre...
                        for ($i = 0; $i < count($this->photos); $i++) {
                            $imgPhoto = $this->photos[$i]['image'];
                            echo "<img src = '../images/$imgPhoto'><br>";
                        }
                    }
                    else {//Image par défaut
                        $imgDefaut = "imgDefaut".$this->langue.".png";
                        echo "<img src = '../images/$imgDefaut'><br>";
                    }
                    
                    if ( $this->oeuvre["description"]) {
                        echo  $this->oeuvre["description"];
                    }
                    echo "</p>";

                    echo "<p>";
                    if ( $this->oeuvre["nomArtiste"]) {
                        echo "Artiste : ";
                        if ( $this->oeuvre["prenomArtiste"]) {
                            echo  $this->oeuvre["prenomArtiste"]." ";
                        }
                        echo  $this->oeuvre["nomArtiste"]."<br>";
                    }
                    if ( $this->oeuvre["nomCollection"]) {
                        echo "Collection : ". $this->oeuvre["nomCollection"]."<br>";
                    }
                    if ( $this->oeuvre["nomCategorie"]) {
                        echo "Catégorie : ". $this->oeuvre["nomCategorie"]."<br>";
                    }
                    if ( $this->oeuvre["sousCategorie"]) {
                        echo "Sous-catégorie : ". $this->oeuvre["sousCategorie"]."<br>";
                    }
                ?>
                </p>
                    <h2>Emplacement</h2>
                <p>
                <?php
                    if ( $this->oeuvre["parc"]) {
                        echo "Parc : ". $this->oeuvre["parc"]."<br>";
                    }
                    if ( $this->oeuvre["batiment"]) {
                        echo "Bâtiment : ". $this->oeuvre["batiment"]."<br>";
                    }
                    if ( $this->oeuvre["adresse"]) {
                        echo "Adresse : ". $this->oeuvre["adresse"]."<br>";
                    }
                    if ( $this->oeuvre["nomArrondissement"]) {
                        echo "Arrondissement : ". $this->oeuvre["nomArrondissement"]."<br>";
                    }
                    echo "</p>";
                   
                    echo "<h2>Commentaires</h2>";
                    echo "<p>";
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

                            echo "<img src = '../images/$imgPhoto'><br>";
                            echo $this->commentaires[$i]["nomUsager"]."<br>";
                            echo "<img src = '../images/$imgVote'><br>";
                            echo $this->commentaires[$i]["texteCommentaire"]."<br>";
                        }
                    }
                    else {
                        echo "Aucun commentaire";
                    }
                    echo "</p>";
                ?>
            </article>
        </body>
    <?php
        }
    }
}
    
?>