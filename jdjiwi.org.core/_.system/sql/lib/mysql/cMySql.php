<?php

cLoader::library('sql:mysql/cMysqlQueryBilder');
cLoader::library('sql:cSql');
cLoader::library('sql:pdo/cPDO');

class cMySql extends cSql {

    protected function driver() {
        static $driver = null;
        if (empty($driver)) {
            $driver = new cPDO(cConfig::get('database.mysql.db'), cConfig::get('database.mysql.host'), cConfig::get('database.mysql.user'), cConfig::get('database.mysql.password'));
            foreach ((array) cConfig::get('database.mysql.query') as $query) {
                $driver->query($query);
            }
        }
        return $driver;
    }

    public function query($query = null) {
        if (empty($query)) {
            return $this->register('cMysqlQueryBilder');
        } else {
            return parent::query($query);
        }
    }

}

?>