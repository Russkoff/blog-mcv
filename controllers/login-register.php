<?php
if (isset($_SESSION['user'])) {
  header('location:index.php');
  exit;

}else {

  require_once('models/category.php');

  $categories = getCategories();

  require_once('models/login-register.php');

  if (isset($_POST['login'])) {

    postLogin($_POST['email'], $_POST['password']);

    $loginMessage = postLogin($_POST['email'], $_POST['password']);

  } elseif (isset($_POST['register'])) {

    postRegister($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password'], $_POST['password_confirm'], $_POST['bio']);

    $registerMessage = postRegister($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password'], $_POST['password_confirm'], $_POST['bio']);

  }

  require_once('views/login-register.php');

}
?>
