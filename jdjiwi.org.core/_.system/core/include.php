<?php

/* конфигурация */
cConfig::load('i18n');
setlocale(LC_ALL, cConfig::get('i18n.locale'));
if (extension_loaded('mbstring')) {
    mb_language(cConfig::get('i18n.mbstring.language'));
    mb_internal_encoding(cConfig::get('i18n.charset'));
}

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
cModul::load('database');
cModul::load('seo');
cModul::load('file');
cModul::load('pages');
cModul::load('cache');
cModul::load('mail');
