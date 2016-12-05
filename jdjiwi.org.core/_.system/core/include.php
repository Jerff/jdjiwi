<?php

/* конфигурация */
\Jdjiwi\Config::load('i18n');
setlocale(LC_ALL, \Jdjiwi\Config::get('i18n.locale'));
if (extension_loaded('mbstring')) {
    mb_language(\Jdjiwi\Config::get('i18n.mbstring.language'));
    mb_internal_encoding(\Jdjiwi\Config::get('i18n.charset'));
}

/* заагрузка библиотек */
\Jdjiwi\Loader::library('core:Input');
\Jdjiwi\Loader::library('core:Session');
\Jdjiwi\Loader::library('core:Cookie');
\Jdjiwi\Loader::library('core:Crypt');
\Jdjiwi\Loader::library('core:JScript');
\Jdjiwi\Loader::library('core:Time');
\Jdjiwi\Loader::library('core:Settings');
\Jdjiwi\Loader::library('core:Limit');
\Jdjiwi\Loader::library('core:Strings');
\Jdjiwi\Loader::library('core:Header');
\Jdjiwi\Loader::library('core:Shell');

/* загрузка модулей */
\Jdjiwi\Modul::load('database');
\Jdjiwi\Modul::load('fileSystem');
\Jdjiwi\Modul::load('pages');
\Jdjiwi\Modul::load('cache');
\Jdjiwi\Modul::load('mail');
