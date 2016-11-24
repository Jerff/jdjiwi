<?php

use Jdjiwi\FileSystem\Exception,
    Jdjiwi\Config;

class cFileAccess {
    /*
     * FILE - проверяет принадлежность к папке данных
     * CORE - проверяет принадлежность к папкам сайта
     */

    const FILE = 0;
    const CORE = 1;

    static private $item = self::FILE;
    static private $mItem = array();

    static public function set($mode) {
        if (!empty(self::$item)) {
            self::$mItem[] = self::$item;
        }
        self::$item = $mode;
    }

    static public function get() {
        return self::$item;
    }

    static public function free() {
        if (empty(self::$mItem)) {
            self::$item = self::FILE;
        } else {
            self::$item = array_pop(self::$mItem);
        }
    }

    static public function path($path) {
        $mPath = array();
        switch (self::get()) {
            case self::CORE:
                $mPath[] = cSoursePath;
                $mPath[] = cWWWPath;
                break;

            case self::FILE:
                $mPath[] = Config::get('path.data');
                $mPath[] = Config::get('path.compile');
                $mPath[] = Config::get('cache.site.path');
                $mPath[] = Config::get('path.file');
                break;

            default:
                throw new Exception('Неизветный статус доступа к файлам', self::get());
                break;
        }
        foreach ($mPath as $root) {
            if (strpos($path, $root) === 0) {
                return;
            }
        }
        throw new Exception('Попытка доступа к запрещенной папке, вне правил {уровень доступа ' . self::get() . '}', $path);
    }

}