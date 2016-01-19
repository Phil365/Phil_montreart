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

 function validePhotoSubmit()
{
if (document.getElementById("fileToUpload").files.length == 0 )
    {alert("Ne peux pas etre vide");
        return false;
   } // end if  
   
   
   
   return true;
} // end function validateForm


function autoComplete(rechercheVoulue)
{
console.log(rechercheVoulue);
var MIN_LENGTH = 1;
    
var url =  "auto-complete.php?rechercheVoulue=";

$( document ).ready(function() {
	$("#keyword").keyup(function() {
		var keyword = $("#keyword").val();
		if (keyword.length >= MIN_LENGTH) {
			$.get(url + rechercheVoulue, { keyword: keyword } )
			.done(function( data ) {
				$('#results').html('');
				var results = jQuery.parseJSON(data);
				$(results).each(function(key, value) {
				
                    if (rechercheVoulue=="titre") {
$('#results').append('<div class="item">' + "<a href=http://localhost:8888/origin/?r=oeuvre&o="+value['idOeuvre']+">"+value['titre']+"</a>" +'</div>');

}
                    if (rechercheVoulue=="artiste") {
$('#results').append('<div class="item">' + "<a href=http://localhost:8888/origin/?r=oeuvre&o="+value['idOeuvre']+">"+value['prenomArtiste']+"</a>" +'</div>');

}
                    if (rechercheVoulue=="categorie") {
$('#results').append('<div class="item">' + "<a href=http://localhost:8888/origin/?r=oeuvre&o="+value['idOeuvre']+">"+value['nomCategorieFR']+"</a>" +'</div>');

}
                    if (rechercheVoulue=="arrondissement") {
$('#results').append('<div class="item">' + "<a href=http://localhost:8888/origin/?r=oeuvre&o="+value['idOeuvre']+">"+value['nomCategorieFR']+"</a>" +'</div>');

}

					
					for(var key in value) {
					console.log('key: ' + key + '\n' + 'value: ' + value[key]);
					}
				})

			   

			});
		} else {
			$('#results').html('');
		}
	});

    $("#keyword").blur(function(){
    		$("#results").fadeOut(500);
    	})
        .focus(function() {		
    	    $("#results").show();
    	});

});
}