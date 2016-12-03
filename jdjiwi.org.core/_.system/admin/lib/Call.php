<?php

namespace Jdjiwi\Admin;

use Jdjiwi\Application,
    Jdjiwi\Log;

class Call {

    static public function start() {
        Application::authorization();
        Log::memory();
        $controler = new cmfApplicationTemplate();
        echo $controler->main();
        Log::memory();
    }

}
