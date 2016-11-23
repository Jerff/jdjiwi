<?php

/* конфигурация */
\Jdjiwi\Config::load('i18n');
setlocale(LC_ALL, \Jdjiwi\Config::get('i18n.locale'));
if (extension_loaded('mbstring')) {
    mb_language(\Jdjiwi\Config::get('i18n.mbstring.language'));
    mb_internal_encoding(\Jdjiwi\Config::get('i18n.charset'));
}

/* заагрузка библиотек */
\Jdjiwi\Loader::library('core:input/cInput');
\Jdjiwi\Loader::library('core:Session');
\Jdjiwi\Loader::library('core:Cookie');
\Jdjiwi\Loader::library('core:settings/cSettings');
\Jdjiwi\Loader::library('core:string/cString');
\Jdjiwi\Loader::library('core:JScript');
\Jdjiwi\Loader::library('core:crypt/cCrypt');
\Jdjiwi\Loader::library('core:time/cTime');
\Jdjiwi\Loader::library('core:Header');

/* загрузка модулей */
\Jdjiwi\Modul::load('database');
\Jdjiwi\Modul::load('fileSystem');
\Jdjiwi\Modul::load('pages');
\Jdjiwi\Modul::load('cache');
\Jdjiwi\Modul::load('mail');
