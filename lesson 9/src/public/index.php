<?php namespace Epic;

use Epic\Controllers\Home;
use Epic\Controllers\Login;
use Epic\Controllers\Profile;

session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

define('SITE_URL', 'http://epic-blog/lesson%209/src/public/index.php');

require '../vendor/autoload.php';

Lib\connection(['host' => 'localhost', 'dbname' => 'blog', 'user' => 'root', 'password' => 'vagrant', 'encoding' => 'utf8']);

Lib\routes($_SERVER['REQUEST_URI'], [
   'home' => new Home(),
   'profile' => new Profile(),
   'login' => new Login(),
]);