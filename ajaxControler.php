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
	
$oCookie = new Cookie();
$langueAffichage = $oCookie->getLangue();

// Mettre ici le code de gestion de la requête AJAX 
switch ($_GET['rAjax']) {//requête
    case 'googleMap':
        googleMap();
        break;
    case 'autoComplete':
        autoComplete();
        break;
    case 'afficherSelectRecherche':
        afficherSelectRecherche();
        break;
    case 'afficherBoutonRecherche':
        afficherBoutonRecherche();
        break;
    case 'ajouterCategorie':
        ajouterCategorie();
        break;
    case 'supprimerCategorie':
        supprimerCategorie();
        break;
    case 'ajouterOeuvre':
        ajouterOeuvre();
        break;
    case 'recupererIdOeuvre':
        recupererIdOeuvre();
        break;
    case 'ajouterPhoto':
        ajouterPhoto();
        break;
    case 'supprimerOeuvre':
        supprimerOeuvre();
        break;
    case 'afficherFormModif':
        afficherFormModif();
        break;
    case 'modifierOeuvre':
        modifierOeuvre();
        break;
    case 'updateOeuvresVille':
        updateOeuvresVille();
        break;
    case 'updateDate':
        updateDate();
        break;
    case 'recupererCategories':
        recupererCategories();
        break;
    case 'recupererOeuvres':
        recupererOeuvres();
        break;
}

/* --------------------------------------------------------------------
============================ PAGE GESTION =============================
-------------------------------------------------------------------- */

/**
* @brief Fonction qui ajoute la catégorie soumise par un administrateur
* @access public
* @return void
*/
function ajouterCategorie () {
    
    $categorie = new Categorie();
    $msgErreurs = $categorie->ajouterCategorie($_POST["categorieFr"], $_POST["categorieEn"]);
    
    echo json_encode($msgErreurs);//Encode le tableau d'erreurs retourné par la requête en Json.
}

/**
* @brief Fonction qui supprime la catégorie soumise par un administrateur
* @access public
* @return void
*/
function supprimerCategorie () {
    
    $categorie = new Categorie();
    $msgErreurs = $categorie->supprimerCategorie($_POST["idCategorie"]);
    
    echo json_encode($msgErreurs);//Encode le tableau d'erreurs retourné par la requête en Json.
}

/**
* @brief Fonction qui récupère toutes les catégories de la BDD.
* @access public
* @return void
*/
function recupererCategories () {

    $categorie = new Categorie();
    $categories = $categorie->getAllCategories($_COOKIE["langue"]);
    
    echo json_encode($categories);//Encode le tableau de catégories retourné par la requête en Json.
} 

/**
* @brief Fonction qui récupère toutes les oeuvres de la BDD.
* @access public
* @return void
*/
function recupererOeuvres () {

    $oeuvre = new Oeuvre();
    $oeuvres = $oeuvre->getAllOeuvres();
        
   echo json_encode($oeuvres);//Encode le tableau d'oeuvres retourné par la requête en Json.
}

/**
* @brief Fonction qui ajoute l'oeuvre soumise par un administrateur
* @access public
* @return void
*/
function ajouterOeuvre () {
    
    //Ajout d'une oeuvre.
    if (isset($_GET["admin"]) && $_GET["admin"] == true) {
        $authorise = true;
    }
    else {
        $authorise = false;
    }
    
    $oeuvre = new Oeuvre();

    $msgErreurs = $oeuvre->AjouterOeuvre($_POST['titre'], $_POST['adresse'], $_POST['prenomArtiste'], $_POST['nomArtiste'], $_POST['description'], $_POST["idCategorie"], $_POST["idArrondissement"], $authorise, $_COOKIE["langue"]);
    
    echo json_encode($msgErreurs);//Encode le tableau d'erreurs retourné par la requête en Json.
}

/**
* @brief Fonction qui récupère l'ID de l'oeuvre qui vient d'être créée
* @access public
* @return void
*/
function recupererIdOeuvre () {

    $oeuvre = new Oeuvre();
    $idOeuvre = $oeuvre->getIdOeuvreByTitreandAdresse($_POST["titre"], $_POST["adresse"]);//aller chercher id oeuvre insérée
    
    echo $idOeuvre;
}

/**
* @brief Fonction qui ajoute la photo soumise
* @access public
* @return void
*/
function ajouterPhoto ( ) {
    
    //Ajout d'une oeuvre.
    if (isset($_GET["admin"]) && $_GET["admin"] == true) {
        $authorise = true;
    }
    else {
        $authorise = false;
    }
    
    $photo = new Photo();
    
    $msgErreurs = $photo->ajouterPhoto($_GET["idOeuvre"], $authorise);
    
    echo $msgErreurs;
}

/**
* @brief Fonction qui supprime l'oeuvre soumise par un administrateur
* @access public
* @return void
*/
function supprimerOeuvre () {
    
    $oeuvre = new Oeuvre();
    $msgErreurs = $oeuvre->supprimerOeuvre($_POST["idOeuvre"]);
    
    echo json_encode($msgErreurs);//Encode le tableau d'erreurs retourné par la requête en Json.
}

/**
* @brief Fonction qui affiche le formulaire de modification d'une oeuvre après sélection de l'oeuvre à modifier par l'utilisateur.
* @access public
* @return void
*/
function afficherFormModif () {
    
    $oeuvre = new Oeuvre();
    $oArrondissement = new Arrondissement();
    $oCategorie = new Categorie();
    $langue = $_COOKIE['langue'];
    
    $oeuvreAModifier = $oeuvre->getOeuvreById($_POST['idOeuvre'], $langue);
    if ($oeuvreAModifier) {
        $arrondissements = $oArrondissement->getAllArrondissements();
        $categories = $oCategorie->getAllCategories($langue);

        $titreModif = $oeuvreAModifier['titre'];
        $adresseModif = $oeuvreAModifier['adresse'];
        $idCategorieModif = $oeuvreAModifier['idCategorie'];
        $idArrondissementModif = $oeuvreAModifier['idArrondissement'];
        if ($_COOKIE["langue"] == "FR") {
            $descriptionModif = $oeuvreAModifier['descriptionFR'];
        }
        else if ($_COOKIE["langue"] == "EN") {
            $descriptionModif = $oeuvreAModifier['descriptionEN'];
        }
        ?>  
            <form method="POST" name="formModifOeuvre" id='formModifSelectOeuvre' action="?r=gestion" onsubmit="return valideModifierOeuvre();">
                <input type='text' class="inputGestion" name='titreModif' id='titreModif' placeholder="Titre de l'oeuvre" value='<?php echo $titreModif; ?>'/>
                <br><span class="erreur" id="erreurTitreOeuvreModif"></span>

                <input type='text' class="inputGestion" name='adresseModif' id='adresseModif'  placeholder="Adresse " value='<?php echo $adresseModif; ?>'/>
                <br><span class="erreur" id="erreurAdresseOeuvreModif"></span>

                <br>
                <textarea name='descriptionModif' class="inputGestion textAreaGestion" id='descriptionModif' placeholder="Description "><?php echo $descriptionModif; ?></textarea>
                <br><span class="erreur" id="erreurDescriptionModif"></span>

                <select name="selectArrondissementModif"  id="selectArrondissementModif" class="selectGestion">

                    <option value="">Choisir un arrondissement</option>
                    <?php
                        foreach ($arrondissements as $arrondissement) {
                            if ($arrondissement["idArrondissement"] == $idArrondissementModif) {
                                $selection = "selected";
                            }
                            else {
                                $selection = "";
                            }
                            echo "<option value='".$arrondissement["idArrondissement"]."'".$selection.">".$arrondissement["nomArrondissement"];
                        }
                    ?>
                </select>
                <br><span class="erreur" id="erreurSelectArrondissementModif"></span>

                <select name="selectCategorieModif" id="selectCategorieModif" class="selectGestion">

                    <option value="">Choisir une catégorie</option>
                    <?php
                        foreach ($categories as $categorie) {
                            if ($categorie["idCategorie"] == $idCategorieModif) {
                                $selection = "selected";
                            }
                            else {
                                $selection = "";
                            }
                            echo "<option value='".$categorie["idCategorie"]."'".$selection.">".$categorie["nomCategorie$langue"];
                        }
                        echo "</select>";
                    ?>
                </select> 

                <br><span class="erreur" id="erreurSelectCategorieModif"></span>

                <br><input class="boutonMoyenne  boutonHover" type='submit' name='boutonModifOeuvre' value='Modifer'>
            </form>
        <?php
    }
    else {
        echo "<span class='erreur'>cette oeuvre n'existe pas.</span>";
    }
}

/**
* @brief Fonction qui modifie l'oeuvre choisie par un administrateur
* @access public
* @return void
*/
function modifierOeuvre () {
    
    $oeuvre = new Oeuvre();
    $msgErreurs = $oeuvre->modifierOeuvre($_POST["idOeuvre"], $_POST["titre"], $_POST["adresse"], $_POST["description"], $_POST["idCategorie"], $_POST["idArrondissement"], $_COOKIE["langue"]);
    
    echo json_encode($msgErreurs);//Encode le tableau d'erreurs retourné par la requête en Json.
}

/**
* @brief Fonction qui mets à jour les oeuvres de la BDD avec les oeuvres de la ville et mets à jour l'affichage dans la page de gestion.
* @access public
* @return void
*/
function updateOeuvresVille () {
    
    //Mise à jour des oeuvres de la ville de Montréal
    $oeuvre = new Oeuvre();
    $msgErreurs = $oeuvre->updaterOeuvresVille();
    
    echo json_encode($msgErreurs);//Encode le tableau d'erreurs retourné par la requête en Json.
}

/**
* @brief Fonction qui récupère la dernière date de mise à jour des oeuvres de la ville.
* @access public
* @return void
*/
function updateDate () {
    
    //Affichage de la date de dernière mise à jour des oeuvres de la ville.
    $oeuvre = new Oeuvre();
    $date = $oeuvre->getDateDernierUpdate();
    
    echo json_encode($date);//Encode la date retournée par la requête en Json.
}

/* --------------------------------------------------------------------
============================ PAGE ACCUEIL =============================
-------------------------------------------------------------------- */
/**
* @brief Fonction qui récupère les infos pour populer la carte de Google Map
* @access public
* @return void
*/
function googleMap () {
    
    $dom = new DOMDocument("1.0");
    $node = $dom->createElement("markers");
    $parnode = $dom->appendChild($node);

    $oeuvre = new Oeuvre();
    $infoOeuvre = $oeuvre->getAllOeuvres();
    
    $urlOeuvre = "http://".$_SERVER['HTTP_HOST']."?r=oeuvre&o=";

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

/* --------------------------------------------------------------------
========================== BARRE DE RECHERCHE =========================
-------------------------------------------------------------------- */
/**
* @brief Fonction qui récupère des noms de la BDD en fonction des lettres entrées par l'utilisateur
* @access public
* @return string
*/
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

/**
* @brief Fonction qui affiche le 2e select de la barre de recherche en fonction du choix de l'utilisateur
* @access public
* @return void
*/
function afficherSelectRecherche () {
    
    if (isset($_GET["typeRecherche"]) && $_GET["typeRecherche"] != "") {
        
        $nomServeur = $_SERVER["HTTP_HOST"];
        
        if ($_GET["typeRecherche"] == "artiste") {
            echo '<input class="text" type="text" placeholder="Entrez le nom de l\'artiste" id="keyword" name="inputArtiste" onkeyup="autoComplete(\'artiste\', \''.$nomServeur.'\')">';
            echo '<div id="results"></div>';
        }
        else if ($_GET["typeRecherche"] == "titre") {
            echo '<input class="text" type="text" placeholder="Entrez le titre de l\'oeuvre" id="keyword" name="inputOeuvre" onkeyup="autoComplete(\'titre\', \''.$nomServeur.'\')">';
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

/**
* @brief Fonction qui affiche le bouton submit de la recherche si l'utilisateur a choisi arrondissement ou catégorie
* @access public
* @return void
*/
function afficherBoutonRecherche () {
    if ((isset($_GET["selectArrondissement"]) && $_GET["selectArrondissement"] != "") || (isset($_GET["selectCategorie"]) && $_GET["selectCategorie"] != "")) {
        echo '<input type="submit" name="boutonRecherche" value="Rechercher">';
    }
}
?>