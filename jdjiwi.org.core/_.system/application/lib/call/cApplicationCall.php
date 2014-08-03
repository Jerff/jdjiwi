<?php

class cApplicationCall {

    static protected function start() {
        cApplication::authorization();

        cLog::memory();
        $controler = new cmfApplicationTemplate();
        echo $controler->main();
        cLog::memory();
    }

}

