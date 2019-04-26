<?php

namespace App;

class Auth
{

    public static function getGroupsDropdown()
    {
        $groups = App::app()->db->query('SELECT id, title from groups')->fetchAll();
        return $groups;
    }

    public static function getRolesDropdown()
    {
        $groups = App::app()->db->query('SELECT id, title from auth_items')->fetchAll();
        return $groups;
    }

    public static function getRolesGroups()
    {
        $groups = App::app()->db->query('SELECT * from items_groups')->fetchAll();
        return $groups;
    }

    public static function updateRights($data)
    {
        $sql = "";
        if ($data['allow']) {
            $sql = 'INSERT INTO items_groups (group_id, item_id) VALUES (' . $data["group_id"] . ', ' . $data['role_id'] . ')';
        } else {
            $sql = 'DELETE FROM items_groups WHERE group_id=' . $data["group_id"] . ' AND item_id = ' . $data['role_id'];
        }
        App::app()->db->query($sql);
        if (App::app()->db->errorCode() > 0) {
            return App::app()->db->errorInfo();
        }
        return true;
    }

    public static function auth($username, $pass)
    {
        $username = Formatter::string($username);
        $pass = Formatter::string($pass);
        $dbh = App::app()->db;
        //todo md5 прикрутить мб
        $sql = 'SELECT * FROM users WHERE fullname = :fullname AND pass = :pass';
        $sth = $dbh->prepare($sql, array(\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY));
        $sth->execute([':fullname' => $username, ':pass' => $pass]);

        $user = $sth->fetch();
        if ($user) {
            $key = self::updateKey($user);
        } else {
            return false;
        }
    }

    public static function getUserByKey($key)
    {
        $dbh = App::app()->db;
        $sql = 'SELECT * FROM users WHERE key = :key';
        $sth = $dbh->prepare($sql, array(\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY));
        $sth->execute([':key' => $key]);
        $user = $sth->fetch();
        if (!$user) {
            return false;
        }
        return $user;
    }

    public static function getUser()
    {
        //todo поставить пез перезагрузки
        $key = $_COOKIE['key'] ?? null;
        if ($key) {
            $dbh = App::app()->db;
            $sql = 'SELECT * FROM users WHERE `key` = :key';
            $sth = $dbh->prepare($sql, array(\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY));
            $sth->execute([':key' => $key]);
            $user = $sth->fetch();
            if (!$user) {
                return false;
            }
            return $user;
        }
    }

    public static function updateKey($user)
    {
        $key = self::generateKey();
        $sql = 'UPDATE users SET `key` = "' . $key . '" WHERE id =' . $user['id'];
        App::app()->db->query($sql);
        setcookie('key', $key, time() + 10000);
        return $key;
    }

    public static function generateKey()
    {
        $bytes = \random_bytes(20);
        return bin2hex($bytes);
    }

}