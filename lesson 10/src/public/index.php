<?php namespace Epic;

session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

define('SITE_URL', 'http://epic-blog/lesson%2010/src/public/index.php');

require '../vendor/autoload.php';

Lib\connection(['host' => 'localhost', 'dbname' => 'blog', 'user' => 'root', 'password' => 'vagrant', 'encoding' => 'utf8']);

$router = new Router();
$router->add('home', '\Epic\Controllers\Home', ['\Epic\Lib\is_logged']);
$router->add('profile', '\Epic\Controllers\Profile', ['\Epic\Lib\is_logged']);
$router->add('login', '\Epic\Controllers\Login');
$router->handle();
