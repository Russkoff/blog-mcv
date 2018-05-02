<?php

function dbConnect(){

	try{
		return new PDO('mysql:host=localhost;dbname=180502-blog-mvc;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}
	catch (Exception $exception)
	{
		die( 'Erreur : ' . $exception->getMessage() );
	}
}

 ?>
