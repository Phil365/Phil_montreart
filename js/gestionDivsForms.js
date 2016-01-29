
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
//formulaire de la vueAdmin qui permet d'afficher le formulaire pour authoriser les photos non-autorisés
function formRevisionPhotos(idPhoto){
    var idPhoto = idPhoto;
    document.getElementById('formRevisionPhotos').style.display = "block";
    document.getElementById('formRevisionPhotos').innerHTML="<form action='#' id='formRevisionPhoto' method='post' name='formRevisionPhoto'><button id='fermer' onclick ='fermer()'>X</button><h3>Id Image:</h3><p>Adresse Oeuvre</p><img src='<?php $photoAffiche = $this->$photoAReviser['image']?>'><input id='insererPhoto' name='insererPhoto' type='submit' onclick='fermer()' value='Insérer'><input id='suprimmerPhoto' name='suprimmerPhoto' type='submit' onclick='fermer()' value='Suprimmer'></form>";
}