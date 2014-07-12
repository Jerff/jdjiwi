<?php

cLoader::library('cache:cCacheDelegation');
cLoader::library('cache:ext/cCacheSql');
cLoader::library('cache:ext/cCacheSQLite');
cLoader::library('cache:ext/cCacheMemcache');

class cCache extends cCacheDelegation {

    private static $page = false;
    private static $data = false;
    private static $driver = null;

    static public function driver() {
        if (self::$driver) {
            return self::$driver;
        }

        $cache = self::getDriver(cConfig::get('cache.driver'));
        if (!$cache->isRun()) {
            foreach (explode('|', cCacheConfig::DRIVER_LIST) as $d) {
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
                $cache = new cCacheSql();
                break;

            case 'SQLite':
                $cache = new cCacheSQLite();
                break;

            case 'Memcache':
                $cache = new cCacheMemcache();
                break;

            case 'Xcache':
                $cache = new cmfCacheXcache();
                break;

            case 'eaccelerator':
                $cache = new cCacheEaccelerator();
                break;

            case 'apc':
                $cache = new cCacheApc();
                break;
        }
        return $cache;
    }

    // управление кеширование
    // вернуть режим кеширование
    static public function isNoPages() {
        return self::$page;
    }

    static public function isNoData() {
        return self::$data;
    }

    // установить режим кеширование
    static public function setPages($s = true) {
        self::$page = (bool) $s;
    }

    static public function setData($s = true) {
        self::$data = (bool) $s;
    }

}

?>