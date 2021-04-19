<?php
session_start();
require_once 'functions.php';

$email = $_POST['email'];
$password = $_POST['password'];
$user = getUserByEmail($email);

if (!empty($user)) {
    setFlashMessage('danger', 'This email is already taken ! Enter other email, please');
    redirectTo('register_form.php');
}
else {
    addUser($email, $password);
    setFlashMessage('success', 'Registration successful');
    redirectTo('login_form.php');
}