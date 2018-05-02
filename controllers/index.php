<?php

require_once('models/article.php');
require_once('models/category.php');
require_once('models/index.php');

$categories = getCategories();
$articles = getArticles(3);


//si un utilisateur est connécté et que l'on reçoit le paramètre "lougout" via URL, on le déconnecte

if(isset($_GET['logout']) && isset($_SESSION['user'])){

getLogout();

require_once('views/index.php');

}

require_once('views/index.php');

?>
