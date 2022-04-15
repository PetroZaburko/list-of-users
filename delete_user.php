<?php
session_start();
require_once 'functions.php';
isUserLogged();
hasReuest($_GET['id']);

$user = getUserById($_GET['id']);
if($_SESSION['authUser']['is_admin'] || $_GET['id'] == $_SESSION['authUser']['id']) {
    deleteUser($user['id']);
    deleteImage($user['image']);
    setFlashMessage('danger', $user['name'] . ' profile successful deleted !');
    if($_GET['id'] == $_SESSION['authUser']['id']) {
        logout();
    }
    else {
        redirectTo('users.php');
    }
}
else {
    setFlashMessage('danger', 'You can delete only your own profile !');
    redirectTo('users.php');
}