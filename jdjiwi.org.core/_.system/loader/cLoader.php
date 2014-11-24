<?php

if (!class_exists('cLoaderCompile', false)) {
    require(__DIR__ . '/compile/cLoaderCompile.php');
}

class cLoader extends cLoaderCompile {

    static private $path = array(
        cSoursePath, cSoursePath . '_.system',
        cSoursePath, cSoursePath . '_.library',
        PATH_SEPARATOR . cSoursePath . 'application'
    );

    static public function init() {
        set_include_path(get_include_path() . PATH_SEPARATOR . implode(PATH_SEPARATOR, self::$path));
    }

    static public function path($file) {
        foreach (self::$path as $path) {
            if (is_file($path . '/' . $file)) {
                return $path . '/' . $file;
            }
        }
        return false;
    }

    static public function library($file) {
        self::file(str_replace(':', '/lib/', $file));
    }

    static public function isExtension($name) {
        if (!extension_loaded($name)) {
            throw new cException('расширение не загружено', $name);
        }
    }

}

cLoader::init();
cLoader::setHistory('loader/cLoader');
cLoader::setHistory('loader/compile/cLoaderCompile');
cLoader::library('loader/config/cConfig');
cConfig::load('host');
cConfig::load('path');
cLoader::library('loader/autoload/cAutoload');
cLoader::library('loader/modul/cModul');
cModul::load('loader', true);
