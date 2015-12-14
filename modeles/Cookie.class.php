<?php
/**
 * @file Cookie.class.php
 * @brief class Cookie
 * @author David Lachambre
 * @version 0.1
 * @update 2015-12-13
 */
class Cookie {

    private $langue;
    
	function __construct() {
    
        if (isset($_COOKIE["langue"])) {
            $this->langue = strtoupper($_COOKIE["langue"]);// Récupération de la langue du cookie.
        }
        else {
            $this->langue = "FR";//Langue par défaut.
        }
        setcookie("langue", $this->langue, time() + (60 * 60 * 24 * 365));//Crée le cookie à chaque visite de page.
	}
	
	function __destruct() {
		
	}
    
    public function getLangue() {
        return $this->langue;
    }
}
?>