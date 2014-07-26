<?php

//if (!defined('cApplication')) {
//    define('cApplication', 'application');
//}

define('cSoursePath', __DIR__ . '/');
define('cTimeInit', microtime());

chdir(__DIR__);

// конфигурация
$compile = require('_.config/compile.php');
//require('_.config/config.php');
//require('_.config/setting.project.php');
// системный кеш
if ($compile['is']) {
    if (is_file($compile['path'] . 'loader.php')) {
        require($compile['path'] . 'loader.php');
    } else {
        require(cSoursePath . '_.system/loader/cLoader.php');
        cCompile::php()->createrLoader();
    }
} else {
    require(cSoursePath . '_.system/loader/cLoader.php');
}
cLog::memory();
cLog::init();

cDebug::setAjax();
cDebug::setError();
cDebug::setSql();
cCache::setPages();
cCache::setData();

return cModul::call(cApplication);
?>