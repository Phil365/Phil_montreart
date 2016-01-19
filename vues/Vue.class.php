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
                    <form action="#" name="formRecherche" method="get">
                    
                        <select name="typeRecherche">
                            <option value="default">Veuillez choisir un type...</option>
                            <option value="artiste">Artiste</option>
                            <option value="nomOeuvre">Nom d'oeuvre</option>
                            <option value="arrondissement">Arrondissement</option>
                            <option value="categorie">Catégorie</option>
                        </select>
                        <input type="submit" id="submitRecherche" name="submit" value="Soumettre" />
                    </form>
                    
                        <?php
                            if(isset($_GET['submit'])) {
                            $choixType = $_GET['typeRecherche'];  
                            echo "<br><br> résultat : " .$choixType; 
                                
                                
                            $cookie = new Cookie();
        
                            $langue = $cookie->getLangue();    
                                
                            //}
        
        
                            //function choisirTypeRecherche() {
                                
                                if ($choixType == "artiste") {
                                
                                $artiste = "artiste";
                                echo '<input class="text" type="text" placeholder="Entrez le nom de l\'artiste" id="keyword" name="inputArtiste" onkeyup="autoComplete(\''.$artiste.'\')">';
                                echo '<div id="results"></div>';
                                }
                                
                                
                                if ($choixType == "nomOeuvre") {
                                
                                $titre = "titre";
                                echo '<input class="text" type="text" placeholder="Entrez le titre de l\'oeuvre" id="keyword" name="inputOeuvre" onkeyup="autoComplete(\''.$titre.'\')">';
                                echo '<div id="results"></div>';
                                }
        
                            
                                else if ($choixType == "arrondissement") {
                                
                                echo '<br><select name="selectArrondissement">
                                    <option>Rosemont - La Petite-Patrie</option>
                                    <option>Côte-des-Neiges/Notre-Dame-de-Grâce</option>
                                    <option>Ville-Marie</option>
                                    </select>';
                                }
        
                            
                                else if ($choixType == "categorie") {
                                
                                echo '<br><select name="selectCatégorie">';
                                    foreach ($categories as $categorie) {
                                        
                                        echo '<option value="'.$categorie["idCategorie"].'>'.$categorie["idCategorie"].$langue.'</option>';
                                    }
                                }
                                
                            }
        
                        ?>
                    
                
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