<?php namespace Epic;

session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

define('SITE_URL', 'http://epic-blog/lesson%208/src/public/index.php');
define('APP_DIR', '');

require '../vendor/autoload.php';

$app = new App([
                  'mysql' => [
                     'host' => 'localhost',
                     'dbname' => 'blog',
                     'user' => 'root',
                     'password' => 'vagrant',
                     'encoding' => 'utf8'
                  ],
                  'templates' => '../templates',
               ]);

$router = new Router($app);
$router->add('home', 'Home', [
   function () {
       var_dump('filtering');
   }
]);
$router->handle();
exit();

routes($_SERVER['REQUEST_URI'], [
   'profile' => function ($params) use ($connection, $user, $style) {
       if (empty($user)) {
           header('Location:' . sprintf('%s?action=login', SITE_URL));
       }

       if (isset($_POST['style'])) {
           setcookie('style', $_POST['style'], 0, '/');
           $style = style($_POST['style']);
       }

       echo template('../templates/profile.php', [
          'site_url' => SITE_URL,
          'style' => $style,
       ]);
   },

   'login' => function ($params) use ($connection, $user, $style) {
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

       echo template('../templates/authorization.php', [
          'token' => token(),
          'login' => $login,
          'site_url' => SITE_URL,
          'style' => $style,
       ]);
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

   }
]);