<?
ini_set('display_errors', 1);	//1 - показывать ошибки, 0 - скрывать
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>php файлы</title>
        <meta charset="utf-8" />
        <link href="/css/style.css" type="text/css" rel="stylesheet"/>
    </head>
    <body>
        <form method="POST" action="/Task/taskIns">
            <p>Тема:</p><p><input type="text" name="head"/></p>
            <p>Текст задачи:</p><p><textarea name="text" placeholder="Введите задачу" rows="5" cols="50"></textarea></p>
            <p>Срок:</p><p><input type="date" name="deadLine" max="2038-01-19" min="2018-01-01"/></p>
            <button>Send</button><br/>
        </form>
    </body>
</html>