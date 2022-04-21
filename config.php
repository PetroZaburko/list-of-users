<?php

//db config
$host = '127.0.0.1';
$db   = 'users';
$user = 'root';
$pass = 'asdfg001';
$charset = 'utf8';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$pdo = new PDO($dsn, $user, $pass);

//user avatar path
$imgDir = 'img/demo/avatars/';

//social links domains
$socialLinks = [
    'vk' => 'https://www.vk.com/',
    'telegram' => 'https://www.telegram.com/@',
    'instagram' => 'https://www.instagram.com/'
];
