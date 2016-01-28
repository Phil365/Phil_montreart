/**
* @file Script contenant les fonctions de base
* @author Jonathan Martel (jmartel@gmail.com)
* @version 0.1
* @update 2013-12-11
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

function validePhotoSubmit() {
    var erreurs = false;
    document.getElementById("erreurPhotoSize").innerHTML = "";
    document.getElementById("erreurPhotoType").innerHTML = "";
    document.getElementById("erreurPhotoVide").innerHTML = "";
    
    if (document.getElementById("fileToUpload").files.length == 0) {
        document.getElementById("erreurPhotoVide").innerHTML = "Vous devez d'abord choisir un fichier.";
        erreurs = true;
    }
    else {
        if (document.getElementById("fileToUpload").files[0].size > 5000000) {
            document.getElementById("erreurPhotoSize").innerHTML = "Votre fichier doit être inférieur à 5Mb.";
            erreurs = true;
        }
        if (document.getElementById("fileToUpload").files[0].type != "image/png" && document.getElementById("fileToUpload").files[0].type != "image/jpg" && document.getElementById("fileToUpload").files[0].type != "image/jpeg") {
            document.getElementById("erreurPhotoType").innerHTML = "Votre fichier doit être de type Jpeg ou Png.";
            erreurs = true;
        }
    } 
    if (!erreurs) {
        return true;
    }
    else {
        return false;
    }
} // end function validateForm



function valideAjoutOeuvreJS() {
    var erreurs = false;
    document.getElementById("erreurTitreOeuvre").innerHTML = "";
    document.getElementById("erreurAdresseOeuvre").innerHTML = "";
    document.getElementById("erreurDescription").innerHTML = "";
    document.getElementById("erreurSelectCategorie").innerHTML = "";
    document.getElementById("erreurSelectArrondissement").innerHTML = "";


//    if (document.getElementById("nomDuInputTitre").value.trim() == "") {
//        document.getElementById("erreurTitreOeuvre").innerHTML = "Veuillez entrer un titre";
//        erreurs = true;
//    }
//
//    if (document.getElementById("nomDuInputAdresse").value.trim() == "") {
//        document.getElementById("erreurAdresseOeuvre").innerHTML = "Veuillez entrer une adresse";
//        erreurs = true;
//    }
//
//    if (document.getElementById("nomDuInputDescription").value.trim() == "") {
//        document.getElementById("erreurDescription").innerHTML = "Veuillez entrer une description réglementaire";
//        erreurs = true;
//    }
//
//    if (document.getElementById("nomDuSelectCategorie").value == "") {
//        document.getElementById("erreurSelectCategorie").innerHTML = "Veuillez choisir une option";
//        erreurs = true;
//    }
//
//    if (document.getElementById("nomDuSelectArrondissement").value == "") {
//        document.getElementById("erreurSelectArrondissement").innerHTML = "Veuillez choisir un arrondissement";
//        erreurs = true;
//    }  

//    if (!erreurs) {
//        return true;
//    }
//    else {
        return false;
//    }
} // end function validateForm




/*
function valideSupprimerOeuvreJS() {
    var erreurs = false;
    document.getElementById("erreurSelectSuppression").innerHTML = "";
    

    if (document.getElementById("nomDuSelect").value == "") {
        document.getElementById("erreurSelectSupression").innerHTML = "Veuillez choisir une option";
        erreurs = true;
    }
    } 
    if (!erreurs) {
        return true;
    }
    else {
        return false;
    }
} // end function validateForm 
*/





function valideModifierOeuvreJS() {
    var erreurs = false;
    document.getElementById("erreurTitreOeuvre").innerHTML = "";
    document.getElementById("erreurAdresseOeuvre").innerHTML = "";
    document.getElementById("erreurDescription").innerHTML = "";
    document.getElementById("erreurSelectCategorie").innerHTML = "";
    document.getElementById("erreurSelectArrondissement").innerHTML = "";


    if (document.getElementById("nomDuInputTitre").value.trim() == "") {
        document.getElementById("erreurTitreOeuvre").innerHTML = "Veuillez entrer un titre";
        erreurs = true;
    }

    if (document.getElementById("nomDuInputAdresse").value.trim() == "") {
        document.getElementById("erreurAdresseOeuvre").innerHTML = "Veuillez entrer une adresse";
        erreurs = true;
    }

    
    if (document.getElementById("nomDuInputDescription").value.trim() == "") {
        document.getElementById("erreurDescription").innerHTML = "Veuillez entrer une description réglementaire";
        erreurs = true;
    }

    if (document.getElementById("nomDuSelectCategorie").value == "") {
        document.getElementById("erreurSelectCategorie").innerHTML = "Veuillez choisir une option";
        erreurs = true;
    }

    if (document.getElementById("nomDuSelectArrondissement").value == "") {
        document.getElementById("erreurSelectArrondissement").innerHTML = "Veuillez choisir un arrondissement";
        erreurs = true;
    }  

    if (!erreurs) {
        return true;
    }
    else {
        return false;
    }
} // end function validateForm






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

 function bindInfoWindow(marker, map, infoWindow, html) {
     
      google.maps.event.addListener(marker, 'click', function() {
          
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
    }

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