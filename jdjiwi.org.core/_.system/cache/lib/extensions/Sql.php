<?php

namespace Jdjiwi\Cache\Extensions;

//\Jdjiwi\Loader::library('cache:extensions/driver/DriverSql');

class Sql extends Driver\DriverSql {

    function __construct() {
        $this->setResurse(\cDB::sql());
    }

}

