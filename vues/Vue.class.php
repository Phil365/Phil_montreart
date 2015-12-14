<?php
/**
 * Class Vue
 * Template de classe Vue. Dupliquer et modifier pour votre usage.
 * 
 * @author Jonathan Martel
 * @author David Lachambre
 * @version 1.0
 * @update 2015-12-14
 * @license Creative Commons BY-NC 3.0 (Licence Creative Commons Attribution - Pas d’utilisation commerciale 3.0 non transposé)
 * @license http://creativecommons.org/licenses/by-nc/3.0/deed.fr
 * 
 */
header('Content-Type: text/html; charset=utf-8');//Affichage du UTF-8 par PHP.

class Vue {

    /**
	 * Affiche le meta de la page et ouvre les balises html
	 * @access public
	 * 
	 */
    public function afficheMeta($meta) {
    ?>
    <!DOCTYPE html>
    <html lang="fr">
	<head>
		<title><?php echo $meta["titre"] ?></title>
		<meta charset="utf-8">
		<meta name="description" content="<?php echo $meta["description"] ?>">
		<meta name="viewport" content="width=device-width">
		
		<link rel="stylesheet" href="./css/normalize.css" type="text/css" media="screen">
		<link rel="stylesheet" href="./css/base_h5bp.css" type="text/css" media="screen">
		<link rel="stylesheet" href="./css/main.css" type="text/css" media="screen">
		
		<script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
		<script src="./js/plugins.js"></script>
		<script src="./js/main.js"></script>
	</head>
    <?php
    }
    
    /**
	 * Affiche l'entête des pages
	 * @access public
	 * 
	 */
    public function afficheEntete($pageActuelle) {
    ?>

        <body>
            <header>
                <div>HEADER</div>
            </header>

    <?php
    }
    
	/**
	 * Affiche la page d'accueil 
	 * @access public
	 * 
	 */
	public function afficheAccueil() {
    ?>

            <article>
                <h1>MontréArt</h1>
                <p>Site en construction</p>
            </article>

            <div id="footer">
            </div>
        </body>
    </html>

    <?php	
	}
    
    /**
	 * Affiche la page d'une oeuvre
	 * @access public
	 * 
	 */
    public function affichePageOeuvre($oeuvre, $commentaires, $photos, $langue) {
        if (empty($oeuvre)) {
            echo "Cette oeuvre n'a pas été trouvée dans la base de données";
        }
        else {
//            var_dump($oeuvre);
//            var_dump($commentaires);
//            var_dump($photos);
//            var_dump($langue);
    ?>        
            <article>
                <h1><?php echo $oeuvre["titre"]; ?></h1>
                <p>
                <?php
                    if ($photos) {//Si des photos existent pour cette oeuvre...
                        for ($i = 0; $i < count($photos); $i++) {
                            $imgPhoto = $photos[$i]['image'];
                            echo "<img src = '../images/$imgPhoto'><br>";
                        }
                    }
                    else {//Image par défaut
                        $imgDefaut = "imgDefaut".$langue.".png";
                        echo "<img src = '../images/$imgDefaut'><br>";
                    }
                    
                    if ($oeuvre["description"]) {
                        echo $oeuvre["description"];
                    }
                    echo "</p>";

                    echo "<p>";
                    if ($oeuvre["nomArtiste"]) {
                        echo "Artiste : ";
                        if ($oeuvre["prenomArtiste"]) {
                            echo $oeuvre["prenomArtiste"]." ";
                        }
                        echo $oeuvre["nomArtiste"]."<br>";
                    }
                    if ($oeuvre["nomCollection"]) {
                        echo "Collection : ".$oeuvre["nomCollection"]."<br>";
                    }
                    if ($oeuvre["nomCategorie"]) {
                        echo "Catégorie : ".$oeuvre["nomCategorie"]."<br>";
                    }
                ?>
                </p>
                    <h2>Emplacement</h2>
                <p>
                <?php
                    if ($oeuvre["parc"]) {
                        echo "Parc : ".$oeuvre["parc"]."<br>";
                    }
                    if ($oeuvre["batiment"]) {
                        echo "Bâtiment : ".$oeuvre["batiment"]."<br>";
                    }
                    if ($oeuvre["adresse"]) {
                        echo "Adresse : ".$oeuvre["adresse"]."<br>";
                    }
                    echo "</p>";
                   
                    echo "<h2>Commentaires</h2>";
                    echo "<p>";
                    if ($commentaires) {//Si des commentaires existent pour cette oeuvre dans la langue d'affichage...
                        for ($i = 0; $i < count($commentaires); $i++) {
                            switch ($commentaires[$i]['voteCommentaire']) {//Sélection de l'image d'étoile appropriée selon le vote
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
                            $imgPhoto = $commentaires[$i]['photoProfil'];

                            echo "<img src = '../images/$imgPhoto'><br>";
                            echo $commentaires[$i]["nomUsager"]."<br>";
                            echo "<img src = '../images/$imgVote'><br>";
                            echo $commentaires[$i]["texteCommentaire"]."<br>";
                        }
                    }
                    else {
                        echo "Aucun commentaire";
                    }
                    echo "</p>";
                ?>
            </article>

            <div id="footer">
            </div>

    <?php
        }
    }
    
    /**
	 * Affiche le pied de page et ferme les balises html
	 * @access public
	 * 
	 */
    public function affichePiedPage() {
    ?>

            <footer>
                <div>FOOTER</div>
            </footer>
        </body>
    </html>

    <?php
    }
}
?>