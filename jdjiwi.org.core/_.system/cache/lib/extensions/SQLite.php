<?php

namespace Jdjiwi\Cache\Extensions;

\Jdjiwi\Loader::library('cache:extensions/driver/DriverSql');

class SQLite extends Driver\DriverSql {

    function __construct() {

        $dns = 'sqlite:' . \Jdjiwi\Config::get('cache.sqlite.path');
        //$dns = 'sqlite::memory:';
        try {
            $sql = new \cmfPDO($dns);
        } catch (PDOException $e) {
            $this->setError();
            return;
        }
        $sql->setAttribute(PDO::ATTR_STATEMENT_CLASS, array('cPDOStatement'));

        $sql->query('
		CREATE TABLE IF NOT EXISTS `' . cDB::table('cache.data') . '` (
		`id` int(11) NOT NULL,
		`name` varchar(40) NOT NULL,
		`time` int(10) unsigned NOT NULL,
		`tag` varchar(250) NOT NULL,
		`data` text NOT NULL,
		PRIMARY KEY  (`id`),
		KEY `id_time` (`id`,`time`),
		KEY `tag` (`tag`)
		) DEFAULT CHARSET=utf8;');
        $this->setResurse($sql);
    }

}

