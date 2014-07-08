<?php

cLoader::library('cache/driver/cmfCacheDriverSql');

class cCacheSql extends cCacheDriverSql {

    function __construct() {
        $this->setResurse(cRegister::sql());
    }

}

?>