<?php namespace Epic\Controllers;

class Home extends Controller
{
    public function getHome($params = [])
    {
        var_dump('get home');
//        $message_id = empty($params['message_id']) ? null : (int)$params['message_id'];
//        $messages = load_messages($connection, $message_id);
//
//        echo template('../templates/home.php', [
//           'messages' => $messages,
//           'token' => token(),
//           'style' => $style,
//           'site_url' => SITE_URL,
//           'message_id' => $message_id,
//        ]);
    }

    public function postHome($params = [])
    {

    }
}