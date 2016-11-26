<?php

namespace Jdjiwi\Compile\JsCss;

use Jdjiwi\Input\Get;

class Call {

    static public function start() {
        JsCss::compile(Get::get('query'));
    }

}
