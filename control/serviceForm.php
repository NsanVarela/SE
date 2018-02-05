<?php
	require_once(__DIR__.'/../dao/MembreDAO.class.php');

	// 
	function rechercherMembreEnLigne(){
		$listeMembre = new MembreDAO();
		return $listeMembre->rechercherMembreConnecte();
		
		var_dump($requete);

		$resultat = '';
		foreach($requete as $pseudo => $value) {
			$resultat .= '<div class="row w-20">
                        	<div class="col-sm-8 col-md-3 px-0 d-flex flex-row">
                                <img src="ninja.jpg" class="rounded-circle mx-auto d-block img-fluid li-el">
                                <label class="p-2 ">'.$value.'</label>
                                <span class="fa fa-phone fa-3x text-success float-right pulse p-2 li-el" title="online now"></span>
                            </div>
                        </div>';
		}

		return $resultat;		                        
	}