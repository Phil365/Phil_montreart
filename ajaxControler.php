<?php
/**
 * Controlleur AJAX. Ce fichier est la porte d'entrée des requêtes AJAX (XHR)
 * @author Jonathan Martel
 * @version 1.0
 * @update 2013-03-11
 * @license Creative Commons BY-NC 3.0 (Licence Creative Commons Attribution - Pas d’utilisation commerciale 3.0 non transposé)
 * @license http://creativecommons.org/licenses/by-nc/3.0/deed.fr
 * 
 */

require_once("./config.php");
	
// Mettre ici le code de gestion de la requête AJAX

// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

$oeuvre = new Oeuvre();
$infoOeuvre = $oeuvre->getAllOeuvreWithPhoto();

header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each

if ($_SERVER['HTTP_HOST'] === '127.0.0.1' || $_SERVER['HTTP_HOST'] === 'localhost') {
    $urlOeuvre = "http://localhost?r=oeuvre&o=";
}
else if ($_SERVER['HTTP_HOST'] === '127.0.0.1:8008' || $_SERVER['HTTP_HOST'] === 'localhost:8008') {
    $urlOeuvre = "http://localhost:8008?r=oeuvre&o=";
    
else if ($_SERVER['HTTP_HOST'] === '127.0.0.1:8080' || $_SERVER['HTTP_HOST'] === 'localhost:8080') {
    $urlOeuvre = "http://localhost:8080?r=oeuvre&o=";
}
else if ($_SERVER['HTTP_HOST'] === '127.0.0.1:8888' || $_SERVER['HTTP_HOST'] === 'localhost:8888') {
    $urlOeuvre = "http://localhost:8888/origin/?r=oeuvre&o=";
}

  // ADD TO XML DOCUMENT NODE
for ($i = 0; $i < count($infoOeuvre); $i++) {
    $node = $dom->createElement("marker");
    $newnode = $parnode->appendChild($node);
    $newnode->setAttribute("name",$infoOeuvre[$i]["titre"]);
    //$newnode->setAttribute("address", $row['adresse']);
    $newnode->setAttribute("lat", $infoOeuvre[$i]["latitude"]);
    $newnode->setAttribute("lng", $infoOeuvre[$i]["longitude"]); 
    $newnode->setAttribute("photo", $infoOeuvre[$i]["image"]);   
    $newnode->setAttribute("url", $urlOeuvre.$infoOeuvre[$i]["idOeuvre"]);
}
//}

echo $dom->saveXML();

?>