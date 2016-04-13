<?php namespace Epic;

use Epic\Controllers;

session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

define('SITE_URL', Lib\url());

require '../vendor/autoload.php';

Lib\connection(['host' => 'localhost', 'dbname' => 'blog', 'user' => 'root', 'password' => 'vagrant', 'encoding' => 'utf8']);

Lib\routes($_SERVER['REQUEST_URI'], [
   'home' => 'Epic\Controllers\Home',
   'profile' => 'Epic\Controllers\Profile',
   'login' => 'Epic\Controllers\Login',
]);