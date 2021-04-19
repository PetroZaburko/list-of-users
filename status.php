<?php
session_start();
require_once 'functions.php';
isUserLogged();
hasReuest($_POST['id']);

if ($_SESSION['authUser']['is_admin'] || $_POST['id'] == $_SESSION['authUser']['id']) {
    setUserStatus($_POST['id'], $_POST['status']);
    setFlashMessage('success', 'User status successful updated');
    redirectTo('users.php');
}
else {
    redirectTo('users.php');
}