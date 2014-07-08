<?php

class cExec {

    static private function is() {
        static $is = null;
        if ($is !== null) {
            return $is;
        }
        return $is = !in_array('exec', explode(',', ini_get('disable_functions')));
    }



}

?>