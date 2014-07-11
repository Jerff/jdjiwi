<?php

cLoader::config('database');
cLoader::library('core:sql/mysql/cMySql');

class cDB extends cPatternsStaticRegistry {

    public static function sql() {
        static $sql = null;
        if (empty($sql)) {
            switch (cSqlDriver) {
                case 'mysql':
                    $sql = new cMySql();
                    break;

                default:
                    break;
            }
        }
        return $sql;
    }

}

?>