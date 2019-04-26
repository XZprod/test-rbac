<?php

namespace App;


class User
{
    const TABLE_NAME = 'users';

    public static function getUsers()
    {
        $query = 'select users.id, fullname, phone, time1, time2, groups.title as group_name, groups.id as group_id from users join users_groups on users.id = users_groups.user_id join groups on users_groups.group_id = groups.id;';
        $users = App::app()->db->query($query, \PDO::FETCH_ASSOC)->fetchAll();
        return array_map(function ($e) {
//            $e['phone'] = $e['phone'] ? Formatter::phone($e['phone']) : '';
            $e['time1'] = Formatter::time($e['time1']);
            $e['time2'] = Formatter::time($e['time2']);
            return $e;
        }, $users);
    }

    public static function updateUser($formData)
    {
        $fields = ['fullname', 'phone'];
        // 'group_id'
        if (!isset($formData['id'])) throw new \Exception('Invalid UserID');
        $params = [];
        foreach ($formData as $field => $value) {
            if (in_array($field, $fields) && $value) {
                $params[] = $field . '="' . $value . '"';
            }
        }

        $sql = 'UPDATE users SET ' . implode(',', $params) . ' WHERE id = ' . $formData['id'] . ';';
        App::app()->db->query($sql);
        if (App::app()->db->errorCode() > 0) {
            return App::app()->db->errorInfo();
        }
        $sql = 'UPDATE users_groups SET group_id = ' . $formData['group_id'] . ' WHERE user_id =' . $formData['id'];
        App::app()->db->query($sql);
        if (App::app()->db->errorCode() > 0) {
            return App::app()->db->errorInfo();
        }
        return true;
    }

    public static function createUser($formData)
    {
        $sql = 'INSERT INTO users (fullname, phone) VALUE ("' . $formData['fullname'] . '", "' . $formData['phone'] . '")';
        App::app()->db->exec($sql);
        if (App::app()->db->errorCode() > 0) {
            return App::app()->db->errorInfo();
        }
        $id = App::app()->db->lastInsertId();


        $sql = 'INSERT INTO users_groups (user_id, group_id) VALUE ("' . $formData['fullname'] . '", "' . $formData['phone'] . '")';
        App::app()->db->exec($sql);
        if (App::app()->db->errorCode() > 0) {
            return App::app()->db->errorInfo();
        }
        return true;
    }

    public static function deleteUser($id)
    {

        $sql = 'DELETE FROM users_groups WHERE user_id = ' . $id;
        App::app()->db->exec($sql);

        $sql = 'DELETE FROM users WHERE id = ' . $id;
        App::app()->db->exec($sql);

        if (App::app()->db->errorCode() > 0) {
            return App::app()->db->errorInfo();
        }
        return true;
    }

    public static function can($user, $item)
    {
        $sql = 'select group_id from users_groups where user_id = ' . $user['id'];
        $groupid = App::app()->db->query($sql)->fetchColumn();
        $sql = 'select name from items_groups join auth_items on auth_items.id = items_groups.item_id WHERE group_id=' . $groupid . ';';
        $items = App::app()->db->query($sql)->fetchAll();
        foreach ($items as $i) {
            if ($i['name'] == $item) return true;
        }
        return false;
    }
}