<?php
  session_start();

  if(isset($_SESSION['user'])){

    if(isset($_SESSION['erreur'])){
      echo $_SESSION['erreur'];
    }

    // Récupérer les informations dans la session de l'utilisateur.
    require_once(__DIR__.'/../model/Membre.class.php');
    $user = unserialize($_SESSION['user']);

    require_once(__DIR__.'/../control/Securite.class.php');
?>
<!DOCTYPE html>
<html>
  <head>
<?php
    require_once('CDN.php');      // Ajout des CDN.
?>
    <link rel="stylesheet" type="text/css" href="update_profil.css">
    <title>Mise à jour du profil</title>
  </head>
  <body>
        <!-- MENU -->
<?php
    require_once('menu.php');
?> 
        <!-- CONTENT -->
    <!-- UPDATE PICTURE -->
    <div class="row">
        <div id="pic" class="col-4">
      		  <div class="container">
              <h3>Bonjour <?php echo $user->getPseudo(); ?></h3><br>
                <div id="pic_update">
                   <img id="pic_user" src="ninja.jpg" alt=""><br>
                   <div class="custom-file"><br>
                      <label class="custom-file-label" for="customFile">Ajouter votre fichier</label>
                      <input type="file" class="custom-file-input" id="customFile">
                   </div><br>
                   <p>Des photos nettes et de face permettent aux hôtes et aux voyageurs d'apprendre à se connaître. Personne n'a envie d'héberger un paysage ! Assurez-vous d'utiliser une photo qui montre clairement votre visage et qui ne contient pas d'informations personnelles ou sensibles, car les hôtes ou voyageurs la verront.</p>
                </div>
            </div>    
        </div>
      

    <!-- UPDATE INFO -->

        <div id="form" class="col-8">
      		<h3>Modifiez votre profil</h3><br />
          		<div id="form">
          			<form method="post" action="../control/majProfil.php" class="form-inline">
            				
                    <div class="form-group">
              				  <label class="prenom" for="inputFirstname6">Prénom</label>
              			    <input type="text" name="inputFirstname6" id="inputFirstname6" class="form-control mx-sm-3" aria-describedby="firstnameHelpInline" value="<?php echo Securite::afficherHTML($user->getPrenom()); ?>">
            				</div>
            				
                    <div class="form-group">
              				  <label class="nom" for="inputName6">Nom</label>
              				  <input type="name" name="inputName6" id="inputName6" class="form-control mx-sm-3" aria-describedby="nameHelpInline" value="<?php echo Securite::afficherHTML($user->getNom()); ?>">
            				</div>

                    <div class="form-group">
                        <label class="pseudo" for="inputPseudo6">Pseudo</label>
                        <input type="pseudo" name="inputPseudo6" id="inputPseudo6" class="form-control mx-sm-3" aria-describedby="pseudoHelpInline" value="<?php echo Securite::afficherHTML($user->getPseudo()); ?>">
                    </div><br />
                    <p class="explain">Doit-être compris entre 8-20 charactères.</p>
            				
                    <div class="form-group">
              				  <label class="email" for="inputEmail6">Email</label>
              				  <input type="email" name="inputEmail6" id="inputEmail6" class="form-control mx-sm-3" aria-describedby="emailHelpInline" value="<?php echo Securite::afficherHTML($user->getMail()); ?>">
            				</div><br />
                    <p class="explain">Sur votre profil public, seul votre pseudo est visible.<br /> Lorsque vous passez un appel, votre correspondant voit votre pseudo.</p>
            				
                    <div class="form-group">
              				  <label class="city" for="inputCity6">Lieu de résidence</label>
              				  <input type="city" name="inputCity6" id="inputCity6" class="form-control mx-sm-3" aria-describedby="cityHelpInline" value="<?php echo Securite::afficherHTML($user->getAdresse()); ?>">
            				</div>

            				<div class="form-group">
            					  <label class="sexe" for="inputSexe6">Sexe</label>
            					  <select name="inputSexe6"class="custom-select custom-select-sm">
            						    <option selected>Sexe</option>
            						    <option value="1">Homme</option>
            						    <option value="2">Femme</option>
            						    <option value="3">Autre</option>
          					     </select>
            				</div>

            				<div class="form-group">
            					  <label class="birth" for="inputBirthDate6">Date de Naissance</label>
            					  <input type="date" id="birth" name="bdaymonth" value="<?php echo Securite::afficherHTML($user->getAnniversaire()); ?>">
            				</div>

            				<div class="form-group">
                				<label class="language" for="inputLanguage">Langage</label>
                				<select name="inputLanguage" id="inputLanguage" class="form-control">
                  				  <option selected>Choisir</option>
                  				  <option value="Français">Français</option>
                  				  <option value="Anglais">Anglais</option>
                    				<option value="Espagnol">Espagnol</option>
                    				<option value="Arabe">Arabe</option>
                    				<option value="Chinois">Chinois</option>
                    				<option value="Portugais">Portugais</option>
                    				<option value="Japonais">Japonais</option>
                    				<option value="Italien">Italien</option>
                    				<option value="Allemand">Allemand</option>
                    				<option value="Russe">Russe</option>
                    				<option value="Neerlandais">Neerlandais</option>
                				</select>
              			</div>

              			<div class="form-group">
          					    <label class="description" for="inputDescription">Description</label>
          					    <textarea id="description" name="comment" form="usrform"></textarea>
          				  </div><br />
                    <p class="explain">SpeakEasy est basé sur la communication. Aidez les autres à mieux vous connaître.</p>

                    <div class="form-group">
                      <input id="sub" type="submit" name="submit" value="Enregistrer">
                    </div>
                  </form>
              </div>
    	   </div>
    </div>
        <!-- SCRIPT -->
    	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
      <script type="text/javascript" src="javascript.js"></script>
    </body>
    </html>
<?php
  } else {

    header('Location: ../home.php');
    exit();
  }