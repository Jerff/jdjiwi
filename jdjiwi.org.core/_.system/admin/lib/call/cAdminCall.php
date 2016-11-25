<?php

class cApplicationCall {

    static protected function start() {
        \Jdjiwi\Application::authorization();

        \Jdjiwi\Log::memory();
        $controler = new cmfApplicationTemplate();
        echo $controler->main();
        \Jdjiwi\Log::memory();
    }

}

