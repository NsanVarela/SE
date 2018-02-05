<?php
	class Securite {
		
		// Sécuriser l'affichage des pages contre les possibles injections HTML, en provenance de la saisie de l'utilisateur.
		public static function afficherHTML($string){
			return htmlentities($string, ENT_QUOTES | ENT_HTML5, 'UTF-8');
		}


		// 
		public static function crypter($chaine){
			return md5($chaine.'4f6c49b3e31a0c');
		}


		// Sécuriser les données en provenance de l'utilisateur, à insérer dans la base de données.
		public static function injectionSQL($string){
		
			require_once(__DIR__.'../Connexion.class.php');
			$db = Connexion::getMySQLIConnexion();

			if(ctype_digit($string)){						// Test de conversion du contenu de la variable passée en paramètre vers le type numérique.
				$string = intval($string);
			} else {										// Pour tous les autres types, recherche puis neutralisation des éventuels caractères spéciaux contenus dans la variable.

				$string = $db->real_escape_string($string);
				$db->close();
				
				$string = addcslashes($string, '%_');
			}
			return $string;
		}
	}