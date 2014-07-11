<?php

/*
 *  драйвер кеша
 */
define('cCacheTypeDriver', 'sql');

/*
 *  конфигурация мемкеша
 */
define('cMemcacheHost', 'localhost');
define('cMemcachePort', 11211);

// места для кеша
define('cCacheSitePath', cWWWPath . '.cache/cache/');
define('cCachePagePath', cDataPath . 'cache/page/');
define('cCacheSQLitePath', cDataPath . 'cache/SQLite/mydb.sq3');
?>