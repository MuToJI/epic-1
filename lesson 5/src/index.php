<?php

error_reporting(E_ALL);
session_start();

require 'config.php';
require 'blog.php';

define('TEMPLATE_DIR', __DIR__);

$mysql = connection(mysql_config());

$user = [
   'id' => 0,
   'login' => 'admin'
];

if (!empty($_POST['command']) && $_POST['command'] === 'save' && valid_request($_POST)) {
    $statement = $mysql->prepare('INSERT INTO `messages` SET `message`=:message, `user_id`=:user_id, `time`=:time');
    $statement->execute([':message' => $_POST['message'], ':user_id' => $user['id'], ':time' => date('Y-m-d H:i:s')]);
}

$messages = $mysql->query('SELECT m.`message`, m.`time`, u.`login` FROM `messages` m LEFT JOIN `users` u ON `m`.`user_id`=`u`.`id` ORDER BY m.`time` DESC')->fetchAll();

$token = uniqid();
echo template('index.html', [
   'token' => $token,
   'messages' => $messages,
]);
$_SESSION['token'] = $token;