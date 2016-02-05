<?php

if (!empty($_SESSION['user'])) {
    return $_SESSION['user'];
}

if (empty($connection) || empty($input['login']) || empty($input['password'])) {
    return [];
}

$query = $connection->prepare("SELECT * FROM `users` WHERE `login`=:login AND `password`=:password");
$query->execute([
                   ':login' => $input['login'],
                   ':password' => md5($input['password']),
                ]);
$user = $query->fetch();
if (!empty($user)) {
    $_SESSION['user'] = $user;
}
return $user;