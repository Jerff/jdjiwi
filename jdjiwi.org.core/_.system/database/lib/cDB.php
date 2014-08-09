<?php

cLoader::library('database:exception/cDatabaseException');
cLoader::library('database:driver/cMySql');

class cDB {

    static private $driver;

    private static function driver() {
        if (empty(self::$driver)) {
            switch (cConfig::get('database.driver')) {
                case 'mysql':
                    self::$driver = new cMySql();
                    break;

                default:
                    throw new cDatabaseException('нет установлен драйвер базы');
                    exit;
            }
        }
        return self::$driver;
    }

    public static function table($table) {
        return cConfig::get('database.pefix') . str_replace('.', '_', $table);
    }

    public static function __callStatic($name, $arguments) {
        switch ($name) {
            case 'select':
            case 'insert':
            case 'update':
            case 'delete':
            case 'truncate':
            case 'optimize':
            case 'union':
                return self::driver()->bilder()->$name(...$arguments);
                break;

            default:
                return self::driver()->$name(...$arguments);
                break;
        }
    }

}
