<?php
session_start();

$login = $_POST['login'];
$password = $_POST['password'];
$check = $_POST['check'];
$document = 'users.txt';

function getUsers($document)
{
    if(file_exists($document))
	{
		$userArr = file($document);
		$usersArr2 = [];
		$users = [];
		foreach ($userArr as $CleanString) {
			$usersArr2[] = str_replace("\r\n", "", $CleanString);
		}
		foreach ($usersArr2 as $user) {
			$users[] = explode(":", $user);
		}
		return $users;
	}
	return false;
}

function checkUsers($document, $login, $password, $check)
{
    if(file_exists($document))
	{
		$users = getUsers($document);

			foreach ($users as $user) {
				if($login == $user[0] && $password == $user[1])
				{
					$_SESSION['user'] = 'ok';
					if($check == 'on')
					{
						setcookie('user','ok', time()+3600, '/');
					}
				}
			}
			return true;
	}
	return false;
}

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if(checkUsers($document, $login, $password, $check))
	{
		header( 'location: index.php' );
	}
	else
	{
		echo "<h1>Данные введены не верно.Попробуйте еще раз...</h1>";
	}
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
        <h3>Авторизация: </h3>
        <form action="#" method="POST">
            <p>
                <input type="text" name="login" placeholder="Login">
            </p>
            <p>
                <input type="text" name="password" placeholder="Password">
			</p>
			<p>
				<input type="checkbox" name="check">
			</p>
            <button type="submit">Отправить</button>
        </form>
    <br>
    <p>
        <a href="index.php">На главную</a>
    </p>
    <p>
        <a href="auth.php">Авторизация</a>
    </p>
   
</body>
</html>