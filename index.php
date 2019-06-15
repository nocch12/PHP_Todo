<?php

require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/functions.php');
require_once(__DIR__ . '/Todo.php');

$todoApp = new \MyApp\Todo();
$todos = $todoApp->getAll();

var_dump($todos);

exit;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Todos</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div id="container">
        <h1>Todos</h1>
        <form action="">
            <input type="text" id="new_todo" placeholder="What needss to be done?">
        </form>
        <ul>
            <li>
                <input type="checkbox">
                <span>Do sommething</span>
                <div class="delete_todo">x</div>
            </li>
            <li>
                <input type="checkbox" checked>
                <span class="done">Do sommething</span>
                <div class="delete_todo">x</div>
            </li>
        </ul>
    </div>
</body>
</html>
