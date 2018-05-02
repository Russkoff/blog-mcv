<?php

if ($_SESSION["user"]) {

    require_once('models/user-profile.php');

    $user = userId($_SESSION["user_id"]);

  if (isset($_POST['update'])) {

    userUpdate($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password'], $_POST['password_confirm'], $_POST['bio'], $user['email'], $_SESSION['user_id']);

    $updateMessage = userUpdate($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password'], $_POST['password_confirm'], $_POST['bio'], $user['email'], $_SESSION['user_id']);

    $user = userId($_SESSION["user_id"]);

  }
  require_once('models/category.php');

  $categories = getCategories();

  require_once('views/user-profile.php');

}else {
  header('location:../index.php');
	exit;
}

 ?>
