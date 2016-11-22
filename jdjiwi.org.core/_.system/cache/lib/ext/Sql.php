<?php

namespace Jdjiwi\Cache;

\Jdjiwi\Loader::library('cache:ext/driver/DriverSql');

class Sql extends DriverSql {

    function __construct() {
        $this->setResurse(\cDB::sql());
    }

}

