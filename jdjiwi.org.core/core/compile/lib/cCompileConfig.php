<?php

class cCompileConfig {

    //cmfCompilePhp
    public static function fileList() {
        return cDir::getFiles(cSoursePath . '.include/');
    }

    //cmfCompileFile
    public static function pathJsCss() {
        return 'core-compile';
    }

}

?>