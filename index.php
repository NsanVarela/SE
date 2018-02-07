<?php
	//si le visiteur a soumis le formulaire de connexion
	if (isset($_POST['connexion']) && $_POST['connexion'] == 'Connexion') {
		if ((isset($_POST['Email']) && !empty($_POST['Email'])) && (isset($_POST['Mdp']) && !empty($_POST['Mdp']))) {

			require_once(__DIR__.'/dao/Connexion.class.php');
			$base = Connexion::getMySQLIConnexion();

			require_once(__DIR__.'/dao/MembreDAO.class.php');
			$listeMembre = new MembreDAO();

			require_once('control/Securite.class.php');
			// si une entrée de la base contient le login / pass
			$user = $listeMembre->authentification($_POST['Email'], Securite::crypter($_POST['Mdp']));

			// si on obtient une réponse, alors l'utilisateur est un client2fodis
			if($user->getID() > 0) {
				$listeMembre->modifierStatut($user->getID(), 'CONNECTE');		// Modifier le statut.
				session_start();
				$_SESSION['user'] = serialize($user);
				header('Location: home.php');
				exit();
			} else {			// si on ne trouve aucune réponse, le visiteur s'est trompé soit dans son login, soit dans son mot de passe
				$erreur =  '<div id="erreur">Email ou mot de passe incorrect!</div>';				   
			}
		} else {
			$erreur = '<div id="erreur">Veuillez remplir<br> tous les champs!!!</div>';
		}
	}

	if (isset($erreur)) echo '<br /><br />',$erreur;
?>

<!DOCTYPE html>
<html>
	<head>
<?php
		// Chargement des CDN.
		require_once(__DIR__.'/view/CDN.php');
?>
		<link rel="stylesheet" type="text/css" href="view/index.css">
    	<title>Speakeasy</title>
	</head>
	<body>
		<br><br><br><br><br>
		<br><br><br>
		<div class="containerInscription">

			<a id="hovInscription" href="inscription.php">Inscription</a> 
			<a href="inscription.php"></a>		 
			<a id="hovInscription" href="mdpOublie.php">Mot depasse oublié </a>
		</div>
		<div class="row">
			<div class=" col-md-6">
				<a class="titre"> <b><font color="#b4cc83" >SPEAK</font><font color="#154854"> EASY</font></b></a><hr class="hrIndexConnexion">
			</div> 
			<div  id="form1" class="col-md-6">
				<br>
				<form class="formulaire" action="index.php" method="POST">
					<input onfocus="currentForm = this.form;" id="inputConnexion" type="text" placeholder="  Email" class="inputEmail" name="Email"  value="<?php if (isset($_POST['Email'])) echo htmlentities(trim($_POST['Email']));?>"/> <BR><BR>
				
					<input  onfocus="currentForm = this.form;" id="inputConnexion" type="password" placeholder="  Mot de passe" class="inputPass" name="Mdp" value="<?php if (isset($_POST['Mdp'])) echo htmlentities(trim($_POST['Mdp']));?>"/> <BR><BR>

					<input id="btnConnexion" type="submit" name="connexion" value="Connexion"/><br><br>
						
					<div class="formLien">
						<a id="aMDPoublie" href="view/mdpOublie.php" style="color:#b4cc83;text-decoration: none;"><u>Mot de passe oublié </u></a> 
						<a id="aSinscrire" href="view/inscription.php" style="color:#b4cc83;text-decoration: none; float: right;"><u>S'inscrire </u></a>
					</div>
					<div class="formLien800maxWidth">
						<a id="aMDPoublie" href="#" style="color:#b4cc83;text-decoration: none;"><u>Mot de passe oublié </u></a> 
						<a id="aSinscrire" href="#" style="color:#b4cc83;text-decoration: none;"><u>S'inscrire </u></a>
					</div>
				</form>
				<br>
			</div>
		</div>
	</body>
</html>