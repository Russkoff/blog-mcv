<?php

require_once('common.php');
$db = dbConnect();
session_start();

if(isset($_GET['page'])){

  if($_GET['page'] == 'article_list'){
    require_once('controllers/article_list.php');
  }
  elseif($_GET['page'] == 'article'){
    require_once('controllers/article.php');
  }
  elseif($_GET['page'] == 'user'){
    require_once('controllers/user.php');
  }
  elseif($_GET['page'] == 'login-register'){
    require_once('controllers/login-register.php');
  }
  elseif($_GET['page'] == 'user-profile'){
    require_once('controllers/user-profile.php');
  }
  elseif($_GET['page'] == 'admin'){
    require_once('controllers/admin.php');
  }
  else{
    require_once('controllers/index.php');
  }

}
else{
  require_once('controllers/index.php');
}



?>
