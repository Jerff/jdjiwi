<?php

/* конфигурация */
cConfig::load('pages');
cConfig::load('base');
cPages::base()->set(cConfig::get('base.host'));
cConfig::load('url');
self::config('sql.table');
self::config('const');
?>