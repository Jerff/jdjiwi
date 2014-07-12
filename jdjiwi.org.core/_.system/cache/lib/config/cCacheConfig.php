<?php

// конфигураци драйверов кеша
class cCacheConfig {

    const DRIVER_LIST = 'SQLite|Memcache|Xcache|eaccelerator|sql';
    const TIME = 60;

    public function __call($name, $arg) {
        
    }

}

?>