<?php
	// Routage entre les pages service, library profil.
	$onglet = array("", "", "");

	$page = 1;
	if(isset($_GET['p']) && is_numeric($_GET['p'])){
		$page = $_GET['p'];
	}

	// Attribution de la classe active pour la page choisie.
	switch($page) {
		case 1:
			$onglet[0] = 'current';
			break;
			
		case 2:
			$onglet[1] = 'current';
			break;
			
		case 3:
			$onglet[2] = 'current';
			break;
	}
?>
	<div id="app" class=" header position-fixed bg-dark">
		<nav class="navbar bg-dark navbar-expand-lg navbar-light bg-faded nav bg-company-red ">
			<a class="navbar-brand text-white" href="../home.php">[ SpeakEasy ]</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div id="navbarNavDropdown" class="navbar-collapse collapse">
				<ul class="navbar-nav mr-auto"></ul>
				<ul id="menu" class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link text-white <?php echo $onglet[0]; ?>" href="service.php?p=1">Service</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-white <?php echo $onglet[1]; ?>" href="library.php?p=2">Library</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-white <?php echo $onglet[2]; ?>" href="update_profil.php?p=3"><i class="fa fa-user-circle-o" aria-hidden="true"></i><?php echo " ".Securite::afficherHTML($user->getPseudo()); ?></a>
                    </li>
                    <li class="nav-item">
                    	<a href="deconnexion.php" class="nav-link text-white">Log out</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
