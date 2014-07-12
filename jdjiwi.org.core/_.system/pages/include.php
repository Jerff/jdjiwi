<?php

/* конфигурация */
cConfig::load('application');
cConfig::load('base');
cPages::base()->set(cConfig::get('base.host'));
cConfig::load('url');
self::config('sql.table');
?>