<?php
session_start();
require_once 'functions.php';

$user = login($_POST['email'], $_POST['password']);
if (!$user) {
    setFlashMessage('danger', 'Wrong login or password. Enter other values !');
    redirectTo('login_form.php');
}
else {
    $_SESSION['authUser'] = $user;
    redirectTo('users.php');
}