<?php

/* конфигурация */
self::config('sql.table');

/* заагрузка библиотек */
cLoader::library('cache:config/cCacheConfig');
cLoader::library('cache:cCache');
?>