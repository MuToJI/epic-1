<?php namespace Epic\Controllers;

use Epic\Lib;

class Login extends Controller
{
    public function getLogin()
    {
        if (!empty(Lib\user())) {
            Lib\redirect(SITE_URL);
        }

        echo Lib\template('../templates/authorization.php', [
           'token' => Lib\token(),
           'login' => empty($_POST['login']) ? '' : $_POST['login'],
           'site_url' => SITE_URL,
           'style' => Lib\style($_COOKIE['style']),
        ]);
    }

    public function postLogin()
    {
        $login = empty($_POST['login']) ? null : $_POST['login'];
        $password = empty($_POST['password']) ? null : $_POST['password'];

        if (!empty($_POST['token']) && Lib\valid_token($_POST['token'])) {
            Lib\user(Lib\connection(), $login, $password);
        }
        if (!empty(Lib\user())) {
            Lib\redirect(SITE_URL);
        }
        Lib\redirect(SITE_URL . '?action=login');
    }
}