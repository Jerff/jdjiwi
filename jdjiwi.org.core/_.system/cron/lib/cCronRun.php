<?php

namespace Jdjiwi;

use Jdjiwi\FileSystem\Utility;

class CronRun {

    static private function path() {
        return cWWWPath . Config::get('file.path') . Config::get('cron.status');
    }

    static public function start() {
        Utility::putContents(self::path(), time());
    }

    static public function stop() {
        Utility::unlink(self::path());
    }

    static public function is() {
        if (file_exists(self::path())) {
            if ((file_get_contents(self::path()) + 60 * 5) > time()) {
                return true;
            }
        }
        return false;
    }

}
