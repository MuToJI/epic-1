<?php

error_reporting(E_ALL);
session_start();

require '../config.php';
require '../blog.php';

define('TEMPLATE_DIR', __DIR__ . '/templates');

$mysql = connection(mysql_config());

$user = user();

if (!empty($_POST['command']) && valid_token($_POST['token'])) {
    switch ($_POST['command']) {
        case 'save':
            insert_message($mysql, $_POST, $user);
            break;
        case 'login':
            $user = user($mysql, $_POST);
            break;
    }
}

if (empty($user)) {
    echo template('authorization.html', [
       'token' => token(),
       'login' => empty($_POST['login']) ? '' : $_POST['login'],
    ]);
    exit();
}

echo template('index.html', [
   'token' => token(),
   'messages' => load_messages($mysql),
]);