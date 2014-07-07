<?php

class cCompileConfig {

    //cmfCompilePhp
    public static function fileList() {
        return array(
            '.include.admin.php',
            '.include.ajax.php',
            '.include.application.php',
            '.include.application.system.php',
            '.include.compileJsCss.php',
            '.include.cron.php',
            '.include.wysiwyng.php'
        );
    }

    //cmfCompileFile
    public static function pathJsCss() {
        return 'core-compile';
    }

}

?>