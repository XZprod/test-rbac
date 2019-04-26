<?php

namespace App;

class App
{
    public $db;
    public static $app;

    private function __construct()
    {
        $db = new Db('localhost', 'rbac', 'root', '');
        $this->db = $db->getInstance();
    }

    public static function app()
    {
        if(!self::$app) {
            self::$app = new self();
        }
        return self::$app;
    }
}
