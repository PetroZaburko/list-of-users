<?php

require_once 'config.php';


function getUserByEmail($email) {
    global $pdo;
    $sql = 'SELECT * FROM users WHERE email=:email';
    $stm = $pdo->prepare($sql);
    $stm->execute([
        'email' => $email
    ]);
    $user = $stm->fetch(PDO::FETCH_ASSOC);
    return $user;
}

function getUserById($id) {
    global $pdo;
    $sql = 'SELECT * FROM users WHERE id=:id';
    $stm = $pdo->prepare($sql);
    $stm->execute([
        'id' => $id
    ]);
    $user = $stm->fetch(PDO::FETCH_ASSOC);
    return $user;
}

function editUserCredentials($id, $email, $password) {
    global $pdo;
    if ($email && !$password ) {
        $sql = 'UPDATE users SET email=:email WHERE id=:id';
        $stm = $pdo->prepare($sql);
        $result = $stm->execute([
            'id' => $id,
            'email' => $email
        ]);
        return $result;
    }
    elseif (!$email && $password) {
        $sql = 'UPDATE users SET password=:password WHERE id=:id';
        $stm = $pdo->prepare($sql);
        $result = $stm->execute([
            'id' => $id,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);
        return $result;
    }
    elseif ($email && $password) {
        $sql = 'UPDATE users SET email=:email, password=:password WHERE id=:id';
        $stm = $pdo->prepare($sql);
        $result = $stm->execute([
            'id' => $id,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);
        return $result;
    }
    else return false;
}

function addUser($email, $password) {
    global $pdo;
    $sql = 'INSERT INTO users (email, password) VALUES (:email, :password)';
    $stm = $pdo->prepare($sql);
    $stm->execute([
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT)
    ]);
    return $pdo->lastInsertId();
}

function setFlashMessage($status, $message) {
    $_SESSION['status'] = $status;
    $_SESSION['message'] = $message;
}

function displayFlashMessage() {
    if (isset($_SESSION['status'])) {
        echo "<div class=\"alert alert-{$_SESSION['status']} text-dark\" role=\"alert\">{$_SESSION['message']}</div>";
        unset($_SESSION['status']);
        unset($_SESSION['message']);
    }
}

function redirectTo($path) {
    header("Location: {$path}");
    exit;
}

function login($email, $password) {
    $user = getUserByEmail($email);
    if (empty($user)) {
        return false;
    }
    elseif (!password_verify($password, $user['password'])) {
        return false;
    }
    else {
        return $user;
    }
}

function logout() {
    unset($_SESSION['authUser']);
    redirectTo('login_form.php');
}

function isUserLogged() {
    if (!isset($_SESSION['authUser'])) {
        redirectTo('login_form.php');
    }
}

function isUserAdmin() {
    if(!($_SESSION['authUser']['is_admin'])) {
        redirectTo('users.php');
    }
}

function getAllUsers() {
    global $pdo;
    $sql = 'SELECT * FROM users';
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $users = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $users;
}

function getUserStatus($id, $field) {
    global $pdo;
    $sql = "SELECT $field FROM statuses WHERE id=:id";
    $stm = $pdo->prepare($sql);
    $stm->execute([
        'id' => $id
    ]);
    $status = $stm->fetch(PDO::FETCH_COLUMN);
    return $status;
}

function getUserImage($image) {
    global $imgDir;
    if (!$image || !file_exists($imgDir . $image)) {
        return $imgDir . 'noavatar.png';
    }
    return $imgDir . $image;
}

function editUserInformation($id, $name, $company, $telephone, $address) {
    global $pdo;
    $sql = 'UPDATE users SET name=:name, company=:company, telephone=:telephone, address=:address WHERE id=:id';
    $stm = $pdo->prepare($sql);
    $result = $stm->execute([
        'id' => $id,
        'name' => $name,
        'company' => $company,
        'telephone' => $telephone,
        'address' => $address
    ]);
    return $result;
}

function setUserStatus($id, $status) {
    global $pdo;
    $sql = 'UPDATE users SET status=:status WHERE id=:id';
    $stm = $pdo->prepare($sql);
    $result = $stm->execute([
        'id' => $id,
        'status' => $status
    ]);
    return $result;
}

function uploadUserImage($id, $image) {
    global $imgDir;
    global $pdo;
    $newFileExt = pathinfo($image['name'], PATHINFO_EXTENSION);
    $newFileName = 'avatar_' . md5($image['name'] . time()) . '.' . $newFileExt;
    $destPath = $imgDir . $newFileName;
    $result = false;
    if(move_uploaded_file($image['tmp_name'], $destPath)) {
        $sql = 'UPDATE users SET image=:image WHERE id=:id';
        $stm = $pdo->prepare($sql);
        $result = $stm->execute([
            'id' => $id,
            'image' => $newFileName
        ]);
    }
    return $result;
}

function deleteImage($image) {
    global $imgDir;
    $destPath = $imgDir . $image;
    return unlink($destPath);
}

function addUserSocialLinks($id, $vk, $telegram, $instagram) {
    global $pdo;
    $sql = 'UPDATE users SET vk=:vk, telegram=:telegram, instagram=:instagram WHERE id=:id';
    $stm = $pdo->prepare($sql);
    $result = $stm->execute([
        'id' => $id,
        'vk' => $vk,
        'telegram' => $telegram,
        'instagram' => $instagram
    ]);
    return $result;
}

function getUserSocialLink ($link, $type) {
    global $socialLinks;
    return $link ? $socialLinks[$type] . $link : '#';
}

function getAllUserStatuses() {
    global  $pdo;
    $sql = 'SELECT * FROM statuses';
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $statuses = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $statuses;
}

function deleteUser($id) {
    global  $pdo;
    $sql = 'DELETE FROM users WHERE id=:id';
    $stm = $pdo->prepare($sql);
    $result = $stm->execute([
        'id' => $id
    ]);
    return $result;
}