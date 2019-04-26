<?php
require __DIR__ . '/vendor/autoload.php';

use App\Auth;

if(Auth::getUser()) {
    echo 'Вы уже авторизованы';
    exit;
}
if ($_POST) {
    Auth::auth($_POST['fullname'], $_POST['pass']);
} else {
    echo <<<EE
<form action="" method="post">
    Имя: <input type="text" name="fullname">
    Пароль: <input type="password" name="pass">
    <input type="submit">
</form>
EE;
}