<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require '../blog.php';

define('SITE_URL', 'http://epic-blog/lesson%208/src/index.php');

$connection = connection(['host' => 'localhost', 'dbname' => 'blog', 'user' => 'root', 'password' => 'vagrant', 'encoding' => 'utf8']);

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

$token = uniqid();
$_SESSION['token'] = $token;

echo template('templates/index.php', [
   'messages' => $messages,
   'token' => $token,
   'style' => $style,
   'site_url' => SITE_URL,
   'message_id' => $message_id,
]);