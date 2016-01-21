<?php
//Mettre les fichiers requis pour les tests ici.
require_once("../config.php");
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
		<title>Tests unitaires</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link href="../css/styles.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
<?php
require_once ("./testAffichageOeuvre.php");
require_once ("./testGestionJson.php");
        
//Mettre les pages test ici.
?>
	</body>
</html>