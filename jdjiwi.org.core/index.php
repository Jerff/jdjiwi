<?php

if (!defined('cApplication')) {
    define('cApplication', 'application');
}

define('cSoursePath', __DIR__ . '/');
define('cTimeInit', microtime());

chdir(__DIR__);

// конфигурация
$compile = require('_.config/compile.php');
//require('_.config/config.php');
//require('_.config/setting.project.php');
// системный кеш
if ($compile['is']) {
    require($compile['path'] . '.compile.' . cApplication . '.php');
} else {
    require('.include/' . cApplication . '.php');
}
cLog::log('.include.' . cApplication . '.php');

cModul::initCompile();
cDebug::setAjax();
cDebug::setError();
cDebug::setSql();
cCache::setPages();
cCache::setData();

return cInit::start();
?>