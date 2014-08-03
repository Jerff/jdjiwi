<?php

cLoader::library('sql:pdo/cPDOStatement');

class cPDO extends PDO {

    function __construct($db, $host, $user, $password) {
        try {
            parent::__construct("mysql:dbname={$db};host={$host}", $user, $password);
            $this->setAttribute(PDO::ATTR_STATEMENT_CLASS, array('cPDOStatement'));
        } catch (PDOException $e) {
            print "Error!: база данных недоступна";
            cLog::errorLog($e);
            exit();
        }
    }

}

