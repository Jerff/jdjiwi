<?php

namespace Jdjiwi\Cache\Extensions;

\Jdjiwi\Loader::library('cache:extensions/driver/DriverTag');

class Apc extends Driver\DriverTag {

    function __construct() {
        if (!extension_loaded('apc')) {
            $this->setError();
        }
    }

    protected function setId($n, $v, $time) {
        apc_store($n, $v, $time);
    }

    protected function getId($n) {
        return apc_fetch($n);
    }

    protected function deleteId($n) {
        apc_delete($n);
    }

    public function clear() {
        apc_clear_cache('user');
    }

}
