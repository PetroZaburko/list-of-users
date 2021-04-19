<?php
session_start();
require_once 'functions.php';
isUserLogged();

if($_SESSION['authUser']['is_admin'] || $_POST['id'] == $_SESSION['authUser']['id']) {
    $user = getUserById($_POST['id']);
    if(uploadUserImage($_POST['id'], $_FILES['image'])) {
        deleteImage($user['image']);
        setFlashMessage('success', $user['name'] .' avatar successful updated');
        redirectTo('profile_user.php?id=' . $_POST['id']);
    }
    else {
        setFlashMessage('danger', 'Something goes wrong. Try again later, please.');
        redirectTo('media_form.php?id=' . $_POST['id']);
    }
}
else {
    redirectTo('users.php');
}