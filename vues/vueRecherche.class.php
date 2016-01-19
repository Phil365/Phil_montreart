<?php
/**
 * @brief Class VueRecherche
 * @author Josianne Thessereault
 * @version 1.0
 * @update 2015-12-16
 * 
 */

header('Content-Type: text/html; charset=utf-8');//Affichage du UTF-8 par PHP.

class VueRecherche extends Vue {
    
    /**
    * @var array $oeuvre Information sur l'oeuvre
    * @access private
    */
    private $oeuvre;
    /**
    * @var array $photos Photos associées à l'oeuvre
    * @access private
    */
    private $photos;
    /**
    * @brief Constructeur. Initialise les propriétés communes de la classe mère
    * @access public
    * @return voids
    */
    function __construct() {
        
        $this->titrePage = "MontréArt - Recherche";
        $this->descriptionPage = "Cette page affiche une recherche spécifique du site MontréArt";
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
    public function setData($oeuvre, $photos) {
        
        $this->oeuvre = $oeuvre;
        $this->photos = $photos;
    }
    
    /**
    * @brief Méthode qui affiche le corps du document HTML
    * @access public
    * @return void
    */
    public function afficherBody() {
    ?> 
        <body>
    <script type="text/javascript" src="js/main.js"></script>
    <?php
        if (empty($this->oeuvre)) {
            echo "<p>Aucune oeuvre n'a été trouvée selon vos critères de recherche</p>";
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
    <main id='pageOeuvres'>";
                

                    if ($this->photos) {//Image par défaut
                        $imgDefaut = "imgDefaut".$this->langue.".png";
                        echo "<img src = '$imgDefaut'>";
                    }
                
                    $idOeuvreencours=$this->oeuvre["id"]
            ?>

            <?php
                    echo "<div class='infosOeuvre'>
                    <h5>Titre: </h5>";
                echo  "<p>".$this->oeuvre['titre']."</p>"; 

                
                 if ( $this->oeuvre["nomArtiste"]) {
                        echo "<h5>Artiste : </h5>";
                        if ( $this->oeuvre["prenomArtiste"]) {
                            echo  "<p>".$this->oeuvre["prenomArtiste"]." ";
                        }
                        echo  $this->oeuvre["nomArtiste"]."</p>";
                        }

                ?>
                
                <?php
            
                    echo "</div></main></body>"; //fin divs sectionCommentaires affichageComm
                ?>
            
            <?php
        }
    }
}
    
?>