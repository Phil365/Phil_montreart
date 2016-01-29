<?php
/**
 * Class Vue
 * @author David Lachambre
 * @version 1.0
 * @update 2015-12-15
 * 
 */
header('Content-Type: text/html; charset=utf-8');//Affichage du UTF-8 par PHP.

class Vue {

    protected $titrePage = "";
    protected $descriptionPage = "";
    protected $langue;
    private $pageActuelle;
    
    /**
    * @brief Méthode qui donne des valeurs aux propriétés globales à toutes les vues.
    * @access public
    * @return void
    */
    public function setDataGlobal($titrePage, $descriptionPage, $langue, $pageActuelle) {
        $this->titrePage = $titrePage;
        $this->descriptionPage = $descriptionPage;
        $this->langue = $langue;
        $this->pageActuelle = $pageActuelle;
    }
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
		
        <!-- POLICES -->
<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:600,400' rel='stylesheet' type='text/css'>
        
        <!-- CSS -->
        <link rel="stylesheet" type="text/css" href="./css/styles.css">
        <link rel="stylesheet" type="text/css" href="js/vendor/slick-1.5.9/slick/slick.css"/>
        <link rel="stylesheet" type="text/css" href="js/vendor/slick-1.5.9/slick/slick-theme.css"/>
		
        <!-- LIBRAIRIES EXTERNES -->
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script type="text/javascript" src="js/vendor/slick-1.5.9/slick/slick.min.js"></script>
        
        <!-- JAVASCRIPT -->
        <script src="js/gestionDivsForms.js"></script>
        <script src="./js/plugins.js"></script>
		<script src="./js/main.js"></script>
            
        <script>
            
        </script>

        
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
        <header id="header">
            <img id="logo" src="images/logo.png" alt="logo">
            <div class="barreRecherche">
                <div class="barreRechercheContenu">
                    <form action="?r=recherche" method="post">
                        <select name="typeRecherche" class="typeRecherche">
                            <option value="">Chercher une oeuvre par...</option>
                            <option value="artiste">Artiste</option>
                            <option value="titre">Titre d'oeuvre</option>
                            <option value="arrondissement">Arrondissement</option>
                            <option value="categorie">Catégorie</option>
                        </select>                    
                        <div class="deuxiemeSelectRecherche"></div>
                        <div class="submitRecherche"></div>
                    </form>
                </div>
            </div>
            <div class="boutonRecherche">
                <div class="flecheRecherche"></div>
                <img class="iconeRecherche" src="./images/flecheRecherche.png">
            </div>
            
            <nav>
                <a href="?r=accueil" id="NavAccueil">Accueil</a>
                <a href="?r=trajet">Trajet</a>
                <a href="?r=soumission">Soumettre une oeuvre</a>
                <?php if ($_GET["r"] == "admin") {
                    echo '<a href="?r=#" onclick="#">Deconnexion</a><h4>Bienvenue nomUtilisateurAdmin</h4>';
                }
                else {
                    echo '<a href="?r=#" onclick="montrer_form()">Se connecter</a>';
                }
                ?>
            </nav>
        </header>

        <div id="div_bgform">
            <div id="div_form">
                <!-- Formulaire login -->
                <form action="#" id="formlogin" method="post" name="formlogin">
                    <button id="fermer" onclick ="fermer()">X</button>
                <h2>Connectez vous</h2>

                    <input id="nomutilisateur" name="nomutilisateur" placeholder="Votre identifiant" type="text">
                    <input id="motpasse" name="motpasse" placeholder="Mot de passe" type="password">

                    <button onclick="validerform()" class="submit" id="submit">Envoyer</button>
                </form>
            </div>
        </div>
        <div class="dummy"><!--Ne mettez rien ici--></div>
    <?php
    }
    
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
                <img id="logofb" src="images/fblogo2.png" alt="logofb">
                <img id="logoInsta" src="images/instalogo2.png" alt="logoInsta">
                <img id="logoPin" src="images/pinlogo2.png" alt="logoPin">
            </div>
        </footer>
    </body>

    <?php
    }
}
?>