<?php
if(!isset($_SESSION['is_admin']) OR $_SESSION['is_admin'] == 0){
	header('location:../index.php');
	exit;
}else {

  require_once('views/admin.php');
}



 ?>
