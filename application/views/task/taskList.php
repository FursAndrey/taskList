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
        <p><a href="/regAuth/page2">Ссылка на 2-ю страницу</a></p>
        <p>Привет, <?=$login?></p>
        <p><a href="/RegAuth/logOut">Выход</a> <a href="/Task/taskInsert">Добавить</a></p>
        <div id="box1">
        <?
        foreach ($task as $row){
            $mas = [];
            foreach ($row as $key => $dat){
                $mas[$key] = $dat;
            }?>
            <div dataid="<?=$mas['id']?>">
                <h2><?=$mas['headTask']?></h2>
                <? $deadLine = date('d-m-Y',$mas['deadLine']); ?>
                <time>Срок: <?=$deadLine?></time>
                <p><?=$mas['textTask']?></p>
                <div class="red"><a href="/Task/taskUpdate/<?=$mas['id']?>">Редактировать</a></div>
                <div class="del"><a href="/Task/taskDel/<?=$mas['id']?>">X</a></div>
            </div>
        <?}?>
        </div>
    </body>
</html>