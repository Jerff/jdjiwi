<?php

// загрузчик
set_include_path(get_include_path() .
        PATH_SEPARATOR . cRootPath .
        PATH_SEPARATOR . cWWWPath .
        PATH_SEPARATOR . cSoursePath .
        PATH_SEPARATOR . cSoursePath . '_.config/' .
        PATH_SEPARATOR . cSoursePath . '_.core/' .
        PATH_SEPARATOR . cSoursePath . '_library/' .
        PATH_SEPARATOR . cSoursePath . '_library/PEAR/' .
        PATH_SEPARATOR . cSoursePath . 'core/' .
        PATH_SEPARATOR . cSoursePath . 'extension/'
);

cLoader::library('loader/cAutoload');
cLoader::library('debug/cConfig');
cLoader::library('loader/cLoaderException');

class cLoader {

    static private $mModul = array();

    static public function library($file) {
        if (!class_exists(basename($file), false)) {
            self::file($file . '.php');
        }
    }

    static private function isFile($file) {
        return is_file($file . '.php');
    }

    static private function file($file) {
        require_once($file . '.php');
    }

    static public function includeModul($name) {
        if (empty($name) or ! is_string($name)) {
            throw new cLoaderException("Не указано имя модуля");
        }
        if (preg_match("#[^a-z0-9._]#iS", $name)) {
            throw new cLoaderException(sprintf("Название модуля '%s' не корректно", $name));
        }
        if (isset(self::$mModul[$name])) {
            return self::$mModul[$name];
        }
        if (!self::isFile($name . '/include')) {
            throw new cLoaderException("Модуль не найден");
        }
    }

}

?>