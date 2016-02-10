<?php namespace Epic\Controllers;

class Home extends Controller
{
    public function getHome($params = [])
    {
        return json_encode($params);
    }

    public function postHome($params = [])
    {

    }
}