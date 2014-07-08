<?php

// загрузчик
set_include_path(get_include_path() .
//        PATH_SEPARATOR . cRootPath .
//        PATH_SEPARATOR . cWWWPath .
//        PATH_SEPARATOR . cSoursePath . '_.config/' .
        PATH_SEPARATOR . cSoursePath . '_library' .
        PATH_SEPARATOR . cSoursePath . '_library/PEAR' .
        PATH_SEPARATOR . cSoursePath . 'core' .
        PATH_SEPARATOR . cSoursePath . 'extension'
);

cLoader::library('loader/cAutoload');
cLoader::library('loader/cModul');
cModul::load('core:core');
cModul::load('file');
cModul::load('pages');

class cLoader {

    static public function library($file) {
        $file = str_replace(':', '/lib/', $file);
        if (!class_exists(basename($file), false)) {
            require_once($file . '.php');
        }
    }

    static public function config($file) {
        if (is_file(cConfigPath . $file . '.php')) {
            require_once(cConfigPath . $file . '.php');
        }
    }

    static public function isExtension($name) {
        if (!extension_loaded($name)) {
            throw new cException('расширение не загружено', $name);
        }
    }

}

?>