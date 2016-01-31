/**
* @file Script contenant les fonctions de base
* @author Jonathan Martel (jmartel@gmail.com)
* @author David Lachambre
* @version 0.1
* @update 2016-01-30
* @license Creative Commons BY-NC 3.0 (Licence Creative Commons Attribution - Pas d’utilisation commerciale 3.0 non transposé)
* @license http://creativecommons.org/licenses/by-nc/3.0/deed.fr
*
*/

// Placer votre JavaScript ici

//INITIALISATION FONCTIONS JQUERY
$(document).ready(function(){
    
    //SLIDE BARRE DE RECHERCHE
    $(".barreRecherche").hide();
    $(".boutonRecherche").click(function(){
        
        $( ".barreRecherche").animate({
            width: "toggle"
        });
    });
    
    //AJAX SELECT TYPE DE RECHERCHE
    $(".barreRecherche").on("change", ".typeRecherche", function(){
        
        $.get("ajaxControler.php?rAjax=selectTypeRecherche&typeRecherche="+this.value, function(reponse){
            //ceci est la fonction de callback
            //elle sera appelée lorsque le contenu obtenu par AJAX sera rendu du côté client
            $(".deuxiemeSelectRecherche").html(reponse);
            $(".submitRecherche").html("");//Pour corriger un bug où le bouton restait affiché si on changeait le type de recherche après son affichage.
        });
    });
    //AJAX SELECT CATEGORIE
    $(".barreRecherche").on("change", ".selectCategorie", function(){
        $.get("ajaxControler.php?rAjax=selectRecherche&selectCategorie="+this.value, function(reponse){
            //ceci est la fonction de callback
            //elle sera appelée lorsque le contenu obtenu par AJAX sera rendu du côté client
            $(".submitRecherche").html(reponse);
        });
    });
    //AJAX SELECT ARRONDISSEMENT
    $(".barreRecherche").on("change", ".selectArrondissement", function(){
        $.get("ajaxControler.php?rAjax=selectRecherche&selectArrondissement="+this.value, function(reponse){
            //ceci est la fonction de callback
            //elle sera appelée lorsque le contenu obtenu par AJAX sera rendu du côté client
            $(".submitRecherche").html(reponse);
        });
    });
});

/* --------------------------------------------------------------------
========================= DÉBUT VALIDATION JS =========================
-------------------------------------------------------------------- */

/**
* @brief Fonction de validation de soumission d'une photo
* @access public
* @return boolean
*/
function validePhotoSubmit() {
    var erreurs = false;
    var msg = "";
    
    if (document.getElementById("fileToUpload").files.length == 0) {
        msg = "Vous devez d'abord choisir un fichier.";
        erreurs = true;
    }
    else {
        if (document.getElementById("fileToUpload").files[0].size > 5000000) {
            if (msg != "") {
                msg += "<br>";
            }
            msg += "Votre fichier doit être inférieur à 5Mb.";
            erreurs = true;
        }
        if (document.getElementById("fileToUpload").files[0].type != "image/png" && document.getElementById("fileToUpload").files[0].type != "image/jpg" && document.getElementById("fileToUpload").files[0].type != "image/jpeg") {
            if (msg != "") {
                msg += "<br>";
            }
            msg += "Votre fichier doit être de type Jpeg ou Png.";
            erreurs = true;
        }
    }
    document.getElementById("msg").innerHTML = msg;
    return (!erreurs);
}

/**
* @brief Fonction de validation de soumission d'une oeuvre
* @access public
* @return boolean
*/
function valideAjoutOeuvre() {
    var erreurs = false;
    var champsPhoto = document.getElementById("fileToUpload");
    var msgErreurPhoto = "";
    
    document.getElementById("erreurTitreOeuvre").innerHTML = "";
    document.getElementById("erreurAdresseOeuvre").innerHTML = "";
    document.getElementById("erreurDescription").innerHTML = "";
    document.getElementById("erreurSelectCategorie").innerHTML = "";
    document.getElementById("erreurSelectArrondissement").innerHTML = "";


    if (document.getElementById("titreAjout").value.trim() == "") {
        document.getElementById("erreurTitreOeuvre").innerHTML = "Veuillez entrer un titre";
        erreurs = true;
    }

    if (document.getElementById("adresseAjout").value.trim() == "") {
        document.getElementById("erreurAdresseOeuvre").innerHTML = "Veuillez entrer une adresse";
        erreurs = true;
    }
    else {
        var adresseAuthorisee = new RegExp("^[0-9]+[A-ÿ.,' \-]+$", "i");//doit avoir la forme d'adresse chiffre suivi d'un ou plusieurs noms.
        var resultat = adresseAuthorisee.exec(document.getElementById("adresseAjout").value);
        if (!resultat) {
            document.getElementById("erreurAdresseOeuvre").innerHTML = "Votre adresse doit débuter par le numéro civique, suivi du nom de la rue";
            erreurs = true;
        }
    }
    
    if (document.getElementById("descriptionAjout").value.trim() == "") {
        document.getElementById("erreurDescription").innerHTML = "Veuillez entrer une description";
        erreurs = true;
    }

    if (document.getElementById("selectCategorie").value == "") {
        document.getElementById("erreurSelectCategorie").innerHTML = "Veuillez choisir une catégorie";
        erreurs = true;
    }

    if (document.getElementById("selectArrondissement").value == "") {
        document.getElementById("erreurSelectArrondissement").innerHTML = "Veuillez choisir un arrondissement";
        erreurs = true;
    }  
    
    if (champsPhoto.value != "") {
        var fichiersAuthorises = new RegExp("(.jpg|.jpeg|.png)$", "i");//doit se terminer par une des extensions suivantes.
        var resultat = fichiersAuthorises.exec(champsPhoto.value);
        if (!resultat) {
            msgErreurPhoto = "Seules les images de type \"JPG\" ou \"PNG\" sont acceptées.";
            erreurs = true;
        }
        if (champsPhoto.files[0].size > 5000000) {//Si plus gros que 5Mb...
            if (msgErreurPhoto != "") {
                msgErreurPhoto += "<br>";
            }
            msgErreurPhoto += "Votre image ne doit pas dépasser 5Mb.";
            erreurs = true;
        }
    }
    document.getElementById("erreurPhoto").innerHTML = msgErreurPhoto;
    return (!erreurs);
}

/**
* @brief Fonction de validation de suppresion d'une oeuvre
* @access public
* @return boolean
*/
function valideSupprimerOeuvre() {
    
    var erreurs = false;
    document.getElementById("erreurSelectSuppression").innerHTML = "";
    

    if (document.getElementById("selectOeuvreSupp").value == "") {
        document.getElementById("erreurSelectSuppression").innerHTML = "Veuillez choisir une option";
        erreurs = true;
    } 
    return (!erreurs);
}

/**
* @brief Fonction de validation de modification d'une oeuvre
* @access public
* @return boolean
*/
function valideModifierOeuvre() {
    
    var erreurs = false;
    document.getElementById("erreurTitreOeuvreModif").innerHTML = "";
    document.getElementById("erreurAdresseOeuvreModif").innerHTML = "";
    document.getElementById("erreurDescriptionModif").innerHTML = "";
    document.getElementById("erreurSelectCategorieModif").innerHTML = "";
    document.getElementById("erreurSelectArrondissementModif").innerHTML = "";

    if (document.getElementById("titreModif").value.trim() == "") {
        document.getElementById("erreurTitreOeuvreModif").innerHTML = "Veuillez entrer le titre";
        erreurs = true;
    }
    if (document.getElementById("adresseModif").value.trim() == "") {
        document.getElementById("erreurAdresseOeuvreModif").innerHTML = "Veuillez entrer l'adresse";
        erreurs = true;
    }

    if (document.getElementById("descriptionModif").value.trim() == "") {
        document.getElementById("erreurDescriptionModif").innerHTML = "Veuillez entrer une description";
        erreurs = true;
    }

    if (document.getElementById("selectCategorieModif").value == "") {
        document.getElementById("erreurSelectCategorieModif").innerHTML = "Veuillez choisir une catégorie";
        erreurs = true;
    }

    if (document.getElementById("selectArrondissementModif").value == "") {
        document.getElementById("erreurSelectArrondissementModif").innerHTML = "Veuillez choisir un arrondissement";
        erreurs = true;
    }  
    return (!erreurs);
}

/**
* @brief Fonction de validation de l'ajout d'une catégorie
* @access public
* @return boolean
*/
function valideAjoutCategorie() {
    
    var erreurs = false;
    document.getElementById("erreurAjoutCategorieFR").innerHTML = "";
    document.getElementById("erreurAjoutCategorieEN").innerHTML = "";
    

    if (document.getElementById("categorieFrAjout").value == "") {
        document.getElementById("erreurAjoutCategorieFR").innerHTML = "Veuillez inscrire le nom de la catégorie en français";
        erreurs = true;
    }
    if (document.getElementById("categorieEnAjout").value == "") {
        document.getElementById("erreurAjoutCategorieEN").innerHTML = "Veuillez inscrire le nom de la catégorie en anglais";
        erreurs = true;
    }
    return (!erreurs);
}

/**
* @brief Fonction de validation de suppresion d'une catégorie
* @access public
* @return boolean
*/
function valideSuppCategorie() {
    
    var erreurs = false;
    document.getElementById("erreurSelectSuppCategorie").innerHTML = "";    

    if (document.getElementById("selectCategorieSupp").value == "") {
        document.getElementById("erreurSelectSuppCategorie").innerHTML = "Veuillez choisir une catégorie à supprimer";
        erreurs = true;
    }
    return (!erreurs);
}

/* --------------------------------------------------------------------
========================== FIN VALIDATION JS ==========================
-------------------------------------------------------------------- */

/**
* @brief Fonction d'autocomplete pour la recherche
* @access public
* @return void
*/
function autoComplete(rechercheVoulue, nomServeur)
{
    var MIN_LENGTH = 1;
    var url =  "ajaxControler.php?rAjax=autoComplete&rechercheVoulue=";

    $("#keyword").keyup(function() {
        
        var keyword = $("#keyword").val();
        if (keyword.length >= MIN_LENGTH) {
            $.get(url + rechercheVoulue, { keyword: keyword } )
            
            .done(function( data ) {
                
                $('#results').html('');
                var results = jQuery.parseJSON(data);
                
                $(results).each(function(key, value) {

                    if (rechercheVoulue=="titre") {
                        $('#results').append('<div class="item">' + "<a href=http://"+nomServeur+"/?r=oeuvre&o="+value['idOeuvre']+">"+value['titre']+"</a></div>");
                    }
                    if (rechercheVoulue=="artiste") {
                        if (value['nomCollectif'] != null) {
                            $('#results').append('<div class="item">' + "<a href=http://"+nomServeur+"/?r=recherche&rechercheParArtiste="+value['idArtiste']+">"+value['nomCollectif']+"</a></div>");
                        }
                        else {
                            $('#results').append('<div class="item">' + "<a href=http://"+nomServeur+"/?r=recherche&rechercheParArtiste="+value['idArtiste']+">"+value['nomCompletArtiste']+"</a></div>");
                        }
                    }
                })
                $("#results").show();
            });
        }
        else {
            $('#results').html('');
        }
    });
    
    $("#keyword").blur(function(){
        
        $("#results").fadeOut(500);
    })
}

/**
* @brief Fonction d'initialisation Google Map
* @access public
* @return void
*/
function initMap() {

    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 11,
        center: new google.maps.LatLng(45.512090, -73.550979),
        mapTypeId: 'roadmap'
    });
    var infoWindow = new google.maps.InfoWindow();

    downloadUrl("ajaxControler.php?rAjax=googleMap", function(data) {

        var xml = data.responseXML;
        var markers = xml.documentElement.getElementsByTagName("marker");
        for (var i = 0; i < markers.length; i++) {
            var name = markers[i].getAttribute("name");
            //    var photo = markers[i].getAttribute("photo");
            //    var urlTest = markers[i].getAttribute("urlTest");
            var url = markers[i].getAttribute("url");
            var point = new google.maps.LatLng(
            parseFloat(markers[i].getAttribute("lat")),
            parseFloat(markers[i].getAttribute("lng")));
            var html = "<a href='" + url + "'>" + name + "</a>";
            var marker = new google.maps.Marker({
                map: map,
                position: point,
            });
            bindInfoWindow(marker, map, infoWindow, html);
        }
    });
}

/**
* @brief Fonction de mise en page pour la Google Map
* @access public
* @return void
*/
function bindInfoWindow(marker, map, infoWindow, html) {
     
  google.maps.event.addListener(marker, 'click', function() {

    infoWindow.setContent(html);
    infoWindow.open(map, marker);
  });
}

/**
* @brief Fonction Ajax pour la Google Map
* @access public
* @return void
*/
function downloadUrl(url,callback) {
     
    var request = window.ActiveXObject ?
    new ActiveXObject('Microsoft.XMLHTTP') :
    new XMLHttpRequest;

    request.onreadystatechange = function() {

        if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request, request.status);
        }
    };
    request.open('GET', url, true);
    request.send(null);
}

function doNothing() {}