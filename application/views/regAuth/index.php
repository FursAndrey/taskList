<?
ini_set('display_errors', 1);	//1 - показывать ошибки, 0 - скрывать
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>php файлы</title>
        <meta charset="utf-8" />
    </head>
    <body>
            <p><a href="/regAuth/page2">Ссылка на 2-ю страницу</a></p>
        <?if($auth == 0){?>
            <p>Выполните <a href="/RegAuth/ra/auth">Авторизацию</a> / <a href="/RegAuth/ra/reg">Регистрацию</a></p>
        <?}else if($auth == 1){?>
            <p>Привет, <?=$login?></p>
            <p><a href="/RegAuth/logOut">Выход</a></p>
            <p><a href="/Task/taskList">Показать задачи</a></p>
        <?}?>
    </body>
</html>