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
    private $oeuvres;
    /**
    * @var array $photos Photos associées à l'oeuvre
    * @access private
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
    public function setOeuvres($oeuvres) {
        
        $this->oeuvres = $oeuvres;
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
        
        $langue = $this->langue;
        
        if (empty($this->oeuvres)) {
            echo "<p>Aucune oeuvre n'a été trouvée selon vos critères de recherche</p>";
        }
        else {
            if ( isset($this->oeuvres[0]["nomCategorie$langue"])) {
                echo "<h5 class='rechercheResultTitre'>Catégorie choisie : </h5>"."<p class='infoResult'>". $this->oeuvres[0]["nomCategorie$langue"]."</p>";
            }
            foreach ($this->oeuvres as $oeuvre) {
                if ( isset($oeuvre["titre"])) {
                    echo "<h5 class='rechercheResultTitre'>Titre : </h5>"."<a class='infoResult' href='http://localhost/?r=oeuvre&o=".$oeuvre["idOeuvre"]."'>". $oeuvre["titre"]."</a>";
                }
                if (isset($oeuvre["nomArtiste"])) {
                    echo "<h5 class='rechercheResultTitre'>Artiste : </h5>";
                    if ( isset($oeuvre["prenomArtiste"])) {
                        echo  "<p class='infoResult'>".$oeuvre["prenomArtiste"]." ";
                    }
                    echo  $oeuvre["nomArtiste"]."</p>";
                }
                if ( isset($oeuvre["description$langue"])) {
                    echo " <div class='description'>
            <h5 class='rechercheResultTitre'>Description :</h5>
            <p class='noIndent'>".$oeuvre["description$langue"]."</p></div>";
                }
            echo "<br><br>";

            }
        }
    }
}
    
?>