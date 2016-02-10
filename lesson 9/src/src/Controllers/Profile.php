<?php namespace Epic\Controllers;

use Epic\Lib;

class Profile extends Controller
{
    public function getProfile()
    {
        if (empty(Lib\user())) {
            Lib\redirect(SITE_URL . '?action=login');
        }

        echo Lib\template('../templates/profile.php', [
           'site_url' => SITE_URL,
           'style' => Lib\style($_COOKIE['style']),
        ]);
    }

    public function postProfile()
    {
        if (isset($_POST['style'])) {
            setcookie('style', $_POST['style'], 0, '/');
        }
        Lib\redirect(SITE_URL . '?action=profile');
    }
}