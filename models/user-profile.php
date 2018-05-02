<?php

function userId($user_id){

		$db = dbConnect();

		//si on modifie un utilisateur, on doit séléctionner l'utilisateur en question (id en session) pour pré-remplir le formulaire plus bas
		$query = $db->prepare('SELECT * FROM user WHERE id = ?');
		$query->execute(array($user_id));
		//$user contiendra les informations de l'utilisateur dont l'id est en session
		return $query->fetch();

}


//En cas de mise à jour des informations
function userUpdate($firstname, $lastname, $email, $password, $password_confirm, $bio, $user_email, $user_id){

	$db = dbConnect();

	//la mise à jour d'un utilisateur ne pourra se faire que sous certaines conditions

	//en premier lieu, vérifier que l'adresse email renseignée n'est pas déjà utilisée
	$query = $db->prepare('SELECT email FROM user WHERE email = ?');
	$query->execute(array($email));

	//$emailAlreadyExists vaudra false si l'email n'a pas été trouvé, ou un tableau contenant le résultat dans le cas contraire
	$emailAlreadyExists = $query->fetch();

	//on teste donc $emailAlreadyExists. Si différent de false, l'adresse a été trouvée en base de données
	//on teste également si l'utilisateur a modifié son email
	if($emailAlreadyExists && $emailAlreadyExists['email'] != $user_email){
		$updateMessage = "Adresse email déjà utilisée";
	}
	elseif(empty($firstname) OR empty($email)){
		//ici on test si les champs obligatoires ont été remplis
        $updateMessage = "Merci de remplir tous les champs obligatoires (*)";
    }
	//uniquement si l'utilisateur souhaite modifier son mot de passe
	elseif( !empty($password) AND ($password != $password_confirm)) {
		//ici on teste si les mots de passe renseignés sont identiques
		$updateMessage = "Les mots de passe ne sont pas identiques";
	}
    else {

		//début de la chaîne de caractères de la requête de mise à jour
		$queryString = 'UPDATE user SET firstname = :firstname, lastname = :lastname, email = :email, bio = :bio ';
		//début du tableau de paramètres de la requête de mise à jour
		$queryParameters = [ 'firstname' => $firstname, 'lastname' => $lastname, 'email' => $email, 'bio' => $bio, 'id' => $user_id ];

		//uniquement si l'utilisateur souhaite modifier son mot de passe
		if( !empty($password)) {
			//concaténation du champ password à mettre à jour
			$queryString .= ', password = :password ';
			//ajout du paramètre password à mettre à jour
			$queryParameters['password'] = hash('md5', $password);
		}

		//fin de la chaîne de caractères de la requête de mise à jour
		$queryString .= 'WHERE id = :id';

		//préparation et execution de la requête avec la chaîne de caractères et le tableau de données
		$query = $db->prepare($queryString);
		$result = $query->execute($queryParameters);

		if($result){
			//une fois l'utilisateur enregistré, on modifie $_SESSION['user'] car il a peut être changé son firstName
			$_SESSION['user'] = $firstname;
			$updateMessage = "Informations mises à jour avec succès !";

			//récupération des informations utilisateur qui ont été mises à jour pour affichage
			$query = $db->prepare('SELECT * FROM user WHERE id = ?');
			$query->execute(array($user_id));
			$user = $query->fetch();
		}
		else{
			$updateMessage = "Erreur";
		}

    }
return $updateMessage;
}

?>
