<?php

namespace Jdjiwi\Input;

class Files {

    public function is($n) {
        return isset($_FILES[$n]);
    }

    public function get($n) {
        return get($_FILES, $n);
    }

    public function &all() {
        return $_FILES;
    }

}
