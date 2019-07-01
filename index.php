<?php

require_once(__DIR__ . '/config.php');
require_once(__DIR__ .'/functions.php');
require_once(__DIR__ . '/Todo.php');
require_once(__DIR__ . '/Pagenation.php');

$todoApp = new \MyApp\Todo();
$pagenation = new \MyApp\Pagenation();


$todos = $pagenation->getTodos();
$currentPage = $pagenation->getCurrentPage();
$maxPage = (int)$pagenation->getPages();


?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Todo</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">

</head>
<body>
    <div id="container">
        <div id="title">
            <h1>My To Do List</h1>
        </div>
        <div class="main_wrap">
            <div id="new_todo_wrap">
                <form action="" id="new_todo_form">
                    <div class="new_todo_wrap"><input type="text" id="new_todo" class="form-control"></div>
                    <div class="submit_btn_wrap">
                    <input type="submit" value="追加する" class="btn btn-primary"></div>
                </form>
            </div>
            <div id="todo_list">
                <ul id="todos">
                    <?php foreach($todos as $todo) : ?>
                    <li class="todo card" id="todo_<?= h($todo->id); ?>" data-id="<?= h($todo->id); ?>">
                        <p class="card-text">
                        <?= h($todo->title); ?>
                        </p>
                        <div class="delete_todo_wrap">
                            <button class="delete_btn btn delete_todo">
                                <span class="delete_line delete_line1"></span>
                                <span class="delete_line delete_line2"></span>
                            </button>
                            <button class="btn delete_confirm">
                                    本当に削除しますか？
                            </button>
                        </div>
                    </li>
                    <?php endforeach; ?>
                    <li class="todo card" id="todo_template" data-id="">
                        <p class="card-text">
                        </p>
                        <div class="delete_todo_wrap">
                            <button class="delete_btn btn delete_todo">
                                <span class="delete_line delete_line1"></span>
                                <span class="delete_line delete_line2"></span>
                            </button>
                            <button class="btn delete_confirm">
                                    本当に削除しますか？
                            </button>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="pagenation">
                <?php if($currentPage !== 1 && $maxPage !== 0) : ?>
                <a href="/?page=<?= $currentPage - 1; ?>">前</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $maxPage; $i++) : ?>
                    <?php if($i === $currentPage) : ?>
                    <a class="current_page"><?= $i; ?></a>
                    <?php else : ?>
                    <a href="?page=<?= $i; ?>"><?= $i; ?></a>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if($currentPage !== $maxPage && $maxPage !== 0) : ?>
                <a href="/?page=<?= $currentPage + 1; ?>">次</a>
                <?php endif; ?>

            </div>
        </div>
    </div>
    
    <input type="hidden" id="token" value="<?= h($_SESSION['token']); ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="todo.js"></script>
</body>
</html>