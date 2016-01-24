<?php
/**
 * Controlleur AJAX. Ce fichier est la porte d'entrée des requêtes AJAX
 * @author Jonathan Martel
 * @author David Lachambre
 * @author Philippe Germain
 * @version 1.0
 * @update 2016-01-23
 * @license Creative Commons BY-NC 3.0 (Licence Creative Commons Attribution - Pas d’utilisation commerciale 3.0 non transposé)
 * @license http://creativecommons.org/licenses/by-nc/3.0/deed.fr
 */
require_once("./config.php");
	
// Mettre ici le code de gestion de la requête AJAX
        
switch ($_GET['rAjax']) {//requête
    case 'googleMap':
        googleMap();
        break;
    case 'autoComplete':
        autoComplete();
        break;
    case 'selectTypeRecherche':
        afficherSelectRecherche();
        break;
    case 'selectRecherche':
        afficherBoutonRecherche();
        break;
}

function googleMap () {
    
    $dom = new DOMDocument("1.0");
    $node = $dom->createElement("markers");
    $parnode = $dom->appendChild($node);

    $oeuvre = new Oeuvre();
    $infoOeuvre = $oeuvre->getAllOeuvres();
    
    $urlOeuvre = "http://".$_SERVER['SERVER_NAME']."?r=oeuvre&o=";

    // ADD TO XML DOCUMENT NODE
    for ($i = 0; $i < count($infoOeuvre); $i++) {
        $node = $dom->createElement("marker");
        $newnode = $parnode->appendChild($node);
        $newnode->setAttribute("name",$infoOeuvre[$i]["titre"]);
        //$newnode->setAttribute("address", $row['adresse']);
        $newnode->setAttribute("lat", $infoOeuvre[$i]["latitude"]);
        $newnode->setAttribute("lng", $infoOeuvre[$i]["longitude"]); 
        //$newnode->setAttribute("photo", $infoOeuvre[$i]["image"]);   
        $newnode->setAttribute("url", $urlOeuvre.$infoOeuvre[$i]["idOeuvre"]);
    }
    header("Content-type: text/xml");
    echo $dom->saveXML();
    
}

function autoComplete () {
    
    if (!isset($_GET['keyword'])) {
        die();
    }

    if (isset($_GET['rechercheVoulue'])) {
        $keyword = $_GET['keyword'];

        if (($_GET['rechercheVoulue'])=="titre") {
            $oeuvre = new Oeuvre();
            $data = $oeuvre->chercheParTitre($keyword);
        }

        else if (($_GET['rechercheVoulue'])=="artiste") {
            $artiste = new Artiste();
            $data = $artiste->chercheParArtiste($keyword);
        }
    }
    echo json_encode($data);
}

function afficherSelectRecherche () {
    
    if (isset($_GET["typeRecherche"]) && $_GET["typeRecherche"] != "") {
        
        if ($_GET["typeRecherche"] == "artiste") {
            echo '<input class="text" type="text" placeholder="Entrez le nom de l\'artiste" id="keyword" name="inputArtiste" onkeyup="autoComplete(\'artiste\')">';
            echo '<div id="results"></div>';
        }
        else if ($_GET["typeRecherche"] == "titre") {
            echo '<input class="text" type="text" placeholder="Entrez le titre de l\'oeuvre" id="keyword" name="inputOeuvre" onkeyup="autoComplete(\'titre\')">';
            echo '<div id="results"></div>';
        }
        else if ($_GET["typeRecherche"] == "arrondissement") {
            echo '<select name="selectArrondissement" class="selectArrondissement">';
            echo '<option value = "">Faites un choix</option>';
            $nouvelArrondissement = new Arrondissement();
            $arrondissements = $nouvelArrondissement->getAllArrondissements();
            foreach ($arrondissements as $arrondissement) {
                echo '<option value="'.$arrondissement["idArrondissement"].'">'.$arrondissement["nomArrondissement"].'</option>';
            }
            echo '</select>';
        }
        else if ($_GET["typeRecherche"] == "categorie") {
            $nouvelleCategorie = new Categorie();
            if (isset($_COOKIE["langue"])) {
                $langue = $_COOKIE["langue"];
            }
            else {
                $langue = "FR";
            }
            $categories = $nouvelleCategorie->getAllCategories($langue);
            echo '<select name="selectCategorie" class="selectCategorie">';
            echo '<option value = "">Faites un choix</option>';
            foreach ($categories as $categorie) {
                echo '<option value="'.$categorie["idCategorie"].'">'.$categorie["nomCategorie$langue"].'</option>';
            }
            echo '</select>';
        }
    }
}

function afficherBoutonRecherche () {
    if ((isset($_GET["selectArrondissement"]) && $_GET["selectArrondissement"] != "") || (isset($_GET["selectCategorie"]) && $_GET["selectCategorie"] != "")) {
        echo '<input type="submit" name="boutonRecherche" value="Rechercher">';
    }
}
?>