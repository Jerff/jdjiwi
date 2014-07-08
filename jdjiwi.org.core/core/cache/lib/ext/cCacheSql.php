<?php

cLoader::library('cache:ext/driver/cmfCacheDriverSql');

class cCacheSql extends cCacheDriverSql {

    function __construct() {
        $this->setResurse(cRegister::sql());
    }

}

?>