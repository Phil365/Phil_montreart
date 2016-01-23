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
    private $typeRecherche;
    private $pageActuelle;
    
    public function setSelectRecherche($typeRecherche) {
        $this->typeRecherche = $typeRecherche;
    }
    
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
		
        <link rel="stylesheet" type="text/css" href="./css/styles.css">
        <link href="https://fonts.googleapis.com/css?family=EB+Garamond%7CNoto+Serif" rel="stylesheet" type="text/css">
		        <link rel="stylesheet" type="text/css" href="js/vendor/slick-1.5.9/slick/slick.css"/>
  <link rel="stylesheet" type="text/css" href="js/vendor/slick-1.5.9/slick/slick-theme.css"/>
		
		<script src="./js/plugins.js"></script>
		<script src="./js/main.js"></script>
        <script src="js/gestionDivsForms.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
            
        <script>$(document).ready(function(){
                    $("#flip").click(function(){
                        $("#barreRechercheContenu").slideToggle("slow");
                        });
                    });
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
        <header>
            <img id="logo" src="images/logo.png" alt="logo">
            <h1 id="titre">MONTR&Eacute;ART</h1>
            <div id="barreRecherche"><div id="flip">Rechercher une oeuvre<br><br></div>

                <div id="barreRechercheContenu">Chercher par : <br><br>

                    <form action="?r=recherche&pageActuelle=<?php if ($this->pageActuelle == "oeuvre") {echo $this->pageActuelle."&o=".$_GET["o"];} else {echo $this->pageActuelle;} ?>" method="post">
                    
                        <select name="typeRecherche"</selec>>
                            <option value="" <?php if (isset($POST_["typeRecherche"]) && $POST_["typeRecherche"] == "") {echo 'selected="selected"';} ?>>Veuillez choisir un type...</option>
                            <option value="artiste" <?php if (isset($POST_["typeRecherche"]) && $POST_["typeRecherche"] == "artiste") {echo 'selected="selected"';} ?>>Artiste</option>
                            <option value="titre" <?php if (isset($POST_["typeRecherche"]) && $POST_["typeRecherche"] == "titre") {echo 'selected="selected"';} ?>>Titre d'oeuvre</option>
                            <option value="arrondissement" <?php if (isset($POST_["typeRecherche"]) && $POST_["typeRecherche"] == "arrondissement") {echo 'selected="selected"';} ?>>Arrondissement</option>
                            <option value="categorie" <?php if (isset($POST_["typeRecherche"]) && $POST_["typeRecherche"] == "categorie") {echo 'selected="selected"';} ?>>Catégorie</option>
                        </select>
                        <input type="submit" id="submitRecherche" name="submit" value="Soumettre" />
                    
        <?php
        
        if(isset($_POST['submit']) && $_POST['submit'] != "") {   
            $choixType = $_POST['typeRecherche'];

            $langue = $this->langue;
//            var_dump($this->typeRecherche);
            if ($choixType == "artiste") {

            $artiste = "artiste";
            echo '<input class="text" type="text" placeholder="Entrez le nom de l\'artiste" id="keyword" name="inputArtiste" onkeyup="autoComplete(\''.$artiste.'\')">';
            echo '<div id="results"></div>';
            }

            if ($choixType == "titre") {

            $titre = "titre";
            echo '<input class="text" type="text" placeholder="Entrez le titre de l\'oeuvre" id="keyword" name="inputOeuvre" onkeyup="autoComplete(\''.$titre.'\')">';
            echo '<div id="results"></div>';
            }

            else if ($choixType == "arrondissement") {

                echo '<select name="selectArrondissement">';
                echo '<option value = "">Choisir un arrondissement</option>';
                foreach ($this->typeRecherche as $arrondissement) {
                    echo '<option value="'.$arrondissement["idArrondissement"].'">'.$arrondissement["nomArrondissement"].'</option>';
                }
                echo '</select>';
            }

            else if ($choixType == "categorie") {

                echo '<select name="selectCategorie">';
                echo '<option value = "">Choisir une catégorie</option>';
                foreach ($this->typeRecherche as $categorie) {
                    echo '<option value="'.$categorie["idCategorie"].'">'.$categorie["nomCategorie$langue"].'</option>';
                }
                echo '</select>';
            }
        }
    ?>
                    </form>
                </div>
            </div>
            <nav>
                <a href="?r=accueil">Accueil</a>
                <a href="?r=trajet">Trajet</a>
                <a href="?r=soumission">Soumettre Oeuvre</a>
                <a href="?r=#" onclick="montrer_form()">Se connecter</a>
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
    <?php
    }
    
      /**
    * @brief Méthode qui affiche l'entête (header) du document HTML de la page admin
    * @access public
    * @return void
    */
    public function afficherEnteteAdmin() {
    ?>
    <body>
        <header>
            <img id="logo" src="images/logo.png" alt="logo">
            <h1 id="titre">MONTR&Eacute;ART</h1>
            <div id="barreRecherche">barre de recherche
            </div>

            <nav>
                <a href="?r=accueil">Accueil</a>
                <a href="?r=trajet">Trajet</a>
                <a href="?r=soumission">Soumettre Oeuvre</a>
                <a href="?r=#" onclick="#">Deconnexion</a>
                <h4>Bienvenue nomUtilisateurAdmin</h4>
            </nav>
        </header>
        
        
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