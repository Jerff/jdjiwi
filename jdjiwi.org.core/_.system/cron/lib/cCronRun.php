<?php

class cCronRun {

    static public function start() {
        file_put_contents(cConfig::get('cron.status'), time());
    }

    static public function stop() {
        cFileSystem::unlink(cConfig::get('cron.status'));
    }

    static public function is() {
        if (file_exists(cConfig::get('cron.status'))) {
            if ((file_get_contents(cConfig::get('cron.status')) + 60 * 5) > time()) {
                return true;
            }
        }
        return false;
    }

}

