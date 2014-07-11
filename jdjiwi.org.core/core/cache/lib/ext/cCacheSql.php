<?php

cLoader::library('cache:ext/driver/cCacheDriverSql');

class cCacheSql extends cCacheDriverSql {

    function __construct() {
        $this->setResurse(cDB::sql());
    }

}

?>