<?php namespace Epic\Controllers;

use Epic\Lib;

class Home extends Controller
{
    /**
     * @param array $params
     * @return string
     */
    public function getHome($params = [])
    {
        if (empty(Lib\user())) {
            Lib\redirect(SITE_URL . '?action=login');
        }
        $message_id = empty($params['message_id']) ? null : (int)$params['message_id'];
        $messages = Lib\load_messages(\Epic\Lib\connection(), $message_id);
        echo Lib\template('../templates/home.php', [
           'messages' => $messages,
           'token' => Lib\token(),
           'style' => Lib\style($_COOKIE['style']),
           'site_url' => SITE_URL,
           'message_id' => $message_id,
        ]);
    }

    public function postHome($params = [])
    {
        if (empty(Lib\user())) {
            Lib\redirect(SITE_URL . '?action=login');
        }
        $message_id = empty($_POST['message_id']) ? null : (int)$_POST['message_id'];
        $message = empty($_POST['message']) ? null : $_POST['message'];

        if (!empty($message) && Lib\valid_token($_POST['token'])) {
            isset($message_id)
               ? Lib\update_message(Lib\connection(), $message, $message_id)
               : Lib\insert_message(Lib\connection(), $message, 0);
        }

        Lib\redirect(SITE_URL . "?message_id={$message_id}");
    }
}