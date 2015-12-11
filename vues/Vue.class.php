<?php
/**
 * Class Vue
 * Template de classe Vue. Dupliquer et modifier pour votre usage.
 * 
 * @author Jonathan Martel
 * @version 1.0
 * @update 2013-12-11
 * @license Creative Commons BY-NC 3.0 (Licence Creative Commons Attribution - Pas d’utilisation commerciale 3.0 non transposé)
 * @license http://creativecommons.org/licenses/by-nc/3.0/deed.fr
 * 
 */


class Vue {

    public function afficheMeta() {
    ?>
    <!DOCTYPE html>
    <html lang="fr">
	<head>
		<title>MontréArt</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width">
		
		<link rel="stylesheet" href="./css/normalize.css" type="text/css" media="screen">
		<link rel="stylesheet" href="./css/base_h5bp.css" type="text/css" media="screen">
		<link rel="stylesheet" href="./css/main.css" type="text/css" media="screen">
		
		<script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
		<script src="./js/plugins.js"></script>
		<script src="./js/main.js"></script>
	</head>
    <?php
    }
    public function afficheEntete() {
    ?>
    <body>
        <header>
            <div>HEADER</div>
        </header>
    <?php
    }
	/**
	 * Affiche la page d'accueil 
	 * @access public
	 * 
	 */
	public function afficheAccueil() {
?>
	
		<article>
			<h1>MontréArt</h1>
			<p>Site en construction</p>
		</article>
		
        <div id="footer">
        </div>
	</body>
</html>

<?php	
	}
    public function affichePageOeuvre($oeuvre) {
?>        
		<article>
			<h1>Page d'une oeuvre</h1>
			<p>
            <?php
                var_dump($oeuvre->getData());
            ?>
            </p>
		</article>
		
        <div id="footer">
        </div>
<?php
    }
    public function affichePiedPage() {
    ?>
                <footer>
                    <div>FOOTER</div>
                </footer>
            </body>
        </html>
    <?php
    }
}
?>