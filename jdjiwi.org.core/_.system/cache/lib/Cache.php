<?php

namespace Jdjiwi;

use Jdjiwi\Cache;

Loader::library('cache:Delegation');
Loader::library('cache:Control');
Loader::library('cache:ext/Sql');
Loader::library('cache:ext/SQLite');
Loader::library('cache:ext/Memcache');

class Cache extends Cache\Delegation {

    static public function driver() {
        if (self::$driver) {
            return self::$driver;
        }

        $cache = self::getDriver(Config::get('cache.driver'));
        if (!$cache->isRun()) {
            foreach (explode('|', Cache\Config::DRIVER_LIST) as $d) {
                if ($d !== $driver) {
                    $cache = self::getDriver($d);
                    if ($cache->isRun())
                        break;
                }
            }
        }

        return self::$driver = $cache;
    }

    // выборка драйвера кеша
    static private function &getDriver($driver) {
        switch ($driver) {
            case 'sql':
                $cache = new Sql();
                break;

            case 'SQLite':
                $cache = new SQLite();
                break;

            case 'Memcache':
                $cache = new Memcache();
                break;

            case 'Xcache':
                $cache = new \cmfCacheXcache();
                break;

            case 'eaccelerator':
                $cache = new \cCacheEaccelerator();
                break;

            case 'apc':
                $cache = new \cCacheApc();
                break;
        }
        return $cache;
    }

}
