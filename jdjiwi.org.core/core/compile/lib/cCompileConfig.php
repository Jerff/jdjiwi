<?php

class cCompileConfig {

    //cmfCompilePhp
    public static function fileList() {
        return cFileSystem::getFileList(cSoursePath . '.include/');
    }

    //cmfCompileFile
    public static function pathJsCss() {
        return 'core-compile';
    }

}

?>