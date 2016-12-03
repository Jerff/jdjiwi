<?php

namespace Jdjiwi\Loader;

// авто загрузчик
spl_autoload_register(function($name) {
    Autoload::init($name);
});

class Autoload {

    static public function init($name) {
        $file = explode('\\', $name);
        if (isset($file[1]) and $file[0] === 'Jdjiwi') {
            $path = strtolower($file[1]{0}) . substr($file[1], 1) . '/lib/';
            unset($file[0]);
            if (isset($file[2])) {
                unset($file[1]);
            }
            $path .= implode('/', $file) . '.php';
            include_once($path);
            return;
        }
        echo '<pre>';
        echo (new \Exception())->getTraceAsString();
        echo '</pre>';
    }

}
