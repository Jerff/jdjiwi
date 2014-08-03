<?php

class cExec {

    static public function is() {
        static $is = null;
        if ($is !== null) {
            return $is;
        }
        return $is = !in_array('exec', explode(',', ini_get('disable_functions')));
    }

    static public function run($command) {
        return exec($command);
    }

}

