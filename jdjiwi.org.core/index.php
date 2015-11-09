<?php

//if (!defined('cApplication')) {
//    define('cApplication', 'application');
//}

define('cSoursePath', __DIR__ . '/');
define('cTimeInit', microtime());

chdir(__DIR__);

// конфигурация
$compile = require(cSoursePath . '_.config/compile.php');
// системный кеш
if ($compile['is']) {
    if (is_file($compile['path'] . 'loader.php')) {
        define('isCompile', true);
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
cDebug::setModul();
cDebug::setSql();
cCache::setPages();
cCache::setData();
return cModul::call(cApplication);
