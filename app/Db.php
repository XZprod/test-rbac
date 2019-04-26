<?php
namespace App;


class Db
{
    const DBNAME = 'myDb';
//    const TABLE_NAME = 'users';

    private $instance;

    public function __construct($host, $db, $user, $pass)
    {
        try {
            $this->instance = new \PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
        } catch (\PDOException $e) {
            print "Database error : " . $e->getMessage() . "<br/>";
            die();
        }

    }


    public function getInstance()
    {
        return $this->instance;
    }
//    public function query($getQuery) {
//        return $this->instance->query($getQuery);
//    }
}