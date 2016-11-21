<?php

namespace Jdjiwi\Loader;

// авто загрузчик
spl_autoload_register(function($name) {
    Autoload::init($name);
});

class Autoload {

    static public function init($name) {
        var_dump($name);
    }

}
