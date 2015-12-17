<?php

    
// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

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

header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each

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

echo $dom->saveXML();
?>