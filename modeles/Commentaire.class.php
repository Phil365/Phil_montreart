<?php
/**
 * @file Commentaire.class.php
 * @brief class Commentaire
 * @author David Lachambre
 * @version 0.1
 * @update 2015-12-13
 */
class Commentaire {
    
    /**
    * @var integer id du commentaire
    */
    private $id;
    
    private $texte;
    private $vote;
    private $langue;
    private $authorise;

    /**
    * @var BaseDeDonnee Objet base de données qui permet la connexion.
    */
    private static $database;
    
	function __construct() {
		
        if (!isset(self::$database)) {
            
            self::$database = new BaseDeDonnees();
        }
	}
	
	function __destruct() {
		
	}
    
    /**
    * @brief Méthode qui assigne des valeurs aux propriétés du commentaire
    * @param integer $id
    * @param string $texte
    * @param integer $vote
    * @param string $langue
    * @param boolean $authorise
    * @return Void
    */
    public function setData($id, $texte, $vote, $langue, $authorise) {
        
		$this->id = $id;
		$this->texte = $texte;
		$this->vote = $vote;
		$this->langue = $langue;
		$this->authorise = $authorise;
	}
		
	/**
    * @brief méthode qui récupère les valeurs des propriétés de cet objet.
    * @access public
    * @return Array
    */
	public function getData() {
        
        $resutlat = ["id"=>$this->id, "texte"=>$this->texte, "vote"=>$this->vote, "langue"=>$this->langue, "authorise"=>$this->authorise];
        
        return $resutlat;
	}
    
    /**
    * @brief méthode qui récupère tous les commentaires associés à une oeuvre.
    * @param $id integer
    * @param $langue string
    * @access public
    * @return Array
    */
    public function getCommentairesByOeuvre($idOeuvre, $langue) {
        
        $infoCommentaires = [];
        
        self::$database->query('SELECT * FROM Commentaires JOIN Utilisateurs ON Utilisateurs.idUtilisateur = Commentaires.idUtilisateur WHERE Commentaires.idOeuvre = :id AND Commentaires.authorise = true AND Commentaires.langueCommentaire = :langue');
        
        //Lie les paramètres aux valeurs
        self::$database->bind(':id', $idOeuvre);
        self::$database->bind(':langue', $langue);
        
        if ($commentairesBDD = self::$database->resultset()) {
            foreach ($commentairesBDD as $commentaire) {
                $unCommentaire = ["texteCommentaire"=>$commentaire["texteCommentaire"], "voteCommentaire"=>$commentaire["voteCommentaire"], "nomUsager"=>$commentaire["nomUsager"], "photoProfil"=>$commentaire["photoProfil"]];
                $infoCommentaires[] = $unCommentaire;
            }
        }
        return $infoCommentaires;
    }
}
?>