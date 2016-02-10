<?php namespace Epic;

use Epic\Controllers;

session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

define('SITE_URL', 'http://epic-blog/lesson%209/src/public/index.php');

require '../vendor/autoload.php';

Lib\connection(['host' => 'localhost', 'dbname' => 'blog', 'user' => 'root', 'password' => 'vagrant', 'encoding' => 'utf8']);

Lib\routes($_SERVER['REQUEST_URI'], [
   'home' => new Controllers\Home(),
   'profile' => new Controllers\Profile(),
   'login' => new Controllers\Login(),
]);