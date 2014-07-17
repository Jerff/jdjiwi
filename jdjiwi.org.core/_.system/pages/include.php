<?php

/* конфигурация */
//cConfig::load('sections');
cConfig::load('router');
cConfig::load('base');

/* заагрузка библиотек */
cLoader::library('pages:cPages');

/* конфигурация */
cPages::base()->set(cConfig::get('base.host'));
cModul::config('sql.table');
cConfig::load('url');
cModul::config('const');
?>