<?php
	session_start();

	$urlRedirection = 'Location: ../index.php';

	if(isset($_SESSION['user'])){

		// Récupérer les informations dans la session de l'utilisateur.
		require_once(__DIR__.'/../model/Membre.class.php');
		$nouveau = unserialize($_SESSION['user']);
	
		require_once('checkForm.class.php');

		if(isset($_POST['inputFirstname6']) && isset($_POST['inputName6']) && isset($_POST['inputPseudo6']) && isset($_POST['inputEmail6']) && isset($_POST['inputCity6']) && isset($_POST['inputSexe6']) && isset($_POST['bdaymonth']) && isset($_POST['inputLanguage'])/* && isset($_POST['comment'])*/){

			$nom = $_POST['inputName6'];
			$prenom = $_POST['inputFirstname6'];
			$pseudo = $_POST['inputPseudo6'];
			$email = $_POST['inputEmail6'];
			$city = $_POST['inputCity6'];
			$sexe = $_POST['inputSexe6'];
			$anniv = $_POST['bdaymonth'];
			$langue = $_POST['inputLanguage'];
			//$commentaire = $_POST['comment'];

			// Controler la validité du formulaire avant l'inscription en BD.
			$valideForm = 0;

			// 
			if(!empty($email)){
				if(!checkForm::valideEmail($email)){
					$valideForm++;
				} else {
					$nouveau->setMail($email);
				}
			}
			
			// Valider la date
			if(!empty($anniv)){
				if(!checkForm::valideDate($anniv)){
					$valideForm++;
				} else {
					$nouveau->setAnniversaire($anniv);
				}
			}

			// Nom
			if(!empty($nom)){
				if(!checkForm::valideTexte($nom)){
					$valideForm++;
				} else {
					$nouveau->setNom($nom);
				}
			}

			// Prénom
			if(!empty($prenom)){
				if(!checkForm::valideTexte($prenom)){
					$valideForm++;
				} else {
					$nouveau->setPrenom($prenom);
				}
			}

			// Pseudo
			if(!empty($pseudo)){
				if(!checkForm::valideTexte($pseudo)){
					$valideForm++;
				} else {
					$nouveau->setPseudo($pseudo);
				}
			}

			// Ville
			if(!empty($city)){
				if(!checkForm::valideTexte($city)){
					$valideForm++;
				} else {
					$nouveau->setAdresse($city);
				}
			}

			$_SESSION['user'] = serialize($nouveau);

			// Enregistrement des modifications.
			if($valideForm == 0){

				$nouveau->setType($sexe);				
				$nouveau->setLangue($langue);

				require_once(__DIR__.'/../dao/MembreDAO.class.php');
				$enregistrerMembre = new MembreDAO();
				$res = $enregistrerMembre->miseAJourMembre($nouveau);
				if($res == 1){

					// MAJ du profil réussi.
					$urlRedirection = 'Location: ../home.php';

				} else {

					// Echec requête SQL.
					$_SESSION['erreur'] = '<div id="erreur">Echec de l\'enregistrement</div>';
					$urlRedirection = 'Location: ../view/update_profil.php';
				}

			} else {

				// Formulaire invalide.
				$_SESSION['erreur'] = '<div id="erreur">Formulaire invalide</div>';
				$urlRedirection = 'Location: ../view/update_profil.php';
			}

		} else {

			// Si le formulaire n'a pas été utilisé.
			$urlRedirection = 'Location: ../home.php';
		}
	}
	
	header($urlRedirection);
	exit();