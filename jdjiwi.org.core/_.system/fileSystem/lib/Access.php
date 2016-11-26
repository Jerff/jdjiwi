<?php

namespace Jdjiwi\FileSystem;

use Jdjiwi\Config;

class Access {
    /*
     * FILE - проверяет принадлежность к папке данных
     * CORE - проверяет принадлежность к папкам сайта
     */

    const FILE = 0;
    const CORE = 1;

    static private $item = self::FILE;
    static private $arItem = array();

    static public function set($mode) {
        if (!empty(self::$item)) {
            self::$arItem[] = self::$item;
        }
        self::$item = $mode;
    }

    static public function get() {
        return self::$item;
    }

    static public function free() {
        if (empty(self::$arItem)) {
            self::$item = self::FILE;
        } else {
            self::$item = array_pop(self::$arItem);
        }
    }

    static public function path($path) {
        $arPath = array();
        switch (self::get()) {
            case self::CORE:
                $arPath[] = cSoursePath;
                $arPath[] = cWWWPath;
                break;

            case self::FILE:
                $arPath[] = Config::get('path.data');
                $arPath[] = Config::get('path.compile');
                $arPath[] = Config::get('cache.site.path');
                $arPath[] = Config::get('path.file');
                break;

            default:
                throw new Exception('Неизветный статус доступа к файлам', self::get());
                break;
        }
        foreach ($arPath as $root) {
            if (strpos($path, $root) === 0) {
                return;
            }
        }
        throw new Exception('Попытка доступа к запрещенной папке, вне правил {уровень доступа ' . self::get() . '}', $path);
    }

}
