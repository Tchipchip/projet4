<?php

namespace project\model;

include $_SERVER['DOCUMENT_ROOT'].'/config.php';


class Manager
{
    protected function dbConnect() {
        $db = new \PDO('mysql:host='.HOST.';dbname='.DBNAME.';charset=utf8', USER, PASS);
        return $db;
    }
}