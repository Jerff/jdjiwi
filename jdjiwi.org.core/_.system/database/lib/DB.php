<?php

use Jdjiwi\Database\Exception,
    \Jdjiwi\Config,
    \Jdjiwi\Loader;

//Loader::library('database:driver/cMySql');
//Loader::library('database:Exception');

class cDB {

    const SQL_CALC_FOUND_ROWS = 'SQL_CALC_FOUND_ROWS';

    static private $driver;

    private static function driver() {
        if (empty(self::$driver)) {
            switch (Config::get('database.driver')) {
                case 'mysql':
                    self::$driver = new cMySql();
                    break;

                default:
                    throw new Exception('нет установлен драйвер базы');
                    exit;
            }
        }
        return self::$driver;
    }

    public static function table($table) {
        return Config::get('database.pefix') . str_replace('.', '_', $table);
    }

    public static function __callStatic($name, $arguments) {
        switch ($name) {
            case 'select':
            case 'selectCalcFoundRows':
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
