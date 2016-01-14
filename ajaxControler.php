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

  // ADD TO XML DOCUMENT NODE
for ($i = 0; $i < count($infoOeuvre); $i++) {
    $node = $dom->createElement("marker");
    $newnode = $parnode->appendChild($node);
    $newnode->setAttribute("name",$infoOeuvre[$i]["titre"]);
    //$newnode->setAttribute("address", $row['adresse']);
    $newnode->setAttribute("lat", $infoOeuvre[$i]["latitude"]);
    $newnode->setAttribute("lng", $infoOeuvre[$i]["longitude"]); 
    $newnode->setAttribute("photo", $infoOeuvre[$i]["image"]);   
$newnode->setAttribute("urlTest", "http://localhost?r=oeuvre&o=".$infoOeuvre[$i]["idOeuvre"]);
  $newnode->setAttribute("url", "http://montreart.net?r=oeuvre&o=".$infoOeuvre[$i]["idOeuvre"]);
}
//}

echo $dom->saveXML();

?>