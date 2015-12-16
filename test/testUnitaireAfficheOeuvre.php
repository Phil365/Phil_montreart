<?php
require_once "../modeles/Oeuvre.class.php";
require_once "../modeles/Commentaire.class.php";
require_once "../modeles/Photo.class.php";
require_once "../config/parametresBDD.php";
require_once "../lib/BDD/BaseDeDonnees.class.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">

	<head>

		<title>Test unitaire</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link href="../css/global.css" rel="stylesheet" type="text/css" />
	</head>

	<body>
		<div id="header">
			<h1>Test - Affichage d'une oeuvre</h1>
		</div>
		<div id="contenu">
			<?php
                //-------------------------------------------------------------
                //TEST UNITAIRE FONCTIONALITÉ AFFICHAGE D'UNE OEUVRE
            
                $idOeuvre = 3;
                $langue = "FR";
                $oeuvre = new Oeuvre();
                $oeuvreAffichee = $oeuvre->getOeuvreById($idOeuvre, $langue);

                $commentaire = new Commentaire();
                $commentairesOeuvre = $commentaire->getCommentairesByOeuvre($idOeuvre, $langue);

                $photo = new Photo();
                $photosOeuvre = $photo->getPhotosByOeuvre($idOeuvre);
            
        if (empty($oeuvreAffichee)) {
            echo "Cette oeuvre n'a pas été trouvée dans la base de données";
        }
        else {
    ?>        
            <article>
                <h1><?php echo  $oeuvreAffichee["titre"]; ?></h1>
                <p>
                <?php
                    if ($photosOeuvre) {//Si des photos existent pour cette oeuvre...
                        for ($i = 0; $i < count($photosOeuvre); $i++) {
                            $imgPhoto = $photosOeuvre[$i]['image'];
                            echo "<img src = '../images/$imgPhoto'><br>";
                        }
                    }
                    else {//Image par défaut
                        $imgDefaut = "imgDefaut".$langue.".png";
                        echo "<img src = '../images/$imgDefaut'><br>";
                    }
                    
                    if ( $oeuvreAffichee["description"]) {
                        echo  $oeuvreAffichee["description"];
                    }
                    echo "</p>";

                    echo "<p>";
                    if ( $oeuvreAffichee["nomArtiste"]) {
                        echo "Artiste : ";
                        if ( $oeuvreAffichee["prenomArtiste"]) {
                            echo  $oeuvreAffichee["prenomArtiste"]." ";
                        }
                        echo  $oeuvreAffichee["nomArtiste"]."<br>";
                    }
                    if ( $oeuvreAffichee["nomCollection"]) {
                        echo "Collection : ". $oeuvreAffichee["nomCollection"]."<br>";
                    }
                    if ( $oeuvreAffichee["nomCategorie"]) {
                        echo "Catégorie : ". $oeuvreAffichee["nomCategorie"]."<br>";
                    }
                    if ( $oeuvreAffichee["sousCategorie"]) {
                        echo "Sous-catégorie : ". $oeuvreAffichee["sousCategorie"]."<br>";
                    }
                ?>
                </p>
                    <h2>Emplacement</h2>
                <p>
                <?php
                    if ( $oeuvreAffichee["parc"]) {
                        echo "Parc : ". $oeuvreAffichee["parc"]."<br>";
                    }
                    if ( $oeuvreAffichee["batiment"]) {
                        echo "Bâtiment : ". $oeuvreAffichee["batiment"]."<br>";
                    }
                    if ( $oeuvreAffichee["adresse"]) {
                        echo "Adresse : ". $oeuvreAffichee["adresse"]."<br>";
                    }
                    if ( $oeuvreAffichee["nomArrondissement"]) {
                        echo "Arrondissement : ". $oeuvreAffichee["nomArrondissement"]."<br>";
                    }
                    echo "</p>";
                   
                    echo "<h2>Commentaires</h2>";
                    echo "<p>";
                    if ($commentairesOeuvre) {//Si des commentaires existent pour cette oeuvre dans la langue d'affichage...
                        for ($i = 0; $i < count($commentairesOeuvre); $i++) {
                            switch ($commentairesOeuvre[$i]['voteCommentaire']) {//Sélection de l'image d'étoile appropriée selon le vote
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
                            $imgPhoto = $commentairesOeuvre[$i]['photoProfil'];

                            echo "<img src = '../images/$imgPhoto'><br>";
                            echo $commentairesOeuvre[$i]["nomUsager"]."<br>";
                            echo "<img src = '../images/$imgVote'><br>";
                            echo $commentairesOeuvre[$i]["texteCommentaire"]."<br>";
                        }
                    }
                    else {
                        echo "Aucun commentaire";
                    }
                    echo "</p>";
                ?>
            </article>
    <?php
        }
                //-------------------------------------------------------------
            
            
            
            
                // Placer vos tests unitaires ici...
            ?>
		</div>
		<div id="footer">

		</div>
	</body>
</html>








