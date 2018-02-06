<?php
	require_once(__DIR__.'/../dao/MembreDAO.class.php');

	// 
	function rechercherMembreEnLigne($id_Membre){
		$listeMembre = new MembreDAO();
		return $listeMembre->rechercherMembreConnecte($id_Membre);
	}