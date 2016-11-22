<?php

return array(
    /*
     *  драйвер кеша
     */
    'driver' => 'Sql',
    'driver.list' => array(
        'SQLite',
        'Memcache',
        'Xcache',
        'eaccelerator',
        'Sql'
    ),
    /*
     *  настройки
     */
    'default.time' => 3600,
    /*
     *  конфигурация мемкеша
     */
    'memcache.host' => 'localhost',
    'memcache.port' => 11211,
    /*
     * места для кеша
     */
    'site.path' => cWWWPath . '.cache/',
    'page.path' => \Jdjiwi\Config::get('path.data') . 'cache/page/',
    'sqlite.path' => \Jdjiwi\Config::get('path.data') . 'cache/sqlite/mydb.sq3',
);
