<?php

/* конфигурация */
cConfig::load('pages');
cConfig::load('base');

/* заагрузка библиотек */
cLoader::library('pages:cPages');

/* конфигурация */
cPages::base()->set(cConfig::get('base.host'));
cModul::config('sql.table');
cConfig::load('url');
cModul::config('const');
?>