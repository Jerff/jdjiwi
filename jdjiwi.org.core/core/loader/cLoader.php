<?php

// загрузчик
set_include_path(get_include_path() .
        PATH_SEPARATOR . cRootPath .
        PATH_SEPARATOR . cWWWPath .
        PATH_SEPARATOR . cSoursePath .
        PATH_SEPARATOR . cSoursePath . '_.config/' .
        PATH_SEPARATOR . cSoursePath . '_library/' .
        PATH_SEPARATOR . cSoursePath . '_library/PEAR/'
);

cLoader::library('cAutoload');
cLoader::library('cModul');

class cLoader {

    static public function library($file) {
        if (!class_exists(basename($file), false)) {
            require_once($file . '.php');
        }
    }

}

?>