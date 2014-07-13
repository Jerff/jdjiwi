<?php

cLoader::library('sql:exception/cSqlException');
cLoader::library('sql:mysql/cMySql');

class cDB extends cPatternsStaticRegistry {

    static private $instance;

    private static function driver() {
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
        switch ($name) {
            case 'select':
            case 'insert':
            case 'update':
            case 'delete':
            case 'truncate':
                return self::driver()->query()->$name(...$arguments);
                break;

            default:
                return self::driver()->$name(...$arguments);
                break;
        }
    }

}

?>