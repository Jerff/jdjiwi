<?php

namespace Jdjiwi\Application;

use Jdjiwi\Log,
    Jdjiwi\Application;

class Call {

    static protected function start() {
        Application::authorization();
        Log::memory();
        $controler = new cmfApplicationTemplate();
        echo $controler->main();
        Log::memory();
    }

}
