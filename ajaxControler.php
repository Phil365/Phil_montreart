<?php
<<<<<<< HEAD
=======
// Start XML file, create parent node


>>>>>>> origin/master
/**
 * Controlleur AJAX. Ce fichier est la porte d'entrée des requêtes AJAX (XHR)
 * @author Jonathan Martel
 * @version 1.0
 * @update 2013-03-11
 * @license Creative Commons BY-NC 3.0 (Licence Creative Commons Attribution - Pas d’utilisation commerciale 3.0 non transposé)
 * @license http://creativecommons.org/licenses/by-nc/3.0/deed.fr
 * 
 */

<<<<<<< HEAD
require_once("./config.php");
	
// Mettre ici le code de gestion de la requête AJAX

// Start XML file, create parent node
=======
	// Start XML file, create parent node
>>>>>>> origin/master

$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

<<<<<<< HEAD
$oeuvre = new Oeuvre();
$infoOeuvre = $oeuvre->getAllOeuvreWithPhoto();
=======
// Opens a connection to a MySQL server

//$connection=mysqli_connect ('localhost', "administrateur", "Bd2cPCoC");
$connection=mysqli_connect ('localhost', "root", "");
if (!$connection) {  die('Not connected : ' . mysql_error());}

// Set the active MySQL database

$db_selected = mysqli_select_db($connection, "montreart");
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}

// Select all the rows in the markers table

$query = "SELECT * FROM oeuvres";
$result = mysqli_query($connection, "SELECT * FROM oeuvres join photos on photos.idOeuvre = oeuvres.idOeuvre");
if (!$result) {
  die('Invalid query: ' . mysql_error());
}
>>>>>>> origin/master

header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each

<<<<<<< HEAD
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
=======
while ($row = @mysqli_fetch_assoc($result)){
  // ADD TO XML DOCUMENT NODE
  $node = $dom->createElement("marker");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("name",$row['titre']);
  //$newnode->setAttribute("address", $row['adresse']);
  $newnode->setAttribute("lat", $row['latitude']);
  $newnode->setAttribute("lng", $row['longitude']); 
  $newnode->setAttribute("photo", $row['image']); 
}
>>>>>>> origin/master

echo $dom->saveXML();
?>