<?php

\Jdjiwi\Config::load('time');
date_default_timezone_set(\Jdjiwi\Config::get('time.zone'));

class cTime {

    static public function microtime($t = null) {
        list($usec, $sec) = explode(" ", empty($t) ? microtime() : $t);
        return ((float) $usec + (float) $sec);
    }

}

