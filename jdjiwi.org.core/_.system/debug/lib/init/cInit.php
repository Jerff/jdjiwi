<?php

cModul::load('ajax');
cInit::init();

class cInit {
    /*
     * инициализация работы
     */

    public static function init() {
        ini_set('html_errors', 'On');
        ini_set('docref_root', '');
        ini_set('docref_ext', '');
        error_reporting(E_ALL);

        set_exception_handler(function($e) {
            if (is_a($e, 'cException')) {
                $e->errorLog('Необработанное исключение');
            } else {
                cLog::errorLog($e);
            }
        });
        set_error_handler(function($c, $m, $f, $l) {
            try {
                throw new cErrorException($m, $c, $f, $l);
            } catch (cErrorException $e) {
                $e->errorLog();
            }
        });
        register_shutdown_function(function() {
            if (cAjax::is()) {
                cAjax::shutdown();
            } else {
                cDebug::shutdown();
            }
        });
    }

    public static function restoreHandler() {
        restore_exception_handler();
        restore_error_handler();
    }

    public static function sessionClose() {
        session_write_close();
    }

    public static function timeLimit($l = 600) {
        set_time_limit($l);
    }

    public static function ignoreUserAbort($s = true) {
        ignore_user_abort($s);
    }

}

