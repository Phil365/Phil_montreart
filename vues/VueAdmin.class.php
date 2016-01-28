<?php
/**
 * @brief Class VueTrajet
 * @author Cristina Mahneke
 * @version 1.0
 * @update 2015-01-14
 * 
 */
//header('Content-Type: text/html; charset=utf-8');//Affichage du UTF-8 par PHP.

class VueAdmin extends Vue{
    
    private $photoAllUnauthorized;
    
    private $photoAReviser;
    
    private $date;
    
    /**
    * @var string $msgAjoutOeuvre Message destiné à l'utilisateur lors de la soumission
    * @access protected
    */
    protected $msgAjoutOeuvre;
    
    function __construct(){
        $this->titrePage = "MontréArt - Gestion";
        $this->descriptionPage = "La page de gestion du site MontréArt";
    }
    
    public function setData($photoAllUnauthorized) {
        
      
        $this->photoAllUnauthorized = $photoAllUnauthorized;
       //var_dump($photoAllUnauthorized);
    }
    
    
    public function setMsgAjoutOeuvre($msg) {
        
        $this->msgAjoutOeuvre = $msg;
    }
       

     /**
    * @brief Méthode qui affiche le corps du document HTML
    * @access public
    * @return void
    */
    public function afficherBody() {
    ?>
       
        <div id='div_bgform'>
            <div id='div_form'>
                <div id="formRevisionPhotos">
                    
                </div>
              
            </div>
        </div> 
        <div class="premiereColonne">
            <h2>Administration</h2>
            
            
        <form name="formadmin" id="formPhotoUnique" action="?r=admin&action=soumetAdminOeuvre" method="post">
            <input type="text" id="nomDuInputTitre" name="nomDuInputTitre">
            <input type="text" id="nomDuInputAdresse">
            <input type="text" id="nomDuInputDescription">
            <input type="text" id="nomDuSelectCategorie">
            <input type="text" id="nomDuSelectArrondissement">
    
            <span id="erreurTitreOeuvre" class="erreur"></span><br>
            <span id="erreurAdresseOeuvre" class="erreur"></span><br>
            <span id="erreurDescription" class="erreur"></span><br>
            <span id="erreurSelectCategorie" class="erreur"></span><br>
            <span id="erreurSelectArrondissement" class="erreur"></span><br>
            <span class="erreur"> <?php if (isset($this->msgAjoutOeuvre)) {echo $this->msgAjoutOeuvre;} ?></span> 
            <input class='boutonMoyenne' type="submit" value="Valider form" name="submit">
        </form>
            

            <!--<input type="submit">-->
                <div id="dateMisAJour">
                <p>Dernière mise à jour: </p>
        <?php
    $oeuvre = new Oeuvre();

    if (isset($_POST["misAJour"])) {
        //mettre les deux prochaines lignes de code dans le controleur
        $oeuvre->updaterOeuvresVille();
        $date = $oeuvre->getDateDernierUpdate();
    }
    $oeuvre->afficherTestJson();
    if (!empty($date)) {
        echo "<br>La dernière mise à jour a été effectuée le " . $date["dateDernierUpdate"] . " à " . $date["heureDernierUpdate"];
    }
        //var_dump($date);
?>
        <form action="#" method="post">
        <input type="submit" id="misAJour" name='misAJour' class="boutonMoyenne" value='Mettre à Jour' />
        </form>  

    </div>
        </div>
        <div class="deuxiemmeColonne listePhotos">
            <h3>Photos à Réviser</h3>
<form action='#' method='post' name='listePhotos' onsubmit='event.preventDefault()'>
              
                <ul>
                   <!-- <li><button type='submit' name='liPhotoId' value='5' onclick='montrer_form();formRevisionPhotos();'>ID #5</button></li>-->
          <?php
                        
                    for ($i = 0; $i < count($this->photoAllUnauthorized); $i++) {
                        
                                $idPhoto = $this->photoAllUnauthorized[$i]['idPhoto'];
                       
                                echo "<li><button type='submit' name='liPhotoId' value='$idPhoto' onclick='montrer_form();formRevisionPhotos($idPhoto);'>ID#: $idPhoto</button></li>";
                            }


        
                ?>
                </ul>
      </form> 
         </div>
        <div class="troisiemmeColonne">
            <div class="listeCommentaires">
                <h3>Commentaires à Réviser</h3>
            </div>
            <div class="listeOeuvres">
                <h3>Catalogue des Oeuvres</h3>
            </div>
        </div>    
       
   
    
        
     <?php
    }
}
?>