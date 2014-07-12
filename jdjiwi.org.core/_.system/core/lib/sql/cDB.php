<?php

cConfig::load('database');
cLoader::library('core:sql/exception/cSqlException');
cLoader::library('core:sql/mysql/cMySql');

class cDB extends cPatternsStaticRegistry {

    static private $instance;

    public static function sql() {
        if (empty(self::$instance)) {
            switch (cSqlDriver) {
                case 'mysql':
                    self::$instance = new cMySql();
                    break;

                default:
                    throw new cSqlException('нет установлен драйвер базы');
                    exit;
            }
        }
        return self::$instance;
    }

}

?>