<?php

cLoader::library('core:sql/mysql/cMysqlConfig');
cLoader::library('core:sql/cSql');
cLoader::library('core:sql/pdo/cPDO');

class cMySql extends cSql {

    protected function config() {
        return $this->register('cMysqlConfig');
    }

    protected function driver() {
        static $driver = null;
        if (empty($driver)) {
            $driver = new cPDO(cMysqDb, cMysqlHost, cMysqUser, cMysqPassword);
            $this->config()->init($driver);
        }
        return $driver;
    }

}

?>