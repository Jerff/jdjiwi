<?php

// загрузчик
set_include_path(get_include_path() .
        PATH_SEPARATOR . cRootPath .
        PATH_SEPARATOR . cWWWPath .
        PATH_SEPARATOR . cSoursePath .
        PATH_SEPARATOR . cSoursePath . '_.config/' .
        PATH_SEPARATOR . cSoursePath . '_library/' .
        PATH_SEPARATOR . cSoursePath . '_library/PEAR/' .
        PATH_SEPARATOR . cSoursePath . 'core' .
        PATH_SEPARATOR . cSoursePath . 'extension'
);

cLoader::library('cAutoload');
cLoader::library('cModul');

class cLoader {

    static public function library($file) {
        $file = str_replace(':', '/lib/', $file);
        if (!class_exists(basename($file), false)) {
            require_once($file . '.php');
        }
    }

    static public function isExtension($name) {
        if (!extension_loaded($name)) {
            throw new cException('расширение не загружено', $name);
        }
    }

}

?>