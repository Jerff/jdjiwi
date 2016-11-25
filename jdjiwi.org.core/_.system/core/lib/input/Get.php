<?php

namespace Jdjiwi\Input;

class Get {

    static public function is($n) {
        return isset($_GET[$n]);
    }

    static public function get($n, $d = null) {
        return get($_GET, $n, $d);
    }

    static public function all() {
        return $_GET;
    }

    static public function set($n, $v) {
        $_GET[$n] = $v;
    }

}
