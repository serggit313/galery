<?php 
session_start();

$login = $_POST['login'];
$password = $_POST['password'];
$document = 'users.txt';

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    validate($document, $_POST['login'], $_POST['password']);
}

function validate($document, $login, $password)
{
    if(!empty($login) && !empty($password))
    {
        saveUsers($document, $login, $password);
        return true;
    }
    return false;
}

function saveUsers($document, $login, $password)
{
    if(file_exists($document) && is_readable($document))
    {
        $data = $login . ':' . $password . "\r\n";
        file_put_contents($document, $data, FILE_APPEND);
        return true;
    }
    return false;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
</head>
<body>
<div class="form_register">
        <h3>Регистрация: </h3>
        <form action="#" method="POST">
            <p>
                <input type="text" name="login" placeholder="Login">
            </p>
            <p>
                <input type="text" name="password" placeholder="Password">
            </p>
            <button type="submit">Отправить</button>
        </form>
    <br>
    <?php if(saveUsers($document, $login, $password) == true):?>
        <h1>
            Вы зарегистрированы
        </h1>
    <?php endif;?>
    <br>
    <p>
        <a href="index.php">На главную</a>
    </p>
    <p>
        <a href="auth.php">Авторизация</a>
    </p>
   
</body>
</html>