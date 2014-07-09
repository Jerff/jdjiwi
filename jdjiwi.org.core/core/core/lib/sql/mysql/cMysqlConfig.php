<?php

cLoader::library('core:sql/config/cSqlConfig');

class cMysqlConfig extends cSqlConfig {

    public function init($driver) {
        switch (cCharset) {
            case 'UTF-8':
                $driver->query("SET NAMES utf8 COLLATE utf8_unicode_ci");
                break;

            default:
                break;
        }
    }

}

?>