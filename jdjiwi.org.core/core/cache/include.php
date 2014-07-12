<?php

/* конфигурация */
cConfig::load('cache');
self::config('sql.table');

/* заагрузка библиотек */
cLoader::library('cache:config/cCacheConfig');
cLoader::library('cache:cCache');
?>