<?php

return array(
    /*
     *  драйвер кеша
     */
    'driver' => 'sql',
    /*
     *  конфигурация мемкеша
     */
    'memcache.host' => 'localhost',
    'memcache.port' => 11211,
    /*
     * места для кеша
     */
    'site.path' => cWWWPath . '.cache/',
    'page.path' => cConfig::get('path.data') . 'cache/page/',
    'sqlite.path' => cConfig::get('path.data') . 'cache/sqlite/mydb.sq3',
);
//define('cCacheTypeDriver', 'sql');

/*
 *  конфигурация мемкеша
 */
//define('cMemcacheHost', 'localhost');
//define('cMemcachePort', 11211);

// места для кеша
define('cCacheSitePath', cWWWPath . '.cache/cache/');
define('cCachePagePath', cConfig::get('path.data') . 'cache/page/');
define('cCacheSQLitePath', cConfig::get('path.data') . 'cache/SQLite/mydb.sq3');
?>