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

    //Accordéon Jquery pour l'onglet des soumissions dans la page de gestion
    $( "#accordeon" ).accordion({
        active: false,
        collapsible: true,
        animate: 400,
        heightStyle: "content"
    });

    
    //SLIDE BARRE DE RECHERCHE
    $(".barreRecherche").hide();
    $(".boutonRecherche").click(function(){
        
        $( ".barreRecherche").animate({
            width: "toggle"
        });
    });
    
    //AJAX SELECT TYPE DE RECHERCHE
    $(".barreRecherche").on("change", ".typeRecherche", function(){
        
        $.get("ajaxControler.php?rAjax=afficherSelectRecherche&typeRecherche="+this.value, function(reponse){
            //ceci est la fonction de callback
            //elle sera appelée lorsque le contenu obtenu par AJAX sera rendu du côté client
            $(".deuxiemeSelectRecherche").html(reponse);
            $(".submitRecherche").html("");//Pour corriger un bug où le bouton restait affiché si on changeait le type de recherche après son affichage.
        });
    });
    //AJAX SELECT CATEGORIE
    $(".barreRecherche").on("change", ".selectCategorie", function(){
        $.get("ajaxControler.php?rAjax=afficherBoutonRecherche&selectCategorie="+this.value, function(reponse){
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
    
    $(document).ready(function(){
        /**
        * @brief fonctions jQuery qui affiche et masque les sections en fonction du lien cliqué par l'utilisateur.
        */
        //------------ DEBUT ONGLETS JQUERY PAGE GESTION -------------

        //ONGLET 1
        $("#lienGestion1").click(function(){
            
            if ($( "#Onglet-1" ).is( ":visible" )){//Si l'onglet est visible...
                $("#Onglet-1").slideToggle(500);
            }
            else {
                if ($("#Onglet-2").is(":visible") || $("#Onglet-3" ).is(":visible") || $( "#Onglet-4").is( ":visible") || $("#Onglet-5").is(":visible") || $("#Onglet-6").is(":visible") || $( "#Onglet-7" ).is( ":visible" )) {
                    $("#Onglet-1").delay(400).slideToggle(500);
                }
                else {
                    $("#Onglet-1").slideToggle(500);
                }
                
            }
            $("#Onglet-2").slideUp(450);
            $("#Onglet-3").slideUp(350);
            $("#Onglet-4").slideUp(350);
            $("#Onglet-5").slideUp(350);
            $("#Onglet-6").slideUp(350);
            $("#Onglet-7").slideUp(350);
        });
        //ONGLET 2
        $("#lienGestion2").click(function(){//Si l'onglet est visible...
            if ($( "#Onglet-2" ).is( ":visible" )) {
                $("#Onglet-2").slideToggle(500);
            }
            else {
                if ($( "#Onglet-1" ).is( ":visible" ) || $( "#Onglet-3" ).is( ":visible" ) || $( "#Onglet-4" ).is( ":visible" ) || $( "#Onglet-5" ).is( ":visible" ) || $( "#Onglet-6" ).is( ":visible" ) || $( "#Onglet-7" ).is( ":visible" )) {
                    $("#Onglet-2").delay(400).slideToggle(750);
                }
                else {
                    $("#Onglet-2").slideToggle(750);
                }
                //---------------------------------------------------------------------------------------------------
                //Requête Ajax pour récupérer les catégories de la BDD afin de mettre le select à jour lorsque l'onglet est ouvert.
                $.post('ajaxControler.php?rAjax=recupererCategories', 
                    function(reponse){

                    var categories = jQuery.parseJSON(reponse);
                    var options = "<option value=''>choisir une catégorie</option>";
                    var langue = getCookie("langue");

                    //Choix du contenu du select en fonction de la langue
                    if (langue == "FR") {
                        $(categories).each(function(index, categorie) {
                            options += '<option value="' + categorie.idCategorie + '">' + categorie.nomCategorieFR + '</option>';
                        })
                    }
                    else if (langue = "EN") {
                        $(categories).each(function(index, categorie) {
                            options += '<option value="' + categorie.idCategorie + '">' + categorie.nomCategorieEN + '</option>';
                        })
                    }

                    $("#selectCategorie").html(options);
                });
                //---------------------------------------------------------------------------------------------------
            }
            $("#Onglet-1").slideUp(350);
            $("#Onglet-3").slideUp(350);
            $("#Onglet-4").slideUp(350);
            $("#Onglet-5").slideUp(350);
            $("#Onglet-6").slideUp(350);
            $("#Onglet-7").slideUp(350);
        });
        //ONGLET 3
        $("#lienGestion3").click(function(){
            if ($( "#Onglet-3" ).is( ":visible" )) {//Si l'onglet est visible...
                $("#Onglet-3").slideToggle(500);
            }
            else {
                if ($( "#Onglet-1" ).is( ":visible" ) || $( "#Onglet-2" ).is( ":visible" ) || $( "#Onglet-4" ).is( ":visible" ) || $( "#Onglet-5" ).is( ":visible" ) || $( "#Onglet-6" ).is( ":visible" ) || $( "#Onglet-7" ).is( ":visible" )) {
                    $("#Onglet-3").delay(400).slideToggle(500);
                }
                else {
                    $("#Onglet-3").slideToggle(500);
                }
                //---------------------------------------------------------------------------------------------------
                //Requête Ajax pour récupérer les oeuvres de la BDD afin de mettre le select à jour lorsque l'onglet est ouvert.
                $.post('ajaxControler.php?rAjax=recupererOeuvres', 
                    function(reponse){

                    var oeuvres = jQuery.parseJSON(reponse);
                    var options = "<option value=''>choisir une oeuvre</option>";
                    
                    $(oeuvres).each(function(index, oeuvre) {
                        options += '<option value="' + oeuvre.idOeuvre + '">' + oeuvre.titre + '</option>';
                    })
                    $("#selectOeuvreSupp").html(options);
                });
                //---------------------------------------------------------------------------------------------------
            }
            $("#Onglet-1").slideUp(350);
            $("#Onglet-2").slideUp(450);
            $("#Onglet-4").slideUp(350);
            $("#Onglet-5").slideUp(350);
            $("#Onglet-6").slideUp(350);
            $("#Onglet-7").slideUp(350);
        });
        //ONGLET 4
        $("#lienGestion4").click(function(){
            if ($( "#Onglet-4" ).is( ":visible" )) {//Si l'onglet est visible...
                $("#Onglet-4").slideToggle(500);
            }
            else {
                if ($( "#Onglet-1" ).is( ":visible" ) || $( "#Onglet-2" ).is( ":visible" ) || $( "#Onglet-3" ).is( ":visible" ) || $( "#Onglet-5" ).is( ":visible" ) || $( "#Onglet-6" ).is( ":visible" ) || $( "#Onglet-7" ).is( ":visible" )) {
                    $("#Onglet-4").delay(400).slideToggle(500);
                }
                else {
                    $("#Onglet-4").slideToggle(500);
                }
                //---------------------------------------------------------------------------------------------------
                //Requête Ajax pour récupérer les oeuvres de la BDD afin de mettre le select à jour lorsque l'onglet est ouvert.
                $.post('ajaxControler.php?rAjax=recupererOeuvres', 
                    function(reponse){

                    var oeuvres = jQuery.parseJSON(reponse);
                    var options = "<option value=''>choisir une oeuvre</option>";
                    
                    $(oeuvres).each(function(index, oeuvre) {
                        options += '<option value="' + oeuvre.idOeuvre + '">' + oeuvre.titre + '</option>';
                    })
                    $("#selectOeuvreModif").html(options);
                });
                //---------------------------------------------------------------------------------------------------
            }
            $("#Onglet-1").slideUp(350);
            $("#Onglet-2").slideUp(450);
            $("#Onglet-3").slideUp(350);
            $("#Onglet-5").slideUp(350);
            $("#Onglet-6").slideUp(350);
            $("#Onglet-7").slideUp(350);
        });
        //ONGLET 5
        $("#lienGestion5").click(function(){
            if ($( "#Onglet-5" ).is( ":visible" )) {//Si l'onglet est visible...
                $("#Onglet-5").slideToggle(500);
            }
            else {
                if ($( "#Onglet-1" ).is( ":visible" ) || $( "#Onglet-2" ).is( ":visible" ) || $( "#Onglet-3" ).is( ":visible" ) || $( "#Onglet-4" ).is( ":visible" ) || $( "#Onglet-6" ).is( ":visible" ) || $( "#Onglet-7" ).is( ":visible" )) {
                    $("#Onglet-5").delay(400).slideToggle(500);
                }
                else {
                    $("#Onglet-5").slideToggle(500);
                }
            }
            $("#Onglet-1").slideUp(350);
            $("#Onglet-2").slideUp(450);
            $("#Onglet-3").slideUp(350);
            $("#Onglet-4").slideUp(350);
            $("#Onglet-6").slideUp(350);
            $("#Onglet-7").slideUp(350);
        });
        //ONGLET 6
        $("#lienGestion6").click(function(){
            if ($( "#Onglet-6" ).is( ":visible" )) {//Si l'onglet est visible...
                $("#Onglet-6").slideToggle(500);
            }
            else {
                if ($( "#Onglet-1" ).is( ":visible" ) || $( "#Onglet-2" ).is( ":visible" ) || $( "#Onglet-3" ).is( ":visible" ) || $( "#Onglet-4" ).is( ":visible" ) || $( "#Onglet-5" ).is( ":visible" ) || $( "#Onglet-7" ).is( ":visible" )) {
                    $("#Onglet-6").delay(400).slideToggle(500);
                }
                else {
                    $("#Onglet-6").slideToggle(500);
                }
                //---------------------------------------------------------------------------------------------------
                //Requête Ajax pour récupérer les catégories de la BDD afin de mettre le select à jour lorsque l'onglet est ouvert.
                $.post('ajaxControler.php?rAjax=recupererCategories', 
                    function(reponse){

                    var categories = jQuery.parseJSON(reponse);
                    var options = "<option value=''>choisir une catégorie</option>";
                    var langue = getCookie("langue");

                    //Choix du contenu du select en fonction de la langue
                    if (langue == "FR") {
                        $(categories).each(function(index, categorie) {
                            options += '<option value="' + categorie.idCategorie + '">' + categorie.nomCategorieFR + '</option>';
                        })
                    }
                    else if (langue = "EN") {
                        $(categories).each(function(index, categorie) {
                            options += '<option value="' + categorie.idCategorie + '">' + categorie.nomCategorieEN + '</option>';
                        })
                    }

                    $("#selectCategorieSupp").html(options);
                });
                //---------------------------------------------------------------------------------------------------
            }
            $("#Onglet-1").slideUp(350);
            $("#Onglet-2").slideUp(450);
            $("#Onglet-3").slideUp(350);
            $("#Onglet-4").slideUp(350);
            $("#Onglet-5").slideUp(350);
            $("#Onglet-7").slideUp(350);
        });
        //ONGLET 7
        $("#lienGestion7").click(function(){
            if ($( "#Onglet-7" ).is( ":visible" )) {//Si l'onglet est visible...
                $("#Onglet-7").slideToggle(500);
            }
            else {
                if ($( "#Onglet-1" ).is( ":visible" ) || $( "#Onglet-2" ).is( ":visible" ) || $( "#Onglet-3" ).is( ":visible" ) || $( "#Onglet-4" ).is( ":visible" ) || $( "#Onglet-5" ).is( ":visible" ) || $( "#Onglet-6" ).is( ":visible" )) {
                    $("#Onglet-7").delay(400).slideToggle(500);
                }
                else {
                    $("#Onglet-7").slideToggle(500);
                }
            }
            $("#Onglet-1").slideUp(350);
            $("#Onglet-2").slideUp(450);
            $("#Onglet-3").slideUp(350);
            $("#Onglet-4").slideUp(350);
            $("#Onglet-5").slideUp(350);
            $("#Onglet-6").slideUp(350);
        });
            //Toutes les sections sont cachées au chargement de la page.
            $("#Onglet-1").hide();
            $("#Onglet-2").hide();
            $("#Onglet-3").hide();
            $("#Onglet-4").hide();
            $("#Onglet-5").hide();
            $("#Onglet-6").hide();
            $("#Onglet-7").hide();
    });
    //------------ FIN ONGLETS JQUERY PAGE GESTION -------------
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
* @brief Fonction de validation de soumission d'une oeuvre. Soumet la requête en Ajax si aucune erreur et transmet les erreurs, le cas échéant.
* @access public
* @return boolean
*/
function valideAjoutOeuvre(droitsAdmin) {
    
    if (droitsAdmin == "false") {
        droitsAdmin = false;
    }
    else if (droitsAdmin == "true") {
        droitsAdmin = true;
    }
    var erreurs = false;
    var photo = document.getElementById("fileToUpload");
    var msgErreurPhoto = "";
    var description = document.getElementById("descriptionAjout").value.trim();
    var idCategorie = document.getElementById("selectCategorie").value;
    var idArrondissement = document.getElementById("selectArrondissement").value;
    var adresse = document.getElementById("adresseAjout").value.trim();
    var titre = document.getElementById("titreAjout").value.trim();
    var prenomArtiste = document.getElementById("prenomArtisteAjout").value.trim();
    var nomArtiste = document.getElementById("nomArtisteAjout").value.trim();
    
    //-----------------------------------------
    //Réinitialisation des messgages d'erreur.
    document.getElementById("erreurTitreOeuvre").innerHTML = "";
    document.getElementById("erreurAdresseOeuvre").innerHTML = "";
    document.getElementById("erreurDescription").innerHTML = "";
    document.getElementById("erreurSelectCategorie").innerHTML = "";
    document.getElementById("erreurSelectArrondissement").innerHTML = "";
    document.getElementById("erreurPhoto").innerHTML = "";
    document.getElementById("msgAjout").innerHTML = "";

    //-----------------------------------------
    //Validation des champs.
    if (titre == "") {
        document.getElementById("erreurTitreOeuvre").innerHTML = "Veuillez entrer un titre";
        erreurs = true;
    }

    if (adresse == "") {
        document.getElementById("erreurAdresseOeuvre").innerHTML = "Veuillez entrer une adresse";
        erreurs = true;
    }
    else {
        var adresseAuthorisee = new RegExp("^[0-9]+[A-ÿ.,' \-]+$", "i");//doit avoir la forme d'adresse chiffre suivi d'un ou plusieurs noms.
        var resultat = adresseAuthorisee.exec(adresse);
        if (!resultat) {
            document.getElementById("erreurAdresseOeuvre").innerHTML = "Votre adresse doit débuter par le numéro civique, suivi du nom de la rue";
            erreurs = true;
        }
    }
    
    if (description == "") {
        document.getElementById("erreurDescription").innerHTML = "Veuillez entrer une description";
        erreurs = true;
    }

    if (idCategorie == "") {
        document.getElementById("erreurSelectCategorie").innerHTML = "Veuillez choisir une catégorie";
        erreurs = true;
    }

    if (idArrondissement == "") {
        document.getElementById("erreurSelectArrondissement").innerHTML = "Veuillez choisir un arrondissement";
        erreurs = true;
    }  
    
    if (photo.value != "") {
        var fichiersAuthorises = new RegExp("(.jpg|.jpeg|.png)$", "i");//doit se terminer par une des extensions suivantes.
        var resultat = fichiersAuthorises.exec(photo.value);
        if (!resultat) {
            msgErreurPhoto = "Seules les images de type \"JPG\" ou \"PNG\" sont acceptées.";
            erreurs = true;
        }
        if (photo.files[0].size > 5000000) {//Si plus gros que 5Mb...
            if (msgErreurPhoto != "") {
                msgErreurPhoto += "<br>";
            }
            msgErreurPhoto += "Votre image ne doit pas dépasser 5Mb.";
            erreurs = true;
        }
        document.getElementById("erreurPhoto").innerHTML = msgErreurPhoto;
    }
    
    //-----------------------------------------
    //Requête AJAX si aucune erreur.
    if (!erreurs) {
        droitsAdmin = false;
        $.post('ajaxControler.php?rAjax=ajouterOeuvre', {titre: titre, adresse: adresse, prenomArtiste: prenomArtiste, nomArtiste: nomArtiste, description: description, idCategorie: idCategorie, idArrondissement: idArrondissement, droitsAdmin: droitsAdmin}, 
            function(reponse){

            var msgErreurs = jQuery.parseJSON(reponse);//Messages d'erreurs de la requêtes encodés au format Json.

            if (msgErreurs.length == 0) {//Si aucune erreur...
                
                document.getElementById("descriptionAjout").value = "";
                document.getElementById("selectCategorie").value = "";
                document.getElementById("selectArrondissement").value = "";
                document.getElementById("adresseAjout").value = "";
                document.getElementById("titreAjout").value = "";
                document.getElementById("prenomArtisteAjout").value = "";
                document.getElementById("nomArtisteAjout").value = "";
                
                $("#msgAjout").html("<span style='color:green'>Oeuvre ajoutée !</span>");
            }
            else {//Sinon indique les erreurs à l'utilisateur.
                $(msgErreurs).each(function(index, valeur) {
                    if (valeur.errRequeteAjout) {
                        $("#msgAjout").html(valeur.errRequeteAjout);
                    }
                    if (valeur.errTitre) {
                        $("#erreurTitreOeuvre").html(valeur.errTitre);
                    }
                    if (valeur.errAdresse) {
                        $("#erreurAdresseOeuvre").html(valeur.errAdresse);
                    }
                    if (valeur.errDescription) {
                        $("#erreurDescription").html(valeur.errDescription);
                    }
                    if (valeur.errCategorie) {
                        $("#erreurSelectCategorie").html(valeur.errCategorie);
                    }
                    if (valeur.errArrondissement) {
                        $("#erreurSelectArrondissement").html(valeur.errArrondissement);
                    }
                })
            }
            if (document.getElementById("fileToUpload").value != "") {//Si l'utilisateur a soumis un fichier photo...
                //Nouvelle requête Ajax pour connaître l'id de la nouvelle oeuvre créée.
                $.post('ajaxControler.php?rAjax=recupererIdOeuvre', {titre: titre, adresse: adresse}, 
                    function(idOeuvre){

                        //Soumission Ajax de la photo une fois la création de l'oeuvre complétée et l'id de l'oeuvre connue.
                        var fd = new FormData();
                        fd.append( 'fileToUpload', $('#fileToUpload')[0].files[0]);

                        $.ajax({
                            url: 'ajaxControler.php?rAjax=ajouterPhoto&idOeuvre='+idOeuvre+'&admin='+droitsAdmin,
                            data: fd,
                            processData: false,
                            contentType: false,
                            type: 'POST',
                            success: function(msgErreurs){

                                if (msgErreurs != "") {//Si erreur avec l'insertion de la photo...
                                    $("#erreurPhoto").html(msgErreurs);
                                }
                                else {
                                    document.getElementById("fileToUpload").value = "";
                                }
                            }
                        });
                });
            }
        });
    }
    return false;//Retourne toujours false pour que le formulaire ne soit pas soumit.
}

/**
* @brief Fonction de validation de suppresion d'une oeuvre. Soumet la requête en Ajax si aucune erreur et transmet les erreurs, le cas échéant.
* @access public
* @return boolean
*/
function valideSupprimerOeuvre() {
    
    var erreurs = false;
    var idOeuvre = document.getElementById("selectOeuvreSupp").value;
    document.getElementById("msgSupp").innerHTML = "";
    
    //-----------------------------------------
    //Réinitialisation des messgages d'erreur.
    document.getElementById("erreurSelectSuppression").innerHTML = "";
    
    //-----------------------------------------
    //Validation des champs.
    if (idOeuvre == "") {
        document.getElementById("erreurSelectSuppression").innerHTML = "Veuillez choisir une option";
        erreurs = true;
    }
    
    //-----------------------------------------
    //Requête AJAX si aucune erreur.
    if (!erreurs) {
        $.post('ajaxControler.php?rAjax=supprimerOeuvre', {idOeuvre: idOeuvre}, 
            function(reponse){

                var msgErreurs = jQuery.parseJSON(reponse);//Messages d'erreurs de la requêtes encodés au format Json.

                if (msgErreurs.length == 0) {//Si aucune erreur...
                    document.getElementById("selectOeuvreSupp").value = "";

                    $("#msgSupp").html("<span style='color:green'>Oeuvre supprimée !</span>");

                    //Requête Ajax pour récupérer les oeuvres de la BDD afin de mettre le select à jour.
                    $.post('ajaxControler.php?rAjax=recupererOeuvres', 
                        function(reponse){

                        var oeuvres = jQuery.parseJSON(reponse);
                        var options = "<option value=''>choisir une oeuvre</option>";

                        $(oeuvres).each(function(index, oeuvre) {
                            options += '<option value="' + oeuvre.idOeuvre + '">' + oeuvre.titre + '</option>';
                        })
                        $("#selectOeuvreSupp").html(options);
                    });
                }
                else {//Sinon indique les erreurs à l'utilisateur.
                    $(msgErreurs).each(function(index, valeur) {
                        if (valeur.errRequeteSupp) {
                            $("#msgSupp").html(valeur.errRequeteSupp);
                        }
                        if (valeur.errSelectOeuvreSupp) {
                            $("#erreurSelectSuppression").html(valeur.errSelectOeuvreSupp);
                        }
                    })
                }
        });
    }
    return false;//Retourne toujours false pour que le formulaire ne soit pas soumit.
}

/**
* @brief Fonction de validation de modification d'une oeuvre. Soumet la requête en Ajax si aucune erreur et transmet les erreurs, le cas échéant.
* @access public
* @return boolean
*/
function valideModifierOeuvre() {
    
    var erreurs = false;
    var titre = document.getElementById("titreModif").value.trim();
    var adresse = document.getElementById("adresseModif").value.trim();
    var description = document.getElementById("descriptionModif").value.trim();
    var idCategorie = document.getElementById("selectCategorieModif").value;
    var idArrondissement = document.getElementById("selectArrondissementModif").value;
    var idOeuvre = document.getElementById("selectOeuvreModif").value;
    
    document.getElementById("erreurTitreOeuvreModif").innerHTML = "";
    document.getElementById("erreurAdresseOeuvreModif").innerHTML = "";
    document.getElementById("erreurDescriptionModif").innerHTML = "";
    document.getElementById("erreurSelectCategorieModif").innerHTML = "";
    document.getElementById("erreurSelectArrondissementModif").innerHTML = "";
    document.getElementById("msgModif").innerHTML = "";

    if (titre == "") {
        document.getElementById("erreurTitreOeuvreModif").innerHTML = "Veuillez entrer le titre";
        erreurs = true;
    }
    if (adresse == "") {
        document.getElementById("erreurAdresseOeuvreModif").innerHTML = "Veuillez entrer l'adresse";
        erreurs = true;
    }

    if (description == "") {
        document.getElementById("erreurDescriptionModif").innerHTML = "Veuillez entrer une description";
        erreurs = true;
    }

    if (idCategorie == "") {
        document.getElementById("erreurSelectCategorieModif").innerHTML = "Veuillez choisir une catégorie";
        erreurs = true;
    }

    if (idArrondissement == "") {
        document.getElementById("erreurSelectArrondissementModif").innerHTML = "Veuillez choisir un arrondissement";
        erreurs = true;
    }
    
    //-----------------------------------------
    //Requête AJAX si aucune erreur.
    if (!erreurs) {

        $.post('ajaxControler.php?rAjax=modifierOeuvre', {idOeuvre: idOeuvre, titre: titre, adresse: adresse, description: description, idCategorie: idCategorie, idArrondissement: idArrondissement}, 
            function(reponse){

                var msgErreurs = jQuery.parseJSON(reponse);//Messages d'erreurs de la requêtes encodés au format Json.

                if (msgErreurs.length == 0) {//Si aucune erreur...
                    document.getElementById("titreModif").value = "";
                    document.getElementById("adresseModif").value = "";
                    document.getElementById("descriptionModif").value = "";
                    document.getElementById("selectCategorieModif").value = "";
                    document.getElementById("selectArrondissementModif").value = "";
                    document.getElementById("selectOeuvreModif").value = "";
                    $('#formModif').html('');

                    $("#msgModif").html("<span style='color:green'>Oeuvre modifiée !</span>");
                }
                else {//Sinon indique les erreurs à l'utilisateur.
                    $(msgErreurs).each(function(index, valeur) {
                        if (valeur.errRequeteAjout) {
                            $("#msgModif").html(valeur.errRequeteAjout);
                        }
                        if (valeur.errTitre) {
                            $("#erreurTitreOeuvreModif").html(valeur.errTitre);
                        }
                        if (valeur.errAdresse) {
                            $("#erreurAdresseOeuvreModif").html(valeur.errAdresse);
                        }
                        if (valeur.errDescription) {
                            $("#erreurDescriptionModif").html(valeur.errDescription);
                        }
                        if (valeur.errCategorie) {
                            $("#erreurSelectCategorieModif").html(valeur.errCategorie);
                        }
                        if (valeur.errArrondissement) {
                            $("#erreurSelectArrondissementModif").html(valeur.errArrondissement);
                        }
                    })
                }
        });
    }
    return false;//Retourne toujours false pour que le formulaire ne soit pas soumit.
}

/**
* @brief Fonction de validation de l'ajout d'une catégorie. Soumet la requête en Ajax si aucune erreur et transmet les erreurs, le cas échéant.
* @access public
* @return boolean
*/
function valideAjoutCategorie() {
    
    var erreurs = false;
    var categorieFr, categorieEn;
    
    //-----------------------------------------
    //Réinitialisation des messgages d'erreur.

    document.getElementById("erreurAjoutCategorieFR").innerHTML = "";
    document.getElementById("erreurAjoutCategorieEN").innerHTML = "";
    document.getElementById("msgAjoutCat").innerHTML = "";
    
    //-----------------------------------------
    //Validation des champs.
    categorieFr = document.getElementById("categorieFrAjout").value.trim();
    if (categorieFr == "") {
        document.getElementById("erreurAjoutCategorieFR").innerHTML = "Veuillez inscrire le nom de la catégorie en français";
        erreurs = true;
    }
    
    categorieEn = document.getElementById("categorieEnAjout").value.trim();
    if (categorieEn == "") {
        document.getElementById("erreurAjoutCategorieEN").innerHTML = "Veuillez inscrire le nom de la catégorie en anglais";
        erreurs = true;
    }
    //-----------------------------------------
    //Requête AJAX si aucune erreur.
    if (!erreurs) {
        $.post('ajaxControler.php?rAjax=ajouterCategorie', {categorieFr: categorieFr, categorieEn: categorieEn}, 
            function(reponse){

                var msgErreurs = jQuery.parseJSON(reponse);//Messages d'erreurs de la requêtes encodés au format Json.

                if (msgErreurs.length == 0) {//Si aucune erreur...
                    document.getElementById("categorieFrAjout").value = "";
                    document.getElementById("categorieEnAjout").value = "";
                    $("#msgAjoutCat").html("<span style='color:green'>Catégorie ajoutée !</span>");
                }
                else {//Sinon indique les erreurs à l'utilisateur.
                    $(msgErreurs).each(function(index, valeur) {
                        if (valeur.errRequeteAjoutCat) {
                            $("#msgAjoutCat").html(valeur.errRequeteAjoutCat);
                        }
                        if (valeur.errAjoutCategorieFR) {
                            $("#erreurAjoutCategorieFR").html(valeur.errAjoutCategorieFR);
                        }
                        if (valeur.errAjoutCategorieEN) {
                            $("#erreurAjoutCategorieEN").html(valeur.errAjoutCategorieEN);
                        }
                    })
                }
        });
    }
    return false;//Retourne toujours false pour que le formulaire ne soit pas soumit.
}

/**
* @brief Fonction de validation de suppresion d'une catégorie. Soumet la requête en Ajax si aucune erreur et transmet les erreurs, le cas échéant.
* @access public
* @return boolean
*/
function valideSuppCategorie() {
    
    var erreurs = false;
    var idCategorie;
    
    //-----------------------------------------
    //Réinitialisation des messgages d'erreur.
    document.getElementById("erreurSelectSuppCategorie").innerHTML = "";    
    document.getElementById("msgSuppCat").innerHTML = "";

    //-----------------------------------------
    //Validation des champs.
    idCategorie = document.getElementById("selectCategorieSupp").value;
    if (idCategorie == "") {
        document.getElementById("erreurSelectSuppCategorie").innerHTML = "Veuillez choisir une catégorie à supprimer";
        erreurs = true;
    }
    
    //-----------------------------------------
    //Requête AJAX si aucune erreur.
    if (!erreurs) {
        $.post('ajaxControler.php?rAjax=supprimerCategorie', {idCategorie: idCategorie}, 
            function(reponse){

                var msgErreurs = jQuery.parseJSON(reponse);//Messages d'erreurs de la requêtes encodés au format Json.

                if (msgErreurs.length == 0) {//Si aucune erreur...
                    document.getElementById("selectCategorieSupp").value = "";

                    $("#msgSuppCat").html("<span style='color:green'>Catégorie supprimée !</span>");

                    //Requête Ajax pour récupérer les catégories de la BDD afin de mettre le select à jour.
                    $.post('ajaxControler.php?rAjax=recupererCategories', 
                        function(reponse){

                        var categories = jQuery.parseJSON(reponse);
                        var options = "<option value=''>choisir une catégorie</option>";
                        var langue = getCookie("langue");

                        //Choix du contenu du select en fonction de la langue
                        if (langue == "FR") {
                            $(categories).each(function(index, categorie) {
                                options += '<option value="' + categorie.idCategorie + '">' + categorie.nomCategorieFR + '</option>';
                            })
                        }
                        else if (langue = "EN") {
                            $(categories).each(function(index, categorie) {
                                options += '<option value="' + categorie.idCategorie + '">' + categorie.nomCategorieEN + '</option>';
                            })
                        }

                        $("#selectCategorieSupp").html(options);
                    });
                }
                else {//Sinon indique les erreurs à l'utilisateur.
                    $(msgErreurs).each(function(index, valeur) {
                        if (valeur.errSelectCategorieSupp) {
                            $("#erreurSelectSuppCategorie").html(valeur.errSelectCategorieSupp);
                        }
                        if (valeur.errRequeteSuppCat) {
                            $("#msgSuppCat").html(valeur.errRequeteSuppCat);
                        }
                    })
                }
        });
    }    
    return false;//Retourne toujours false pour que le formulaire ne soit pas soumit.
}

/**
* @brief Fonction de validation d'ajout commentaire oeuvre
* @access public
* @return boolean
*/
function valideAjoutCommentaireOeuvre() {
    var erreurs = false;
    document.getElementById("erreurCommentaire").innerHTML = "";
    if (document.getElementById("commentaireAjout").value.trim() == "") {
        document.getElementById("erreurCommentaire").innerHTML = "Veuillez entrer un commentaire";
        erreurs = true;
    }
    return (!erreurs);
}
/**
* @brief Fonction de validation d'ajout d'un nouveau utilisateur
* @access public
* @return boolean
*/
function validerFormAjoutUtilisateur(){
     var erreurs = false;
     var msg = "";
    document.getElementById("erreurNomUsager").innerHTML = "";
    document.getElementById("erreurMotPasse").innerHTML = "";
    document.getElementById("erreurPrenom").innerHTML = "";
    document.getElementById("erreurNom").innerHTML = "";
    document.getElementById("erreurCourriel").innerHTML = "";
    


    if (document.getElementById("nomUsager").value.trim() == "") {
        document.getElementById("erreurNomUsager").innerHTML = "Veuillez choisir un nom usager";
        erreurs = true;
    }

    if (document.getElementById("motPasse").value.trim() == "") {
        document.getElementById("erreurMotPasse").innerHTML = "Veuillez ecrire un mot de passe.";
        erreurs = true;
    }

    if (document.getElementById("prenom").value.trim() == "") {
        document.getElementById("erreurPrenom").innerHTML = "Veuillez entrer votre prenom";
        erreurs = true;
    }

    if (document.getElementById("nom").value == "") {
        document.getElementById("erreurNom").innerHTML = "Veuillez entrer votre nom de famille";
        erreurs = true;
    }

    if (document.getElementById("courriel").value == "") {
        document.getElementById("erreurCourriel").innerHTML = "Veuillez entrer votre courriel";
        erreurs = true;
    }else if(!document.getElementById("courriel").value == ""){
        var courriel = document.getElementById("courriel").value;
        var regex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
        if(!regex.test(courriel)){
            document.getElementById("erreurCourriel").innerHTML = "Veuillez entrer un adresse courriel valide.";
            erreurs = true;
        }
    }

    document.getElementById("msg").innerHTML = msg;
    return (!erreurs);
}
/* --------------------------------------------------------------------
========================== FIN VALIDATION JS ==========================
-------------------------------------------------------------------- */
/**
* @brief Fonction qui mets à jour les oeuvres de la BDD avec les oeuvres de la ville et mets à jour l'affichage dans la page de gestion.
* @access public
* @return void
*/
function updateOeuvresVille() {
    
    $("#msgUpdateDate").html("<span style='color:green'>En traitement...</span>");
    
    $.post('ajaxControler.php?rAjax=updateOeuvresVille',
        function(reponse){

            var msgErreurs = jQuery.parseJSON(reponse);//Messages d'erreurs de la requêtes encodés au format Json.

            if (msgErreurs.length == 0) {//Si aucune erreur...

                $("#msgUpdateDate").html("<span style='color:green'>Mise à jour complétée !</span>");

                //Récupération de la nouvelle date de mise à jour.
                $.post('ajaxControler.php?rAjax=updateDate',
                    function(reponse){
                        var tableauDate = jQuery.parseJSON(reponse);

                        var date = "Dernière mise à jour : Le " + tableauDate["dateDernierUpdate"] + " à " + tableauDate["heureDernierUpdate"];
                        $("#affichageDate").html(date);
                    });
            }
            else {//Sinon indique les erreurs à l'utilisateur.
                $(msgErreurs).each(function(index, valeur) {
                    if (valeur.errUrl) {
                        $("#msgUpdateDate").html(valeur.errUrl);
                    }
                })
            }
    });
    return false;
}

/**
* @brief Fonction qui affiche le formulaire de modification d'une oeuvre après sélection de l'oeuvre à modifier par l'utilisateur.
* @access public
* @return void
*/
function afficherFormModif() {
    
    var idOeuvre = document.getElementById("selectOeuvreModif").value;
    if (idOeuvre != "") {
        
        $.post('ajaxControler.php?rAjax=afficherFormModif', {idOeuvre: idOeuvre}, 
            function(reponse){
                $('#formModif').html(reponse);
        });
    }
    else {
        $('#formModif').html('');
    }
    
}
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

//methode pour monter le formulaire login
function montrer_form() {
    document.getElementById('div_bgform').style.display = "block";
    document.getElementById('div_form').style.display = "block";
}
//methode pour cacher le formulaire
function fermer(){
    document.getElementById('div_bgform').style.display = "none";
    document.getElementById('div_form').style.display = "none";
}

//methode pour cacher le formulaire
function fermerApprob(){
    document.getElementById('bgPanneauApprobation').style.display = "none";
    document.getElementById('panneauApprobation').style.display = "none";
}

//formulaire de la vueAdmin qui permet d'afficher le formulaire pour authoriser les photos non-autorisés
function formRevisionPhotos(idPhoto){
    var idPhoto = idPhoto;
    document.getElementById('formRevisionPhotos').style.display = "block";
    document.getElementById('formRevisionPhotos').innerHTML="<form action='#' id='formRevisionPhoto' method='post' name='formRevisionPhoto'><button id='fermer' onclick ='fermer()'>X</button><h3>Id Image:</h3><p>Adresse Oeuvre</p><img src='<?php $photoAffiche = $this->$photoAReviser['image']?>'><input id='insererPhoto' name='insererPhoto' type='submit' onclick='fermer()' value='Insérer'><input id='suprimmerPhoto' name='suprimmerPhoto' type='submit' onclick='fermer()' value='Suprimmer'></form>";
}

/**
* @brief Fonction qui récupère la valeur d'un cookie selon le nom passé en paramètre
* @access public
* @return void
* @author W3Schools
*/
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
}

/**
* @brief Fonction qui récupère l'oeuvre choisie et affiche son contenu dans un panneau de style pop-up
* @access public
* @param idOeuvre integer
* @return void
*/
function afficherOeuvrePourApprobation(idOeuvre) {
    
    $.post('ajaxControler.php?rAjax=recupererUneOeuvre', {idOeuvre:idOeuvre},
        function(reponse){
        var oeuvre = jQuery.parseJSON(reponse);
        var langue = getCookie("langue");
        var contenu = "";
        var type = "\"oeuvre\"";
        var id = idOeuvre;
        
        contenu += "<button id='fermer' onclick ='fermerApprob()'>X</button>";
        contenu += "<div id='divPanneauApprobation'>";
        contenu += "<h2>Oeuvre soumise</h2>";
        contenu += "<p>Titre : <span style='color:green'>" + oeuvre.titre + "</span><br>";
        contenu += "Adresse : <span style='color:green'>" + oeuvre.adresse + "</span><br>";
        contenu += "Description en anglais : <span style='color:green'>" + oeuvre.descriptionFR + "</span><br>";
        contenu += "Description en français : <span style='color:green'>" + oeuvre.descriptionEN + "</span><br>";
        contenu += "Arrondissement : <span style='color:green'>" + oeuvre.nomArrondissement + "</span><br>";
        if (langue == "FR") {
            contenu += "Catégorie : <span style='color:green'>" + oeuvre.nomCategorieFR + "</span><br>";
        }
        else if (langue == "EN") {
            contenu += "Catégorie : <span style='color:green'>" + oeuvre.nomCategorieEN + "</span><br>";
        }
        if (oeuvre.prenomArtiste == null) {
            contenu += "Prénom de l'artiste :<br>";
        }
        else {
            contenu += "Prénom de l'artiste : <span style='color:green'>" + oeuvre.prenomArtiste + "</span><br>";
        }
        if (oeuvre.nomArtiste == null) {
            contenu += "Nom de l'artiste :<br>";
        }
        else {
            contenu += "Nom de l'artiste : <span style='color:green'>" + oeuvre.nomArtiste + "</span><br>";
        }
        contenu += "</p>";
        contenu += "<input class='boutonHover boutonRefuser' type='button' name='boutonRefuserSoumission' value='Refuser' onclick ='refuserSoumissions(" + type + ", " + id + ")'>";
        contenu += "<input class='boutonHover boutonAccepter' type='button' name='boutonAccepterSoumission' value='Accepter' onclick ='accepterSoumissions(" + type + ", " + id + ")'>";
        contenu += "<div id='msgErreurApprobation'></div>";
        contenu += "</div>";
        
        document.getElementById('bgPanneauApprobation').style.display = "block";
        document.getElementById('panneauApprobation').style.display = "block";
        document.getElementById("panneauApprobation").innerHTML = contenu;
    });
}

/**
* @brief Fonction qui récupère la photo choisie et affiche son contenu dans un panneau de style pop-up
* @access public
* @param idPhoto integer
* @return void
*/
function afficherPhotoPourApprobation(idPhoto) {
    
    $.post('ajaxControler.php?rAjax=recupererUnePhoto', {idPhoto:idPhoto},
        function(reponse){
        var photo = jQuery.parseJSON(reponse);
        var contenu = "";
        var type = "\"photo\"";
        var id = idPhoto;
        
        contenu += "<button id='fermer' onclick ='fermerApprob()'>X</button>";
        contenu += "<div id='divPanneauApprobation'>";
        contenu += "<h2>Photo soumise</h2>";
        contenu += "<img src='../" + photo.image + "' alt='photoSoumise'></span><br>";
        contenu += "<input class='boutonHover boutonRefuser' type='button' name='boutonRefuserSoumission' value='Refuser' onclick ='refuserSoumissions(" + type + ", " + id + ")'>";
        contenu += "<input class='boutonHover boutonAccepter' type='button' name='boutonAccepterSoumission' value='Accepter' onclick ='accepterSoumissions(" + type + ", " + id + ")'>";
        contenu += "<div id='msgErreurApprobation'></div>";
        contenu += "</div>";
        
        document.getElementById('bgPanneauApprobation').style.display = "block";
        document.getElementById('panneauApprobation').style.display = "block";
        document.getElementById("panneauApprobation").innerHTML = contenu;
    });
}

/**
* @brief Fonction qui récupère la photo choisie et affiche son contenu dans un panneau de style pop-up
* @access public
* @param idPhoto integer
* @return void
*/
function afficherCommentairePourApprobation(idCommentaire) {
    
    $.post('ajaxControler.php?rAjax=recupererUnCommentaire', {idCommentaire:idCommentaire},
        function(reponse){
        var commentaire = jQuery.parseJSON(reponse);
        var contenu = "";
        var type = "\"commentaire\"";
        var id = idCommentaire;
        
        contenu += "<button id='fermer' onclick ='fermerApprob()'>X</button>";
        contenu += "<div id='divPanneauApprobation'>";
        contenu += "<h2>Commentaire soumis</h2>";
        contenu += "<p>" + commentaire.texteCommentaire + "</p>";
        contenu += "<input class='boutonHover boutonRefuser' type='button' name='boutonRefuserSoumission' value='Refuser' onclick ='refuserSoumissions(" + type + ", " + id + ")'>";
        contenu += "<input class='boutonHover boutonAccepter' type='button' name='boutonAccepterSoumission' value='Accepter' onclick ='accepterSoumissions(" + type + ", " + id + ")'>";
        contenu += "</div id='msgErreurApprobation'></div>";
        contenu += "</div>";
        
        document.getElementById('bgPanneauApprobation').style.display = "block";
        document.getElementById('panneauApprobation').style.display = "block";
        document.getElementById("panneauApprobation").innerHTML = contenu;
    });
}

/**
* @brief Fonction qui accepte une soumission et recharge la liste des soumissions à authoriser
* @param type string
* @param id integer
* @access public
* @return void
*/
function accepterSoumissions(type, id) {

    switch (type) {
        case "oeuvre":
            var requete = "accepterSoumissionOeuvre";
            break;
        case "photo":
            var requete = "accepterSoumissionPhoto";
            break;
        case "commentaire":
            var requete = "accepterSoumissionCommentaire";
            break;
    }
    
    $.post('ajaxControler.php?rAjax=' + requete, {id: id},
        function(reponse){
        
        var msgErreurs = jQuery.parseJSON(reponse);//Messages d'erreurs de la requêtes encodés au format Json.

        if (msgErreurs.length == 0) {//Si aucune erreur...

            rechargerOeuvresApprob();
            rechargerPhotosApprob();
            rechargerCommentairesApprob();
        }
        else {//Sinon indique les erreurs à l'utilisateur.
            $(msgErreurs).each(function(index, valeur) {
                console.log(valeur.errRequeteApprob);
                if (valeur.errRequeteApprob) {
                    $("#msgErreurApprobation").html(valeur.errRequeteApprob);
                }
            })
        }
    });
}

/**
* @brief Fonction qui refuse/supprime une soumission et recharge la liste des soumissions à authoriser
* @param type string
* @param id integer
* @access public
* @return void
*/
function refuserSoumissions(type, id) {

    switch (type) {
        case "oeuvre":
            var requete = "refuserSoumissionOeuvre";
            break;
        case "photo":
            var requete = "refuserSoumissionPhoto";
            break;
        case "commentaire":
            var requete = "refuserSoumissionCommentaire";
            break;
    }
    
    $.post('ajaxControler.php?rAjax=' + requete, {id: id},
        function(reponse){
        
        var msgErreurs = jQuery.parseJSON(reponse);//Messages d'erreurs de la requêtes encodés au format Json.

        if (msgErreurs.length == 0) {//Si aucune erreur...
            
            rechargerOeuvresApprob();
            rechargerPhotosApprob();
            rechargerCommentairesApprob();
        }
        else {//Sinon indique les erreurs à l'utilisateur.
            $(msgErreurs).each(function(index, valeur) {
                if (valeur.errRequeteSupp) {
                    $("#msgErreurApprobation").html(valeur.errRequeteSupp);
                }
            })
        }
    });
}

/**
* @brief Fonction qui mets à jour dans la page gestion la liste des oeuvres à approuver
* @param type string
* @param id integer
* @access public
* @return void
*/
function rechargerOeuvresApprob() {
    $.post('ajaxControler.php?rAjax=updateLiensApprobOeuvres', 
        function(reponse){

        var soumissions = jQuery.parseJSON(reponse);
        var oeuvresApprob = "";

        for (var i = 1; i <= soumissions.length; i++) {
            oeuvresApprob += '<a href="#"; onclick="afficherOeuvrePourApprobation(' + soumissions[i-1]['idOeuvre'] + ')">Oeuvre ' + i + ' <span>Soumise le ' + soumissions[i-1]['dateSoumissionOeuvre'] + '</span></a>';
        }
        $("#contenuSoumissionOeuvres").html(oeuvresApprob);
        $("#nbOeuvresEnAttente").html("En attente : " + soumissions.length);
        fermerApprob();
    });
}

/**
* @brief Fonction qui mets à jour dans la page gestion la liste des photos à approuver
* @param type string
* @param id integer
* @access public
* @return void
*/
function rechargerPhotosApprob() {
    $.post('ajaxControler.php?rAjax=updateLiensApprobPhotos', 
        function(reponse){

        var soumissions = jQuery.parseJSON(reponse);
        var photosApprob = "";

        for (var i = 1; i <= soumissions.length; i++) {
            photosApprob += '<a href="#"; onclick="afficherPhotoPourApprobation(' + soumissions[i-1]['idPhoto'] + ')">Photo ' + i + ' <span>Soumise le ' + soumissions[i-1]['dateSoumissionPhoto'] + '</span></a>';
        }
        $("#contenuSoumissionPhotos").html(photosApprob);
        $("#nbPhotosEnAttente").html("En attente : " + soumissions.length);
        fermerApprob();
    });
}

/**
* @brief Fonction qui mets à jour dans la page gestion la liste des commentaires à approuver
* @param type string
* @param id integer
* @access public
* @return void
*/
function rechargerCommentairesApprob() {
    $.post('ajaxControler.php?rAjax=updateLiensApprobCommentaires', 
        function(reponse){

        var soumissions = jQuery.parseJSON(reponse);
        var commentairesApprob = "";

        for (var i = 1; i <= soumissions.length; i++) {
            commentairesApprob += '<a href="#"; onclick="afficherCommentairePourApprobation(' + soumissions[i-1]['idCommentaire'] + ')">Commentaire ' + i + ' <span>Soumise le ' + soumissions[i-1]['dateSoumissionCommentaire'] + '</span></a>';
        }
        $("#contenuSoumissionCommentaires").html(commentairesApprob);
        $("#nbCommentairesEnAttente").html("En attente : " + soumissions.length);
        fermerApprob();
    });
}