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
            echo "<h2>informations sur l'oeuvre</h2>";
            echo "<details>";
            echo '<summary>Oeuvre::getOeuvreById($idOeuvre = ' . $idOeuvre . ', $langue = ' . $langue . ')</summary>';
            var_dump($oeuvreAffichee);
            echo "</details>";
            
            $commentaire = new Commentaire();
            $commentairesOeuvre = $commentaire->getCommentairesByOeuvre($idOeuvre, $langue);
            echo "<h2>commentaires sur l'oeuvre</h2>";
            echo "<details>";
            echo '<summary>Commentaire::getCommentairesByOeuvre = ' . $idOeuvre . ', $langue = ' . $langue . ')</summary>';
            var_dump($commentairesOeuvre);
            echo "</details>";
            
            $photo = new Photo();
            $photosOeuvre = $photo->getPhotosByOeuvre($idOeuvre);
            echo "<h2>photos associées à l'oeuvre</h2>";
            echo "<details>";
            echo '<summary>Photo::getPhotosByOeuvre($idOeuvre = ' . $idOeuvre . ')</summary>';
            var_dump($photosOeuvre);
            echo "</details>";
            ?>
		</div>
		<div id="footer">

		</div>
	</body>
</html>








