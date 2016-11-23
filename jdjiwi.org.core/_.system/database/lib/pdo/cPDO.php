<?php

\Jdjiwi\Loader::library('database:pdo/cResult');

class cPDO extends PDO {

    function __construct($driver, $db, $host, $user, $password) {
        try {
            parent::__construct("{$driver}:dbname={$db};host={$host}", $user, $password);
            $this->setAttribute(PDO::ATTR_STATEMENT_CLASS, array('cResult'));
        } catch (PDOException $e) {
            print "Error!: база данных недоступна";
            \Jdjiwi\Log::addError($e);
            exit();
        }
    }

}
