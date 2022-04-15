<?php
session_start();
require_once 'functions.php';
isUserLogged();
isUserAdmin();

if (getUserByEmail($_POST['email'])) {
    setFlashMessage('danger', 'This email is already taken ! Enter other email, please.');
    redirectTo('add_user_form.php');
}
else {
    $userId = addUser($_POST['email'], $_POST['password']);
    if ($userId) {
        editUserInformation($userId, $_POST['name'], $_POST['company'], $_POST['telephone'], $_POST['address']);
        uploadUserImage($userId, $_FILES['image']);
        setUserStatus($userId, $_POST['status']);
        addUserSocialLinks($userId, $_POST['vk'], $_POST['telegram'], $_POST['instagram']);
        setFlashMessage('success', 'User successful added!');
        redirectTo('users.php');
    }
    else {
        setFlashMessage('danger', 'Something goes wrong, try again later, please');
        redirectTo('add_users_form.php');
    }
}