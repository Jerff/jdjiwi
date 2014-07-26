<?php

// загрузчик
set_include_path(get_include_path() .
        PATH_SEPARATOR . cSoursePath .
        PATH_SEPARATOR . cSoursePath . '_.library' .
        PATH_SEPARATOR . cSoursePath . '_.library/PEAR' .
        PATH_SEPARATOR . cSoursePath . '_.system' .
        PATH_SEPARATOR . cSoursePath . 'application'
);

if (!class_exists('cLoaderCompile', false)) {
    require(__DIR__ . '/compile/cLoaderCompile.php');
}

class cLoader extends cLoaderCompile {

    static public function library($file) {
        self::file(str_replace(':', '/lib/', $file));
    }

    static public function isExtension($name) {
        if (!extension_loaded($name)) {
            throw new cException('расширение не загружено', $name);
        }
    }

}

cLoader::setHistory('loader/cLoader');
cLoader::setHistory('loader/compile/cLoaderCompile');
cLoader::library('loader/config/cConfig');
cConfig::load('host');
cConfig::load('path');
cLoader::library('loader/autoload/cAutoload');
cLoader::library('loader/modul/cModul');
cModul::load('loader');
?>