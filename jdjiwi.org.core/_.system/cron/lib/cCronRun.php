<?php

class cCronRun {

    static public function start() {
        file_put_contents(\Jdjiwi\Config::get('cron.status'), time());
    }

    static public function stop() {
        cFileSystem::unlink(\Jdjiwi\Config::get('cron.status'));
    }

    static public function is() {
        if (file_exists(\Jdjiwi\Config::get('cron.status'))) {
            if ((file_get_contents(\Jdjiwi\Config::get('cron.status')) + 60 * 5) > time()) {
                return true;
            }
        }
        return false;
    }

}

