<?php

namespace Jdjiwi\Application;

use Jdjiwi\Log,
    Jdjiwi\Application;

class Call {

    static public function start() {
        Application::authorization();
        Log::memory();
        $controler = new Template();
        echo $controler->main();
        Log::memory();
    }

}
