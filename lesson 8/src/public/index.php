<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

define('SITE_URL', 'http://epic-blog/lesson%208/src/public/index.php');

require '../blog.php';

$connection = connection(['host' => 'localhost', 'dbname' => 'blog', 'user' => 'root', 'password' => 'vagrant', 'encoding' => 'utf8']);
$style = style(empty($_COOKIE['style']) ? 0 : $_COOKIE['style']);
$user = user();

$action = empty($_GET['action']) ? 'home' : $_GET['action'];
switch ($action) {
    case 'login':
        if (!empty($user)) {
            header('Location:' . sprintf('%s?action=home', SITE_URL));
        }
        $login = empty($_POST['login']) ? null : $_POST['login'];
        $password = empty($_POST['password']) ? null : $_POST['password'];

        if (!empty($_POST['token']) && valid_token($_POST['token'])) {
            $user = user($connection, $login, $password);
            if (!empty($user)) {
                header('Location:' . sprintf('%s?action=home', SITE_URL));
            }
        }
        $response = template('../templates/authorization.php', [
            'token' => token(),
            'login' => $login,
            'site_url' => SITE_URL,
            'style' => $style,
        ]);
        break;
    case 'profile':
        if (empty($user)) {
            header('Location:' . sprintf('%s?action=login', SITE_URL));
        }

        if (isset($_POST['style'])) {
            setcookie('style', $_POST['style'], 0, '/');
            $style = style($_POST['style']);
        }

        $response = template('../templates/profile.php', [
            'site_url' => SITE_URL,
            'style' => $style,
        ]);
        break;
    case 'save':
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
        break;
    default:
        if (empty($user)) {
            header('Location:' . sprintf('%s?action=login', SITE_URL));
        }

        $message_id = empty($_GET['message_id']) ? null : (int)$_GET['message_id'];
        $messages = load_messages($connection, $message_id);

        $response = template('../templates/home.php', [
            'messages' => $messages,
            'token' => token(),
            'style' => $style,
            'site_url' => SITE_URL,
            'message_id' => $message_id,
        ]);
}

empty($response) ?
    template('404.php')
    : $response;