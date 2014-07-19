<?php

class cCronRun {

    static private function getFile() {
        return cConfig::get('path.data') . '/cron/cron.run';
    }

    static public function run() {
        file_put_contents(self::getFile(), time());
    }

    static public function free() {
        cFileSystem::unlink(self::getFile());
    }

    static public function isRun() {
        if (file_exists(self::getFile())) {
            if ((file_get_contents(self::getFile()) + 60 * 5) > time()) {
                return true;
            }
        }
        return false;
    }

    static public function runModul($name, $id = 0) {
        if ($id) {
            cDb::update(cDb::table('sys.cron'), array('status' => 'start', 'date' => date('Y-m-d H:i:s')), $id);
        }
        self::run();
        cModul::cron($name);
        self::free();
        if ($id) {
            cDb::update(cDb::table('sys.cron'), array('status' => 'end', 'date' => date('Y-m-d H:i:s')), $id);
        }
        exit;
    }

}

?>