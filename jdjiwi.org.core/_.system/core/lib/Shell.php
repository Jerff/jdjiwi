<?php

namespace Jdjiwi;

class Shell {

    static public function isOn() {
        static $is = null;
        if ($is !== null) {
            return $is;
        }
        return $is = !in_array('exec', explode(',', ini_get('disable_functions')));
    }

    static public function exec($command) {
        return exec($command);
    }

}
