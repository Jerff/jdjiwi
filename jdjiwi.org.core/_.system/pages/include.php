<?php

/* конфигурация */
cConfig::load('pages');
cConfig::load('base');
cLoader::library('pages:cPages');
cPages::base()->set(cConfig::get('base.host'));
self::config('sql.table');
cConfig::load('url');
self::config('const');
?>