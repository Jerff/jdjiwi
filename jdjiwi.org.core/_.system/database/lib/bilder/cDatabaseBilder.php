<?php

cLoader::library('database:registry/cDatabaseRegistry');

abstract class cDatabaseBilder extends cDatabaseRegistry {

    private $mQuery = array();

    // очищение таблиц базы
    public function truncate() {
        foreach (func_get_args() as $t) {
            $this->sql()->placeholder("TRUNCATE TABLE ?t", $t);
        }
    }

    private function compile() {
        pre(self::$mQuery);
        return 'SELECT 1';
    }

    public function exec() {
        return $this->sql()->query($this->compile());
    }

}
