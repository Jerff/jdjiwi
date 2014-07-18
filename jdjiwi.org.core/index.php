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
    try {
        require($compile['path'] . 'loader.php');
    } catch (Exception $ex) {
        require(cSoursePath . 'loader.php');
        cCompile::php()->createrLoader();
    }
} else {
    require(cSoursePath . 'loader.php');
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