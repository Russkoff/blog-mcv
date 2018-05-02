<?php

function postLogin($email, $password){

	if(empty($email) OR empty($password)){
		$loginMessage = "Merci de remplir tous les champs";
	}
	else{
		//on cherche un utilisateur correspondant au couple email / password renseigné

		$db = dbConnect();

		$query = $db->prepare('SELECT *
							FROM user
							WHERE email = ? AND password = ?');
		$query->execute( array( $email, hash('md5', $password), ) );
		$user = $query->fetch();

		//si un utilisateur correspond
		if($user){
			//on prend en session ses droits d'administration pour vérifier s'il a la permission d'accès au back-office
			$_SESSION['is_admin'] = $user['is_admin'];
			$_SESSION['user'] = $user['firstname'];
			//détruire $_SESSION["user_id"] sera utilisé pour une requête de pré-remplissage du formulaire user-profile.php
			$_SESSION['user_id'] = $user['id'];

			header('location:index.php');
			exit;
		}
		else{ //si pas d'utilisateur correspondant on génère un message pour l'afficher plus bas
			$loginMessage = "Mauvais identifiants";
		}
	}
		return $loginMessage;
}


function postRegister($firstname, $lastname, $email, $password, $password_confirm, $bio){

		//un enregistrement utilisateur ne pourra se faire que sous certaines conditions
		//en premier lieu, vérifier que l'adresse email renseignée n'est pas déjà utilisée

		$db = dbConnect();

		$query = $db->prepare('SELECT email FROM user WHERE email = ?');
		$query->execute(array($email));

		//$userAlreadyExists vaudra false si l'email n'a pas été trouvé, ou un tableau contenant le résultat dans le cas contraire
		$userAlreadyExists = $query->fetch();

		//on teste donc $userAlreadyExists. Si différent de false, l'adresse a été trouvée en base de données
		if($userAlreadyExists){
			$registerMessage = "Adresse email déjà enregistrée";
		}
		elseif(empty($firstname) OR empty($password) OR empty($email)){
			//ici on test si les champs obligatoires ont été remplis
	        $registerMessage = "Merci de remplir tous les champs obligatoires (*)";
	    }
	    elseif($password != $password_confirm) {
				//ici on teste si les mots de passe renseignés sont identiques
				$registerMessage = "Les mots de passe ne sont pas identiques";
	    }
	    else {

			//si tout les tests ci-dessus sont passés avec succès, on peut enregistrer l'utilisateur
			//le champ is_admin étant par défaut à 0 dans la base de données, inutile de le renseigner dans la requête

					$db = dbConnect();

	        $query = $db->prepare('INSERT INTO user (firstname,lastname,email,password,bio) VALUES (?, ?, ?, ?, ?)');
	        $newUser = $query->execute(
	            [
	                $firstname,
	                $lastname,
	                $email,
									hash('md5', $password),
	                $bio
	            ]
	        );

			//une fois l'utilisateur enregistré, on le connecte en créant sa session
			$_SESSION['is_admin'] = 0; //PAS ADMIN !
			$_SESSION['user'] = $firstname;

			header('location:index.php');
			exit;
	    }

return $registerMessage;

}
?>
