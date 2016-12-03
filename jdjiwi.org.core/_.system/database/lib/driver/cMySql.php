<?php

//\Jdjiwi\Loader::library('database:bilder/cMysqlbilder');
//\Jdjiwi\Loader::library('database:placeholder/cDatabasePlaceholder');
//\Jdjiwi\Loader::library('database:driver/cDatabase');
//\Jdjiwi\Loader::library('database:pdo/cPDO');

class cMySql extends cDatabase {

    protected function driver() {
        static $driver = null;
        if (empty($driver)) {
            $driver = new cPDO(\Jdjiwi\Config::get('database.driver'), \Jdjiwi\Config::get('database.mysql.db'), \Jdjiwi\Config::get('database.mysql.host'), \Jdjiwi\Config::get('database.mysql.user'), \Jdjiwi\Config::get('database.mysql.password'));
            foreach ((array) \Jdjiwi\Config::get('database.mysql.query') as $query) {
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
        return new cMysqlbilder();
    }

    /*
     * utility
     */

    public function utility() {
        return $this->register('cMysqlUtility');
    }

}
