<?php
require_once("./config.php");

if (!isset($_GET['keyword'])) {
	die();
}

($_GET['rechercheVoulue']);


$keyword = $_GET['keyword'];

if (($_GET['rechercheVoulue'])=="titre") {
    $oeuvre = new Oeuvre();
    $data =  $oeuvre->chercheParTitre($keyword);
}

else if (($_GET['rechercheVoulue'])=="artiste") {
    $artiste = new Artiste();
    $data =  $artiste->chercheParArtiste($keyword);
}


//var_dump($_GET['rechercheVoulue']);
echo json_encode($data);
?>