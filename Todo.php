<?php

namespace MyApp;

class Todo {
    private $_db;

    public function __construct() {
        $this->_createToken();
        try {
            $this->_db = new \PDO(DSN, DB_USER, DB_PASS);
            $this->_db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    }

    private function _createToken() {
        if(!isset($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(\openssl_random_pseudo_bytes(16));
        }
    }


    public function post() {
        $this->_validateToken();
        if (!isset($_POST['mode'])) {
            throw new \Exception('mode not set');
        }

        switch ($_POST['mode']) {
            case 'create':
                return $this->_create();
            case 'delete':
                return $this->_delete();
        }
    }

    private function _validateToken() {
        if (
            !isset($_SESSION['token']) ||
            !isset($_POST['token']) ||
            $_POST['token'] !== $_SESSION['token']
        ) {
            throw new \Exceotion('invalid Token');
        }
    }

    private function _create() {
       if(!isset($_POST['title'])) {
           throw new \Exception('[create] mode not set');
       }

        $sql = sprintf('insert into todos (title) values(:title)', $_POST['title']);
        $stmt = $this->_db->prepare($sql);
        $stmt->execute([':title' => $_POST['title']]);

        return [
            'id' => $this->_db->lastInsertId()
        ];
    }

    private function _delete() {
         if(!isset($_POST['id'])) {
            throw new \Exception('[delete] id not set');
        }

        $sql = sprintf("delete from todos where id = %d", $_POST['id']);
        $stmt = $this->_db->prepare($sql);
        $stmt->execute();

        return [];
    }

}