<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require '../blog.php';

define('SITE_URL', 'http://epic-blog/lesson%207/src/public/index.php');

$connection = connection(['host' => 'localhost', 'dbname' => 'blog', 'user' => 'root', 'password' => 'vagrant', 'encoding' => 'utf8']);

$login = empty($_REQUEST['login']) ? null : $_REQUEST['login'];
$password = empty($_REQUEST['password']) ? null : $_REQUEST['password'];

$user = user();
if (!empty($_REQUEST['action']) && $_REQUEST['action'] === 'login' && valid_token($_REQUEST['token'])) {
    $user = user($connection, $login, $password);
}

if (empty($user)) {
    echo template('templates/authorization.php', [
       'token' => token(),
       'login' => $login,
       'site_url' => SITE_URL
    ]);
    exit();
}

$message_id = empty($_REQUEST['message_id']) ? null : (int)$_REQUEST['message_id'];
$message = empty($_REQUEST['message']) ? null : $_REQUEST['message'];

if (!empty($message) && valid_token($_REQUEST['token'])) {
    isset($message_id)
       ? update_message($connection, $message, $message_id)
       : insert_message($connection, $message, 0);
    header('Location:' . SITE_URL);
}

$messages = load_messages($connection, $message_id);
$style = style($_COOKIE['style']);

echo template('templates/home.php', [
   'messages' => $messages,
   'token' => token(),
   'style' => $style,
   'site_url' => SITE_URL,
   'message_id' => $message_id,
]);