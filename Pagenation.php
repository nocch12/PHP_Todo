<?php

namespace MyApp;

class Pagenation {
    private $_commentsPerPage = 5;
    public $page;


    public function __construct() {
        try {
            $this->_db = new \PDO(DSN, DB_USER, DB_PASS);
            $this->_db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public function getCurrentPage() {
        if (preg_match('/^[1-9][0-9]*$/', $_GET['page'])) {
            $page = (int)$_GET['page'];
        } else {
            $page = 1;
        }

        return $page;
    }

    public function getTodos() {
        $page = $this->getCurrentPage();
        $offset = $this->_commentsPerPage * ($page - 1);

        $stmt = $this->_db->prepare("select * from todos order by id desc limit :offset, ". $this->_commentsPerPage);

        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }
    
    public function getPages() {
        $stmt = $this->_db->query("select count(*) from todos");
        $result = $stmt->fetchColumn();
        return ceil($result / 5);
    }
}