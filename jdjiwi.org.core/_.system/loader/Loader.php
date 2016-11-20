<?php

namespace Jdjiwi;

if (!class_exists('\Jdjiwi\Loader\Compile', false)) {
    require(__DIR__ . '/Compile.php');
}

class Loader extends Loader\Compile {

    static private $path = array(
        cSoursePath,
        cSoursePath . '_.system',
        cSoursePath . '_.library',
        cSoursePath . 'application'
    );

    static public function init() {
        set_include_path(get_include_path() . PATH_SEPARATOR . implode(PATH_SEPARATOR, self::$path));
    }

    static public function path(string $file) {
        foreach (self::$path as $path) {
            if (is_file($path . '/' . $file)) {
                return $path . '/' . $file;
            }
        }
        return false;
    }

    static public function library(string $file) {
        self::file(str_replace(':', '/lib/', $file));
    }

    static public function isExtension(string $name) {
        if (!extension_loaded($name)) {
            throw new \cException('расширение не загружено', $name);
        }
    }

}

Loader::init();
Loader::setHistory('loader/Loader');
Loader::setHistory('loader/Compile');
Loader::library('loader/Config');
Config::load('host');
Loader::library('loader/Autoload');
Loader::library('loader/Modul');
Modul::load('loader', true);
