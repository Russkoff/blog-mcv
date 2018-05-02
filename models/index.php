<?php
function getLogout(){
	//la fonction unset() détruit une variable ou une partie de tableau. ici on détruit la session user
	unset($_SESSION["user"]);
	//détruire $_SESSION["user"] va permettre l'affichage du bouton connexion / inscription de la nav, et permettre à nouveau l'accès aux formulaires de connexion / inscription
	//détruire $_SESSION["is_admin"] va empêcher l'accès au back-office
	unset($_SESSION["is_admin"]);
	unset($_SESSION["user_id"]);
}
?>
