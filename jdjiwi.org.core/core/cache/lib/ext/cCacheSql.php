<?php

cLoader::library('cache:ext/driver/cCacheDriverSql');

class cCacheSql extends cCacheDriverSql {

    function __construct() {
        $this->setResurse(cRegister::sql());
    }

}

?>