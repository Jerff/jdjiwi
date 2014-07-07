<?php

cLoader::library('core:sql/cSqlDriver');

class cMySql extends cSqlDriver {

    function __construct() {
        $host = cMysqlHost;
        $db = cMysqDb;
        $dsn = "mysql:dbname={$db};host={$host}";
        $res = new cmfPDO($dsn, cMysqUser, cMysqPassword);
        $this->set($res);
    }

}

?>