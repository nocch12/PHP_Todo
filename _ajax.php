<?php

require_once(__DIR__ . '/config.php');
require_once(__DIR__ .'/functions.php');
require_once(__DIR__ . '/Todo.php');

$todoApp = new \MyApp\Todo();

// todo.jsからのpost送信を確認
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // tokenチェックと処理の分岐
        $res = $todoApp->post();
        
        header('Content-Type: application/json');
        // json形式で出力
        echo json_encode($res);
        exit;
    } catch (Exception $e) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo $e->getMessage();
        exit;

    }
}