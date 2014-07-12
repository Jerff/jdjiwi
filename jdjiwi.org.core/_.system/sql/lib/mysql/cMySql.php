<?php

cLoader::library('sql:mysql/cMysqlConfig');
cLoader::library('sql:mysql/cMysqlQuery');
cLoader::library('sql:cSql');
cLoader::library('sql:pdo/cPDO');

class cMySql extends cSql {

    protected function config() {
        return $this->register('cMysqlConfig');
    }

    protected function driver() {
        static $driver = null;
        if (empty($driver)) {
            $driver = new cPDO(cConfig::get('database.mysql.db'), cConfig::get('database.mysql.host'), cConfig::get('database.mysql.user'), cConfig::get('database.mysql.password'));
            $this->config()->init($driver);
        }
        return $driver;
    }

    public function query($query = null) {
        if (empty($query)) {
            return $this->register('cMysqlQuery');
        } else {
            return parent::query($query);
        }
    }

}

?>