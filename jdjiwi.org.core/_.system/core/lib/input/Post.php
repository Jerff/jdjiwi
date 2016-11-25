<?php

namespace Jdjiwi\Input;

class Post {

    static public function is($n) {
        return isset($_POST[$n]);
    }

    static public function get($n, $d = null) {
        return get($_POST, $n, $d);
    }

    static public function all() {
        return $_POST;
    }

    static public function set($n, $v) {
        $_POST[$n] = $v;
    }

}
