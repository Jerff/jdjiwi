<?php

namespace Jdjiwi;

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
        require(cSoursePath . '_.system/loader/Loader.php');
        Compile\Php::createrLoader();
    }
} else {
    require(cSoursePath . '_.system/loader/Loader.php');
}
Log::memory();
Log::init();

Debug::setAjax();
Debug::setError();
//Debug::setModul();
Debug::setSql();
Cache\Control::setPages();
Cache\Control::setData();
return Modul::call(cApplication);
