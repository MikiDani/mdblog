<?php
ini_set('display_errors', 1);
date_default_timezone_set('Europe/Budapest');
session_start();

if (isset($_GET['inc'])) { $_SESSION['inc']=$_GET['inc']; }
if (isset($_SESSION['inc'])) { $inc=$_SESSION['inc']; }
if (!isset($inc)) { $inc="home"; }

require_once "backend/session_url.php";
include_once "function_includes.php";
include_once "user/user_includes.php";
include_once "blog/blog_includes.php";

if (isset($_SESSION['login'])) { token_check($_SESSION['login']['usertoken']); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/main.css">
    <title>MD Blog - Portal</title>
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">
</head>
<body>
    <div class="container-fluid page mt-2">
        <div class="row head p-3 rounded-top">
            <div class="w-50"><h1 class="link"><a href="index.php?inc=home">MD Blog</a></h1><h2 class="link"><a href="index.php?inc=home">Portal</a></h2></div>
            <div class="w-50 text-end"><img src="img/logo.svg" height="100px" alt="logo" title="logo"></div>
        </div>
        <div class="row"><?php require_once "menu.php"; ?></div>
        <div class="row content justify-content-center">
            <?php 
            $inc=='login' ? require_once "user/login_form.php" : false ;
            $inc=='registration' ? require_once "user/registration_form.php" : false ;
            $inc=='profil' ? require_once "user/profil_form.php" : false ;
            if ($inc=='myblog') {
                require_once "blog/myblog_form.php";
                if (isset($_POST['selectentrie_submit'])) {
                    //echo "kisnyúl!".$_POST['selectentrie_submit'];
                    require_once "blog/entriemod_form.php";
                } else {
                    require_once "blog/mynewentrie_form.php";
                    require_once "blog/myentries_form.php";
                }
            }
            $inc=='home' ? require_once "home.php" : false ;
            $inc=='bloglist' ? require_once "blog/blogslist_list.php" : false ;
            $inc=='userlist' ? require_once "user/userslist_list.php" : false ;
            ?>
        </div>
        <?php require_once "footer.php"; ?>
    </div>
</body>
</html>