<?php
require __DIR__ . '/vendor/autoload.php';
date_default_timezone_set('UTC');

use App\App;
use App\Auth;
use App\Formatter;
use App\User;

//todo может роутер оформить
$action = explode('/', $_SERVER['REQUEST_URI'])[2];

if ($action === 'get-users') {
    $users = User::getUsers();
    echo json_encode($users);
}

if ($action === 'get-groups') {
    $groups = Auth::getGroupsDropdown();
    echo json_encode($groups);
}

if ($action === 'get-roles') {
    $groups = Auth::getRolesDropdown();
    echo json_encode($groups);
}

if ($action === 'get-roles_groups') {
    $groups = Auth::getRolesGroups();
    echo json_encode($groups);
}

if ($action === 'update-user') {
    //мда
    $entityBody = json_decode(file_get_contents('php://input'));
    if ($entityBody) {
        $err = User::updateUser((array)$entityBody);
        if (User::updateUser((array)$entityBody)) {
            echo json_encode(['status' => 'success', 'message' => 'успех']);
        } else {
            echo json_encode(['status' => 'error', 'message' => $err]);
        }
    }
}

if ($action === 'delete-user') {
    //мда
    $entityBody = json_decode(file_get_contents('php://input'));
    if ($entityBody) {
        $id = $entityBody->id;
        if ($id) {
            if (User::deleteUser($id)) {
                echo json_encode(['status' => 'success', 'message' => 'успех']);
            } else {
                echo json_encode(['status' => 'error', 'message' => $err]);
            }
        }
    }
}

if ($action === 'create-user') {
    //мда
    $entityBody = json_decode(file_get_contents('php://input'));
    if ($entityBody) {
        if (User::createUser((array)$entityBody)) {
            echo json_encode(['status' => 'success', 'message' => 'успех']);
        } else {
            echo json_encode(['status' => 'error', 'message' => $err]);
        }
    }
}

if ($action === 'update-role') {
    //мда
    $entityBody = json_decode(file_get_contents('php://input'));
    if ($entityBody) {
        if (Auth::updateRights((array)$entityBody)) {
            echo json_encode(['status' => 'success', 'message' => 'успех']);
        } else {
            echo json_encode(['status' => 'error', 'message' => $err]);
        }
    }
}