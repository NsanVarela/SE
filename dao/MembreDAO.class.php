<?php
	require_once('Connexion.class.php');		// Connexion à la base de données.
	require_once(__DIR__.'/../model/Membre.class.php');
	
	class MembreDAO {

		private $db;
		
		/*
		 * Constructeur par défaut.
		 */
		function __construct(){
			$this->db = Connexion::getPDOConnexion();
		}
		
		/*
		 * Ajouter un nouveau membre.
		 */
		public function ajouterMembre($nouveauMembre){

			$query = $this->db->prepare('INSERT INTO user (nom, prenom, email, pseudo, dateNaissance, mdp, reponse, sexe, adresse, langue, description) VALUES (:nom, :prenom, :email, :pseudo, :dateN, :passe, :reponse, :sexe, :adresse, :langue, :description)');
			
			$query->bindValue(':nom', $nouveauMembre->getNom(), PDO::PARAM_STR);
			$query->bindValue(':prenom', $nouveauMembre->getPrenom(), PDO::PARAM_STR);
			$query->bindValue(':email', $nouveauMembre->getMail(), PDO::PARAM_STR);
			$query->bindValue(':pseudo', $nouveauMembre->getPseudo(), PDO::PARAM_STR);
			$query->bindValue(':dateN', $nouveauMembre->getAnniversaire(), PDO::PARAM_STR);
			$query->bindValue(':passe', $nouveauMembre->getPassword(), PDO::PARAM_STR);
			$query->bindValue(':reponse', $nouveauMembre->getReponse(), PDO::PARAM_STR);
			$query->bindValue(':sexe', $nouveauMembre->getType(), PDO::PARAM_INT);
			$query->bindValue(':adresse', $nouveauMembre->getAdresse(), PDO::PARAM_STR);
			$query->bindValue(':langue', $nouveauMembre->getLangue(), PDO::PARAM_STR);
			$query->bindValue(':description', $nouveauMembre->getDescription(), PDO::PARAM_STR);
			
			$res = 0;
			try {
				$query->execute();
				$res = 1;
			} catch (PDOException $ex){				
				$res = -1;
			}

			$query->CloseCursor();
			return $res;
		}
		
		/*
		 * Mise à jour du profil d'un membre.
		 */
		public function miseAJourMembre($membre){
			$query = $this->db->prepare("UPDATE user SET email = :email, nom = :nom, prenom = :prenom, pseudo = :pseudo, mdp = :passe, dateNaissance = :dateNaiss, sexe = :sexe, adresse = :adresse, langue = :langue WHERE id_user = :id_user");
			$query->bindValue(':email', $membre->getMail(), PDO::PARAM_STR);
			$query->bindValue(':nom', $membre->getNom(), PDO::PARAM_STR);
			$query->bindValue(':prenom', $membre->getPrenom(), PDO::PARAM_STR);
			$query->bindValue(':pseudo', $membre->getPseudo(), PDO::PARAM_STR);
			$query->bindValue(':passe', $membre->getPassword(), PDO::PARAM_STR);
			$query->bindValue(':dateNaiss', $membre->getAnniversaire(), PDO::PARAM_STR);
			$query->bindValue(':sexe', $membre->getType(), PDO::PARAM_INT);
			$query->bindValue(':adresse', $membre->getAdresse(), PDO::PARAM_STR);
			$query->bindValue(':langue', $membre->getLangue(), PDO::PARAM_STR);
			$query->bindValue(':id_user', $membre->getID(), PDO::PARAM_INT);

			try {
				$query->execute();
			} catch(PDOException $ex) {				// Traiter les requêtes invalides.
				$res = -1;
			}

			$res = 0;
			if($query->rowCount() == 1){
				$res = 1;
			}

			$query->CloseCursor();
			return $res;
		}
		
		/*
		 * Utile pour assurer l'authentification de chaque membre.
		 */
		public function authentification($email, $mdp){
			
			$sql = $this->db->prepare('SELECT id_user, nom ,prenom, email, pseudo, photo, dateNaissance, mdp, reponse, sexe, adresse, langue, description FROM user WHERE email = :email AND mdp = :mdp');
			$sql->bindValue(':email', $email, PDO::PARAM_STR);
			$sql->bindValue(':mdp', $mdp, PDO::PARAM_STR);
			$sql->execute();

			$tmp = new Membre();					// Objet de récupération des information du membre.
			if($row = $sql->fetch()){

				$tmp->setID($row['id_user']);
				$tmp->setNom($row['nom']);
				$tmp->setPrenom($row['prenom']);
				$tmp->setMail($row['email']);
				$tmp->setPseudo($row['pseudo']);
				$tmp->setPhoto($row['photo']);
				$tmp->setPassword($row['mdp']);
				$tmp->setAnniversaire($row['dateNaissance']);
				$tmp->setReponse($row['reponse']);
				$tmp->setType($row['sexe']);
				$tmp->setAdresse($row['adresse']);
				$tmp->setLangue($row['langue']);
				$tmp->setDescription($row['description']);

			}
			$sql->CloseCursor();
			return $tmp;
		}

		/*
		 * Déconnexion d'un membre.
		 */
		public function deconnexion($idMembre){
			$query = $this->db->prepare("UPDATE connexion SET statut_connexion = 'DECONNECTE' WHERE id_user = :id_user");
			$query->bindValue(':id_user', $idMembre, PDO::PARAM_INT);
			$query->execute();
			$query->CloseCursor();
		}
		
		/*
		 * Utiliser pour vérifier que l'adresse mail ou le pseudo sont bien uniques.
		 */
		public function rechercherMailOuPseudo($email, $pseudo){
			
			$result = $this->db->prepare('SELECT count(id_user) AS total FROM user WHERE email LIKE :email OR pseudo LIKE :pseudo');
			$result->bindValue(':email', $email, PDO::PARAM_STR);
			$result->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
			$result->execute();
			$resultat = 0;
			$row = $result->fetch();
			
			if($row['total'] > 0){
				$resultat = 1;
			}
			
			$result->CloseCursor();
			return $resultat;
		}
		
		/*
		 * Utiliser lors de la phase de vérification de l'unicité de l'adresse mail avant chaque nouvelle inscription.
		 */
		public function rechercherMembreConnecte(){
			$query = $this->db->prepare('SELECT pseudo FROM user INNER JOIN connexion on user.id_user = connexion.id_user WHERE connexion.statut_connexion LIKE "CONNECTE"');
			$query->execute();
			$result = $query->fetchAll(PDO::FETCH_COLUMN, 0);
			$query->CloseCursor();
			
			if($result){
				return $result;
			} else {
				return false;
			}
		}
	}