<?php

// авто загрузчик
spl_autoload_register(function($name) {
    cAutoload::init($name);
});

class cAutoload {

    static public function init($name) {
//        var_dump($name);
    }

}

?>