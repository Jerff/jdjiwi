<?php

if (!defined('cApplication')) {
    define('cApplication', 'application');
}

define('cRootPath', realpath(__DIR__ . '/../') . '/');
define('cCorePath', __DIR__ . '/');
define('cTimeInit', microtime());

chdir(__DIR__);

// конфигурация
require('_.config/config.php');
require('_.config/setting.project.php');

// системный кеш
if (isComplile) {
    require(cCompilePath . '.compile.' . cApplication . '.php');
} else {
    require('.include/' . cApplication . '.php');
}
cLog::log('.include.' . cApplication . '.php');

cModul::initCompile();
cDebug::setAjax();
cDebug::setError();
cDebug::setSql();
cmfCache::setPages();
cmfCache::setData();

return cInit::start();
?>