<?php
  /**
   * Faire l'assignation des variables ici avec les isset() ou !empty()
   */
   
   
	if(empty($_GET['r'])) {//Requête d'une page
		$_GET['r'] = '';
	}
    if(empty($_GET['o'])) {//id d'une oeuvre
		$_GET['o'] = '';
	}
    if(empty($_GET['action'])) {//id d'une oeuvre
		$_GET['action'] = '';
	}

    if(empty($_GET['typeRecherche'])) {//initialise le select de la barre de recherche
        $_GET['typeRecherche'] = '';  
    }
	if(empty($_GET['keyword'])) {//initialise les keywords de l'autocomplete
        $_GET['keyword'] = '';  
    }
    if(empty($_GET['testAutocomplete'])) {//initialise les keywords de l'autocomplete
        $_GET['testAutocomplete'] = '';  
    }
?>