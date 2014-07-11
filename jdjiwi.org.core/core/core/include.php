<?php

/* конфигурация */
cLoader::config('application');
cLoader::library('core:sql/cDB');
self::config('sql.table');

/* заагрузка библиотек */
cLoader::library('core:input/cInput');
cLoader::library('core:session/cSession');
cLoader::library('core:settings/cSettings');
cLoader::library('core:string/cString');
cLoader::library('core:jscript/cJScript');
cLoader::library('core:crypt/cCrypt');
cLoader::library('core:time/cTime');
cLoader::library('core:header/cHeader');

/* загрузка модулей */
cModul::load('seo');
cModul::load('pages');
cModul::load('cache');
?>