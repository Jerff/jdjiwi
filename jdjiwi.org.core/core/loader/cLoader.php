<?php

// загрузчик
set_include_path(get_include_path() .
        PATH_SEPARATOR . cSoursePath .
        PATH_SEPARATOR . cSoursePath . '_library' .
        PATH_SEPARATOR . cSoursePath . '_library/PEAR' .
        PATH_SEPARATOR . cSoursePath . 'core' .
        PATH_SEPARATOR . cSoursePath . 'extension'
);

cLoader::library('loader/config/cConfig');
cConfig::load('path');
cLoader::library('loader/autoload/cAutoload');
cLoader::library('loader/modul/cModul');
cModul::load('core:core');
cModul::load('file');
cModul::load('pages');

class cLoader {

    static private $mHistory = array();

    static public function setHistory($file) {
        self::$mHistory[$file] = true;
    }

    static public function getIndex() {
        return cCrypt::hash(serialize(self::$mHistory));
    }
    
    static public function isLoad($file) {
        return isset(self::$mHistory[$file]);
    }

    static public function file($file) {
        if (isset(self::$mHistory[$file])) {
            return false;
        }
        self::$mHistory[$file] = true;
        require_once($file . '.php');
        return true;
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

?>