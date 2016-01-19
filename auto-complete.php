<?php
require_once("./config.php");
$oeuvre = new Oeuvre();



if (!isset($_GET['keyword'])) {
	die();
}

($_GET['rechercheVoulue']);


$keyword = $_GET['keyword'];

if (($_GET['rechercheVoulue'])=="titre") {
$data =  $oeuvre->searchForKeyword($keyword);
}

else if (($_GET['rechercheVoulue'])=="artiste") {
$data =  $oeuvre->chercheParArtiste($keyword);
}


//var_dump($_GET['rechercheVoulue']);
echo json_encode($data);
?>