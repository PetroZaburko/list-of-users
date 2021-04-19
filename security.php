<?php
session_start();
require_once 'functions.php';
isUserLogged();
hasReuest($_POST['id']);

if($_SESSION['authUser']['is_admin'] || $_POST['id'] == $_SESSION['authUser']['id']) {
    // updating only email
    if ($_POST['email'] && !$_POST['password'] && !$_POST['confirm_password']) {
        $existing_user = getUserByEmail($_POST['email']);
        if (!$existing_user) {
            $user = getUserById($_POST['id']);
            editUserCredentials($_POST['id'], $_POST['email'], $_POST['password']);
            setFlashMessage('success', $user['name'] . ' email successful updated !');
            redirectTo('users.php');
        } else {
            setFlashMessage('danger', 'This email is already taken ! Enter other email, please');
            redirectTo('security_form.php?id=' . $_POST['id']);
        }
    }
    // updating only password
    elseif ($_POST['password'] && $_POST['confirm_password'] && !$_POST['email']) {
        if ($_POST['confirm_password'] != $_POST['password']) {
            setFlashMessage('danger', 'The password confirmation does not match.');
            redirectTo('security_form.php?id=' . $_POST['id']);
        } else {
            $user = getUserById($_POST['id']);
            editUserCredentials($_POST['id'], $_POST['email'], $_POST['password']);
            setFlashMessage('success', $user['name'] . ' password successful updated !');
            redirectTo('users.php');
        }
    }
    // updating password and email
    elseif ($_POST['password'] && $_POST['confirm_password'] && $_POST['email']) {
        if ($_POST['confirm_password'] != $_POST['password']) {
            setFlashMessage('danger', 'The password confirmation does not match.');
            redirectTo('security_form.php?id=' . $_POST['id']);
        } else {
            $user = getUserById($_POST['id']);
            editUserCredentials($_POST['id'], $_POST['email'], $_POST['password']);
            setFlashMessage('success', $user['name'] . ' password and email successful updated !');
            redirectTo('users.php');
        }
    }
    else {
        setFlashMessage('danger', 'Enter needed values, please !');
        redirectTo('security_form.php?id=' . $_POST['id']);
    }
}
else {
    redirectTo('users.php');
}