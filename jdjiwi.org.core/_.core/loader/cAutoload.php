<?php

// авто загрузчик
spl_autoload_register(function() {
    cAutoload::init($name);
});

class cAutoload {

    static public function init($name) {
        
    }

}

?>