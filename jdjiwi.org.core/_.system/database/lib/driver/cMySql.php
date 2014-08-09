<?php

cLoader::library('database:bilder/cMysqlbilder');
cLoader::library('database:placeholder/cDatabasePlaceholder');
cLoader::library('database:driver/cDatabase');
cLoader::library('database:pdo/cPDO');

class cMySql extends cDatabase {

    protected function driver() {
        static $driver = null;
        if (empty($driver)) {
            $driver = new cPDO(cConfig::get('database.driver'), cConfig::get('database.mysql.db'), cConfig::get('database.mysql.host'), cConfig::get('database.mysql.user'), cConfig::get('database.mysql.password'));
            foreach ((array) cConfig::get('database.mysql.query') as $query) {
                $driver->query($query);
            }
        }
        return $driver;
    }

    /*
     * placeholder
     */

    public function placeholder() {
        return $this->register('cDatabasePlaceholder')->query(...func_get_args());
    }

    /*
     * bilder
     */

    public function bilder() {
        return $this->register('cMysqlbilder');
    }

}
