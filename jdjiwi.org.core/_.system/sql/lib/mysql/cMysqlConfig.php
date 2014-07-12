<?php

cLoader::library('sql:cSqlConfig');

class cMysqlConfig extends cSqlConfig {

    public function init($driver) {
        switch (cConfig::get('i18n.charset')) {
            case 'UTF-8':
                $driver->query("SET NAMES utf8 COLLATE utf8_unicode_ci");
                break;

            default:
                break;
        }
    }

}

?>