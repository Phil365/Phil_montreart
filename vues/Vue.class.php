<?php
/**
 * Class Vue
 * @author David Lachambre
 * @version 1.0
 * @update 2015-12-15
 * 
 */
header('Content-Type: text/html; charset=utf-8');//Affichage du UTF-8 par PHP.

abstract class Vue {

    protected $titrePage = "";
    protected $descriptionPage = "";
    
    /**
    * @brief Méthode qui écrit les information de meta du document HTML, incluant le doctype et la balise d'ouverture du HTML
    * @access public
    * @return void
    */
    public function afficherMeta() {
    ?>
    <!DOCTYPE html>
    <html lang="fr">
	<head>
		<title><?php echo $this->titrePage ?></title>
		<meta charset="utf-8">
		<meta name="description" content="<?php echo $this->descriptionPage ?>">
		<meta name="viewport" content="width=device-width">
		
        <link rel="stylesheet" type="text/css" href="./css/styles.css">
        <link href="https://fonts.googleapis.com/css?family=EB+Garamond%7CNoto+Serif" rel="stylesheet" type="text/css">
		
		<script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
		<script src="./js/plugins.js"></script>
		<script src="./js/main.js"></script>
        <script src="gestionDivsForms.js"></script>

        
	</head>
    <?php
    }

    /**
    * @brief Méthode qui affiche l'entête (header) du document HTML
    * @access public
    * @return void
    */
    public function afficherEntete() {
    ?>
    <body>
        <header>
            <img id="logo" src="../images/logo.png" alt="logo">
            <h1 id="titre">MONTR&Eacute;ART</h1>
            <div id="barreRecherche">barre de recherche
            </div>

            <nav>
                <a href="" class="ici">Accueil</a>
                <a href="carte.php">Trajet</a>
                <a href="contribuerArticle.php">Soumettre Oeuvre</a>
                <a href="#" onclick="montrer_form()">Se connecter</a>
            </nav>
        </header>
    <?php
    }
    
    /**
    * @brief Méthode abstraite qui affiche le corps du document HTML - doit être défini par chaque nouvelle vue
    * @access public
    * @return void
    */
    abstract public function afficherBody();
    
    /**
    * @brief Méthode qui affiche le pied de page (footer) du document HTML et ferme la balise HTML
    * @access public
    * @return void
    */
    public function afficherPiedPage() {
    ?>
        <footer>
            <div class="lienPageMembre">
                <a href='#'><h3>Devenez membre</h3></a>
            </div>
            <div class="reseauxsociaux">
                <img id="logofb" src="../images/fblogo2.png" alt="logofb">
                <img id="logoInsta" src="../images/instalogo2.png" alt="logoInsta">
                <img id="logoPin" src="../images/pinlogo2.png" alt="logoPin">
            </div>
        </footer>
    </body>

    <?php
    }
}
?>