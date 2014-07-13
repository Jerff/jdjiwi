<?php

cLoader::library('sql:exception/cSqlException');
cLoader::library('sql:mysql/cMySql');

class cDB extends cPatternsStaticRegistry {

    static private $instance;

    const queryBilder = 'select|insert|update|delete|truncate';

    public static function sql() {
        if (empty(self::$instance)) {
            switch (cConfig::get('database.mysql')) {
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

    public static function table($table) {
        return cConfig::get('database.mysql') . str_replace('.', '_', $table);
    }

    public static function __callStatic($name, $arguments) {
        static $queryBilder = null;
        if (empty($queryBilder)) {
            $queryBilder = explode('|', self::queryBilder);
            $queryBilder = array_combine($queryBilder, $queryBilder);
        }
        if (isset($queryBilder[$name])) {
            return self::sql()->query()->$name(...$arguments);
        }
    }

}

?>