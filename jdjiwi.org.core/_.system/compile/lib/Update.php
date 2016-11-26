<?php

namespace Jdjiwi\Compile;

use Jdjiwi\Init;

class Update {

    public static function start() {
        Init::ignoreUserAbort();
        Init::timeLimit();


        Compile\Php::update();
        Compile\JsCss::update();
        Init::ignoreUserAbort(false);
    }

}
