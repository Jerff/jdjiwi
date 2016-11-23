<?php

namespace Jdjiwi;

Config::load('time');
date_default_timezone_set(Config::get('time.zone'));

class Time {

    static public function microtime($t = null) {
        list($usec, $sec) = explode(" ", empty($t) ? microtime() : $t);
        return ((float) $usec + (float) $sec);
    }

}
