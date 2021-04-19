<?php
session_start();
include_once 'functions.php';
isUserLogged();

if($_SESSION['authUser']['is_admin'] || $_POST['id'] == $_SESSION['authUser']['id']) {
    if(editUserInformation($_POST['id'], $_POST['name'], $_POST['company'], $_POST['telephone'], $_POST['address'] )) {
        setFlashMessage('success', $_POST['name'] . ' profile successful updated');
        redirectTo('users.php');
    }
    else {
        setFlashMessage('danger', 'Something goes wrong. Try again later, please.');
        redirectTo('users.php');
    }
}
else {
    redirectTo('users.php');
}