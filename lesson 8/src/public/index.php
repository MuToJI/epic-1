<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

define('SITE_URL', 'http://epic-blog/lesson%208/src/public/index.php');

require '../blog.php';

$connection = connection(['host' => 'localhost', 'dbname' => 'blog', 'user' => 'root', 'password' => 'vagrant', 'encoding' => 'utf8']);
$style = style($_COOKIE['style']);
$user = user();

routes($_SERVER['REQUEST_URI'], [
   'login' => function ($params) use ($connection, $user, $style) {
       if (!empty($user)) {
           header('Location:' . sprintf('%s?action=home', SITE_URL));
       }
       $login = empty($_POST['login']) ? null : $_POST['login'];
       $password = empty($_POST['password']) ? null : $_POST['password'];

       if (valid_token($_POST['token'])) {
           $user = user($connection, $login, $password);
       }

       if (empty($user)) {
           echo template('../templates/authorization.php', [
              'token' => token(),
              'login' => $login,
              'site_url' => SITE_URL
           ]);
       }
   },
   'save' => function ($params) use ($connection, $user) {
       if (empty($user)) {
           header('Location:' . sprintf('%s?action=login', SITE_URL));
       }

       $message_id = empty($_POST['message_id']) ? null : (int)$_POST['message_id'];
       $message = empty($_POST['message']) ? null : $_POST['message'];

       if (!empty($message) && valid_token($_POST['token'])) {
           isset($message_id)
              ? update_message($connection, $message, $message_id)
              : insert_message($connection, $message, $user['id']);
       }

       header('Location:' . sprintf('%s?action=home&message_id=%d', SITE_URL, $message_id));
   },
   'home' => function ($params) use ($connection, $user, $style) {
       if (empty($user)) {
           header('Location:' . sprintf('%s?action=login', SITE_URL));
       }

       $message_id = empty($params['message_id']) ? null : (int)$params['message_id'];
       $messages = load_messages($connection, $message_id);

       echo template('../templates/home.php', [
          'messages' => $messages,
          'token' => token(),
          'style' => $style,
          'site_url' => SITE_URL,
          'message_id' => $message_id,
       ]);
   }
]);