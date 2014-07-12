<?php

/* конфигурация */
cConfig::load('pages');
cConfig::load('base');

/* заагрузка библиотек */
cLoader::library('pages:cPages');
self::config('const');

/* конфигурация */
cPages::base()->set(cConfig::get('base.host'));
self::config('sql.table');
cConfig::load('url');
?>